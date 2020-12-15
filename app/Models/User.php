<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\HasApiTokens;

/**
 * 用户模型
 * @property int $id ID
 * @property string $mobile 手机号
 * @property string $username 昵称
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $remember_token
 * @property string $avatar_path 头像路径
 * @property boolean $disabled 是否已经停用
 * @property \Illuminate\Support\Carbon|null $mobile_verified_at 手机验证时间
 * @property \Illuminate\Support\Carbon|null $email_verified_at 邮箱验证时间
 * @property \Illuminate\Support\Carbon|null $first_sign_in_at 开始签到时间
 * @property \Illuminate\Support\Carbon|null $created_at 注册时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 *
 * @property-read string $avatar 头像Url
 * @property-read boolean $hasAvatar 是否有头像
 * @property UserExtra $extra 扩展信息
 * @property UserProfile $profile 个人信息
 * @property UserSocial[] $socials 社交账户
 * @property UserDevice[] $devices 移动设备
 * @property UserLoginHistory[] $loginHistories 登录历史
 * @property \Larva\Wallet\Models\Wallet $wallet 钱包
 * @property \Larva\Integral\Models\IntegralWallet $integral 积分钱包
 * @property Administrator $administrator 管理员实例
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;
    use Traits\HasDateTimeFormatter;

    /**
     * 模型数据表
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 允许批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'mobile', 'password', 'avatar_path', 'disabled', 'first_sign_in_at'
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'first_sign_in_at' => 'datetime',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'disabled' => false,
    ];

    /**
     * 获取用户资料
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * 获取用户扩展资料
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function extra()
    {
        return $this->hasOne(UserExtra::class);
    }

    /**
     * 获取用户已经绑定的社交账户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    /**
     * 获取登录历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginHistories()
    {
        return $this->hasMany(UserLoginHistory::class);
    }

    /**
     * 获取用户设备列表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * 获取用户签到记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signs()
    {
        return $this->hasMany(UserSignIn::class);
    }

    /**
     * Get the admin relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'id', 'user_id');
    }

    /**
     * 获取用户收藏
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collections()
    {
        return $this->hasMany(UserCollection::class);
    }

    /**
     * 获取用户文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * 获取用户资源
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * 获取用户钱包
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @throws \Exception
     */
    public function wallet()
    {
        if (class_exists('\Larva\Wallet\Models\Wallet')) {
            return $this->hasOne(\Larva\Wallet\Models\Wallet::class);
        } else {
            throw new \Exception('Please install the wallet extension first.');//钱包未安装
        }
    }

    /**
     * 获取用户积分钱包
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @throws \Exception
     */
    public function integral()
    {
        if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
            return $this->hasOne(\Larva\Integral\Models\IntegralWallet::class);
        } else {
            throw new \Exception('Please install the integral extension first.');//未安装
        }
    }

    /**
     * 查询未禁用的
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('disabled', '=', false);
    }

    /**
     * 是否有头像
     * @return boolean
     */
    public function getHasAvatarAttribute()
    {
        return !empty($this->avatar_path);
    }

    /**
     * 返回头像Url
     * @return string
     */
    public function getAvatarAttribute()
    {
        $avatar = $this->avatar_path;
        if ($avatar) {
            if (!URL::isValidUrl($avatar)) {
                $avatar = \Illuminate\Support\Facades\Storage::cloud()->url($avatar);
            }
            return $avatar;
        }
        return asset('img/avatar.jpg');
    }

    /**
     * 获取已经收藏的指定内容
     * @param string $source_type
     * @param string $source_id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getCollected($source_type, $source_id)
    {
        return $this->collections()->where('source_type', '=', $source_type)->where('source_id', '=', $source_id)->first();
    }

    /**
     * 设置头像
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool
     */
    public function setAvatar(\Illuminate\Http\UploadedFile $file)
    {
        $oldAvatarPath = $this->avatar_path;
        $avatarPath = $file->storePubliclyAs(\App\Services\UserService::getAvatarPath($this->id), $file->hashName(), ['disk' => config('filesystems.cloud')]);
        \Illuminate\Support\Facades\Storage::cloud()->delete($oldAvatarPath);
        if ($this->administrator) {
            $this->administrator->avatar = $avatarPath;
            $this->administrator->saveQuietly();
        }
        return $this->forceFill([
            'avatar_path' => $avatarPath
        ])->save();
    }

    /**
     * 获取手机号
     * @param \Illuminate\Notifications\Notification|null $notification
     * @return int|null
     */
    public function routeNotificationForMobile($notification)
    {
        return $this->mobile;
    }

    /**
     * 获取移动端设备
     * @param \Illuminate\Notifications\Notification|null $notification
     * @return UserDevice|null
     */
    public function routeNotificationForDevice($notification)
    {
        return UserDevice::byUser($this->id)->latest('id')->first();
    }

    /**
     * 获取微信(公众号) open_id
     * @param \Illuminate\Notifications\Notification|null $notification
     * @return string|null
     */
    public function routeNotificationForWechat($notification)
    {
        if (($social = UserSocial::byUser($this->id)->byWechatPlatform()->latest('id')->first()) != null) {
            return $social->openid;
        }
        return null;
    }

    /**
     * 用户是否在线
     * @return bool
     */
    public function isOnline()
    {
        return \Illuminate\Support\Facades\Cache::has('user-online-' . $this->primaryKey);
    }

    /**
     * 发送邮箱验证通知
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        if (!is_null($this->email)) {
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        }
    }

    /**
     * Determine if the user has verified their mobile number.
     *
     * @return bool
     */
    public function hasVerifiedMobile()
    {
        return !is_null($this->mobile_verified_at);
    }

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified()
    {
        $status = $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\MobileVerified($this));
        return $status;
    }

    /**
     * Mark the given user's disabled.
     *
     * @return bool
     */
    public function markDisabled()
    {
        return $this->forceFill([
            'disabled' => true,
        ])->save();
    }

    /**
     * Determine if the user has disabled.
     *
     * @return bool
     */
    public function hasDisabled()
    {
        return $this->disabled;
    }

    /**
     * 重置用户密码
     *
     * @param string $password
     * @return void
     */
    public function resetPassword($password)
    {
        $this->password = \Illuminate\Support\Facades\Hash::make($password);
        $this->setRememberToken(\Illuminate\Support\Str::random(60));
        $this->save();
        event(new \Illuminate\Auth\Events\PasswordReset($this));
    }

    /**
     * 重置用户手机号
     * @param int $mobile
     * @return bool
     */
    public function resetMobile($mobile)
    {
        $status = $this->forceFill([
            'mobile' => $mobile,
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\MobileReset($this));
        return $status;
    }

    /**
     * 重置用户邮箱
     * @param string $email
     * @return bool
     */
    public function resetEmail($email)
    {
        $status = $this->forceFill([
            'email' => $email,
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\MailReset($this));
        return $status;
    }

    /**
     * 更新最后登录
     * @param string $clientIp
     * @param string|null $userAgent
     */
    public function updateLogin($clientIp, $userAgent = null)
    {
        $this->extra()->increment('login_num', 1, [
            'login_at' => $this->fromDateTime($this->freshTimestamp()),
            'login_ip' => $clientIp
        ]);
        $this->loginHistories()->create([
            'ip' => $clientIp,
            'user_agent' => $userAgent
        ]);
    }

    /**
     * Find user using social provider's user
     *
     * @param string $provider Provider name as requested from oauth e.g. facebook
     * @param \Laravel\Socialite\Contracts\User $user User of social provider
     * @param bool $autoRegistration
     * @return User
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     */
    public static function findForPassportSocialite($provider, \Laravel\Socialite\Contracts\User $user, $autoRegistration = true)
    {
        try {
            return \App\Services\UserService::byPassportSocialRequest($provider, $user, $autoRegistration);
        } catch (\Exception $e) {
            throw \League\OAuth2\Server\Exception\OAuthServerException::accessDenied($e->getMessage());
        }
    }

    /**
     * 查找用户
     * @param string $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        if (preg_match(config('system.mobile_rule'), $username)) {
            return static::active()
                ->where('mobile', $username)
                ->first();
        } else if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return static::active()
                ->where('email', $username)
                ->first();
        } else {
            return static::active()
                ->where('username', $username)
                ->first();
        }
    }

    /**
     * Verify and retrieve user by sms verify code request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param bool $autoRegistration 是否自动注册用户
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     */
    public static function findForPassportSmsRequest(\Illuminate\Http\Request $request, $autoRegistration = true)
    {
        try {
            return \App\Services\UserService::byPassportSmsRequest($request, $autoRegistration);
        } catch (\Exception $e) {
            throw \League\OAuth2\Server\Exception\OAuthServerException::accessDenied($e->getMessage());
        }
    }

    /**
     * 通过Passport的密码授权验证用户使用的密码。
     *
     * @param string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return \Illuminate\Support\Facades\Hash::check($password, $this->password);
    }

    /**
     * 随机生成一个用户名
     * @param string $username 用户名
     * @return string
     */
    public static function generateUsername($username)
    {
        if (static::query()->where('username', '=', $username)->exists()) {
            $row = static::query()->max('id');
            $username = $username . ++$row;
        }
        return $username;
    }

    /**
     * 随机获取一个系统用户
     * @return int
     */
    public static function getRandomSystemUserId()
    {
        $systemUserIds = config('system.system_user_ids');
        $random_keys = array_rand($systemUserIds);
        return $systemUserIds[$random_keys];
    }
}
