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
 * 用户扩展资料
 * @property int $user_id 用户ID
 * @property string $login_ip 最后登录IP
 * @property string $login_at 最后登录时间
 * @property int $login_num 登录次数
 *
 * @property User $user
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserExtra extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_extras';

    /**
     * @var string 主键
     */
    protected $primaryKey = 'user_id';

    /**
     * @var bool 关闭主键自增
     */
    public $incrementing = false;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'login_ip', 'login_at', 'login_num',
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
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'login_num' => 'int'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'login_at',
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
     * 计数器增加
     * @param int $user_id
     * @param string $column
     * @param float|int $amount
     * @param array $extra
     * @return int
     * @return int
     */
    public static function inc($user_id, $column, $amount = 1, array $extra = [])
    {
        return static::query()->where('user_id', $user_id)->increment($column, $amount, $extra);
    }

    /**
     * 计数器减少
     * @param int $user_id
     * @param string $column
     * @param float|int $amount
     * @param array $extra
     * @return int
     */
    public static function dec($user_id, $column, $amount = 1, array $extra = [])
    {
        return static::query()->where('user_id', $user_id)->where($column, '>', 0)->decrement($column, $amount, $extra);
    }
}
