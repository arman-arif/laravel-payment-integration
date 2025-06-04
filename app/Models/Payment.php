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
        'payment_meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'payment_meta' => 'object',
    ];

    public function getAmountString()
    {
        return number_format($this->amount, 2)." $this->currency";
    }


}
