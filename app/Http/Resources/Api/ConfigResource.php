<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ConfigResource
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ConfigResource extends JsonResource
{
    /**
     * 禁用资源包裹
     *
     * @var string
     */
    public static $wrap = null;
}
