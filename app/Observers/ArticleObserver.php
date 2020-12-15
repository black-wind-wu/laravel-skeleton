<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Article;
use App\Services\FileService;

/**
 * 文章观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleObserver
{
    /**
     * Handle the "saving" event.
     *
     * @param Article $article
     * @return void
     */
    public function saving(Article $article)
    {
        $article->metas = array_merge([
            'title' => null,
            'keywords' => null,
            'description' => null
        ], is_array($article->metas) ? $article->metas : []);
        if ($article->status == Article::STATUS_APPROVED) {
            $article->pub_date = now();
        }
    }

    /**
     * Handle the "created" event.
     *
     * @param Article $article
     * @return void
     */
    public function created(Article $article)
    {
        $article->stopWords()->create();
        if ($article->user_id) {
            \App\Models\UserExtra::inc($article->user_id, 'articles');
        }
    }

    /**
     * 处理「更新」事件
     *
     * @param \App\Models\Article $article
     * @return void
     */
    public function updated(Article $article)
    {
        Article::forgetCache($article->id);
    }

    /**
     * 处理「删除」事件
     *
     * @param \App\Models\Article $article
     * @return void
     * @throws \Exception
     */
    public function deleted(Article $article)
    {
        Article::forgetCache($article->id);
    }

    /**
     * 处理「强制删除」事件
     *
     * @param Article $article
     * @return void
     * @throws \Exception
     */
    public function forceDeleted(Article $article)
    {
        if ($article->user_id) {
            \App\Models\UserExtra::dec($article->user_id, 'articles');
        }
        //删除缩略图
        if ($article->thumb_path) {
            FileService::deleteFile($article->thumb);
        }
        //删除附加表
        if ($article->detail) {
            //删除附件
            $files = FileService::getLocalFilesByContent($article->detail->content);
            foreach ($files as $file) {
                FileService::deleteFile($file);
            }
            $article->detail->delete();
        }
        Article::forgetCache($article->id);
    }
}
