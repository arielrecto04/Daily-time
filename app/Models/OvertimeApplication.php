<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeApplication extends Model
{
    protected $fillable = [
        'attendance',
        'overtime_in_minutes',
        'overtime_in_hours',
        'date',
        'user_id'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
