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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * 轮播
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Carousel extends Model implements Sortable
{
    use Traits\HasDateTimeFormatter;
    use SortableTrait;

    //版本约定
    const TYPE_HOME = 1;//首页

    const CACHE_TAG = 'carousels:';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carousels';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    protected $fillable = [
        'name', 'order', 'image_path', 'url'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'order' => 0,
    ];

    /**
     * 排序字段
     * @var array
     */
    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    /**
     * 追加字段
     * @var string[]
     */
    protected $appends = [
        'image'
    ];

    /**
     * 标题字段
     * @var string
     */
    protected $titleColumn = 'name';

    /**
     * 获取轮播图
     * @return string
     */
    public function getImageAttribute()
    {
        $image = $this->attributes['image_path'];
        if ($image) {
            if (!URL::isValidUrl($image)) {
                $image = Storage::cloud()->url($image);
            }
            return $image;
        }
        return asset('img/img_invalid.png');
    }

    /**
     * 删除缓存
     * @param int $id
     */
    public static function forgetCache($id)
    {
        Cache::forget(static::CACHE_TAG . $id);
        Cache::forget(static::CACHE_TAG . 'home:ids');
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return Category
     */
    public static function findById($id): Carousel
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return static::query()->find($id);
        });
    }

    /**
     * 获取 首页 轮播
     * @param int $cacheMinutes 缓存时间
     * @return mixed
     */
    public static function home($cacheMinutes = 60)
    {
        $ids = Cache::store('file')->remember(static::CACHE_TAG . 'home:ids', Carbon::now()->addMinutes($cacheMinutes), function () {
            return Carousel::query()->where('type', static::TYPE_HOME)->orderByDesc('order')->orderByDesc('id')->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取连接类型
     * @return string[]
     */
    public static function getTypeLabels()
    {
        return [
            static::TYPE_HOME => '首页',
        ];
    }
}
