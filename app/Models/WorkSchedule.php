<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $fillable = [
        'name',
        'hours_week',
        'average_hour_per_day'
    ];


    public function workHours()
    {
        return $this->hasMany(WorkHour::class);
    }
}
