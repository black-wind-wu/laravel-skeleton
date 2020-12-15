<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * 点赞表
 * @property int $id
 * @property int $user_id
 * @property int $source_id
 * @property string $souce_type
 * @property Model $source
 *
 * @property User $user
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Support extends Model
{
    use Traits\HasDateTimeFormatter;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'supports';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'source_id', 'source_type'
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
     * 多态关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function source()
    {
        return $this->morphTo();
    }

    /**
     * 获取Source模型
     * @param string $type
     * @param int $id
     * @return null
     */
    public static function getSourceModel($type, $id)
    {
        $class = Relation::getMorphedModel($type);
        if (!$class) {
            return null;
        }
        return $class::find($id);
    }
}
