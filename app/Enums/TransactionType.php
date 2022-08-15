<?php

namespace App\Enums;

enum TransactionType: string
{
    case DEPOSIT = "deposit";
    case WITHDROW = "with-drow";
}
