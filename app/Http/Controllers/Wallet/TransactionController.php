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

class TransactionController extends Controller
{
    public function __invoke(User $user,Request $request) {
        // dd('asd');

        $transactions = [
            [
                'id' => "11111",
                'globalTxId' => "12",
                'tenantId' => "122",
                'refId' => "1224",
                'hash' => "1asdasd224",
                'type' => "DEPOSIT",
                'state' => "SUBMITTED",
                "asset" => "XNO",
                'fromAccountId' => "5cf1f635-5359-415f-b940-4bd9601727bb",
                'toAccountId' => "97e561bf-91ff-466b-93c4-0de6138c08cc",
                'amount' => 5,
                'fee' => 1,
                'scope' => "Internal",
                'createdAt' => "2022-08-15T07:53:06.001Z",
                'updatedAt' => "2022-08-15T07:53:06.001Z"
            ],
            [
                'id' => "11211",
                'globalTxId' => "12",
                'tenantId' => "122",
                'refId' => "1224",
                'hash' => "1asdasd224",
                'type' => "DEPOSIT",
                'state' => "SUBMITTED",
                "asset" => "XNO",
                'fromAccountId' => "5cf1f635-5359-415f-b940-4bd9601727bb",
                'toAccountId' => "97e561bf-91ff-466b-93c4-0de6138c08cc",
                'amount' => 5,
                'fee' => 1,
                'scope' => "Internal",
                'createdAt' => "2022-08-15T07:53:06.001Z",
                'updatedAt' => "2022-08-15T07:53:06.001Z"
            ]
        ];

        // $transactions = UserTransactionPipeline::make(
        //     builder: Transcation::query()->whereBelongsTo($user),
        //     request: $request,
        // );

        $assets = Asset::get(['id','name']);
        
        return Inertia::render('Wallet/Transaction', [
            'usertransactions' => $transactions,
            // 'usertransactions' => TransactionResource::collection($transactions->paginate()->withQueryString()),
            'assets' => AssetResource::collection($assets),
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_game'),
        ]);
    }
}
