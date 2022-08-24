<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionState: string
{
    case Submitted = 'SUBMITTED';
    case Processing = 'PROCESSING';
    case Completed = 'COMPLETED';
    case Failed = 'FAILED';

    public static function toSelect(): Collection
    {
        return collect(TransactionState::cases())->map(function (TransactionState $transactionState) {
            return [
                'label' => $transactionState->name,
                'value' => $transactionState->value,
            ];
        });
    }
}
