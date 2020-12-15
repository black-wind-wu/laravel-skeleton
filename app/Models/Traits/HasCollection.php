<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\User;
use App\Models\UserCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HasCollection
 *
 * @property \Illuminate\Database\Eloquent\Model $this
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasCollection
{
    /**
     * Boot the trait.
     *
     * Listen for the deleting event of a model, then remove the relation between it and tags
     */
    protected static function bootHasCollection(): void
    {
        static::saved(function ($model) {
            $model->source()->increment('collection_count');
        });
        static::deleted(function ($model) {
            $model->source()->where('collection_count', '>', 0)->decrement('collection_count');
        });
    }

    /**
     * Collection Relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function collections()
    {
        return $this->morphMany(UserCollection::class, 'source');
    }

    /**
     * 获取收藏
     * @param User $user
     * @return UserCollection|Model|\Illuminate\Database\Eloquent\Relations\MorphMany|object
     */
    public function getCollection($user)
    {
        return $this->collections()->where(['user_id' => $user->id])->first();
    }

    /**
     * 是否收藏过
     * @param User $user
     * @return bool
     */
    public function isCollected($user)
    {
        return $this->collections()->where(['user_id' => $user->id])->exists();
    }
}
