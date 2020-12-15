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
use App\Services\UserService;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * 社交账户登录和回调
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SocialController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        //跳转到登录前页面
        return $this->getReferrer($this->redirectTo);
    }

    /**
     * 社交账户登录
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(Request $request, $provider)
    {
        try {
            $this->setReferrer();
            $driver = Socialite::driver($provider);
            if ($provider == 'qq' && method_exists($driver, 'withUnionId')) {
                $driver->withUnionId();
            }
            return $driver->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect($this->redirectTo())->with('status', trans('user.not_supported_yet'));
        }
    }

    /**
     * 社交账户回调
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        /** @var \Laravel\Socialite\Contracts\User $socialUser */
        $socialUser = Socialite::driver($provider)->user();
        $social = UserService::getSocialUser($provider, $socialUser);
        if ($social->user == null) {//用户未绑定
            if ($request->user()) {//已经登录，自动绑定
                $social->connect($request->user());
                return redirect()->intended($this->redirectPath());
            } else {
                $request->session()->put('social_id', $social->id);
                $this->flash()->warning(trans('user.login_bind'));
                return redirect("/auth/social/{$provider}/binding", 302);
            }
        } else {//如果已经绑定过了账户，这里检查用户是否被禁用
            if ($social->user->hasDisabled()) {
                $this->flash()->warning(trans('user.account_has_been_blocked'));
                return redirect('/login');
            } else {
                Auth::login($social->user);
                $social->user->updateLogin($request->getClientIp(), $request->userAgent());
                return redirect()->intended($this->redirectPath());
            }
        }
    }

    /**
     * 绑定社交账户
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handleProviderBinding(Request $request, $provider)
    {
        return view('auth.binding');
    }
}
