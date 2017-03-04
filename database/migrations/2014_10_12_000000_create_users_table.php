<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('gender',10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('account_type')->default(0);
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('weight',6)->nullable();
            $table->string('height',6)->nullable();
            $table->string('religion',80)->nullable();
            $table->string('photo')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('specialization',80)->nullable();
            $table->timestamp('birthdate')->nullable();
            $table->string('health_history')->nullable();
            $table->string('consultation_fee',40)->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
