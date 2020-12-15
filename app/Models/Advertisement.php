<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * 广告管理
 * @property int $id
 * @property string $name
 * @property boolean $enabled
 * @property string $body
 * @property string $html
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Advertisement extends Model
{
    use Traits\HasDateTimeFormatter;

    const CACHE_TAG = 'ads:';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advertisements';

    /**
     * 允许批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'name', 'enabled', 'body',
    ];

    /**
     * 追加字段
     * @var string[]
     */
    protected $appends = [
        'html',
    ];

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
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
     * 可用的广告
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * 禁用的广告
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeDisabled($query)
    {
        return $query->where('enabled', false);
    }

    /**
     * 获取 视图调用代码
     * @return string
     */
    public function getHtmlAttribute()
    {
        return '<x-widgets.ads id="' . $this->id . '"/>';
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return Advertisement|null
     */
    public static function findById($id)
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return Advertisement::query()->find($id);
        });
    }

    /**
     * 删除缓存
     * @param int $id
     * @return void
     */
    public static function forgetCache($id)
    {
        Cache::forget(static::CACHE_TAG . $id);
    }
}
