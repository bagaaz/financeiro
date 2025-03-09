<?php

namespace App\Enums;

enum TransactionType: int
{
    case Expense = 1;
    case Income  = 2;

    public function label(): string
    {
        return match ($this) {
            self::Expense => __('enums.transaction_type.expense'),
            self::Income  => __('enums.transaction_type.income'),
        };
    }
}
