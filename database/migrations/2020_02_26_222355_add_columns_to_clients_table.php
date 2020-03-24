<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('name');
            $table->integer('time_zone');
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->string('documents')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('status')->default(1);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
        // Schema::table('clients', function (Blueprint $table) {
        //     $table->dropColumn('name');
        //     $table->dropColumn('description');
        //     $table->dropColumn('color');
        //     $table->dropColumn('documents');
        //     $table->dropColumn('updated_by');
        //     $table->dropColumn('status');
        // });
    }
}
