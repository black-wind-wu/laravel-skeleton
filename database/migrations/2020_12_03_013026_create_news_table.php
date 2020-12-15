<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->string('description', 1000)->nullable()->comment('描述');
            $table->unsignedInteger('views')->nullable()->default(0)->comment('查看次数');
            $table->string('from')->nullable()->comment('来源');
            $table->string('from_url')->nullable()->comment('原文链接');
            $table->date('pub_date')->nullable()->comment('发表时间');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
