<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Forms;

use App\Models\Category;
use Illuminate\View\Component;

/**
 * 栏目选择器
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleCategorySelect extends Component
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
     * @var string
     */
    public $value;

    /**
     * The selectable options.
     *
     * @var string
     */
    public $placeholder;

    /**
     * The selectable categories.
     *
     * @var array
     */
    public $categories;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param string $value
     * @param string $placeholder
     */
    public function __construct(string $name = "category_id", string $label = "栏目",  $value = "", string $placeholder = "请选择栏目")
    {
        $this->id = 'form-' . $name;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->categories = Category::getRootSelect(Category::TYPE_ARTICLE);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.category-select');
    }
}
