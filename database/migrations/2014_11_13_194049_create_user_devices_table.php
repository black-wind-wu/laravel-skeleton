<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('token')->unique();
            $table->string('os', 20);//操作系统
            $table->string('imei')->nullable();//设备的国际移动设备身份码
            $table->string('imsi')->nullable();//设备的国际移动用户识别码
            $table->string('model')->nullable();//设备型号
            $table->string('vendor')->nullable();//设备供应商
            $table->string('version')->nullable();//APP版本
            $table->timestamps();

            $table->unique(['token', 'os']);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_devices');
    }
}
