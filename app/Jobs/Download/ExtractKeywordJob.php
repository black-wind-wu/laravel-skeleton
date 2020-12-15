<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Jobs\Download;

use App\Models\Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 更新下载关键词
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
     * @var Download
     */
    protected $download;

    /**
     * Create a new job instance.
     *
     * @param Download $download
     */
    public function __construct(Download $download)
    {
        $this->download = $download;
    }

    /**
     * Execute the job.
     * @reurn void
     */
    public function handle()
    {
        $metas = $this->download->metas;
        if (!empty($this->download->tag_values)) {
            $metas['keywords'] = $this->download->tag_values;
        } else {
            $words = \Larva\Baidu\Cloud\Bce::get('nlp')->keywords($this->download->title, $this->download->description);
            if (!empty($words) && is_array($words)) {
                $metas['keywords'] = implode(',', $words);
            }
        }
        $this->download->metas = $metas;
        $this->download->saveQuietly();
    }
}
