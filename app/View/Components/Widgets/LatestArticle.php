<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Article;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

/**
 * 获取最新文章
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LatestArticle extends Component
{
    /**
     * @var int
     */
    public $limit;

    /**
     * 文章栏目
     *
     * @var int
     */
    public $category;

    /**
     * 缓存时间
     *
     * @var int
     */
    public $cacheMinutes;

    /**
     * Create a new component instance.
     *
     * @param int $limit
     * @param int|null $category
     * @param int $cacheMinutes
     */
    public function __construct($limit = 10, $category = null, $cacheMinutes = 5)
    {
        $this->limit = $limit;
        $this->category = $category;
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->category == null) {
            $items = Article::latest($this->limit);
        } else {
            $ids = Cache::remember(Article::CACHE_TAG . $this->category . $this->limit, Carbon::now()->addMinutes($this->cacheMinutes), function () {
                return Article::approved()->byCategoryId($this->category)->orderByDesc('id')->pluck('id');
            });
            $items = $ids->map(function ($id) {
                return Article::findById($id);
            });
        }
        return view('components.widgets.latest_article', [
            'items' => $items
        ]);
    }
}
