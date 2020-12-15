<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Article;
use Illuminate\View\Component;

/**
 * Class HomeArticle
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeArticle extends Component
{
    /**
     * @var int
     */
    public $limit;

    /**
     * Create a new component instance.
     *
     * @param int $limit
     * @param int $cacheMinutes
     */
    public function __construct($limit = 10)
    {
        $this->limit = $limit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.widgets.home_article', [
            'items' => Article::latest($this->limit)
        ]);
    }
}
