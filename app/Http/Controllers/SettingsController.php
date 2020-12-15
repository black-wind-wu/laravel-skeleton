<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

/**
 * 设置中心
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户中心首页
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('settings.profile');
    }

    /**
     * 个人信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        return view('settings.profile');
    }

    /**
     * 账户管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        return view('settings.account');
    }

    /**
     * 登录历史
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginHistories()
    {
        return view('settings.login-histories');
    }

    /**
     * Token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tokens()
    {
        return view('settings.tokens');
    }

    /**
     * OAuth 应用
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function applications()
    {
        return view('settings.applications');
    }

    /**
     * 授权
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authorization()
    {
        return view('settings.authorization');
    }

    /**
     * 余额
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function balance()
    {
        return view('settings.balance');
    }

    /**
     * 积分
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function integral()
    {
        return view('settings.integral');
    }

    /**
     * 提现账户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settle()
    {
        return view('settings.settle');
    }
}
