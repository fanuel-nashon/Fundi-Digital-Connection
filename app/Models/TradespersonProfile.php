<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobRequest;
use App\Models\Review;

class TradespersonProfile extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'bio',
        'availability_status',
        'reviews',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function averageRating(): float
    {
        $jobIds = JobRequest::where('tradesperson_id', $this->user_id)->pluck('id');
        return round(Review::whereIn('job_requests_id', $jobIds)->avg('rating') ?? 0, 1);
    }
}
