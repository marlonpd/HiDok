<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualTreatmentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_treatment_record', function (Blueprint $table) {
            $table->uuid('id');
            $table->char('consultation_id',36);
            $table->char('patient_id',36);
            $table->char('doctor_id',36);
            $table->string('value')->nullable();
            $table->string('type',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_treatment_record');
    }
}
