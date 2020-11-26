<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVarOptsValsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_var_opts_vals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_var_opt_id')->constrained('product_var_opts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('product_var_opts_vals');
    }
}
