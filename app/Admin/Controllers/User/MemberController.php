<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\User;

use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\ForceDelete;
use App\Admin\Actions\Grid\Restore;
use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Carbon;

/**
 * 会员管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MemberController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '会员';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('mobile');
                $filter->equal('email');
                //顶部筛选
                $filter->scope('today', '今天数据')->whereDay('created_at', Carbon::today());
                $filter->scope('yesterday', '昨天数据')->whereDay('created_at', Carbon::yesterday());
                $thisWeek = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
                $filter->scope('this_week', '本周数据')
                    ->whereBetween('created_at', $thisWeek);
                $lastWeek = [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()];
                $filter->scope('last_week', '上周数据')->whereBetween('created_at', $lastWeek);
                $filter->scope('this_month', '本月数据')->whereMonth('created_at', Carbon::now()->month);
                $filter->scope('last_month', '上月数据')->whereBetween('created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->subMonth()->endOfDay()]);
                $filter->scope('year', '本年数据')->whereYear('created_at', Carbon::now()->year);
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->quickSearch(['id', 'mobile', 'email']);
            $grid->model()->orderBy('id', 'desc');
            $with = ['profile'];
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $with[] = 'wallet';
            }
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $with[] = 'integral';
            }

            $grid->model()->with($with);

            $grid->column('id', 'ID')->sortable();
            $grid->column('username', '用户名');
            $grid->column('mobile', '手机');
            $grid->column('email', '邮箱');
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $grid->column('integral.integral', '积分');
            }
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $grid->column('wallet.available_amount', '余额');
            }
            $grid->column('mobile_verified_at');
            $grid->column('email_verified_at');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->paginate(10);
            if (request('_scope_') == 'trashed') {// 回收站
                $grid->tools(function (Grid\Tools $tools) {
                    $tools->append(new ForceDelete(User::class));
                });
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new Restore(User::class));
                });
                $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                    $batch->add(new BatchRestore(User::class));
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
        return Show::make($id, new User(), function (Show $show) {
            $with = ['profile'];
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $with[] = 'wallet';
            }
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $with[] = 'integral';
            }

            $show->model()->with($with);

            $show->id;
            $show->username;
            $show->mobile;
            $show->email;
            $show->mobile_verified_at;
            $show->email_verified_at;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(User::with('profile'), function (Form $form) {
            $form->tab('基本信息', function (Form $form) {
                $form->display('id');
                $form->text('username');
                $form->text('mobile', '手机');
                $form->text('mobile_verified_at', '手机验证时间');
                $form->email('email');
                $form->text('email_verified_at', '邮箱验证时间');
                $form->display('created_at');
                $form->display('updated_at');
            })->tab('个人信息', function (Form $form) {
                $form->date('birthday', '生日');
                $form->url('address', '联系地址');
                $form->text('website', '个人主页');
                $form->textarea('introduction', '个人描述');
                $form->textarea('bio', '个性签名');


                $form->row(function (Form\Row $form) {
                    $form->width(3)->select('profile.province_id', '省')->options(\App\Models\Region::getProvinceSelect())->load('profile.city_id', '/api/regions');
                    $form->width(3)->select('profile.city_id', '市')->load('profile.district_id', '/api/regions');
                    $form->width(3)->select('profile.district_id', '区');
                });
            });
        });
    }
}
