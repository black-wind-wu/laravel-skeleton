<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Larva\Integral\Models\Transaction;

/**
 * 下载历史
 * @property int $id
 * @property int $download_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $download_at
 * @property string|null $deleted_at
 * @property-read Download $download
 * @property-read User $user
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserDownload extends Model
{
    use Traits\HasDateTimeFormatter;

    const CREATED_AT = 'download_at';
    const UPDATED_AT = null;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_downloads';


    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'download_id', 'download_at'
    ];

    /**
     * @var string[]
     */
    protected $touches = ['download'];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'download_at',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->download_at = $model->freshTimestamp();
        });
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
     * Get the download relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function download()
    {
        return $this->belongsTo(Download::class);
    }

    /**
     * Get the entity's transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'source');
    }
}
