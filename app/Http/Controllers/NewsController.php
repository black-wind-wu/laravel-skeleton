<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;

/**
 * 快讯
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NewsController extends Controller
{

    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $items = News::query()->orderByDesc('id')->paginate(15);
        return view('news.index', [
            'items' => $items
        ]);
    }

    /**
     * 快讯Tag页
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function tag(Tag $tag)
    {
        $items = $tag->news()->paginate(15);
        return view('news.tag', [
            'items' => $items,
            'tag' => $tag
        ]);
    }

    /**
     * Display the specified news.
     *
     * @param \App\Models\News $news
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(News $news)
    {
        /*查看数+1*/
        $news->increment('views');
        return view('news.show', [
            'news' => $news
        ]);
    }
}
