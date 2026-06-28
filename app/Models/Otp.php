<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'otps';
    public $timestamps = false;

    protected $fillable = ['email', 'otp_code', 'purpose', 'channel', 'phone', 'is_used', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];
}
