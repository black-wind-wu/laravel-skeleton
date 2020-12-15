<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * 用户登录控制器
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }

    /**
     * 登录后的页面转向
     * @return mixed
     */
    public function redirectTo()
    {
        return $this->getReferrer($this->redirectTo);
    }

    /**
     * 显示登录表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $this->setReferrer();
        return view('auth.login');
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];
        if (config('app.env') != 'testing' && settings('user.enable_login_ticket')) {
            $rules['ticket'] = ['required', 'ticket:login'];//开启防水墙
        }
        $request->validate($rules);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $username = $request->input($this->username());
        if (preg_match(config('system.mobile_rule'), $username)) {
            $credentials = ['mobile' => $username, 'password' => $request->input('password'), 'disabled' => false];
        } else {
            $credentials = ['email' => $username, 'password' => $request->input('password'), 'disabled' => false];
        }
        return $credentials;
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //绑定请求
        if ($request->session()->has('social_id')) {
            \App\Models\UserSocial::bySocial($request->session()->pull('social_id'))->connect($user);
        }
        $user->updateLogin($request->getClientIp(), $request->userAgent());
        return;
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //返回注销前的页面
        return redirect()->back();
    }
}
