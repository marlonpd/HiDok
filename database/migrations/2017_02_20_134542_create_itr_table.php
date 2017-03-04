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
            $table->uuid('id');
            $table->primary('id');
            $table->char('appointment_id',36);
            $table->char('doctor_id',36);
            $table->char('patient_id',36);
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
