<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mat', 3)->default('IRE');
            $table->integer('id_setting');
            $table->integer('id_user');
            $table->integer('id_supervisor');
            $table->string('start');
            $table->string('end');
            $table->string('duration');
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('incident_reports');
    }
}
