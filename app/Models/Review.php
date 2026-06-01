<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'job_requests_id',
        'rating',
        'comment',
    ];

    public function jobRequest()
    {
        return $this->belongsTo(JobRequest::class, 'job_requests_id');
    }
}
