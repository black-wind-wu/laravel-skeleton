<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 社交账户
 * @property int $id ID
 * @property int $user_id 用户ID
 * @property string $name 用户名
 * @property string $nickname 昵称
 * @property string $email 邮箱
 * @property string $avatar 头像
 * @property string $provider 供应商
 * @property string $union_id 联合ID
 * @property string $social_id 社交用户ID
 * @property string $access_token 帐户令牌
 * @property array $data 附加数据
 * @property string $token_expires_at 令牌过期时间
 * @property string $refresh_token 刷新令牌
 * @property User $user 用户
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 *
 * @property-read string $openid 社交用户ID
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byWechatPlatform()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial bySocialAndProvider($id, $provider)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byUnionIdAndProvider($id, $provider)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byProvider($provider)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial bySocial($id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byOpenid($openid)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byUser($userId)
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserSocial extends Model
{
    use Traits\HasDateTimeFormatter;

    const SERVICE_WECHAT = 'wechat';
    const SERVICE_WECHAT_WEB = 'wechat_web';
    const SERVICE_WECHAT_MOBILE = 'wechat_mobile';
    const SERVICE_WECHAT_MINI_PROGRAM = 'wechat_mini_program';
    const SERVICE_QQ_MINI_PROGRAM = 'qq_mini_program';
    const SERVICE_BAIDU_SMART_PROGRAM = 'baidu_smart_program';
    const SERVICE_BYTEDANCE_MINI_PROGRAM = 'bytedance_mini_program';
    const SERVICE_ALIPAY_MINI_PROGRAM = 'alipay_mini_program';
    const SERVICE_DINGTALK_MINI_PROGRAM = 'dingtalk_mini_program';
    const SERVICE_WEIBO = 'weibo';
    const SERVICE_QQ = 'qq';
    const SERVICE_ALIPAY = 'alipay';
    const SERVICE_BAIDU = 'baidu';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_social_accounts';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'nickname', 'email', 'avatar', 'provider', 'union_id', 'social_id', 'access_token',
        'data',
    ];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * 获取所有提供商类型
     * @return array
     */
    public static function getProviders()
    {
        return [
            static::SERVICE_WECHAT => trans('user.' . static::SERVICE_WECHAT),
            static::SERVICE_WECHAT_WEB => trans('user.' . static::SERVICE_WECHAT_WEB),
            static::SERVICE_WECHAT_MOBILE => trans('user.' . static::SERVICE_WECHAT_MOBILE),
            static::SERVICE_WECHAT_MINI_PROGRAM => trans('user.' . static::SERVICE_WECHAT_MINI_PROGRAM),
            static::SERVICE_QQ_MINI_PROGRAM => trans('user.' . static::SERVICE_QQ_MINI_PROGRAM),
            static::SERVICE_BAIDU_SMART_PROGRAM => trans('user.' . static::SERVICE_BAIDU_SMART_PROGRAM),
            static::SERVICE_BYTEDANCE_MINI_PROGRAM => trans('user.' . static::SERVICE_BYTEDANCE_MINI_PROGRAM),
            static::SERVICE_ALIPAY_MINI_PROGRAM => trans('user.' . static::SERVICE_ALIPAY_MINI_PROGRAM),
            static::SERVICE_DINGTALK_MINI_PROGRAM => trans('user.' . static::SERVICE_DINGTALK_MINI_PROGRAM),
            static::SERVICE_WEIBO => trans('user.' . static::SERVICE_WEIBO),
            static::SERVICE_QQ => trans('user.' . static::SERVICE_QQ),
            static::SERVICE_ALIPAY => trans('user.' . static::SERVICE_ALIPAY),
            static::SERVICE_BAIDU => trans('user.' . static::SERVICE_BAIDU),
        ];
    }

    /**
     * 获取所有小程序提供商类型
     * @return array
     */
    public static function getMiniProgramProviders()
    {
        return [
            static::SERVICE_WECHAT_MINI_PROGRAM => trans('user.' . static::SERVICE_WECHAT_MINI_PROGRAM),
            static::SERVICE_QQ_MINI_PROGRAM => trans('user.' . static::SERVICE_QQ_MINI_PROGRAM),
            static::SERVICE_BAIDU_SMART_PROGRAM => trans('user.' . static::SERVICE_BAIDU_SMART_PROGRAM),
            static::SERVICE_BYTEDANCE_MINI_PROGRAM => trans('user.' . static::SERVICE_BYTEDANCE_MINI_PROGRAM),
            static::SERVICE_ALIPAY_MINI_PROGRAM => trans('user.' . static::SERVICE_ALIPAY_MINI_PROGRAM),
            static::SERVICE_DINGTALK_MINI_PROGRAM => trans('user.' . static::SERVICE_DINGTALK_MINI_PROGRAM),
        ];
    }

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取Openid
     * @return string
     */
    public function getOpenidAttribute()
    {
        return $this->social_id;
    }

    /**
     * 链接用户
     * @param User $user
     * @return bool
     */
    public function connect(User $user)
    {
        return $this->update(['user_id' => $user->id]);
    }

    /**
     * 解除绑定
     * @return bool
     */
    public function unbind()
    {
        return $this->update(['user_id' => null]);
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Finds an account by openid.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $openid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByOpenid($query, $openid)
    {
        return $query->where('social_id', $openid);
    }

    /**
     * Finds an account by id.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySocial($query, $id)
    {
        return $query->where('social_id', $id);
    }

    /**
     * Finds an account by user_id.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySocialAndProvider($query, $id, $provider)
    {
        return $query->where('social_id', $id)->where('provider', $provider);
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUnionIdAndProvider($query, $id, $provider)
    {
        return $query->where('union_id', $id)->where('provider', $provider);
    }

    /**
     * 查询微信公众号
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByWechatPlatform($query)
    {
        return $query->where('provider', static::SERVICE_WECHAT);
    }

    /**
     * 刷新用户资料
     * @param bool $autoRegistration
     */
    public function refreshUser($autoRegistration = false)
    {
        $user = \Laravel\Socialite\Facades\Socialite::driver($this->provider)->userFromToken($this->access_token);
        \App\Services\UserService::getSocialUser($this->provider, $user, $autoRegistration);
    }
}
