<?php

namespace App\Http\Controllers\Wallet;

use App\Enums\TransactionType;
use App\Enums\Wallet\TransactionAsset;
use App\Enums\Wallet\TransactionScope;
use App\Enums\Wallet\TransactionState;
use App\Services\Internal\WalletAPI;
use Redirect;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\TransactionResource;
//use App\Http\QueryPipelines\UserTransactionsPipeline\UserTransactionsPipeline;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Str;

class TransactionController extends Controller
{
    public function __construct(protected WalletAPI $walletAPI)
    {
    }

    public function __invoke(User $user, Request $request)
    {
        $payload = $request
            ->collect()
            ->keyBy(fn($value, $key) => Str::camel($key))
            ->all();

        $response = $this->walletAPI->listTransactions($payload);

        if (!$response->ok()) {
            // TODO: Put session here
            return redirect()->back();
        }

        $transactions = new LengthAwarePaginator(
            $response->object()->data,
            $response->object()->meta->total,
            $response->object()->meta->per_page,
            $response->object()->meta->current_page,
            [
                'path' => url()->current(),
            ],
        );

        // $transactions = UserTransactionPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id', 'name']);

        return Inertia::render('Wallet/Transaction', [
            'userTransactions' => TransactionResource::collection($transactions),
            'assets' => AssetResource::collection($assets),
            '_filters' => $request
                ->collect()
                ->only(
                    'sort_by',
                    'sort_order',
                    'hash',
                    'scope',
                    'asset',
                    'type',
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
