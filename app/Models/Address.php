<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'isdefault',
        'name',
        'phone',
        'zip',
        'state',
        'city',
        'address',
        'locality',
        'landmark',
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
