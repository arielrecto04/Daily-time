<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPlace extends Model
{
    protected $fillable = [
        'name',
        'address',
        'image_url',
        'coordinates'
    ];


    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}
