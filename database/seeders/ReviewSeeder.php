<?php

namespace Database\Seeders;

use App\Models\JobRequest;
use App\Models\Message;
use App\Models\Review;
use App\Models\TradespersonProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customers    = User::where('role', 'customer')->get();
        $tradespeople = User::where('role', 'tradesperson')->get();

        if ($customers->isEmpty() || $tradespeople->isEmpty()) {
            return;
        }

        $descriptions = [
            'Need my bathroom sink pipe fixed, it has been leaking for two days.',
            'Electrical fault in my kitchen, the sockets stopped working.',
            'Want a custom wooden bookshelf for my living room.',
            'Gate needs welding and repainting.',
            'Kitchen floor tiling needs to be redone.',
            'Solar panel installation for my house.',
            'Ceiling boards falling off, need urgent repair.',
            'Build a concrete fence around my compound.',
        ];

        $ratings = [5, 4, 5, 3, 4, 5, 4, 5];

        foreach ($customers->take(5) as $ci => $customer) {
            $tradesperson = $tradespeople[$ci % $tradespeople->count()];

            $jobRequest = JobRequest::create([
                'customer_id'    => $customer->id,
                'tradesperson_id'=> $tradesperson->id,
                'status'         => 'reviewed',
                'scheduled_date' => now()->subDays(rand(5, 30)),
                'description'    => $descriptions[$ci % count($descriptions)],
            ]);

            Message::create([
                'job_request_id' => $jobRequest->id,
                'senders_id'     => $customer->id,
                'receivers_id'   => $tradesperson->id,
                'message_content'=> $descriptions[$ci % count($descriptions)],
            ]);

            Message::create([
                'job_request_id' => $jobRequest->id,
                'senders_id'     => $tradesperson->id,
                'receivers_id'   => $customer->id,
                'message_content'=> 'Thank you for reaching out. I can handle this job on the scheduled date.',
            ]);

            $rating = $ratings[$ci % count($ratings)];

            Review::create([
                'job_requests_id' => $jobRequest->id,
                'rating'          => $rating,
            ]);

            $profile = TradespersonProfile::where('user_id', $tradesperson->id)->first();
            if ($profile) {
                $profile->increment('reviews');
            }
        }
    }
}
