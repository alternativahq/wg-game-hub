<?php

namespace App\Http\Controllers\Wallet;

use App\Enums\TransactionType;
use App\Enums\Wallet\TransactionAsset;
use App\Enums\Wallet\TransactionScope;
use App\Enums\Wallet\TransactionState;
use Redirect;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Http;
use App\Http\QueryPipelines\UserTransactionsPipeline\UserTransactionsPipeline;
use Illuminate\Pagination\LengthAwarePaginator;
use Str;

class WithdrawController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $payload = $request
            ->collect()
            ->merge([
                'type' => 'WITHDRAW',
            ])
            ->keyBy(fn($value, $key) => Str::camel($key))
            ->all();
        $response = Http::get(config('wodo.wallet-transactions-api'), $payload);
        if (!$response->ok()) {
            // TODO: Put session here
            return redirect()->back();
        }
        $withdrawTransactions = new LengthAwarePaginator(
            $response->object()->data,
            $response->object()->meta->total,
            $response->object()->meta->per_page,
            $response->object()->meta->current_page,
            [
                'path' => url()->current(),
            ],
        );

        //Todo need to set up the pipeline

        // $transactions = UserTransactionPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id', 'name']);
        return Inertia::render('Wallet/Withdraw', [
            'userWithdrawTransactions' => TransactionResource::collection($withdrawTransactions->withQueryString()),
            'assets' => AssetResource::collection($assets),
            '_filters' => $request
                ->collect()
                ->only('sort_by', 'sort_order', 'filter_by_game', 'hash', 'scope', 'asset', 'type', 'state')
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
