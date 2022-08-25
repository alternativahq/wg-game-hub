<?php

namespace App\Http\Controllers\Wallet;

use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionShowController extends Controller
{
    public function __invoke($id, Request $request)
    {
        // return 'SADASDAS';
        // return $response = Http::get();
        // if (!$response->ok()) {
        //     // TODO: Put session here
        //     return redirect()->back();
        // }
    }
}
