<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reward() {
        return $this->hasOne(Reward::class, 'id', 'reward_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
