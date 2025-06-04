<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'email',
        'description',
        'amount',
        'currency',
        'is_paid',
        'paid_at',
        'payment_id',
        'payment_gateway',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];
}
