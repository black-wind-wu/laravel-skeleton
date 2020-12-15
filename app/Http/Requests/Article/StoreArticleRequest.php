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
 * 文章存储请求
 * @property int $user_id;
 * @property int $category_id
 * @property string $title
 * @property string $content
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StoreArticleRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * 准备验证数据
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['numeric'],
            'category_id' => ['required', 'numeric', 'exists:categories,id',],
            'title' => ['required', 'string', 'max:40', 'min:5', 'text_censor'],
            'tag_values' => ['nullable', 'array'],
            'content' => ['required', 'string', 'text_censor'],
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
