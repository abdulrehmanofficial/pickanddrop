<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_type');
            $table->string('vehicle_num');
            $table->string('licence_image');
            $table->string('certificate_image');
            $table->string('lat')->default(0);
            $table->string('long')->default(0);
            $table->boolean('on_route')->default(false);
            $table->integer('user_id');
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
        Schema::dropIfExists('driver_datas');
    }
}
