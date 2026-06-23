<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostOperation extends Model
{
    protected $table = 'post_operations';

    protected $fillable = [
        'fire_report_id', 'user_id', 'personnel_name', 'id_number',
        'incident_summary', 'action_taken', 'extinguished_at', 'remarks',
        'report_file_path', 'report_file_original_name',
    ];

    protected $casts = [
        'extinguished_at' => 'datetime',
    ];

    public function fireReport()
    {
        return $this->belongsTo(FireReport::class);
    }

    public function personnel()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
