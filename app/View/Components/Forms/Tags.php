<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Forms;

use App\Models\Tag;
use Illuminate\View\Component;

/**
 * 标签输入
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Tags extends Component
{
    /**
     * The input id attribute.
     *
     * @var string
     */
    public $id;

    /**
     * The input name attribute.
     *
     * @var string
     */
    public $name;

    /**
     * The input label.
     *
     * @var string
     */
    public $label;

    /**
     * @var array
     */
    public $options;

    /**
     * The selectable options.
     *
     * @var string
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string|null $value
     */
    public function __construct(string $name = "tag_values", string $label = "选择标签", string $placeholder = "请输入标签", string $value = null)
    {
        $this->id = 'form-' . $name;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        if ($value) {
            $this->options = Tag::query()->whereIn('id', explode(',', $value))->pluck('name', 'id');
        } else {
            $this->options = [];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.tags');
    }
}
