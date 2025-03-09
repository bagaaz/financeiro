<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TransactionInstallment
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $installment_number
 * @property float $installment_amount
 * @property Carbon|null $transaction_date
 * @property TransactionStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Transaction $transaction
 */
class TransactionInstallment extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transactions_installments';

    protected $casts = [
        'status' => TransactionStatus::class,
        'transaction_date' => 'datetime',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    protected function installmentAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Helper::floatToReal($value)
        );
    }
}
