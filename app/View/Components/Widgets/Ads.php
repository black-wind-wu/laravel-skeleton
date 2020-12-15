<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Advertisement;
use Illuminate\View\Component;

/**
 * 广告
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Ads extends Component
{
    /**
     * 广告ID
     *
     * @var string
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.widgets.ads', [
            'advertisement' => Advertisement::findById($this->id)
        ]);
    }
}
