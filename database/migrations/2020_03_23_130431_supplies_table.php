<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_provider')->unsigned();
            $table->integer('id_department')->unsigned();
            $table->string('mat', 3)->default('SUP');
            $table->string('name');
            $table->integer('quantity');
            $table->float('price', 8, 2)->default(00.00);
            $table->float('cost', 8, 2)->default(00.00);
            $table->float('total_price',8, 2)->default(00.00);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('supplies');
    }
}
