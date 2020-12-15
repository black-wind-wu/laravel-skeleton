<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Article;

use App\Http\Requests\Request;

/**
 * 更新文章
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UpdateArticleRequest extends Request
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
            'content' => ['required', 'string', 'text_censor'],
            'tag_values' => ['nullable', 'array'],
            'extra.from' => [
                'nullable', 'string', 'min:2', 'max:20', 'text_censor'
            ],
            'extra.from_url' => [
                'nullable', 'url'
            ],
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
