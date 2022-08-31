<?php

namespace App\Enums\Wallet;

use Illuminate\Support\Collection;

enum TransactionAsset: string
{
    case XNO = 'XNO';
    case BAN = 'BAN';
    case ETH = 'ETH';
    case AVAX = 'AVAX';
    case BSC = 'BSC';
    case SOL = 'SOL';
    case TRY = 'TRY';
    case XWGT = 'XWGT';

    public static function toSelect(): Collection
    {
        return collect(TransactionAsset::cases())->map(function (TransactionAsset $transactionAsset) {
            return [
                'label' => $transactionAsset->name,
                'value' => $transactionAsset->value,
            ];
        });
    }
}
