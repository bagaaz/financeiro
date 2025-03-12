<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TransactionCategory
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property TransactionCategory $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class TransactionCategory extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transactions_categories';

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
