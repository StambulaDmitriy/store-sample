<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $stores = Store::factory(10)->create();
        $products = Product::factory(10)->create();

        foreach ($stores as $store) {
            $products_assoc = [];

            foreach($products->random(rand(1,5)) as $product) {
                $products_assoc[$product->id] = [
                    'stock_quantity' => rand(1,1000)
                ];
            }

            Log::debug($products_assoc);

            $store->products()->attach($products_assoc);
        }
    }
}
