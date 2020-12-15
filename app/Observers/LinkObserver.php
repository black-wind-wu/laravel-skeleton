<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Link;

/**
 * Class LinkObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LinkObserver
{
    /**
     * 处理「saved」事件
     * @param Link $link
     * @return void
     */
    public function saved(Link $link)
    {
        Link::forgetCache($link->id);
    }

    /**
     * 处理「删除」事件
     *
     * @param \App\Models\Link $link
     * @return void
     * @throws \Exception
     */
    public function deleted(Link $link)
    {
        Link::forgetCache($link->id);
    }
}
