<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'name',
        'file_type',
        'file_size',
        'url',
        'attachable_id',
        'attachable_type',
        'uploaded_by'
    ];


    public function uploadedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function attachable()
    {
        return $this->morphTo();
    }
}
