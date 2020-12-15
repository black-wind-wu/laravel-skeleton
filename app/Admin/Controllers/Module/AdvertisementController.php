<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use App\Models\Advertisement;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;
use Larva\Supports\HtmlHelper;

/**
 * 广告管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AdvertisementController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '广告管理';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Advertisement(), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
            });
            $grid->quickSearch(['id', 'name']);
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', 'ID')->sortable();
            $grid->column('name', '广告名称');
            $grid->column('enabled', '状态')->switch();
            $grid->column('html','调用代码')->display('查看')
                ->modal(function ($modal) {
                    // 设置弹窗标题
                    $modal->title('调用代码');
                    $adCode = HtmlHelper::encode($this->html);
                    return "<div style='padding:10px 10px 0'><pre>{$adCode}</pre></div>";
                });
            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('updated_at', '更新时间')->sortable();
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
        return Show::make($id, Advertisement::query(), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('name', '名称');
            $show->field('enabled', '状态');
            $show->field('created_at','创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Advertisement(), function (Form $form) {
            $form->text('name', '广告名称')->required();
            $form->switch('enabled', '状态');
            $form->textarea('body', '广告内容')->required();
        });
    }
}
