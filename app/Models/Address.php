<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'isdefault',
        'line1',
        'line2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    protected $casts = [
        'isdefault' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
