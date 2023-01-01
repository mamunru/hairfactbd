<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnpoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returnpolicies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('rate');
            $table->string('mrp');
            $table->string('qty');
            $table->string('userid');
            $table->string('status');
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
        Schema::dropIfExists('returnpolicies');
    }
}
