<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\MailRegisterRequest;
use App\Http\Requests\Api\V1\User\ModifyAvatarRequest;
use App\Http\Requests\Api\V1\User\ModifyMailRequest;
use App\Http\Requests\Api\V1\User\ModifyPasswordRequest;
use App\Http\Requests\Api\V1\User\ModifyMobileRequest;
use App\Http\Requests\Api\V1\User\ModifyProfileRequest;
use App\Http\Requests\Api\V1\User\MobileRegisterRequest;
use App\Http\Requests\Api\V1\User\ResetPasswordByMobileRequest;
use App\Http\Requests\Api\V1\User\VerifyMobileRequest;
use App\Http\Resources\Api\V1\User\ExtraResource;
use App\Http\Resources\Api\V1\User\LoginHistoriesResource;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 用户接口
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['exists', 'mobileRegister', 'emailRegister', 'resetPasswordByMobile']);
    }

    /**
     * 检查接口
     * @param Request $request
     * @return array
     */
    public function exists(Request $request)
    {
        if ($request->has('username') && !empty($request->get('username'))) {
            return ['exist' => !User::withTrashed()->where('username', $request->get('username'))->exists()];
        } else if ($request->has('email') && !empty($request->get('email'))) {
            return ['exist' => !User::withTrashed()->where('email', $request->get('email'))->exists()];
        } else if ($request->has('mobile') && !empty($request->get('mobile'))) {
            return ['exist' => !User::withTrashed()->where('mobile', $request->get('mobile'))->exists()];
        } else {
            throw new BadRequestHttpException('Bad request');
        }
    }

    /**
     * 手机注册接口
     * @param MobileRegisterRequest $request
     * @return UserResource
     */
    public function mobileRegister(MobileRegisterRequest $request)
    {
        if (!settings('user.enable_registration')) {
            throw new AccessDeniedHttpException(__('user.registration_closed'));
        }
        event(new Registered($user = UserService::createByMobile($request->mobile, $request->password)));
        return new UserResource($user);
    }

    /**
     * 邮箱注册接口
     * @param MailRegisterRequest $request
     * @return UserResource
     */
    public function emailRegister(MailRegisterRequest $request)
    {
        if (!settings('user.enable_registration')) {
            throw new AccessDeniedHttpException(__('user.registration_closed'));
        }
        event(new Registered($user = UserService::createByUsernameAndEmail($request->username, $request->email, $request->password)));
        return new UserResource($user);
    }

    /**
     * 发送激活邮件
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendVerificationMail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            'message' => __('user.email_verification_notification_been_sent'),
        ]);
    }

    /**
     * 通过短信重置密码
     * @param ResetPasswordByMobileRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPasswordByMobile(ResetPasswordByMobileRequest $request)
    {
        /** @var User $user */
        if (($user = User::query()->where('mobile', $request->mobile)->first()) != null) {
            $user->resetPassword($request->password);
            return response('', 200);
        } else {
            throw new NotFoundHttpException("User not found.");
        }
    }

    /**
     * 获取个人资料
     * @router /api/v1/user/profile
     * @param Request $request
     * @return UserResource
     */
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * 获取用户扩展信息
     * @router /api/v1/user/extra
     * @param Request $request
     * @return ExtraResource
     */
    public function extra(Request $request)
    {
        return new ExtraResource($request->user());
    }

    /**
     * 验证手机号码
     * @param VerifyMobileRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function verifyMobile(VerifyMobileRequest $request)
    {
        if (!$request->user()->hasVerifiedMobile()) {
            $request->user()->markMobileAsVerified();
        }
        return response('', 200);
    }

    /**
     * 修改邮箱
     * @param ModifyMailRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyEMail(ModifyMailRequest $request)
    {
        $request->user()->resetEmail($request->email);
        return response('', 200);
    }

    /**
     * 修改手机号码
     * @param ModifyMobileRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyMobile(ModifyMobileRequest $request)
    {
        $request->user()->resetMobile($request->mobile);
        return response('', 200);
    }

    /**
     * 修改个人资料
     * @router /api/v1/user/profile
     * @param ModifyProfileRequest $request
     * @return UserResource
     */
    public function modifyProfile(ModifyProfileRequest $request)
    {
        $request->user()->profile->update($request->validated());
        $request->user()->update($request->only(['gender', 'username']));
        return new UserResource($request->user());
    }

    /**
     * 修改头像
     * @param ModifyAvatarRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyAvatar(ModifyAvatarRequest $request)
    {
        $request->user()->setAvatar($request->file('avatar'));
        return response('', 200);
    }

    /**
     * 修改密码接口
     * @param ModifyPasswordRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyPassword(ModifyPasswordRequest $request)
    {
        $request->user()->resetPassword($request->password);
        return response('', 200);
    }

    /**
     * 搜索用户
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        $q = $request->input('q');
        $users = User::query()
            ->where('id', '<>', $request->user()->id)
            ->where('username', 'like', "$q%")->take(10)->get();
        return UserResource::collection($users);
    }

    /**
     * 注销并删除自己的账户
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();
        return $this->withNoContent();
    }

    /**
     * 获取登录历史
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function loginHistories(Request $request)
    {
        $loginHistories = $request->user()->loginHistories()->orderByDesc('id')->paginate();
        return LoginHistoriesResource::collection($loginHistories);
    }
}
