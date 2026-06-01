<?php

namespace Database\Seeders;

use App\Models\TradespersonProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class TradespersonProfileSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['plumbing', 'electrical', 'carpentry', 'welding', 'masonry'];

        $bios = [
            'Experienced plumber with over 8 years fixing leaks, installing pipes, and handling bathroom renovations across Dar es Salaam.',
            'Certified electrician specializing in wiring, solar installations, and electrical fault diagnosis. Safety-first approach.',
            'Skilled carpenter crafting furniture, cabinets, and wooden structures. Attention to detail and quality finishes.',
            'Professional welder with expertise in fabrication, gates, and metalwork. Fast turnaround on custom orders.',
            'Masonry expert handling foundations, bricklaying, and tiling. Over 10 years building strong structures.',
            'Reliable plumber known for prompt service and clean workmanship. Available for both residential and commercial jobs.',
            'Electrician with deep knowledge of solar, inverters, and smart home systems. Serving Arusha and surroundings.',
            'Carpenter offering custom furniture and joinery. Each piece built to last.',
            'Welder and fabricator specializing in roofing frames, staircases, and decorative ironwork.',
            'Experienced mason offering plastering, tiling, and construction finishing works.',
        ];

        $tradespeople = User::where('role', 'tradesperson')->get();

        foreach ($tradespeople as $index => $user) {
            if (TradespersonProfile::where('user_id', $user->id)->exists()) {
                continue;
            }

            TradespersonProfile::create([
                'user_id'             => $user->id,
                'category'            => $categories[$index % count($categories)],
                'bio'                 => $bios[$index] ?? 'Experienced tradesperson ready to help.',
                'availability_status' => $index % 4 === 0 ? 'unavailable' : 'available',
                'reviews'             => 0,
            ]);
        }
    }
}
