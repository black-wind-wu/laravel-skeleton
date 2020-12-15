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
use Laravel\Passport\Events\RefreshTokenCreated;
use Laravel\Passport\Passport;

/**
 * Class AccessTokenRefreshListener
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AccessTokenRefreshListener
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
     * @param RefreshTokenCreated $event
     * @return void
     */
    public function handle(RefreshTokenCreated $event)
    {
        $token = Passport::token()->where('id', $event->accessTokenId)->first();
        if ($token && $token->user_id) {
            //User::find($token->user_id)->updateLogin(Request::ip(), Request::userAgent());
        }
    }
}
