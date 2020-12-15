<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\Support;
use App\Models\User;

/**
 * Trait HasAttention
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasAttention
{
    /**
     * Boot the trait.
     *
     * Listen for the deleting event of a model, then remove the relation between it and tags
     */
    protected static function bootHasAttention(): void
    {
        static::saved(function ($model) {
            $model->source()->increment('followers');
        });
        static::deleted(function ($model) {
            $model->source()->where('followers', '>', 0)->decrement('support_count');
        });
    }

    /**
     * support Relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function supports()
    {
        return $this->morphMany(Support::class, 'source');
    }

    /**
     * 是否赞过
     * @param User $user
     * @return bool
     */
    public function supported($user)
    {
        return $this->supports()->where(['user_id' => $user->id])->exists();
    }
}
