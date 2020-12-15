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
 * 修改个人资料
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ModifyProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users|nickname',
            'birthday' => 'sometimes|date_format:Y-m-d',
            'gender' => 'nullable|integer|min:0|max:2',
            'country_code' => 'nullable|string',
            'province_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'introduction' => 'nullable|string',
            'bio' => 'nullable|string',
        ];
    }
}
