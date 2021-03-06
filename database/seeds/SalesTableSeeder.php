<?php

use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Sale::class, 10)->create()->each(function ($sale) {
            $product = App\Product::inRandomOrder()->first();
            factory(App\SaleItem::class, 10)->create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->unit_price,
                'total' => $product->unit_price,
            ]);
        });

    }
}
