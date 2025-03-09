<?php

namespace App\Models;

use App\Enums\VaultRecordType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultRecord extends Model
{
    /** @use HasFactory<\Database\Factories\VaultRecordFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => VaultRecordType::class,
    ];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }
}
