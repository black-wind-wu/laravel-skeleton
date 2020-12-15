<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Social\SocialResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 社交账户
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SocialController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 获取已经绑定的社交账户
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function socialAccounts(Request $request)
    {
        return SocialResource::collection($request->user()->socials);
    }

    /**
     * 解绑社交账户
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroySocial(Request $request, $provider)
    {
        /** @var \App\Models\UserSocial $social */
        $social = $request->user()->socials()->where('provider', $provider)->first();
        if ($social && $social->unbind()) {
            return $this->withNoContent();
        }
        throw new NotFoundHttpException('Object not found.');
    }

    /**
     * 绑定社交账户
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function bindSocial(Request $request, $provider)
    {
        //获取社交 用户
        /** @var \Laravel\Socialite\Contracts\User $socialUser */
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $social = UserService::getSocialUser($provider, $socialUser, false);
        if (!$social->user && $social->connect($request->user())) {
            return response('', 200);
        }
        throw new AccessDeniedHttpException('This account has been used, please replace it!');
    }

    /**
     * 获取微信绑定二维码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function weChatQrCode(Request $request)
    {
        $result = UserService::getWechatBindQrCode($request);
        return response()->json($result);
    }

    /**
     * 微信扫码检测
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function weChatCheck(Request $request)
    {
        $status = false;
        if (($flag = $request->get('flag')) != null) {
            $userInfo = Cache::get(UserService::WECHAT_LOGIN . $flag);
            if ($userInfo && empty($userInfo['id'])) {
                $status = true;
                Cache::forget(UserService::WECHAT_LOGIN . $flag);
            }
        }
        return response()->json([
            'status' => $status,
        ]);
    }
}
