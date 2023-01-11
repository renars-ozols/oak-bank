<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'user_crypto_id',
        'crypto_id',
        'type',
        'account_number',
        'currency',
        'crypto_name',
        'amount',
        'crypto_price',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function userCrypto()
    {
        return $this->belongsTo(UserCrypto::class);
    }
}
