<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'search_query',
        'criteria_weights',
        'filters_applied',
        'results'
    ];

    protected $casts = [
        'criteria_weights' => 'array',
        'filters_applied' => 'array',
        'results' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
