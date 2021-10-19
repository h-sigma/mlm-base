<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $attributes = [
        'joining_invoice_id' => NULL,
        'admin' => false
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sponsor_id',
        'joining_invoice_id',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sponsor() {
        return $this->hasOne(User::class, 'id', 'sponsor_id');
    }

    public function joiningInvoice() {
        return $this->hasOne(Invoice::class, 'id', 'joining_invoice_id');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'user_id', 'id');
    }

    public function paymentAttempts() {
        return $this->hasManyThrough(PaymentAttempt::class, Invoice::class, 'user_id', 'invoice_id', 'id', 'id');
    }

    public function redemptions() {
        return $this->hasMany(Redemption::class, 'user_id', 'id');
    }

    public function commissions() {
        return $this->hasMany(Commission::class, 'user_id', 'id');
    }

    public function leftChild() {
        return $this->hasOneThrough(User::class, UserNetwork::class, 'parent_id', 'id', 'id', 'left_child_id');
    }
    
    public function rightChild() {
        return $this->hasOneThrough(User::class, UserNetwork::class, 'parent_id', 'id', 'id', 'right_child_id');
    }
}
