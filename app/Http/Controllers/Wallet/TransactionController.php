<?php

namespace App\Http\Controllers\Wallet;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\TransactionResource;
use App\Http\QueryPipelines\UserTransactionsPipeline\UserTransactionsPipeline;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    public function __invoke(User $user,Request $request) {
         
        $response = Http::get(env('TRANSACTION_API'),$request->all());

        $transactions =  new LengthAwarePaginator(
            $response->object()->data, 
            $response->object()->meta->total, 
            $response->object()->meta->per_page, 
            $response->object()->meta->current_page,
            [
                'path' => url()->current(),
            ]
        );
        
        // $transactions = UserTransactionPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id','name']);
        
        return Inertia::render('Wallet/Transaction', [
            'usertransactions' => TransactionResource::collection($transactions),
            'assets' => AssetResource::collection($assets),
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_game'),
        ]);
    }
}
