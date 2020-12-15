<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Download;
use App\Services\FileService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * 下载观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DownloadObserver
{
    /**
     * Handle the "saving" event.
     *
     * @param Download $download
     * @return void
     */
    public function saving(Download $download)
    {
        $download->metas = array_merge([
            'title' => null,
            'keywords' => null,
            'description' => null
        ], is_array($download->metas) ? $download->metas : []);

    }

    /**
     * Handle the "created" event.
     *
     * @param Download $download
     * @return void
     */
    public function created(Download $download)
    {
        $download->stopWords()->create();
        if ($download->user_id) {
            \App\Models\UserExtra::inc($download->user_id, 'downloads');
        }
    }

    /**
     * 处理「更新」事件
     *
     * @param Download $download
     * @return void
     */
    public function updated(Download $download)
    {
        Download::forgetCache($download->id);
    }

    /**
     * 处理「删除」事件
     *
     * @param Download $download
     * @return void
     */
    public function deleted(Download $download)
    {
        Download::forgetCache($download->id);
    }

    /**
     * 处理「强制删除」事件
     *
     * @param Download $download
     * @return void
     */
    public function forceDeleted(Download $download)
    {
        if ($download->user_id) {
            \App\Models\UserExtra::dec($download->user_id, 'downloads');
        }
        //删除附件
        FileService::deleteFile($download->file_path);
        Download::forgetCache($download->id);
    }
}
