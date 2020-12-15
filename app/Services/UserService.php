<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Support\Facades\Hash;

/**
 * 用户服务助手
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserService
{
    //APP缓存登录标记
    const APP_LOGIN = 'app_login';

    //微信缓存登录标记
    const WECHAT_LOGIN = 'wx_login';

    /**
     * 计算用户头像子路径
     *
     * @param int $userId 用户ID
     * @return string
     */
    public static function getAvatarPath($userId)
    {
        return static::generateSubPath($userId, 'avatar');
    }

    /**
     * 获取用户提供程序实现。
     * @param string|null $name
     * @return \Illuminate\Contracts\Auth\UserProvider
     */
    public static function userProvider($name = null)
    {
        return app('auth')->guard($name)->getProvider();
    }

    /**
     * 获取社交账户
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User $socialUser
     * @param bool $autoRegistration 是否自动注册用户
     * @return UserSocial
     */
    public static function getSocialUser($provider, \Laravel\Socialite\Contracts\User $socialUser, $autoRegistration = false)
    {
        //检查是否是有联合ID
        $userId = null;
        $unionId = null;
        $socialId = $socialUser->getId();
        if (isset($socialUser->unionid) && !empty($socialUser->unionid)) {
            $unionId = $socialUser->unionid;
            if (($union = UserSocial::byUnionIdAndProvider($socialUser->unionid, $provider)->first()) != null && $union->user_id) {
                $userId = $union->user_id;
            }
        }
        if (($social = UserSocial::bySocialAndProvider($socialId, $provider)->first()) == null) {
            $attributes = [
                'user_id' => $userId,
                'provider' => $provider,
                'social_id' => $socialId,
                'union_id' => $unionId,
                'name' => $socialUser->getName(),
                'nickname' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
            ];
            if ($socialUser->user) {
                $attributes['data'] = $socialUser->user;
            }
            if ($socialUser->token) {
                $attributes['access_token'] = $socialUser->token;
            }
            if ($socialUser->expiresIn && is_int($socialUser->expiresIn)) {
                $attributes['token_expires_at'] = \Illuminate\Support\Carbon::now()->addSeconds($socialUser->expiresIn)->toDateTimeString();
            }
            if (isset($socialUser->refreshToken)) {
                $attributes['refresh_token'] = $socialUser->refreshToken;
            }
            $social = UserSocial::create($attributes);
        } else {
            if ($socialUser->user) {
                $social->update(['data' => $socialUser->user]);
            }
        }

        //社交账户自动注册用户
        if (!$social->user && $autoRegistration && settings('user.enable_socialite_auto_registration', false)) {
            $user = static::createByUsernameAndEmail('', '', '');
            if (!empty($attributes['name'])) {
                $user->username = User::generateUsername($attributes['name']);
            } else if (!empty($attributes['nickname'])) {
                $user->username = User::generateUsername($attributes['nickname']);
            }
            if (!empty($attributes['email'])) {
                $user->email = $attributes['email'];
            }
            $user->save();
            $social->connect($user);
            return static::getSocialUser($provider, $socialUser);
        }
        return $social;
    }

    /**
     * Verify and retrieve user by socialite verify code request.
     * @param $provider
     * @param \Laravel\Socialite\Contracts\User $user
     * @param bool $autoRegistration 是否自动注册用户
     * @return User|null
     * @throws \Exception
     */
    public static function byPassportSocialRequest($provider, \Laravel\Socialite\Contracts\User $user, $autoRegistration = false)
    {
        $social = UserService::getSocialUser($provider, $user, $autoRegistration);
        if ($social && $social->user) {
            if ($social->user->hasDisabled()) {//禁止掉的用户不允许通过 社交账户登录
                throw new \Exception(__('user.account_has_been_blocked'));
            }
            return $social->user;
        }
        return null;
    }

    /**
     * Verify and retrieve user by sms verify code request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param bool $autoRegistration 是否自动注册用户
     * @return User|null
     * @throws \Exception
     */
    public static function byPassportSmsRequest(\Illuminate\Http\Request $request, $autoRegistration = false)
    {
        \Illuminate\Support\Facades\Validator::make($request->all(), [
            'mobile' => ['required', 'min:11', 'max:11', 'mobile',],
            'verifyCode' => ['required', 'min:4', 'max:6', 'mobile_verify_code'],
        ])->validate();
        if (($user = User::query()->where('mobile',$request->mobile)->first()) != null) {
            if ($user->hasDisabled()) {//禁止掉的用户不允许登录
                throw new \Exception(__('user.account_has_been_blocked'));
            }
        } else if ($autoRegistration && settings('user.enable_sms_auto_registration', false)) {
            $user = static::createByMobile($request->mobile, '');
        }
        return $user;
    }

    /**
     * 通过手机创建用户
     * @param int $mobile
     * @param string $password
     * @return User
     */
    public static function createByMobile($mobile, $password)
    {
        /** @var User $user */
        $user = User::create([
            'username' => 'm' . $mobile,
            'mobile' => $mobile,
            'password' => Hash::make($password)
        ]);
        $user->markMobileAsVerified();
        return $user;
    }

    /**
     * 通过用户名创建用户
     * @param string $username
     * @param string $password
     * @return User
     */
    public static function createByUsername($username, $password)
    {
        /** @var User $user */
        $user = User::create([
            'username' => $username,
            'password' => Hash::make($password)
        ]);
        return $user;
    }

    /**
     * 通过邮箱创建用户
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function createByEmail($email, $password)
    {
        $emailArr = explode('@', $email);
        return static::createByUsernameAndEmail($emailArr[0], $email, $password);
    }

    /**
     * 通过用户名和邮箱创建用户
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function createByUsernameAndEmail($username, $email, $password)
    {
        return User::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    /**
     * 计算子路径
     * @param int $userId 用户ID
     * @param string $prefix 前缀
     * @return string
     */
    private static function generateSubPath($userId, $prefix = 'user')
    {
        $id = sprintf("%09d", $userId);
        $dir1 = substr($id, 0, 3);
        $dir2 = substr($id, 3, 2);
        $dir3 = substr($id, 5, 2);
        return $prefix . '/' . $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($userId, -2);
    }
}
