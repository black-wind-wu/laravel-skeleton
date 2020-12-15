<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 邮件验证码
 * @property string $email 邮箱
 * @property string $code 验证码
 * @property string $scenario 验证场景
 * @property string $ip IP地址
 * @property int $state 使用状态
 * @property Carbon $expired_at 过期时间
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 *
 * @property User $user
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MailCode extends Model
{
    use Traits\HasDateTimeFormatter;

    //使用状态
    const USED_STATE = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mail_codes';

    /**
     * @var array 允许批量赋值属性
     */
    protected $fillable = ['email', 'code', 'scenario', 'expired_at'];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'expired_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @param int $duration
     * @param string $ip
     * @return $this
     * @throws \Exception
     */
    public function regenerate($duration, $ip)
    {
        $this->code = static::generateVerifyCode();
        $this->ip = $ip;
        $this->expired_at = Carbon::now()->addMinutes($duration);
        return $this;
    }

    /**
     * 修改使用状态
     * @param int $status
     * @return $this
     */
    public function changeState($status)
    {
        $this->state = $status;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * 获取场景
     * @return string[]
     */
    public static function getScenarios()
    {
        return [
            'register' => '注册'
        ];
    }

    /**
     * 获取今日发送总数
     * @param string $email
     * @param string $ip
     * @return int
     */
    public static function getTodayCount($email, $ip)
    {
        return static::getIpTodayCount($ip) + static::getMailTodayCount($email);
    }

    /**
     * 获取验证码
     * @param string $email
     * @param string $scenario
     * @param int $state
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getVerifyCode($email, $scenario, $state = 0)
    {
        return static::query()
            ->where('email', $email)
            ->where('scenario', $scenario)
            ->where('state', $state)
            ->first();
    }

    /**
     * 获取IP今日发送总数
     * @param string $ip
     * @param int $state
     * @return int
     */
    public static function getIpTodayCount($ip, $state = 0)
    {
        return static::query()
            ->where('ip', $ip)
            ->whereDay('created_at', Carbon::today())
            ->where('state', $state)
            ->count();
    }

    /**
     * 获取邮箱今日发送总数
     * @param string $email
     * @param int $state
     * @return int
     */
    public static function getMailTodayCount($email, $state = 0)
    {
        return static::query()
            ->where('email', $email)
            ->whereDay('created_at', Carbon::today())
            ->where('state', $state)
            ->count();
    }

    /**
     * 生成验证码
     * @return string the generated verification code
     * @throws \Exception
     */
    protected static function generateVerifyCode()
    {
        return (string)random_int(100000, 999999);
    }
}
