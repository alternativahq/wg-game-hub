<?php

namespace App\Http\Controllers\Wallet;

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

class DepositController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        //Todo need to get all transactions and fillter them and get them by type to deposit
        $response = Http::get(
            config('wodo.wallet-transactions-api'),
            array_merge($request->all(), [
                'type' => 'WITHDRAW',
            ]),
        );

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

        $assets = Asset::get(['id', 'name']);

        return Inertia::render('Wallet/Deposit', [
            'userDepositTransactions' => TransactionResource::collection($depositTransactions),
            'assets' => AssetResource::collection($assets),
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_game'),
        ]);
    }
}
