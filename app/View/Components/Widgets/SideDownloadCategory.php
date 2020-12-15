<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Category;
use Illuminate\View\Component;

/**
 * 边栏栏目
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SideDownloadCategory extends Component
{
    /**
     * @var int|null
     */
    public $category_id;

    /**
     * @var Category[]
     */
    public $categories;

    /**
     * Create a new component instance.
     *
     * @param string $id
     */
    public function __construct(string $id = "")
    {
        $this->category_id = intval($id);
        $this->categories = Category::getRootNodes(Category::TYPE_DOWNLOAD);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.widgets.side_download_category');
    }
}
