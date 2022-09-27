<?php

namespace App\Http\Controllers\Wallet;

use App\Enums\TransactionType;
use App\Enums\Wallet\TransactionAsset;
use App\Enums\Wallet\TransactionScope;
use App\Enums\Wallet\TransactionState;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\TransactionResource;
use App\Http\QueryPipelines\UserDepositsPipeline\UserDepositsPipeline;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Str;

class DepositController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $payload = $request
            ->collect()
            ->merge([
                'type' => TransactionType::Deposit->value,
            ])
            ->keyBy(fn($value, $key) => Str::camel($key))
            ->all();
        $response = Http::get(config('wodo.wallet-transactions-api'), $payload);
        if (!$response->ok()) {
            // TODO: Put session here
            return redirect()->back();
        }

        $depositTransactions = new LengthAwarePaginator(
            $response->object()->data,
            $response->object()->meta->total,
            $response->object()->meta->per_page,
            $response->object()->meta->current_page,
            [
                'path' => url()->current(),
            ],
        );

        //Todo need to set up the pipeline
        // $transactions = UserDepositsPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id', 'name', 'symbol']);

        return Inertia::render('Wallet/Deposit', [
            'userDepositTransactions' => TransactionResource::collection($depositTransactions),
            'assetInformation' => function () use ($request) {
                if (!$request->exists('coin')) {
                    return [];
                }
                $url =
                    config('wodo.wallet-service') .
                    'accounts?userId=' .
                    auth()->user()->id .
                    '&asset=' .
                    $request->coin;
                $response = Http::get(url: $url);
                if ($response->failed()) {
                    session()->flash('error', 'Something went wrong, please try again later');
                    return redirect()->back();
                }
                return count($response->json('data')) ? $response->json('data')[0] : [];
            },
            'assets' => AssetResource::collection($assets),
            '_filters' => $request
                ->collect()
                ->only(
                    'sort_by',
                    'sort_order',
                    'hash',
                    'scope',
                    'asset',
                    'state',
                    'global_tx_id',
                    'ref_id',
                    'hash',
                    'to_account_id',
                    'from_account_id',
                )
                ->filter()
                ->toArray(),
            '_filtersOptions' => [
                'transactionScopeOptions' => TransactionScope::toSelect()->toArray(),
                'transactionAssetOptions' => TransactionAsset::toSelect()->toArray(),
                'transactionStateOptions' => TransactionState::toSelect()->toArray(),
                'transactionTypeOptions' => TransactionType::toSelect()->toArray(),
            ],
        ]);
    }
}
