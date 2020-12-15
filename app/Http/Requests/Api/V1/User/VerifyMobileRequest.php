<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Request;

/**
 * 验证手机号码请求
 * @property-read int $mobile
 * @property-read string $verifyCode
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class VerifyMobileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => [
                'required',
                'max:11',
                'mobile',
                'exists:users',
            ],
            'verify_code' => [
                'required',
                'min:4',
                'max:6',
                'mobile_verify_code:mobile',
            ],
        ];
    }
}
