<?php

namespace App\Console\Commands;

use App\Models\JobRequest;
use App\Notifications\JobOverdueNotification;
use Illuminate\Console\Command;

class CheckJobDeadlines extends Command
{
    protected $signature   = 'jobs:check-deadlines';
    protected $description = 'Notify tradespeople of job requests that have passed their deadline';

    public function handle(): void
    {
        $overdue = JobRequest::with(['customer', 'tradesperson'])
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now())
            ->whereNotIn('status', ['complete', 'reviewed', 'declined'])
            ->get();

        $notified = 0;

        foreach ($overdue as $job) {
            // Skip if already notified today for this job
            $alreadyNotified = $job->tradesperson->notifications()
                ->where('type', JobOverdueNotification::class)
                ->whereDate('created_at', today())
                ->whereJsonContains('data->job_request_id', $job->id)
                ->exists();

            if (!$alreadyNotified) {
                $job->tradesperson->notify(new JobOverdueNotification($job));

                // Also notify the customer
                $job->customer->notify(new JobOverdueNotification($job));
                $notified++;
            }
        }

        $this->info("Checked {$overdue->count()} overdue jobs. Sent {$notified} new notifications.");
    }
}
