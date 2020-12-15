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
use Larva\Censor\Censor;
use Larva\Censor\CensorNotPassedException;

/**
 * 内容审查
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CensorJob implements ShouldQueue
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

    /** @var Article */
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
        $stopWords = [];
        $censor = Censor::make();
        try {
            $this->article->title = $censor->textCensor($this->article->title);
            $this->article->detail->content = $censor->textCensor($this->article->detail->content);
            if ($censor->isMod) {//如果标题命中了关键词就放入待审核
                $this->article->status = Article::STATUS_PENDING;
                $stopWords = array_unique($censor->wordMod);
            }
        } catch (CensorNotPassedException $e) {
            $stopWords = array_unique($censor->wordBanned);
            $this->article->status = Article::STATUS_REJECTED;
        }

        $this->article->saveQuietly();
        $this->article->detail->saveQuietly();

        Article::forgetCache($this->article->id);
        // 记录触发的审核词
        if (($this->article->status != Article::STATUS_APPROVED) && $stopWords) {
            $this->article->stopWords->stop_word = implode(',', $stopWords);
            $this->article->stopWords->saveQuietly();
        }
    }
}
