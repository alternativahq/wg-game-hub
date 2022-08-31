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

        session()->flash('error', 'Something went wrong, please try again later');
        if (!$response->ok()) {
            return response()->json(['message' => 'Something went wrong please try again later.'], 400);
        }

        return $response;
    }
}
