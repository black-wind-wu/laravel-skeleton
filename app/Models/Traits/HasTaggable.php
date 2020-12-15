<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\Tag;

/**
 * 标签处理
 * @property Tag[] $tags
 * @property \Illuminate\Database\Eloquent\Model $this
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasTaggable
{
    protected $_tagValues;

    /**
     * Boot the trait.
     *
     * Listen for the deleting event of a model, then remove the relation between it and tags
     */
    protected static function bootHasTaggable(): void
    {
        static::saved(function ($model) {
            $model->delAllTags();
            $model->addTags($model->_tagValues);
        });
        static::deleted(function ($model) {
            $model->delAllTags();
        });
    }

    /**
     * @param array $tags
     */
    public function addTags($tags): void
    {
        if ($tags === null || empty($tags)) {
            return;
        }
        foreach ($tags as $value) {
            /* @var Tag $tag */
            $tag = Tag::firstOrCreate(['name' => $value], ['frequency' => 0]);
            $tag->increment('frequency');
            $this->tags()->save($tag);
        }
    }

    /**
     * 删除所有tag
     */
    public function delAllTags(): void
    {
        foreach ($this->tags as $tag) {
            if ($tag->frequency > 0) {
                $tag->decrement('frequency');
            }
        }
        $this->tags()->detach();
    }

    /**
     * 获取所有的标签
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * 获取逗号分隔的tag
     * @return string
     */
    public function getTagValuesAttribute()
    {
        return $this->tags()->pluck('name')->implode(',');
    }

    /**
     * 获取逗号分隔的tag ID
     * @return string
     */
    public function getTagIdsAttribute()
    {
        return $this->tags()->pluck('id')->implode(',');
    }

    /**
     * Sets tags.
     * @param array $values
     */
    public function setTagValuesAttribute($values)
    {
        $this->_tagValues = $this->filterTagValues($values);
    }

    /**
     * Filters tags.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterTagValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}
