<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuditorUserSeeder extends Seeder
{
    public function run(): void
    {
        $city = DB::table('cities')->first();

        User::updateOrCreate(
            ['email' => 'auditor@nicasky.com'],
            [
                'city_id' => $city?->id,
                'name' => 'Auditor NicaSky',
                'phone' => '86666666',
                'role' => 'auditor',
                'is_verified' => true,
                'password' => Hash::make('password123'),
            ]
        );
    }
}
