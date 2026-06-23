<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';

    protected $fillable = [
        'user_id', 'id_number', 'rank', 'assigned_fire_station_id', 'command_level',
        'unit_division_handled', 'managed_units', 'area_of_jurisdiction',
        'official_email', 'official_contact_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
