<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWorkSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'work_schdule_id',
        'is_active'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
