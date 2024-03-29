<?php

namespace App\Http\Requests;

use App\Rules\WithdrawalCodeExistAndValid;
use Illuminate\Foundation\Http\FormRequest;

class CompleteWithdrawControllerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                new WithdrawalCodeExistAndValid(),
            ],
            'transaction_uuid' => ['required', 'uuid','exists:withdrawal_confirmations,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
