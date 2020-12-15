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
 * 邮箱注册
 * @property-read string $username
 * @property-read string $email
 * @property-read string $password
 * @property-read string $ticket
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MailRegisterRequest extends Request
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
        $rules = [
            'username' => 'required|string|max:255|nickname|keep_word|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
        if (config('app.env') != 'testing') {
            $rules['ticket'] = ['required', 'ticket:register'];//防水墙
        }
        return $rules;
    }
}
