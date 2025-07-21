<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model
{
    protected $fillable = [
        'name',
        'day_of_week',
        'day_period',
        'hours_from',
        'hours_to',
        'duration_days',
        'work_schedule_id'
    ];


    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }
}
