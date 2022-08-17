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

class DepositController extends Controller
{
    public function __invoke(User $user,Request $request) {

        //Todo need to get all transactions and fillter them and get them by type to deposit
        $response = Http::get(env('TRANSACTION_API'),$request->all());
        $depositTransactions = $response->json();
        
        //Todo need to set up the pipeline
        // $transactions = UserDepositsPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id','name']);

        return Inertia::render('Wallet/Deposit', [
            'userDepositTransactions' => $depositTransactions,
            // 'usertransactions' => TransactionResource::collection($depositTransactions->paginate()->withQueryString()),
            'assets' => AssetResource::collection($assets),
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_game'),
        ]);
    }
}
