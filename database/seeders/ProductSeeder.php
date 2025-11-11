<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Color;
use App\Models\Product;
use App\Models\Taille;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories, Tailles, Colors
        $categories = Categorie::factory()->count(5)->create();
        $tailles = Taille::factory()->count(4)->create();
        $colors = Color::factory()->count(6)->create();

        // 2. Create Products
        Product::factory()->count(20)->create([
            'category_id' => $categories->random()->id,
        ])->each(function ($product) use ($tailles, $colors) {
            // 3. For each product, create a few variants
            $numberOfVariants = rand(2, 5);
            for ($i = 0; $i < $numberOfVariants; $i++) {
                $product->variants()->create([
                    'taille_id' => $tailles->random()->id,
                    'color_id' => $colors->random()->id,
                    'quantity' => rand(5, 50),
                ]);
            }
        });
    }
}