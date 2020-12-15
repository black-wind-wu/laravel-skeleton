<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Jobs\News;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 更新快讯关键词
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
     * @var News
     */
    protected $news;

    /**
     * Create a new job instance.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Execute the job.
     * @reurn void
     */
    public function handle()
    {
        if (!empty($this->news->tag_values)) {
            $this->news->keywords = $this->news->tag_values;
        } else {
            $words = \Larva\Baidu\Cloud\Bce::get('nlp')->keywords($this->news->title, $this->news->description);
            $this->news->keywords = implode(',', $words);
        }
        $this->news->saveQuietly();
    }
}
