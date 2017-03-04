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
            $table->uuid('id');
            $table->primary('id');
            $table->char('clinic_id',36);
            $table->char('doctor_id',36);
            $table->char('patient_id',36);
            $table->timestamp('appointment_date');
            $table->char('creator_id',36)->default(0); //creator of the appointment
            $table->char('re_schedule_by_id',36)->default(0);//last to reschedule the appoint doctor or patient
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
