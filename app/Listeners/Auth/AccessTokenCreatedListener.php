<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use Laravel\Passport\Events\AccessTokenCreated;

/**
 * 通过Passport登录后，更新用户
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AccessTokenCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AccessTokenCreated $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        if ($event->userId) {
            User::find($event->userId)->updateLogin(Request::ip(), Request::userAgent());
        }
    }
}
