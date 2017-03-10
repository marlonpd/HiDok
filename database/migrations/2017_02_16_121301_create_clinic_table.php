<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->char('doctor_id',36);
            $table->string('from_time');
            $table->string('to_time');
            $table->tinyInteger('open_sunday')->default(0);
            $table->tinyInteger('open_monday')->default(0);
            $table->tinyInteger('open_tuesday')->default(0);
            $table->tinyInteger('open_wednesday')->default(0);
            $table->tinyInteger('open_thursday')->default(0);
            $table->tinyInteger('open_friday')->default(0);
            $table->tinyInteger('open_saturday')->default(0);
            $table->string('address');
            $table->string('contact_no', 20)->nullable();
            $table->string('gmap_lat')->nullable();
            $table->string('gmap_lng')->nullable();
            $table->integer('default_address')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
}
