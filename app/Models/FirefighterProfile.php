<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirefighterProfile extends Model
{
    protected $table = 'firefighter_profiles';

    protected $fillable = [
        'user_id', 'bfp_id_number', 'official_email', 'official_contact_number',
        'duty_status', 'rank', 'unit_division', 'assigned_fire_station_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
