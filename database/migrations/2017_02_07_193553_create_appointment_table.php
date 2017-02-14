<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->timestamp('appointment_date');
            $table->integer('creator_id')->default(0); //creator of the appointment
            $table->integer('re_schedule_by_id')->default(0);//last to reschedule the appoint doctor or patient
            $table->string('note');
            $table->tinyInteger('confirmed')->default(0); // 0 not confirm, 1 confirmed 
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
        Schema::dropIfExists('appointment');
    }
}
