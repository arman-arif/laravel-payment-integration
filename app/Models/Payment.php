<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'description',
        'amount',
        'currency',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
