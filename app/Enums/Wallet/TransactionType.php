<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionType: string
{
    case Deposit = 'deposite';
    case Withdraw = 'withdraw';

    public static function toSelect(): Collection
    {
        return collect(TransactionType::cases())->map(function (TransactionType $transactionState) {
            return [
                'label' => $transactionState->name,
                'value' => $transactionState->value,
            ];
        });
    }
}
