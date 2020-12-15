<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use Larva\Baidu\Push\Admin\Controllers\PushController;

/**
 * 百度推送
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPushController extends PushController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '百度推送';
    }
}
