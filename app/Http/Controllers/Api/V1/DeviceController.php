<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Device\RegisterRequest;
use App\Http\Resources\Api\V1\User\DeviceResource;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;

/**
 * 设备接口
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DeviceController extends Controller
{
    /**
     * DeviceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register']);
    }

    /**
     * 设备注册
     * @param RegisterRequest $request
     * @return DeviceResource
     */
    public function register(RegisterRequest $request)
    {
        $device = UserDevice::findDevice($request->only(['token', 'os', 'imei', 'imsi', 'model', 'vendor', 'version']));
        if (Auth::guard('api')->check() && !$device->user_id) {
            $device->connect(Auth::guard('api')->user());
        }

        return new DeviceResource($device);
    }
}
