<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();
        $productVariants = ProductVariant::all();

        if ($productVariants->isEmpty()) {
            $this->command->info('No product variants found. Please run the ProductSeeder first.');
            return;
        }

        $users->each(function ($user) use ($productVariants) {
            $address = \App\Models\Address::factory()->create(['user_id' => $user->id]);

            Order::factory()->count(rand(1, 5))->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
            ])->each(function ($order) use ($productVariants) {
                $selectedVariants = $productVariants->random(rand(1, 3));
                foreach ($selectedVariants as $variant) {
                    $order->items()->create([
                        'product_variant_id' => $variant->id,
                        'quantity' => rand(1, 3),
                        'price' => $variant->product->price, // Assuming product price is base price
                    ]);
                }
                // Update order total amount after items are added
                $order->total_amount = $order->items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
                $order->save();
            });
        });
    }
}
