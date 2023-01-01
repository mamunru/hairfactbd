<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstabdingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstabdings', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('username');
            $table->string('balance');
            $table->string('address');
            $table->string('adjusted');
            $table->string('adjustedbal');
            $table->string('Un_adjusted');
            $table->string('netbal');
            $table->string('pdc');
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
        Schema::dropIfExists('outstabdings');
    }
}
