<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\EloquentSortable\Sortable;

/**
 * 栏目
 * @property int $id ID
 * @property int $parent_id 父ID
 * @property string $name 栏目名称
 * @protecty string $type 栏目类型
 * @property string $image_path 缩略图
 * @property string $title 网页Title
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property int $order 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read string $image 缩略图连接
 * @property-read string $link 栏目链接
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Category root()
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Category extends Model implements Sortable
{
    use ModelTree;
    use Traits\HasDateTimeFormatter;
    use SoftDeletes;

    const CACHE_TAG = 'categories:';
    const TYPE_ARTICLE = 0b0;
    const TYPE_DOWNLOAD = 0b1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    protected $fillable = [
        'id', 'parent_id', 'type', 'name', 'order', 'image_path', 'title', 'keywords', 'description'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'parent_id' => 0,
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
     * 标题字段
     * @var string
     */
    protected $titleColumn = 'name';

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = (new \Overtrue\Pinyin\Pinyin)->permalink($model->name);
            }
        });
    }

    /**
     * Get the children relation.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    /**
     * Get the parent relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class);
    }

    /**
     * 查找指定类型栏目
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 查找顶级栏目
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoot($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * 获取子栏目
     * @return array
     */
    public function getChildrenIds()
    {
        return $this->children()->pluck('id')->all();
    }

    /**
     * 获取 访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('categories.show', $this);
    }

    /**
     * 获取 栏目Title
     * @return string
     */
    public function getTitleAttribute()
    {
        if (!empty($this->attributes['title'])) {
            return $this->attributes['title'];
        }
        return $this->attributes['name'];
    }

    /**
     * 获取 栏目keywords
     * @return string
     */
    public function getKeywordsAttribute()
    {
        if (!empty($this->attributes['keywords'])) {
            return $this->attributes['keywords'];
        }
        return $this->attributes['name'];
    }

    /**
     * 获取 栏目 description
     * @return string
     */
    public function getDescriptionAttribute()
    {
        if (!empty($this->attributes['description'])) {
            return $this->attributes['description'];
        }
        return $this->attributes['name'];
    }

    /**
     * 获取栏目缩略图
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
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return Category
     */
    public static function findById($id): Category
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return static::query()->find($id);
        });
    }

    /**
     * 获取顶级栏目下拉数据
     * @return \Illuminate\Support\Collection
     */
    public static function getRootSelect($type)
    {
        return static::type($type)->root()->select(['id', 'name'])->orderBy('order')->pluck('name', 'id');
    }

    /**
     * 获取顶级栏目
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getRootNodes($type)
    {
        return static::type($type)->root()->select(['id', 'name'])->orderBy('order')->get();
    }

    /**
     * 获取Type Label
     * @return string[]
     */
    public static function getTypeLabels()
    {
        return [
            static::TYPE_ARTICLE => '文章',
            static::TYPE_DOWNLOAD => '下载',
        ];
    }
}
