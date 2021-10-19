<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paymentAttempts() {
        return $this->hasMany(PaymentAttempt::class, 'invoice_id', 'id');
    }

    public function commissions() {
        return $this->hasMany(Commission::class, 'invoice_id', 'id');
    }
}
