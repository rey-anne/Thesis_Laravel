<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role', 'full_name', 'email', 'contact_number', 'password',
        'profile_photo_path', 'account_status', 'last_login_at',
        'date_registered', 'created_by', 'approved_by', 'approved_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'last_login_at' => 'datetime',
        'date_registered' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function firefighterProfile()
    {
        return $this->hasOne(FirefighterProfile::class);
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function hasPermission(string $key): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        return RolePermission::where('role', $this->role)
            ->whereHas('permission', fn ($query) => $query->where('key', $key))
            ->exists();
    }
}
