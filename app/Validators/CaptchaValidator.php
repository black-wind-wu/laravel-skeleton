<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

use App\Services\CaptchaService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * 验证码验证
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CaptchaValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $service = CaptchaService::make();
        if (config('app.env') == 'testing') {
            $service->setFixedVerifyCode(1234);
        }
        try {
            if ($service->validate($value, false)) {
                return true;
            }
        } catch (BindingResolutionException $e) {
        }
        return false;
    }
}
