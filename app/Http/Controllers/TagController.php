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
 * Tag 页
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TagController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Tag 首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tags = Tag::query()->orderByDesc('frequency')->paginate(100);
        return view('tag.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Tag 详情
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Tag $tag)
    {
        return response()->redirectToRoute('tag.articles', $tag);
    }
}
