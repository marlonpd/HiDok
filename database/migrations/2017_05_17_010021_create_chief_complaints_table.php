<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiefComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chief_complaints', function (Blueprint $table) {
            $table->uuid('id');
            $table->char('consultation_id',36);
            $table->char('patient_id',36);
            $table->char('doctor_id',36);
            $table->string('symptom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chief_complaints');
    }
}
