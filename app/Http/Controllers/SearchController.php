<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * 搜索
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SearchController extends Controller
{
    /**
     * Display search page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        if (!$request->has('q') || empty($request->get('q'))) {
            return view('search.index');
        }
        return $this->callAction('query', ['q' => $request->get('q')]);
    }

    /**
     * 搜索结果
     * @param string $q
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function query(string $q)
    {
        if (($tag = Tag::findByName($q)) != null) {//检查Tag是否命中
            return redirect()->route('tag.show', $tag);
        } else if (($tag = Tag::findByName($q)) != null) {//检查词库命中
            return redirect()->route('tag.show', $tag);
        }
        //开始搜索
        $items = [];
        return view('search.list', ['items' => $items, 'q' => $q]);
    }
}
