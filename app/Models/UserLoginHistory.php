<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use hisorange\BrowserDetect\Facade as Browser;
use Illuminate\Database\Eloquent\Model;

/**
 * 登录历史
 * @property int $id 记录ID
 * @property int $user_id 用户ID
 * @property string $ip 登录IP
 * @property string $browser 登录使用的浏览器
 * @property string $user_agent 用户代理
 * @property string $address 用户地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property User $user
 *
 * @property-read \hisorange\BrowserDetect\Result|false $device
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserLoginHistory extends Model
{
    use Traits\HasDateTimeFormatter;

    const UPDATED_AT = null;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_login_history';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'browser', 'user_agent', 'address'
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
     * 获取设备属性
     * @return \hisorange\BrowserDetect\Result|false
     */
    public function getDeviceAttribute()
    {
        if ($this->user_agent) {
            return Browser::parse($this->user_agent);
        }
        return false;
    }
}
