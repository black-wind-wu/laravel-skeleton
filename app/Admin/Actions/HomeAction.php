<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Actions;

use Dcat\Admin\Actions\Action;

/**
 * 点击打开首页
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeAction extends Action
{
    /**
     * @return string|void
     */
    public function render()
    {
        $appUrl = config('app.url');
        return <<<HTML
<ul class="nav navbar-nav">
   <li class="nav-item"><a class="nav-link" href="{$appUrl}" target="_blank"><i class="fa fa-lg fa-fw fa-home"></i>前台主页</a></li>
</ul>
HTML;
    }
}
