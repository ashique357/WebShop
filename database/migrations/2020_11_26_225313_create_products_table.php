<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('category_id')->constrained('categories');
            $table->float('price');
            $table->float('discount_price')->nullable();
            $table->float('discount_rate')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_top_seller')->default(0);
            $table->boolean('is_new')->default(0);
            $table->longText('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('products');
    }
}
