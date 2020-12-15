<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('provider', 32);
            $table->string('social_id');
            $table->string('union_id')->index()->nullable();//UnionID
            $table->string('name')->nullable()->comment('Name');
            $table->string('nickname')->nullable()->comment('NickName');
            $table->string('email')->nullable()->comment('email');
            $table->string('avatar')->nullable()->comment('avatar');
            $table->string('access_token')->nullable();//访问令牌
            $table->dateTime('token_expires_at')->nullable();//访问令牌过期时间
            $table->string('refresh_token')->nullable();//刷新令牌
            $table->json('data')->nullable()->comment('Data');
            $table->timestamps();

            $table->unique(['provider','social_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_social_accounts');
    }
}
