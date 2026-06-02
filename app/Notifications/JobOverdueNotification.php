<?php

namespace App\Notifications;

use App\Models\JobRequest;
use Illuminate\Notifications\Notification;

class JobOverdueNotification extends Notification
{
    public function __construct(public JobRequest $jobRequest) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'job_request_id' => $this->jobRequest->id,
            'customer_name'  => $this->jobRequest->customer->name,
            'deadline'       => $this->jobRequest->deadline->format('M d, Y'),
            'message'        => "Job for {$this->jobRequest->customer->name} was due on {$this->jobRequest->deadline->format('M d, Y')} and is now overdue.",
        ];
    }
}
