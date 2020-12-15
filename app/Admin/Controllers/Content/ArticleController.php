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
use App\Admin\Actions\WechatArticleCrawler;
use App\Models\Article;
use App\Services\FileService;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

/**
 * 文章管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '文章';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Article::with(['category', 'tags', 'user']), function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('title', '标题');
                $filter->scope('pending', '待审核')->where('status', Article::STATUS_PENDING);
                $filter->scope('rejected', '已拒绝')->where('status', Article::STATUS_REJECTED);
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->quickSearch(['id', 'title']);

            $grid->column('id', 'ID')->sortable();
            $grid->column('user.username', '作者');
            $grid->column('category.name', '文章类别');
            $grid->column('title', '标题')->display(function ($title) {
                return "<a href='$this->link' target='_blank'>{$title}</a>";
            });
            $grid->column('tag_values', '标签');
            if (request('_scope_') == 'pending' || request('_scope_') == 'rejected') {
                $grid->model()->with('stopWords');
                $grid->column('stopWords.stop_word', '命中敏感词');
            } else {
                $grid->column('views', '查看数');
                $grid->column('comment_count', '评论数');
                $grid->column('support_count', '点赞数');
                $grid->column('collection_count', '收藏数');
                $grid->column('order', '排序权重')->editable();
            }
            $grid->column('status', '状态')->using(Article::getStatusLabels())->dot(Article::getStatusDots(), 'info');
            $grid->column('pub_date', '发布时间')->sortable();
            $grid->paginate(10);

            //待审核
            if (request('_scope_') == 'pending') {
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new ReviewAccept(Article::class));
                    $actions->append(new ReviewReject(Article::class));
                });
            }
            // 回收站
            if (request('_scope_') == 'trashed') {
                $grid->tools(function (Grid\Tools $tools) {
                    $tools->append(new ForceDelete(Article::class));
                });
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new Restore(Article::class));
                });
                $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                    $batch->add(new BatchRestore(Article::class));
                });
            }

            $grid->tools(WechatArticleCrawler::make());
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
        return Show::make($id, Article::with(['category', 'tags', 'detail']), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('title', '标题');
            $show->field('category.name', '文章栏目');
            $show->field('description', '摘要');
            $show->field('thumb', '特色图像')->image();
            $show->field('tag_values', '标签')->explode()->label();
            $show->field('views', '查看数');
            $show->field('comment_count', '评论数');
            $show->field('support_count', '点赞数');
            $show->field('collection_count', '收藏数');
            $show->field('order', '排序权重');
            $show->field('created_at');
            $show->field('updated_at');
            $show->field('pub_date');
            $show->field('detail.content', '文章内容')->unescape();

            $show->tools(function (Show\Tools $tools) {
                $tools->append(new \App\Admin\Actions\Show\ReviewAccept(Article::class));
                $tools->append(new \App\Admin\Actions\Show\ReviewReject(Article::class));
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
        return Form::make(Article::with(['category', 'tags', 'detail']), function (Form $form) {
            $form->block(8, function (Form\BlockForm $form) {
                $form->showFooter();
                $form->tab('基本信息', function (Form\BlockForm $form) {
                    $form->hidden('user_id');
                    $form->text('title', '标题')->required()->rules('string|max:40|min:5|text_censor')->placeholder('内容标题（5-30个中英文字符）。');
                    $form->editor('detail.content', '内容')->required()->rules('string|text_censor')->placeholder('内容正文,限制20000个中英文字符内。');

                    $default_extra_operation = ['extract_summary_automatically_from_content'];
                    if (settings('system.download_remote_pictures')) {
                        $default_extra_operation[] = 'download_remote_pictures';
                        $default_extra_operation[] = 'use_the_first_picture_as_the_thumbnail';
                    }

                    $form->checkbox('extra_operation', false)->options([
                        'download_remote_pictures' => '下载远程图片',
                        'use_the_first_picture_as_the_thumbnail' => '使用第一张图片作为缩略图',
                        'extract_summary_automatically_from_content' => '从内容自动提取摘要',
                    ])->default($default_extra_operation);
                })->tab('Metas', function (Form\BlockForm $form) {
                    $form->embeds('metas', false, function ($form) {
                        $form->text('title', 'Title')->rules('nullable|string|text_censor');
                        $form->text('keywords', 'Keywords')->rules('nullable|string|text_censor');
                        $form->textarea('description', 'Description')->rows(3)->rules('nullable|string|text_censor');
                    });
                })->tab('扩展', function (Form\BlockForm $form) {
                    $form->embeds('detail.extra', false, function ($form) {
                        $form->text('from', '来源名')->rules('nullable|string|text_censor');
                        $form->url('from_url', '来源网址')->rules('nullable|url|text_censor');
                        $form->switch('bd_daily', '百度快速收录')->default(0);
                    });
                });
            });

            $form->block(4, function (Form\BlockForm $form) {
                $form->select('category_id', '栏目')->options(Article::categorySelectOptions())->required();
                $form->tags('tag_values', '标签')->ajax('api/tags', 'name', 'name');
                $form->image('thumb_path', '特色图像')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
                $form->textarea('description', '摘要')->rows(3)->rules('nullable|string|text_censor');
                $form->slider('order', '排序权重')->options(['max' => 100, 'min' => 0, 'step' => 1, 'prefix' => '权重'])->help('权重越大越靠前。');
            });

            //数据保存前的骚操作
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->input('user_id', Admin::user()->user_id);
                }
                //扩展操作
                $extraOperation = array_flip(array_filter($form->input('extra_operation')));
                $form->deleteInput('extra_operation');
                $content = $form->input('detail.content');//取内容

                //远程图片本地化
                if (settings('system.download_remote_pictures') || isset($extraOperation['download_remote_pictures'])) {
                    $content = FileService::handleContentRemoteFile($content);
                    $form->input('detail.content', $content);
                }
                //自动提取缩略图
                if (isset($extraOperation['use_the_first_picture_as_the_thumbnail']) && empty($form->input('thumb_path'))) {
                    if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
                        $form->input('thumb_path', $matches[3][0]);
                    }
                }
                //自动提取摘要
                if (isset($extraOperation['extract_summary_automatically_from_content']) && empty($form->input('description'))) {
                    $description = str_replace(["\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'], '', strip_tags($content));
                    $form->input('description', mb_substr($description, 0, 190));
                }

            });
        });
    }
}
