<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_codes', function (Blueprint $table) {
            $table->id()->comment('验证码ID');
            $table->string('mobile', 20)->default('')->comment('手机号');
            $table->string('code', 10)->default('')->comment('验证码');
            $table->string('scenario', 20)->default('')->comment('使用场景');
            $table->tinyInteger('state')->default(0)->comment('验证状态');
            $table->ipAddress('ip')->default('')->comment('ip');
            $table->timestamp('expired_at')->nullable()->comment('验证码过期时间');
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
        Schema::dropIfExists('mobile_codes');
    }
}
