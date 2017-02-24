<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('itr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_id');
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->string('assessment')->nullable();
            $table->string('laboratory')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('treatment')->nullable();
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
        Schema::dropIfExists('itr');
    }
}
