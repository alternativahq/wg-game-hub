<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionType: string
{
    case Deposit = 'DEPOSIT';
    case Withdraw = 'WITHDRAW';

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
