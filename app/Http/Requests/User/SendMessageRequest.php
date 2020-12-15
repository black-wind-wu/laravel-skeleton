<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

/**
 * 发送短消息
 * @property int $to_user_id
 * @property string $content
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SendMessageRequest extends Request
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
            'to_user_id' => 'required|numeric|exists:users,id',
            'content' => 'required|string|max:191',
        ];
    }

    /**
     * 获取验证错误的自定义属性。
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'to_user_id' => '收件人',
            'content' => '内容',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'to_user_id.required' => '用户不能为空！',
            'to_user_id.exists' => '用户不存在！',
            'content.required' => '私信内容不能为空！'
        ];
    }
}
