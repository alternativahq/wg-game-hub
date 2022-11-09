<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyAlgorithmsType;
use App\Enums\Wallet\TransactionAsset;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'coin' => ['required', 'in:' . collect(array_column(TransactionAsset::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
