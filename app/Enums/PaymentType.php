<?php

namespace App\Enums;

enum PaymentType: int
{
    case Unique      = 1;
    case Installment = 2;
    case Recurring   = 3;

    public function label(): string
    {
        return match ($this) {
            self::Unique      => __('enums.payment_types.unique'),
            self::Installment => __('enums.payment_types.installment'),
            self::Recurring   => __('enums.payment_types.recurring'),
        };
    }
}
