<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use App\Models\Carousel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 轮播
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CarouselController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '轮播';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Carousel(), function (Grid $grid) {
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('type', '位置', Carousel::getTypeLabels());
            });

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
            });
            $grid->quickSearch(['id', 'name']);
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', 'ID')->sortable();
            $grid->column('type', '位置')->using(Carousel::getTypeLabels());
            $grid->column('name', '名称');
            $grid->column('url','连接')->link();
            $grid->column('image','轮播图')->image();
            $grid->column('order', '排序')->orderable();
            $grid->column('created_at','创建时间')->sortable();
            $grid->column('updated_at','更新时间')->sortable();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->paginate(10);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Carousel(), function (Form $form) {
            $form->radio('type', '位置')->options(Carousel::getTypeLabels())->required()->default(Carousel::TYPE_HOME);
            $form->text('name', '名称')->required();
            $form->url('url', 'Url')->required();
            $form->text('order', '排序')->default(0);
            $form->image('image_path', '图片')->required()->rules('image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
        });
    }
}
