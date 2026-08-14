<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$categories = [
            // Tipo: Calzado
            ['type_category' => 'Calzado', 'name' => 'Tenis y Sneakers'],
            ['type_category' => 'Calzado', 'name' => 'Botas y Botines'],
            ['type_category' => 'Calzado', 'name' => 'Sandalias y Chinelas'],
            ['type_category' => 'Calzado', 'name' => 'Zapatos Formales'],

            // Tipo: Ropa y Moda
            ['type_category' => 'Ropa y Moda', 'name' => 'Camisetas y Polos'],
            ['type_category' => 'Ropa y Moda', 'name' => 'Pantalones y Jeans'],
            ['type_category' => 'Ropa y Moda', 'name' => 'Chquetas y Abrigos'],
            ['type_category' => 'Ropa y Moda', 'name' => 'Ropa Deportiva'],

            // Tipo: Tecnologia y Electronica
            ['type_category' => 'Tecnologia', 'name' => 'Telefonos y Celulares'],
            ['type_category' => 'Tecnologia', 'name' => 'Computadoras y Laptops'],
            ['type_category' => 'Tecnologia', 'name' => 'Accesorios y Audio'],
            ['type_category' => 'Tecnologia', 'name' => 'Consolas y Videojuegos'],

            // Tipo: Artesanias y Arte
            ['type_category' => 'Artesanias', 'name' => 'Ceramica y Barro'],
            ['type_category' => 'Artesanias', 'name' => 'Textiles y Hamacas'],
            ['type_category' => 'Artesanias', 'name' => 'Madera y Esculturas'],
            ['type_category' => 'Artesanias', 'name' => 'Bisuteria y Joyeria'],

            // Tipo: Alimentos y Bebidas
            ['type_category' => 'Alimentos', 'name' => 'Cafe y Granos'],
            ['type_category' => 'Alimentos', 'name' => 'Miel y Derivados'],
            ['type_category' => 'Alimentos', 'name' => 'Lacteos y Quesos'],
            ['type_category' => 'Alimentos', 'name' => 'Dulces Tradicionales'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
