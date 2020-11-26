<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    const CREATED_AT = false;
    const UPDATED_AT = false;

    protected $fillable = [
        'name',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
