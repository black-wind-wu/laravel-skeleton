<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Download;

use App\Http\Requests\Request;

/**
 * 更新下载
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UpdateDownloadRequest extends Request
{
    /**
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
            'category_id' => ['required', 'numeric', 'exists:categories,id',],
            'title' => ['required', 'string', 'max:40', 'min:5', 'text_censor'],
            'description' => ['required', 'string', 'text_censor'],
            'tag_values' => ['nullable', 'array'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'category_id.numeric' => '必须选择一个栏目。',
        ];
    }
}
