<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case Pending   = 1;
    case Completed = 2;

    public function label(): string
    {
        return match ($this) {
            self::Pending   => __('enums.transaction_status.pending'),
            self::Completed => __('enums.transaction_status.completed'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'orange',
            self::Completed => 'green',
        };
    }
}
