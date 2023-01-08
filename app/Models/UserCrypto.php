<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCrypto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crypto_id',
        'account_id',
        'name',
        'symbol',
        'logo',
        'currency',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
