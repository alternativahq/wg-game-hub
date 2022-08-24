<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionScope: string
{
    case Internal = 'Internal';
    case External = 'External';

    public static function toSelect(): Collection
    {
        return collect(TransactionScope::cases())->map(function (TransactionScope $transactionScope) {
            return [
                'label' => $transactionScope->name,
                'value' => $transactionScope->value,
            ];
        });
    }
}
