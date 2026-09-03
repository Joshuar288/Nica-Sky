<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos el ID de la primera ciudad (Managua)
        $city = DB::table('cities')->first();

        $admins = [
            [
                'name' => 'Joshuar',
                'email' => 'joshuar@admin.com',
                'phone' => '88888888',
                'name_bussines' => 'Admin Central',
            ],
            [
                'name' => 'Ulises',
                'email' => 'ulises@admin.com',
                'phone' => '87777777',
                'name_bussines' => 'Admin Central',
            ],
        ];

        foreach ($admins as $admin) {
            User::create([
                'city_id' => $city ? $city->id : null,
                'name' => $admin['name'],
                'phone' => $admin['phone'],
                'email' => $admin['email'],
                'name_bussines' => $admin['name_bussines'],
                'is_verified' => true,
                'email_verified_at' => now(),
                'role' => UserRole::Admin,
                'plan' => 'pro_3',
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
