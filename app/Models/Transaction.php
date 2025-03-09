<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Transaction
 *
 * @property int $id
 * @property User $user_id
 * @property TransactionCategory $category_id
 * @property string $title
 * @property string|null $description
 * @property float $total_amount
 * @property TransactionType $transaction_type
 * @property PaymentType $payment_type
 * @property int $installments_count
 * @property TransactionStatus $status
 * @property Carbon|null $transaction_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|TransactionInstallment[] $installments
 * @property-read float $installment_value
 */
class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'transaction_type' => TransactionType::class,
        'payment_type'      => PaymentType::class,
        'status'            => TransactionStatus::class,
        'transaction_date'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(TransactionInstallment::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    /**
     * Retorna o valor da parcela (total_amount dividido pelo número de installments).
     *
     * @return float
     */
    public function getInstallmentValueAttribute(): float
    {
        // Se houver parcelas, divide o total_amount pelo número de parcelas.
        // Caso contrário, retorna o total_amount.
        return $this->installments_count && $this->installments->count() > 0
            ? $this->total_amount / $this->installments->count()
            : $this->total_amount;
    }

    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Helper::floatToReal($value)
        );
    }
}
