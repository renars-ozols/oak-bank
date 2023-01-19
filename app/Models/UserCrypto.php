<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCrypto extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'crypto_id',
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

    public function transactions()
    {
        return $this->hasMany(CryptoTransaction::class);
    }
}
