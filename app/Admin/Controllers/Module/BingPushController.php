<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use Larva\Bing\Push\Admin\Controllers\PushController;

/**
 * 必应推送
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BingPushController extends PushController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '必应推送';
    }
}
