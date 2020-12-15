<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Content;

use App\Models\Article;
use App\Models\Category;
use App\Models\News;
use App\Services\FileService;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

/**
 * 快讯
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NewsController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '快讯';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new News, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->quickSearch(['id', 'title']);

            $grid->column('id', 'ID')->sortable();
            $grid->column('from', '来源')->display(function ($from) {
                if ($this->from_url) {
                    return "<a href='$this->from_url' target='_blank'>{$from}</a>";
                }
                return $from;
            });
            $grid->column('title', '标题')->display(function ($title) {
                return "<a href='$this->link' target='_blank'>{$title}</a>";
            });
            $grid->column('keywords', '关键词');
            $grid->column('tag_values', '标签');
            $grid->column('views', '查看数');
            $grid->column('created_at', '发布时间')->sortable();
            $grid->paginate(10);
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
        return Show::make($id, News::query(), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('title', '标题');
            $show->field('description', '摘要');
            $show->field('views', '查看数');
            $show->field('tag_values', '标签')->explode()->label();
            $show->field('from', '来源');
            $show->field('from_url', '来源网址');
            $show->field('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(News::query(), function (Form $form) {
            $form->text('title', '标题')->required()->rules('string|max:40|min:2|text_censor')->placeholder('请输入文字标题（一般不超过30个汉字）');
            $form->text('keywords', '关键词')->rules('nullable|string|text_censor')->placeholder('请输入关键词（一般不超过100个汉字）');
            $form->tags('tag_values', '标签')->ajax('api/tags', 'name', 'name');
            $form->textarea('description', '摘要')->rows(3)->rules('nullable|string|text_censor')->placeholder('请输入描述（一般不超过200个汉字）');
            $form->text('from', '来源名')->rules('nullable|string|text_censor');
            $form->url('from_url', '来源网址')->rules('nullable|url|text_censor');
        });
    }
}
