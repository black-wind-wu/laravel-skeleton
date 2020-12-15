<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\Main;

use App\Http\Requests\Request;

/**
 * 邮件验证码请求
 * @property string $email
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MailVerifyCodeRequest extends Request
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
        $rules =  [
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                'mail_verify'
            ],
        ];
        if (config('app.env') != 'testing') {
            $rules['ticket'] = ['required', 'ticket:verify_code'];//防水墙
        }
        return $rules;
    }
}
