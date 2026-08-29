<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            'Camiseta clásica', 'Zapatos deportivos', 'Bolso artesanal',
            'Café premium', 'Audífonos inalámbricos', 'Silla de madera',
            'Teléfono inteligente', 'Hamaca tradicional', 'Miel natural',
            'Mochila casual', 'Reloj moderno', 'Juego de cerámica',
            'Computadora portátil', 'Pantalón de mezclilla', 'Queso artesanal',
        ];

        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'title' => fake()->randomElement($products).' '.fake()->unique()->numberBetween(100, 9999),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 50, 50000),
            'unit' => fake()->randomElement(['unidad', 'pieza', 'par', 'libra', 'paquete']),
            'stock' => fake()->numberBetween(0, 100),
            'state' => fake()->randomElement(['Nuevo', 'Usado', 'Reacondicionado']),
            'views_count' => fake()->numberBetween(0, 5000),
        ];
    }
}
