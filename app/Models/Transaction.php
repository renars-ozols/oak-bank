<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_account_id',
        'recipient_account_id',
        'amount',
    ];

    public function senderAccount()
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }

    public function recipientAccount()
    {
        return $this->belongsTo(Account::class, 'recipient_account_id');
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100
        );
    }

    public function scopeRecipientName($query, $name)
    {
        return $query->whereHas('recipientAccount.user', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
    }

    public function scopeAccountNumber($query, $number)
    {
        return $query->whereHas('senderAccount', function ($q) use ($number) {
            $q->where('number', 'like', '%'.$number.'%');
        })->orWhereHas('recipientAccount', function ($q) use ($number) {
            $q->where('number', 'like', '%'.$number.'%');
        });
    }

    public function scopeDateRange($query, $start_date, $end_date)
    {
        return $query->whereBetween('created_at', [$start_date, $end_date]);
    }
}
