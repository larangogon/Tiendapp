<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\Product;
use App\Models\Size;
use App\Models\Trademark;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::factory(Product::class, 3)->create();

        $sizes = Size::all();

        $trademark = Trademark::all();

        Product::inRandomOrder()->each(function ($product) use ($sizes, $trademark) {

            $product->sizes()->attach(
                $sizes->random(rand(1, 5))->pluck('id')->toArray()
            );

            $product->categories()->attach(
                $trademark->random(1)->pluck('id')->toArray()
            );

            \App\Models\Imagen::factory(Imagen::class, rand(1, 2))->create([
                'product_id' => $product->id
            ]);
        });
    }
}
