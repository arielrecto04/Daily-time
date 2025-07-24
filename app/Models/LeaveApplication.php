<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'name',
        'descriptions',
        'total_days',
        'leave_type_id',
        'start_date',
        'end_date',
        'user_id'
    ];


    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

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
