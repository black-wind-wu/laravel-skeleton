<?php

namespace App\View\Components\Widgets;

use App\Models\Link;
use Illuminate\View\Component;

/**
 * 首页友情链接
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeLink extends Component
{
    /**
     * 友情连接 类型。
     *
     * @var string
     */
    public $type;

    /**
     * 缓存时间
     *
     * @var int
     */
    public $cacheMinutes;

    /**
     * Create a new component instance.
     *
     * @param int $cacheMinutes
     */
    public function __construct($cacheMinutes = 5)
    {
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.widgets.link', [
            'links' => Link::home($this->cacheMinutes)
        ]);
    }
}
