<?php

use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Purchase::class, 10)->create()->each(function ($purchase) {
            $product = App\Product::inRandomOrder()->first();
            factory(App\PurchaseItem::class, 10)->create([
                'purchase_id' => $purchase->id,
                //        'product_id' => $product->id,
                'name' => $product->name,
                //'code' => $product->code,
                'price' => $product->unit_price,
            ]);
        });
    }
}
