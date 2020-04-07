<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')
                ->constrained()
                ->onDelete('cascade');

            // $table->foreignId('product_id')
            //     ->constrained()
            //     ->onDelete('cascade');

            $table->string('name')->nullable();
            //  $table->string('code')->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->float('quantity', 5, 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
