<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'health_condition',
        'preferred_categories',
        'min_price',
        'max_price',
        'allergic_ingredients',
        'weight_kandungan',
        'weight_khasiat',
        'weight_harga',
        'weight_expired'
    ];

    protected $casts = [
        'preferred_categories' => 'array',
        'allergic_ingredients' => 'array',
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'weight_kandungan' => 'decimal:2',
        'weight_khasiat' => 'decimal:2',
        'weight_harga' => 'decimal:2',
        'weight_expired' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
