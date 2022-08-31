<?php

namespace App\Http\Controllers\API\Wallet;

use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionShowController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $response = Http::get(config('wodo.wallet-transactions-show-api') . $id);
        return $response;
        // if (!$response->ok()) {
        //     session()->flash('erorr', 'there is no response!');
        //     return redirect()->route('admin-game-lobbies',$gameLobby->game->id);
        // }
    }
}
