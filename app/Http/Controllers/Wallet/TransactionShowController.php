<?php

namespace App\Http\Controllers\Wallet;

use App\Services\Internal\WalletAPI;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionShowController extends Controller
{
    public function __construct(protected WalletAPI $walletAPI)
    {
    }

    public function __invoke($id, Request $request)
    {
        $response = $this->walletAPI->transactionLog($id);
        return $response;
        // if (!$response->ok()) {
        //     session()->flash('erorr', 'there is no response!');
        //     return redirect()->route('admin-game-lobbies',$gameLobby->game->id);
        // }
    }
}
