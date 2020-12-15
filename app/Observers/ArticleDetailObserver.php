<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Jobs\Article\CensorJob;
use App\Models\ArticleDetail;

/**
 * 文章详情观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleDetailObserver
{
    /**
     * Handle the "saving" event.
     *
     * @param ArticleDetail $articleDetail
     * @return void
     */
    public function saving(ArticleDetail $articleDetail)
    {
        $articleDetail->extra = array_merge([
            'from' => null,
            'from_url' => null,
            'bd_daily' => 0
        ], is_array($articleDetail->extra) ? $articleDetail->extra : []);
    }

    /**
     * Handle the "saved" event.
     *
     * @param ArticleDetail $articleDetail
     * @return void
     */
    public function saved(ArticleDetail $articleDetail)
    {
        //内容审查
        CensorJob::dispatch($articleDetail->article);
        //自动提取Tag
        if (empty($articleDetail->article->tag_values)) {
            \App\Jobs\Article\ExtractTagJob::dispatch($articleDetail->article);
        }

        //提取关键词
        if (empty($articleDetail->article->metas['keywords'])) {
            \App\Jobs\Article\ExtractKeywordJob::dispatch($articleDetail->article)->delay(now()->addSeconds(20));
        }
        $articleDetail->article->notifySearchEngines();
    }
}
