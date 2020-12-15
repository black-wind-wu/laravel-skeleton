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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 友情链接管理
 * @property int $id ID
 * @property int $type 链接类型
 * @property string $title 链接标题
 * @property string $url 链接Url
 * @property string $logo_path Logo
 * @property string $description 链接描述
 * @property \Illuminate\Support\Carbon $expired_at 过期时间
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read string $logo
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Link active()
 * @method static \Illuminate\Database\Eloquent\Builder|Link logo()
 * @method static \Illuminate\Database\Eloquent\Builder|Link type($type)
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Link extends Model
{
    use Traits\HasDateTimeFormatter;

    const CACHE_TAG = 'links:';
    //版本约定
    const TYPE_SPONSOR = 1;//赞助商
    const TYPE_PARTNER = 2;//合作伙伴
    const TYPE_HOME = 3;//首页链接
    const TYPE_INNER = 4;//内页链接
    const TYPE_ALL = 5;//全站链接

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'links';

    /**
     * @var array 允许批量赋值属性
     */
    protected $fillable = [
        'type', 'title', 'url', 'logo_path', 'description', 'expired_at'
    ];

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

    protected $appends = [
        'logo'
    ];

    /**
     * 只查询正常状态的链接
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            $query->whereNull('expired_at')
                ->orWhere('expired_at', '>', now());
        });
    }

    /**
     * 查询 Logo 链接
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLogo($query)
    {
        return $query->whereNotNull('logo');
    }

    /**
     * 查询特定类别链接
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    /**
     * 获取Logo存储位置
     * @return string
     */
    public function getLogoAttribute()
    {
        if (!empty($this->attributes['logo_path'])) {
            if (Str::contains($this->attributes['logo_path'], '//')) {
                return $this->attributes['logo_path'];
            } else {
                return Storage::cloud()->url($this->attributes['logo_path']);
            }
        }
        return null;
    }

    /**
     * 获取连接类型
     * @return string[]
     */
    public static function getTypeLabels()
    {
        return [
            Link::TYPE_SPONSOR => '赞助商',
            Link::TYPE_PARTNER => '合作伙伴',
            Link::TYPE_HOME => '首页链接',
            Link::TYPE_INNER => '内页链接',
            Link::TYPE_ALL => '全站链接'
        ];
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return Link
     */
    public static function findById($id): Link
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return Link::query()->find($id);
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
        Cache::forget(static::CACHE_TAG . 'home:ids');
        Cache::forget(static::CACHE_TAG . 'inner:ids');
        Cache::forget(static::CACHE_TAG . 'sponsor:ids');
        Cache::forget(static::CACHE_TAG . 'partner:ids');
    }

    /**
     * 获取赞助商链接
     * @param int $limit
     * @param int $cacheMinutes 缓存时间
     * @return mixed
     */
    public static function sponsor($limit = 10, $cacheMinutes = 60)
    {
        $ids = Cache::store('file')->remember(static::CACHE_TAG . 'sponsor:ids', Carbon::now()->addMinutes($cacheMinutes), function () use ($limit) {
            return Link::active()->type(static::TYPE_SPONSOR)->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取合作伙伴链接
     * @param int $limit
     * @param int $cacheMinutes 缓存时间
     * @return mixed
     */
    public static function partner($limit = 10, $cacheMinutes = 60)
    {
        $ids = Cache::store('file')->remember(static::CACHE_TAG . 'partner:ids', Carbon::now()->addMinutes($cacheMinutes), function () use ($limit) {
            return Link::active()->type(static::TYPE_PARTNER)->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取 首页 链接
     * @param int $cacheMinutes 缓存时间
     * @return mixed
     */
    public static function home($cacheMinutes = 60)
    {
        $ids = Cache::store('file')->remember(static::CACHE_TAG . 'home:ids', Carbon::now()->addMinutes($cacheMinutes), function () {
            return Link::active()->whereIn('type', [static::TYPE_HOME, static::TYPE_ALL])->orderByDesc('id')->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取 内页 链接
     * @param int $cacheMinutes 缓存时间
     * @return mixed
     */
    public static function inner($cacheMinutes = 60)
    {
        $ids = Cache::store('file')->remember(static::CACHE_TAG . 'inner:ids', Carbon::now()->addMinutes($cacheMinutes), function () {
            return Link::active()->whereIn('type', [static::TYPE_INNER, static::TYPE_ALL])->orderByDesc('id')->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }
}
