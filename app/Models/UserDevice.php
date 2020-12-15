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
 * 用户设备实例
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $os
 * @property string $imei
 * @property string $imsi
 * @property string $model
 * @property string $vendor
 * @property string $version
 * @property User $user
 * @property-read boolean $isAndroid
 * @property-read boolean $isIOS
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice byUser($userId)
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserDevice extends Model
{
    use Traits\HasDateTimeFormatter;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_devices';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'token', 'os', 'imei', 'imsi', 'model', 'vendor', 'version'
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
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 链接用户
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @return bool
     */
    public function connect(User $user)
    {
        return $this->update(['user_id' => $user->id]);
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
     * 获取设备
     * @param array $deviceAttributes
     * @return $this
     */
    public static function findDevice($deviceAttributes)
    {
        if (($device = static::where('token', $deviceAttributes['token'])->first()) == null) {
            $device = static::create($deviceAttributes);
        }
        return $device;
    }

    /**
     * 是否是安卓
     * @return bool
     */
    public function getIsAndroidAttribute()
    {
        return strtolower($this->os) == 'android';
    }

    /**
     * 是否是IOS
     * @return bool
     */
    public function getIsIOSAttribute()
    {
        return strtolower($this->os) == 'ios';
    }
}
