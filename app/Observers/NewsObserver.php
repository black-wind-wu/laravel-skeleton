<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\News;

/**
 * Class NewsObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NewsObserver
{
    /**
     * 处理「saved」事件
     * @param News $news
     * @return void
     */
    public function saved(News $news)
    {
        //自动提取Tag
        if (empty($news->tag_values)) {
            \App\Jobs\News\ExtractTagJob::dispatch($news);
        }

        //提取关键词
        if (empty($news->keywords)) {
            \App\Jobs\News\ExtractKeywordJob::dispatch($news)->delay(now()->addSeconds(20));
        }
        News::forgetCache($news->id);
        $news->notifySearchEngines();
    }

    /**
     * 处理「删除」事件
     *
     * @param \App\Models\News $news
     * @return void
     * @throws \Exception
     */
    public function deleted(News $news)
    {
        News::forgetCache($news->id);
    }
}
