<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Requests\Api\V1\Device;

use App\Http\Requests\Request;

/**
 * 设备注册请求
 * @property string $token
 * @property string $imei
 * @property string $imsi
 * @property string $model
 * @property string $vendor
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RegisterRequest extends Request
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
            'token' => [
                'required',
                'string',
            ],
            'os' => [
                'required',
                'string',
            ],
            'imei' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'imsi' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'model' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'vendor' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }
}
