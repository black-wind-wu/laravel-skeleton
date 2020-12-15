<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.arva.com.cn/
 * @license http://www.arva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 站内信
 * @property int $id 消息ID
 * @property int $to_user_id 收件人
 * @property int $from_user_id 发件人
 * @property string $content 消息内容
 * @property boolean $is_read 是否已读
 * @property boolean $from_deleted 发送方已删除
 * @property boolean $to_deleted 接收方删除
 * @property User $user
 * @property User $from
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Message byUserId($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Message sessions($to_user_id, $from_user_id)
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Message extends Model
{
    use Traits\HasDateTimeFormatter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    protected $fillable = [
        'to_user_id', 'from_user_id', 'content', 'is_read', 'from_deleted', 'to_deleted'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'is_read' => false,
        'from_deleted' => false,
        'to_deleted' => false,
    ];

    /**
     * 查询指定用户话题列表
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUserId($query, $user_id)
    {
        return $query->where('to_user_id', $user_id)
            ->where('to_deleted', '=', false)
            ->groupBy('from_user_id')
            ->orderByDesc('created_at');
    }

    /**
     * 获取会话列表
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $to_user_id
     * @param int $from_user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSessions($query, $to_user_id, $from_user_id)
    {
        // 设置该对话全部未读为已读
        static::where('to_user_id', '=', $to_user_id)->where('is_read', '=', true)->update(['is_read' => true]);

        return $query->where(function ($query) use ($from_user_id, $to_user_id) {
            $query->where('to_user_id', '=', $to_user_id)
                ->where('from_user_id', '=', $from_user_id)
                ->where('to_deleted', '=', false);
        })->orWhere(function ($query) use ($from_user_id, $to_user_id) {
            $query->where('to_user_id', '=', $from_user_id)
                ->where('from_user_id', '=', $to_user_id)
                ->where('from_deleted', '=', false);
        })->orderByDesc('created_at');
    }

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    /**
     * Get the from relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function from()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    /**
     * 设置已读
     * @return bool
     */
    public function setRead()
    {
        return $this->update(['is_read' => true]);
    }
}
