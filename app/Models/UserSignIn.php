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
 * 用户签到表
 * @property int $id
 * @property int $user_id
 * @property int $integral 签到获取的积分
 * @property \Illuminate\Support\Carbon $created_at 签到时间
 * @property User $user
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserSignIn extends Model
{
    use Traits\HasDateTimeFormatter;

    const UPDATED_AT = null;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_signin';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'integral',
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
    ];

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
     * 判断今天是否已经签到
     * @param $userId
     * @return bool
     */
    public static function isSignIn($userId)
    {
        return static::query()->where('user_id', $userId)->whereDate('created_at', Carbon::today())->exists();
    }

    /**
     * 昨天是否签到
     * @param int $userId
     * @return bool
     */
    public static function yesterdayIsSignIn($userId)
    {
        return static::query()->where('user_id', $userId)->whereDate('created_at', Carbon::yesterday())->exists();
    }

}
