<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('products', function (Blueprint $collection) {
            $collection->string('name');
            $collection->string('slug')->unique();
            $collection->string('category_id');
            $collection->string('sku')->unique();
            $collection->unsignedInteger('stock');
            $collection->integer('cost_price');
            $collection->integer('sell_price');
            $collection->integer('special_price')->nullable();
            $collection->boolean('status')->default(true);
            $collection->string('image')->nullable();
            $collection->timestamps();
            $collection->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('products');
    }
};
