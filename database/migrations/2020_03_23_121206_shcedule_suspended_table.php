<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShceduleSuspendedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_suspended', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_operator')->nullable();
            $table->string('mat', 3)->default('SCS');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('schedule_suspended');
    }
}
