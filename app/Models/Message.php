<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'job_request_id',
        'senders_id',
        'receivers_id',
        'message_content',
    ];

    public function jobRequest()
    {
        return $this->belongsTo(JobRequest::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senders_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receivers_id');
    }
}
