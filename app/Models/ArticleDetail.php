<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Larva\Censor\Models\StopWord;

/**
 * 文章内容
 * @property int $article_id
 * @property string $content
 * @property array $extra
 *
 * @property Article $article
 * @property StopWord $stopWords
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleDetail extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'article_details';

    /**
     * @var string 主键
     */
    protected $primaryKey = 'article_id';

    /**
     * @var bool 关闭主键自增
     */
    public $incrementing = false;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'content', 'extra',
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'article_id'
    ];

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'extra' => 'array',
    ];

    /**
     * Get the article relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Define the relationship with the article stop words.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stopWords()
    {
        return $this->hasOne(ArticleStopWord::class, 'article_id', 'article_id');
    }
}
