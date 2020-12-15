<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 内容涉及的敏感词表
 * @property int $article_id
 * @property string $stop_word
 * @property Article $article
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleStopWord extends Model
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
    protected $table = 'article_stopwords';

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
        'article_id', 'stop_word'
    ];

    /**
     * Define the relationship with the article's mod stop words.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
