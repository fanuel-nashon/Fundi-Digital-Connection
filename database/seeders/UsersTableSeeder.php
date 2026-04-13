<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {

        $admins = [
            ['name' => 'Abdul Mussa', 'email' => 'abdul.admin@gmail.com', 'location' => 'Dar es Salaam'],
            ['name' => 'Neema Joseph', 'email' => 'neema.admin@gmail.com', 'location' => 'Dodoma'],
            ['name' => 'Hassan Mwinyi', 'email' => 'hassan.admin@gmail.com', 'location' => 'Zanzibar'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'location' => $admin['location'],
                'email_verified_at' => now(),
            ]);
        }


        $customers = [
            ['Asha Said', 'asha.customer@gmail.com', 'Dar es Salaam'],
            ['John Mwakalinga', 'john.customer@gmail.com', 'Mbeya'],
            ['Rehema Suleiman', 'rehema.customer@gmail.com', 'Tanga'],
            ['Peter Nyerere', 'peter.customer@gmail.com', 'Mwanza'],
            ['Fatma Omari', 'fatma.customer@gmail.com', 'Zanzibar'],
            ['Kelvin Mgaya', 'kelvin.customer@gmail.com', 'Morogoro'],
            ['Sophia Mushi', 'sophia.customer@gmail.com', 'Arusha'],
            ['George Lema', 'george.customer@gmail.com', 'Kilimanjaro'],
            ['Salma Kassim', 'salma.customer@gmail.com', 'Dodoma'],
            ['Victor Chacha', 'victor.customer@gmail.com', 'Mara'],
        ];

        foreach ($customers as $cust) {
            User::create([
                'name' => $cust[0],
                'email' => $cust[1],
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'location' => $cust[2],
                'email_verified_at' => now(),
            ]);
        }


        $tradespersons = [
            ['Juma Fundi', 'juma.trades@gmail.com', 'Dar es Salaam'],
            ['Moses Mafundi', 'moses.trades@gmail.com', 'Arusha'],
            ['Ali Mchomeleaji', 'ali.trades@gmail.com', 'Dodoma'],
            ['Isack Umeme', 'isack.trades@gmail.com', 'Mwanza'],
            ['Baraka Seremala', 'baraka.trades@gmail.com', 'Mbeya'],
            ['Hamisi Painter', 'hamisi.trades@gmail.com', 'Tanga'],
            ['Rajabu Plumber', 'rajabu.trades@gmail.com', 'Morogoro'],
            ['Said Tiles', 'said.trades@gmail.com', 'Zanzibar'],
            ['Edwin Builder', 'edwin.trades@gmail.com', 'Kilimanjaro'],
            ['Yusuph Technician', 'yusuph.trades@gmail.com', 'Singida'],
        ];

        foreach ($tradespersons as $trade) {
            User::create([
                'name' => $trade[0],
                'email' => $trade[1],
                'password' => Hash::make('password123'),
                'role' => 'tradesperson',
                'location' => $trade[2],
                'email_verified_at' => now(),
            ]);
        }
    }
}
