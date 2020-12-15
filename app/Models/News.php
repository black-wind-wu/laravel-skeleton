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
use Illuminate\Support\Facades\Cache;

/**
 * 快讯
 * @property int $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $views
 * @property string $from
 * @property string from_url
 * @property string $pub_date 发表时间
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property string $tag_values 标签
 * @property-read string $link Url
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class News extends Model
{
    use Traits\HasDateTimeFormatter;
    use Traits\HasTaggable;

    const UPDATED_AT = null;

    const CACHE_TAG = 'news:';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    protected $fillable = [
        'title', 'keywords', 'description', 'views', 'from', 'from_url', 'pub_date', 'tag_values'
    ];

    /**
     * 追加字段
     * @var string[]
     */
    protected $appends = [
        'tag_values',
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'views' => 0,
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
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'pub_date' => 'date',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(function ($model) {
            if (!$model->pub_date) {
                $model->pub_date = Carbon::now()->toDateString();
            }
        });
    }

    /**
     * 上一篇
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getPreviousAttribute()
    {
        return static::query()->where('id', '<', $this->id)->first();
    }

    /**
     * 下一篇
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getNextAttribute()
    {
        return static::query()->where('id', '>', $this->id)->first();
    }

    /**
     * 获取访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        if (empty($this->from_url)) {
            return route('news.view', ['news' => $this]);
        }
        return $this->from_url;
    }

    /**
     * 通知搜索引擎
     */
    public function notifySearchEngines()
    {
        //推送
        if (!config('app.debug')) {
            \Larva\Baidu\Push\BaiduPush::push($this->link);//推普通收录
            \Larva\Bing\Push\BingPush::push($this->link);//推普通收录
        }
    }

    /**
     * 删除缓存
     * @param int $id
     */
    public static function forgetCache($id)
    {
        Cache::forget(static::CACHE_TAG . $id);
        Cache::forget(static::CACHE_TAG . 'latest');
        Cache::forget(static::CACHE_TAG . 'total');
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return News
     */
    public static function findById($id): News
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return static::query()->find($id);
        });
    }

    /**
     * 获取最新的10条
     * @param int $limit
     * @param int $cacheMinutes
     * @return News[]
     */
    public static function latest($limit = 10, $cacheMinutes = 15)
    {
        $ids = Cache::remember(static::CACHE_TAG . 'latest', now()->addMinutes($cacheMinutes), function () use ($limit) {
            return static::query()->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取缓存的总数
     * @param int $cacheMinutes
     * @return int
     */
    public static function getTotal($cacheMinutes = 60)
    {
        return Cache::remember(static::CACHE_TAG . 'total', now()->addMinutes($cacheMinutes), function () {
            return static::query()->count();
        });
    }
}
