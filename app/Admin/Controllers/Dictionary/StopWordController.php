<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Dictionary;

use Larva\Censor\Models\StopWord;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

/**
 * 敏感词管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StopWordController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '敏感词';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new StopWord(), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
            });
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id', 'ID')->sortable();
            $grid->column('find', '敏感词');
            $grid->column('ugc', '内容处理方式')->using(StopWord::getUGCActions());
            $grid->column('replacement', '替换规则');
            $grid->column('created_at','创建时间')->sortable();
            $grid->column('updated_at','更新时间')->sortable();
            $grid->disableRowSelector();
            $grid->disableViewButton();
            $grid->enableDialogCreate();
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
        return Form::make(new StopWord(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });
            $form->text('find', '敏感词')->required();
            $form->select('ugc', '内容处理方式')->rules('required')->options(StopWord::getUGCActions())->required();
            $form->text('replacement', '替换规则')->rules('required_if:ugc,{REPLACE}');
        });
    }
}
