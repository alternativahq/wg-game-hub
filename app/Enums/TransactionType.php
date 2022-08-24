<?php

namespace App\Enums;

use App\Enums\Wallet\TransactionState;
use Illuminate\Support\Collection;

enum TransactionType: string
{
    case Deposit = 'deposit';
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
