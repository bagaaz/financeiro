<?php

namespace App\Enums;

enum VaultRecordType: int
{
    case Deposit = 1;
    case Exit  = 2;
    case Income = 3;

    public function label(): string
    {
        return match ($this) {
            self::Deposit => __('enums.vault_record_type.deposit'),
            self::Exit  => __('enums.vault_record_type.exit'),
            self::Income => __('enums.vault_record_type.income'),
        };
    }
}
