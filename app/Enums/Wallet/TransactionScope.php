<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionScope: string
{
    case Internal = 'internal';
    case External = 'external';

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
