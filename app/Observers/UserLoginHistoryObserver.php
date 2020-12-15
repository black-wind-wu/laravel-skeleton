<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\UserLoginHistory;

/**
 * 用户登录记录
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserLoginHistoryObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param UserLoginHistory $loginHistory
     * @return void
     */
    public function created(UserLoginHistory $loginHistory)
    {
        //$ip = \App\Models\Ipv4Location::getLocation($loginHistory->ip);
        //$loginHistory->address = $ip->province . $ip->city . $ip->district;
        if ($loginHistory->device) {
            $loginHistory->browser = $loginHistory->device->browserName();
        }
        $loginHistory->saveQuietly();
        if (settings('user.enable_login_email')) {
            $loginHistory->user->notify(new \App\Notifications\LoginNotification($loginHistory));
        }
    }
}
