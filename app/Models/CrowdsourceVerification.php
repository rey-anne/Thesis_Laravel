<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdsourceVerification extends Model
{
    protected $table = 'crowdsource_verifications';
    public $timestamps = false;

    protected $fillable = [
        'fire_report_id', 'verifier_latitude', 'verifier_longitude',
        'verification_photo_path', 'submitted_at',
    ];
}
