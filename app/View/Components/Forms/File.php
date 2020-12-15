<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Forms;

use Illuminate\View\Component;

/**
 * 文件上传
 * @author Tongle Xu <xutongle@gmail.com>
 */
class File extends Component
{
    /**
     * The input id attribute.
     *
     * @var string
     */
    public $id;

    /**
     * The input name.
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
     * The input placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * @var string
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param string $value
     * @param string $placeholder
     */
    public function __construct($name = "text", $label = "Text Input", $value = "", $placeholder = "Enter Text")
    {
        $this->id = 'form-' . $name;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.file');
    }
}
