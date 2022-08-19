<?php

namespace App\Http\Controllers\Wallet;

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

class WithdrawController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        //Todo need to get all transactions and filter them and get them by type to withdraw
        $response = Http::get(config('wodo.wallet-transactions-api'), $request->all());

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
            'userWithdrawTransactions' => $withdrawTransactions,
            // 'usertransactions' => TransactionResource::collection($withdrawTransactions->paginate()->withQueryString()),
            'assets' => AssetResource::collection($assets),
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_game'),
        ]);
    }
}
