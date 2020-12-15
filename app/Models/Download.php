<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * 下载模型
 * @property int $id ID
 * @property int $user_id 作者ID
 * @property int $category_id 栏目ID
 * @property string $title 标题
 * @property string $description 描述
 * @property int $status 状态
 * @property int $views 查看次数
 * @property int $score 需要的积分
 * @property int $download_count 下载次数
 * @property int $comment_count 评论次数
 * @property int $support_count 点赞次数
 * @property int $collection_count 收藏次数
 * @property array $metas Meta信息
 * @property string $file_path 文件存储路径
 * @property string $file_name 文件名
 * @property string $file_type 文件类型
 * @property int $file_size 文件大小
 * @property string $file_hash 文件哈希
 * @property string $file_list 压缩文件列表
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 *
 * @property Tag[] $tags Tags
 * @property Category $category 栏目
 * @property User $user 发布者
 * @property DownloadStopWord $stopWords 触发的审核词
 *
 * @property string $tag_values Tags
 * @property-read boolean $isPending 是否待审核
 * @property-read boolean $isApproved 是否已审核
 * @property-read string $fileIcon
 * @property-read string $link
 * @property-read string $downloadLink
 * @property-read string $url 原始下载地址
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Download approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Download byCategoryId($categoryId)
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Download extends Model
{
    use Traits\HasTaggable;
    use Traits\HasDateTimeFormatter;
    use Traits\HasCollection;
    use Traits\HasSupport;
    use SoftDeletes;

    const CACHE_TAG = 'downloads:';
    const STATUS_PENDING = 0b0;//待审核
    const STATUS_APPROVED = 0b1;//已审核
    const STATUS_REJECTED = 0b10;//拒绝

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'downloads';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public $fillable = [
        'user_id', 'category_id', 'title', 'description', 'score', 'status', 'file_path', 'file_name',
        'file_type', 'file_size', 'file_hash', 'file_list', 'metas',
        //虚拟字段
        'tag_values',
    ];

    /**
     * 追加标签字段
     * @var string[]
     */
    protected $appends = [
        'tag_values',
        'fileIcon',
        'link'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'status' => 0b1,
        'views' => 0,
        'score' => 1,
        'download_count' => 0,
        'comment_count' => 0,
        'support_count' => 0,
        'collection_count' => 0,
        'file_type' => 'unknow'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'metas' => 'array',
        'views' => 'int',
        'download_count' => 'int',
        'comment_count' => 'int',
        'support_count' => 'int',
        'collection_count' => 'int',
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
     * 关联到栏目
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
     * 获取下载记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(UserDownload::class);
    }

    /**
     * Define the relationship with the article stop words.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stopWords()
    {
        return $this->hasOne(DownloadStopWord::class);
    }

    /**
     * 查找指定栏目下的
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * 获取审核通过的
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', static::STATUS_APPROVED);
    }

    /**
     * 是否待审核
     * @return boolean
     */
    public function getIsPendingAttribute()
    {
        return $this->status == static::STATUS_PENDING;
    }

    /**
     * 是否已经审核
     * @return boolean
     */
    public function getIsApprovedAttribute()
    {
        return $this->status == static::STATUS_APPROVED;
    }

    /**
     * 获取图标
     * @return string
     */
    public function getFileIconAttribute()
    {
        if (!empty($this->attributes['file_type'])) {
            return asset("img/type/{$this->attributes['file_type']}.svg");
        }
        return asset("img/type/unknow.svg");
    }

    /**
     * 上一个
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getPreviousAttribute()
    {
        return static::approved()->byCategoryId($this->category_id)->where('id', '<', $this->id)->first();
    }

    /**
     * 下一个
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getNextAttribute()
    {
        return static::approved()->byCategoryId($this->category_id)->where('id', '>', $this->id)->first();
    }

    /**
     * 获取访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('downloads.view', $this);
    }

    /**
     * 获取下载地址
     * @return string
     */
    public function getDownloadLinkAttribute()
    {
        return route('downloads.download_link', ['id' => $this->id]);
    }

    /**
     * 获取文件下载地址
     * @return string
     */
    public function getUrlAttribute()
    {
        if (!empty($this->attributes['file_path'])) {
            return FileService::url($this->attributes['file_path']);
        }
        return '';
    }

    /**
     * 获取文件临时下载地址
     * @param \DateTimeInterface $expiration 链接有效期
     * @return string
     */
    public function temporaryUrl($expiration)
    {
        if (!empty($this->attributes['file_path'])) {
            FileService::temporaryUrl($this->attributes['file_path'], $expiration);
        }
        return '';
    }

    /**
     * 购买源码
     * @param User $user
     * @return bool
     */
    public function buy(User $user)
    {
        if ($user->integral->integral >= $this->score) {
            $this->downloads()->create(['user_id' => $user->id]);
            //加价
            $this->increment('score');
            return true;
        }
        return false;
    }

    /**
     * 获取格式化后的文件大小
     * @return string
     */
    public function getSizeFormatAttribute()
    {
        $sizes = [" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"];
        if ($this->attributes['file_size'] == 0) {
            return 'n/a';
        } else {
            return round($this->attributes['file_size'] / pow(1024, ($i = floor(log($this->attributes['file_size'], 1024)))), 2) . $sizes[$i];
        }
    }

    /**
     * 通知搜索引擎
     */
    public function notifySearchEngines()
    {
        //推送
        if ($this->isApproved && !config('app.debug')) {
            \Larva\Baidu\Push\BaiduPush::push($this->link);//推普通收录
            \Larva\Bing\Push\BingPush::push($this->link);//推普通收录
        }
    }

    /**
     * 设置已审核
     */
    public function setApproved()
    {
        $this->status = static::STATUS_APPROVED;
        $this->saveQuietly();
        $this->notifySearchEngines();
    }

    /**
     * 设置审核拒绝通过
     */
    public function setRejected()
    {
        $this->status = static::STATUS_REJECTED;
        $this->saveQuietly();
    }

    /**
     * 用户在30天内是否下载过该代码
     * @param Download $item
     * @param int $user_id
     * @return bool
     */
    public static function isDownload(Download $item, $user_id)
    {
        try {
            $dateTime = new \DateTime('-30 days');
            return $item->downloads()->where('user_id', $user_id)->where('download_at', '>', $dateTime)->exists();
        } catch (\Exception $exception) {
            return $item->downloads()->where('user_id', $user_id)->exists();
        }
    }


    /**
     * 栏目下拉
     * @return array
     */
    public static function categorySelectOptions(): array
    {
        return Category::selectOptions(function ($query) {
            return $query->where('type', Category::TYPE_DOWNLOAD);
        });
    }

    /**
     * 获取状态Label
     * @return string[]
     */
    public static function getStatusLabels()
    {
        return [
            static::STATUS_PENDING => '待审核',
            static::STATUS_APPROVED => '审核通过',
            static::STATUS_REJECTED => '已拒绝',
        ];
    }

    /**
     * 获取状态Dot
     * @return string[]
     */
    public static function getStatusDots()
    {
        return [
            static::STATUS_PENDING => 'info',
            static::STATUS_APPROVED => 'success',
            static::STATUS_REJECTED => 'warning',
        ];
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
     * @return Download|null
     */
    public static function findById($id)
    {
        return Cache::rememberForever(static::CACHE_TAG . $id, function () use ($id) {
            return static::query()->find($id);
        });
    }

    /**
     * 获取最新的10条
     * @param int $limit
     * @param int $cacheMinutes
     * @return mixed
     */
    public static function latest($limit = 10, $cacheMinutes = 15)
    {
        $ids = Cache::remember(static::CACHE_TAG . 'latest', now()->addMinutes($cacheMinutes), function () use ($limit) {
            return static::approved()->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取缓存的总数
     * @param int $cacheMinutes
     * @return mixed
     */
    public static function getTotal($cacheMinutes = 60)
    {
        return Cache::remember(static::CACHE_TAG . 'total', now()->addMinutes($cacheMinutes), function () {
            return static::query()->count();
        });
    }
}
