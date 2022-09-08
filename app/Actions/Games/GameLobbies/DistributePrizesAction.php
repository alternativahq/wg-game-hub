<?php

namespace App\Actions\Games\GameLobbies;

use App\DataTransferObjects\GameMatchResultData;
use App\Models\Asset;
use App\Models\GameLobby;
use App\Models\User;
use App\Models\WodoAssetAccount;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class DistributePrizesAction
{
    public function execute(GameLobby $gameLobby, GameMatchResultData $gameMatchResultData): void
    {
        $gameLobby->load('asset');
        $totalFees = $gameLobby->users->sum('pivot.entrance_fee');
        $amountPerPerson = $totalFees / $gameLobby->users->count();
        $payload = $gameLobby
            ->users()
            ->with([
                'assetAccounts' => function ($query) use ($gameLobby) {
                    $query->where('asset_id', $gameLobby->asset_id);
                },
            ])
            ->get()
            ->map(function (User $user) use ($gameLobby, $gameMatchResultData) {
                $userScore = collect($gameMatchResultData->scores)
                    ->where('user_id', $user->id)
                    ->first();
                return [
                    'refId' => $gameLobby->id,
                    'fromAccountId' => $gameLobby->asset->id,
                    'toAccountId' => $user->assetAccounts->first()->id,
                    'asset' => $gameLobby->asset->symbol,
                    'rank' => $userScore['rank'],
                ];
            })
            ->sortBy('rank')
            ->map(function ($record, $index) use ($amountPerPerson, $gameLobby) {
                $amount = $amountPerPerson;
                if ($index === 0) {
                    $amount = $amountPerPerson * 2;
                } elseif ($index === $gameLobby->users->count() - 1) {
                    $amount = 0;
                }
                $data = array_merge($record, [
                    'amount' => (float) $amount,
                ]);

                unset($data['rank']);

                return $data;
            });

        foreach ($payload as $item) {
            $item = (object) $item;
            $temporalClient = app('temporal-client');

            $workflow = $temporalClient->newWorkflowStub(
                \App\Services\Temporal\Contracts\GameLobbyPrizeTransactionWorkflowContract::class,
                \Temporal\Client\WorkflowOptions::new()->withWorkflowExecutionTimeout(\Carbon\CarbonInterval::minute()),
            );
            $temporalClient->start(
                $workflow,
                $item->refId,
                $item->toAccountId,
                $item->asset,
                $item->amount,
                $item->fromAccountId,
            );
        }
    }
}
