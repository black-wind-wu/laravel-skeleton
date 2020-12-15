<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\ForceDelete;
use App\Admin\Actions\Grid\Restore;
use App\Admin\Actions\Grid\ReviewAccept;
use App\Admin\Actions\Grid\ReviewReject;
use App\Models\Download;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

/**
 * 下载管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DownloadController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '下载';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Download::with(['category', 'tags', 'user']), function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('title', '标题');
                $filter->scope('pending', '待审核')->where('status', Download::STATUS_PENDING);
                $filter->scope('rejected', '已拒绝')->where('status', Download::STATUS_REJECTED);
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->quickSearch(['id', 'title']);

            $grid->column('id', 'ID')->sortable();
            $grid->column('user.username', '作者');
            $grid->column('category.name', '类别');
            $grid->column('title', '标题')->display(function ($title) {
                return "<a href='$this->link' target='_blank'>{$title}</a>";
            });
            $grid->column('tag_values', '标签');
            if (request('_scope_') == 'pending' || request('_scope_') == 'rejected') {
                $grid->model()->with('stopWords');
                $grid->column('stopWords.stop_word', '命中敏感词');
            } else {
                $grid->column('download_count', '下载数');
                $grid->column('comment_count', '评论数');
                $grid->column('support_count', '点赞数');
                $grid->column('collection_count', '收藏数');
                $grid->column('recommend', '推荐')->switch();
            }
            $grid->column('status', '状态')->using(Download::getStatusLabels())->dot(Download::getStatusDots(), 'info');

            $grid->paginate(10);

            //待审核
            if (request('_scope_') == 'pending') {
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new ReviewAccept(Download::class));
                    $actions->append(new ReviewReject(Download::class));
                });
            }
            // 回收站
            if (request('_scope_') == 'trashed') {
                $grid->tools(function (Grid\Tools $tools) {
                    $tools->append(new ForceDelete(Download::class));
                });
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new Restore(Download::class));
                });
                $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                    $batch->add(new BatchRestore(Download::class));
                });
            }

        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, Download::with(['category', 'tags']), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('title', '标题');
            $show->field('category.name', '栏目');
            $show->field('description', '摘要');
            $show->field('thumb', '特色图像')->image();
            $show->field('tag_values', '标签')->explode()->label();
            $show->field('views', '查看数');
            $show->field('download_count', '下载数');
            $show->field('comment_count', '评论数');
            $show->field('support_count', '点赞数');
            $show->field('collection_count', '收藏数');
            $show->field('created_at');
            $show->field('updated_at');

            $show->tools(function (Show\Tools $tools) {
                $tools->append(new \App\Admin\Actions\Show\ReviewAccept(Download::class));
                $tools->append(new \App\Admin\Actions\Show\ReviewReject(Download::class));
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(Download::with(['category', 'tags']), function (Form $form) {
            $form->block(8, function (Form\BlockForm $form) {
                $form->showFooter();
                $form->tab('基本信息', function (Form\BlockForm $form) {
                    $form->hidden('user_id');
                    $form->text('title', '标题')->required()->rules('string|max:40|min:5|text_censor')->placeholder('标题（5-30个中英文字符）。');
                    $form->textarea('description', '摘要')->rows(3)->rules('nullable|string|text_censor');
                    $form->file('file_path', '上传文件')->required()
                        ->accept('7z,doc,docx,exe,gz,jar,pdf,ppt,pptx,rar,txt,xls,xlsx,zip')
                        ->chunkSize(4096)->maxSize(10240 * 100)
                        ->dir('temp')->autoUpload()->help('最大上传100M的文件。');
                })->tab('Metas', function (Form\BlockForm $form) {
                    $form->embeds('metas', false, function ($form) {
                        $form->text('title', 'Title')->rules('nullable|string|text_censor');
                        $form->text('keywords', 'Keywords')->rules('nullable|string|text_censor');
                        $form->textarea('description', 'Description')->rows(3)->rules('nullable|string|text_censor');
                    });
                });
            });

            $form->block(4, function (Form\BlockForm $form) {
                $form->select('category_id', '栏目')->options(Download::categorySelectOptions())->required();
                $form->switch('recommend', '推荐');
                $form->text('score', '积分')->default(1)->required();
                $form->tags('tag_values', '标签')->ajax('api/tags', 'name', 'name');
            });

            //数据保存前的骚操作
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->input('user_id', Admin::user()->user_id);
                }
            });
        });
    }
}
