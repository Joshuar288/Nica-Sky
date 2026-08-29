<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use LogicException;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (! User::query()->exists() || ! Category::query()->exists()) {
            throw new LogicException('Debes registrar usuarios y categorías antes de ejecutar ProductSeeder.');
        }

        $images = collect(File::files(public_path('images')))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']))
            ->values();

        if ($images->isEmpty()) {
            throw new LogicException('No se encontraron imágenes en public/images.');
        }

        DB::transaction(function () use ($images) {
            Product::query()->delete();

            for ($index = 1; $index <= 100; $index++) {
                $image = $images->random();
                $baseName = pathinfo($image->getFilename(), PATHINFO_FILENAME);
                $productName = ucfirst(str_replace('_', ' ', preg_replace('/^\d+_/', '', $baseName)));

                $product = Product::factory()->create([
                    'title' => $productName.' '.$index,
                ]);

                if ($product->user->plan === 'pro_3') {
                    $product->update(['is_recommended' => true]);
                }

                Image::create([
                    'product_id' => $product->id,
                    'rute' => 'images/'.$image->getFilename(),
                    'is_first' => true,
                ]);
            }
        });
    }
}
