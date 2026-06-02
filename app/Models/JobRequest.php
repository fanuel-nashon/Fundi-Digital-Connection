<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'tradesperson_id',
        'status',
        'scheduled_date',
        'deadline',
        'progress',
        'description',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'deadline'       => 'date',
    ];

    public function isOverdue(): bool
    {
        return $this->deadline
            && $this->deadline->isPast()
            && !in_array($this->status, ['complete', 'reviewed', 'declined']);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function tradesperson()
    {
        return $this->belongsTo(User::class, 'tradesperson_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'job_requests_id');
    }
}
