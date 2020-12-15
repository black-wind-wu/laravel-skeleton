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
 * 修改密码
 *
 * @property string $old_password
 * @property string $password
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ModifyPasswordRequest extends Request
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
            'old_password' => [
                'required',
                'string',
                'min:4',
                'hash:' . $this->user()->password,
            ],
            'password' => 'required|string|min:6',
        ];
    }

}
