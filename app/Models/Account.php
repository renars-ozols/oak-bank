<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'currency',
    ];

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
        $this->save();
    }

    public function senderTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_account_id');
    }

    public function recipientTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_account_id');
    }

    public function cryptos()
    {
        return $this->hasMany(UserCrypto::class);
    }

    public function cryptoTransactions()
    {
        return $this->hasMany(CryptoTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->number = 'LV33BANK' . rand(1000000000000, 9999999999999);
        });
    }
}
