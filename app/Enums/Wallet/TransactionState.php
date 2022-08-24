<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionState: string
{
    case Submitted = 'submitted';
    case Processing = 'processing';
    case Completed = 'completed';
    case Failed = 'failed';

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
