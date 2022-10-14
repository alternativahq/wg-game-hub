<?php

namespace App\Http\Requests;

use App\Enums\Wallet\TransactionAsset;
use App\Rules\WithdrawalCodeExistAndValid;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawConfirmationControllerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //TODO: need to check if he has this amount in his account
            'coin' => ['required', 'string'],
            //'coin' => ['required', 'in:' . collect(array_column(GameLobbyType::cases(), 'value'))->implode(',')],
            'amount' => ['required', 'numeric', 'min:1', 'max:28'],
            'wallet_address' => ['required'],
            'network' => ['required', 'in:' . collect(array_column(TransactionAsset::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
