<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * 登录历史响应
 *
 * @mixin \App\Models\UserLoginHistory
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LoginHistoriesResource extends JsonResource
{
    /**
     * 禁用资源包裹
     *
     * @var string
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ip' => $this->ip,
            'user_agent' => $this->user_agent,
            'address' => $this->address,
            'browser' => $this->browser,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
