<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    protected $fillable = [
        'id',
        'name',
        'symbol',
        'currency',
        'price',
        'logo',
        'percentChange1h',
        'percentChange24h',
        'percentChange7d',
    ];
}
