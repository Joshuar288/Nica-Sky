<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
                'name'          => 'Joshuar',
                'email'         => 'joshuar@admin.com',
                'phone'         => '88888888',
                'name_bussines' => 'Admin Central',
            ],
            [
                'name'          => 'Ulises',
                'email'         => 'ulises@admin.com',
                'phone'         => '87777777',
                'name_bussines' => 'Admin Central',
            ],
        ];

        foreach ($admins as $admin) {
            User::create([
                'city_id'       => $city ? $city->id : null,
                'name'          => $admin['name'],
                'phone'         => $admin['phone'],
                'email'         => $admin['email'],
                'name_bussines' => $admin['name_bussines'],
                'is_verified'   => true, // Adaptado a string según tu migración $table->string('is_verified')
                'password'      => Hash::make('password123'), // Contraseña por defecto
            ]);
        }
    }
}
