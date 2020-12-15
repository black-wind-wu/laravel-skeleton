<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id')->comment('栏目ID');
            $table->unsignedBigInteger('user_id')->nullable()->index()->comment('作者ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('description')->nullable()->comment('描述');
            $table->boolean('recommend')->default(false)->nullable()->comment('是否推荐');
            $table->unsignedInteger('views')->nullable()->default(0)->comment('查看次数');
            $table->unsignedInteger('download_count')->nullable()->default(0)->comment('下载数量');
            $table->unsignedInteger('comment_count')->nullable()->default(0)->comment('评论数量');
            $table->unsignedInteger('support_count')->nullable()->default(0)->comment('点赞数量');
            $table->unsignedInteger('collection_count')->nullable()->default(0)->comment('收藏数量');
            $table->unsignedInteger('score')->nullable()->default(0)->comment('需要积分');
            $table->unsignedTinyInteger('status');
            $table->string('file_path')->comment('文件存储路径');
            $table->string('file_name')->nullable()->comment('文件名');
            $table->string('file_type')->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->string('file_hash')->nullable();
            $table->text('file_list')->nullable();
            $table->json('metas')->nullable()->comment('元数据');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'recommend', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}
