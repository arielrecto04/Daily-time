<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'name',
        'descriptions',
        'is_active',
        'is_credited'
    ];



    public function leaveApplication()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
