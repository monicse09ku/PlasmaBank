<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('age');
            $table->string('weight');
            $table->string('blood_group');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('device_id')->nullable();
            $table->boolean('is_donor')->default(0);
            $table->boolean('is_verified')->default(0);
            $table->date('test_positive_date')->nullable();
            $table->date('test_negative_date')->nullable();
            $table->date('test_negative_date_second')->nullable();
            $table->date('last_donation_date')->nullable();
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
        Schema::dropIfExists('user_infos');
    }
}
