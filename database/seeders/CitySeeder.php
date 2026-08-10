<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Managua
            ['name_departament' => 'Managua', 'name_city' => 'Managua'],
            ['name_departament' => 'Managua', 'name_city' => 'Tipitapa'],
            ['name_departament' => 'Managua', 'name_city' => 'Ciudad Sandino'],
            ['name_departament' => 'Managua', 'name_city' => 'Mateare'],
            ['name_departament' => 'Managua', 'name_city' => 'El Crucero'],
            ['name_departament' => 'Managua', 'name_city' => 'Ticuantepe'],
            ['name_departament' => 'Managua', 'name_city' => 'San Rafael del Sur'],
            ['name_departament' => 'Managua', 'name_city' => 'Villa El Carmen'],
            ['name_departament' => 'Managua', 'name_city' => 'San Francisco Libre'],

            // León
            ['name_departament' => 'León', 'name_city' => 'León'],
            ['name_departament' => 'León', 'name_city' => 'Nagarote'],
            ['name_departament' => 'León', 'name_city' => 'La Paz Centro'],
            ['name_departament' => 'León', 'name_city' => 'Telica'],
            ['name_departament' => 'León', 'name_city' => 'El Jicaral'],

            // Masaya
            ['name_departament' => 'Masaya', 'name_city' => 'Masaya'],
            ['name_departament' => 'Masaya', 'name_city' => 'Nindirí'],
            ['name_departament' => 'Masaya', 'name_city' => 'Monimbó'],
            ['name_departament' => 'Masaya', 'name_city' => 'Catarina'],
            ['name_departament' => 'Masaya', 'name_city' => 'Niquinohomo'],

            // Granada
            ['name_departament' => 'Granada', 'name_city' => 'Granada'],
            ['name_departament' => 'Granada', 'name_city' => 'Nandaime'],
            ['name_departament' => 'Granada', 'name_city' => 'Diriomo'],
            ['name_departament' => 'Granada', 'name_city' => 'Diriá'],

            // Carazo
            ['name_departament' => 'Carazo', 'name_city' => 'Jinotepe'],
            ['name_departament' => 'Carazo', 'name_city' => 'Diriamba'],
            ['name_departament' => 'Carazo', 'name_city' => 'San Marcos'],

            // Chinandega
            ['name_departament' => 'Chinandega', 'name_city' => 'Chinandega'],
            ['name_departament' => 'Chinandega', 'name_city' => 'El Viejo'],
            ['name_departament' => 'Chinandega', 'name_city' => 'Corinto'],
            ['name_departament' => 'Chinandega', 'name_city' => 'Chichigalpa'],

            // Rivas
            ['name_departament' => 'Rivas', 'name_city' => 'Rivas'],
            ['name_departament' => 'Rivas', 'name_city' => 'San Juan del Sur'],
            ['name_departament' => 'Rivas', 'name_city' => 'Tola'],
            ['name_departament' => 'Rivas', 'name_city' => 'Moyogalpa'],
            ['name_departament' => 'Rivas', 'name_city' => 'Altagracia'],

            // Estelí
            ['name_departament' => 'Estelí', 'name_city' => 'Estelí'],
            ['name_departament' => 'Estelí', 'name_city' => 'Condega'],
            ['name_departament' => 'Estelí', 'name_city' => 'Pueblo Nuevo'],
            ['name_departament' => 'Estelí', 'name_city' => 'San Juan de Limay'],
            ['name_departament' => 'Estelí', 'name_city' => 'La Trinidad'],
            ['name_departament' => 'Estelí', 'name_city' => 'San Nicolás'],

            // Madriz
            ['name_departament' => 'Madriz', 'name_city' => 'Somoto'],
            ['name_departament' => 'Madriz', 'name_city' => 'Yalagüina'],
            ['name_departament' => 'Madriz', 'name_city' => 'Palacagüina'],
            ['name_departament' => 'Madriz', 'name_city' => 'San Lucas'],

            // Nueva Segovia
            ['name_departament' => 'Nueva Segovia', 'name_city' => 'Ocotal'],
            ['name_departament' => 'Nueva Segovia', 'name_city' => 'Jalapa'],
            ['name_departament' => 'Nueva Segovia', 'name_city' => 'Jícaro'],
            ['name_departament' => 'Nueva Segovia', 'name_city' => 'Wiwilí de Nueva Segovia'],

            // Matagalpa
            ['name_departament' => 'Matagalpa', 'name_city' => 'Matagalpa'],
            ['name_departament' => 'Matagalpa', 'name_city' => 'Sébaco'],
            ['name_departament' => 'Matagalpa', 'name_city' => 'Ciudad Darío'],
            ['name_departament' => 'Matagalpa', 'name_city' => 'San Ramón'],
            ['name_departament' => 'Matagalpa', 'name_city' => 'Matiguás'],

            // Jinotega
            ['name_departament' => 'Jinotega', 'name_city' => 'Jinotega'],
            ['name_departament' => 'Jinotega', 'name_city' => 'San Rafael del Norte'],
            ['name_departament' => 'Jinotega', 'name_city' => 'Pantasma'],
            ['name_departament' => 'Jinotega', 'name_city' => 'Wiwilí de Jinotega'],

            // Boaco
            ['name_departament' => 'Boaco', 'name_city' => 'Boaco'],
            ['name_departament' => 'Boaco', 'name_city' => 'Camoapa'],
            ['name_departament' => 'Boaco', 'name_city' => 'San Lorenzo'],

            // Chontales
            ['name_departament' => 'Chontales', 'name_city' => 'Juigalpa'],
            ['name_departament' => 'Chontales', 'name_city' => 'Acoyapa'],
            ['name_departament' => 'Chontales', 'name_city' => 'Santo Tomás'],

            // Río San Juan
            ['name_departament' => 'Río San Juan', 'name_city' => 'San Carlos'],
            ['name_departament' => 'Río San Juan', 'name_city' => 'El Castillo'],
            ['name_departament' => 'Río San Juan', 'name_city' => 'San Miguelito'],

            // RACCN
            ['name_departament' => 'RACCN', 'name_city' => 'Puerto Cabezas (Bilwi)'],
            ['name_departament' => 'RACCN', 'name_city' => 'Waspam'],
            ['name_departament' => 'RACCN', 'name_city' => 'Siuna'],
            ['name_departament' => 'RACCN', 'name_city' => 'Rosita'],
            ['name_departament' => 'RACCN', 'name_city' => 'Bonanza'],

            // RACCS
            ['name_departament' => 'RACCS', 'name_city' => 'Bluefields'],
            ['name_departament' => 'RACCS', 'name_city' => 'El Rama'],
            ['name_departament' => 'RACCS', 'name_city' => 'Nueva Guinea'],
            ['name_departament' => 'RACCS', 'name_city' => 'Corn Island'],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name_departament' => $city['name_departament'],
                'name_city'        => $city['name_city'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
