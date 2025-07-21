<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'name',
        'date',
        'check_in',
        'check_out',
        'overtime_in_minutes',
        'late_in_minutes',
        'day_of_week',
        'duration_days',
        'user_id'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
