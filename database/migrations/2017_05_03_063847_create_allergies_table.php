<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Si Pete Enrile hinung ani nganung naguba ang naming convention
        Schema::create('Allergy', function (Blueprint $table) {    
            $table->char('AllergyID',36);
            $table->char('PatientID',36);
            $table->string('Allergy',45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('allergies', function (Blueprint $table) {
            //
        });
    }
}
