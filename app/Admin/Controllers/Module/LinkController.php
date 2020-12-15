<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use App\Models\Link;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

/**
 * 友情链接
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LinkController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '友情链接';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Link(), function (Grid $grid) {
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('type', '类型', Link::getTypeLabels());
            });

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id', 'ID');
                $filter->like('title', '名称');
                $filter->like('url', 'Url');
                //顶部筛选
                $filter->scope('expired', '已经到期')->where('expired_at', '>', now());
            });
            $grid->quickSearch(['id', 'title']);
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id', 'ID')->sortable();
            $grid->column('type', '链接类型')->using(Link::getTypeLabels());
            $grid->column('title', '链接名称')->title();
            $grid->column('url')->link();
            $grid->column('logo')->image();
            $grid->description('链接描述');
            $grid->column('expired_at', '过期时间');
            $grid->column('created_at', '创建时间')->sortable();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
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
        return Show::make($id, Link::query(), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('title', '链接名称');
            $show->field('url', 'Url')->link();
            $show->field('logo', '链接Logo')->image();
            $show->field('description', '链接描述');
            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
            $show->field('expired_at', '过期时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Link(), function (Form $form) {
            $form->radio('type', '链接类型')->options(Link::getTypeLabels())->required()->default(Link::TYPE_HOME);
            $form->text('title', '链接名称')->required();
            $form->url('url', 'Url')->required();
            $form->image('logo_path', '链接Logo')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
            $form->text('description', '链接描述');
            $form->datetime('expired_at', '过期时间');
        });
    }
}
