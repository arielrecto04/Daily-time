<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'image_url',
        'last_name',
        'first_name',
        'middle_name',
        'mobile',
        'phone',
        'gender',
        'birthday',
        'street',
        'street_2',
        'barangay',
        'city',
        'region',
        'user_id',
        'work_place_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workPlace()
    {
        return $this->belongsTo(WorkPlace::class);
    }
}
