<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function scopeAccountNumber($query, $number)
    {
        return $query->where('account_number', 'like', '%'.$number.'%');
    }

    public function scopeDateRange($query, $start_date, $end_date)
    {
        return $query->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function scopeCryptoName($query, $name)
    {
        return $query->where('crypto_name', 'like', '%'.$name.'%');
    }
}
