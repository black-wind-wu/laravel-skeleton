<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username', 50)->unique()->nullable()->comment('用户名');//用户名。
            $table->string('email', 64)->unique()->nullable()->comment('邮箱');//邮箱
            $table->string('mobile', 11)->unique()->nullable()->comment('手机号');//手机号码
            $table->string('avatar_path', 191)->nullable();//头像地址
            $table->string('password')->comment('密码');
            $table->boolean('disabled')->default(false)->nullable();//是否被禁用
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('first_sign_in_at')->nullable()->comment('开始签到时间');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
