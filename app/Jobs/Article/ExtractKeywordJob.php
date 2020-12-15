<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Jobs\Article;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 更新文章关键词
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ExtractKeywordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * @var Article
     */
    protected $article;

    /**
     * Create a new job instance.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     * @reurn void
     */
    public function handle()
    {
        $metas = $this->article->metas;
        if (!empty($this->article->tag_values)) {
            $metas['keywords'] = $this->article->tag_values;
        } else {
            $words = \Larva\Baidu\Cloud\Bce::get('nlp')->keywords($this->article->title, $this->article->detail->content);
            if (!empty($words) && is_array($words)) {
                $metas['keywords'] = implode(',', $words);
            }
        }
        $this->article->metas = $metas;
        $this->article->saveQuietly();
    }
}
