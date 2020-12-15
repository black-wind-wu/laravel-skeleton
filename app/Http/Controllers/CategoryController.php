<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Download;

/**
 * 栏目页
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of the content.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Category $category)
    {
        if (Category::TYPE_ARTICLE == $category->type) {
            $items = Article::approved()->with('user')->byCategoryId($category->id)->orderByDesc('order')->orderByDesc('id')->paginate(15);
            return view('article.index', [
                'items' => $items,
                'category' => $category,
            ]);
        } else if (Category::TYPE_DOWNLOAD == $category->type) {
            $items = Download::approved()->with('user')->byCategoryId($category->id)->orderByDesc('id')->paginate(15);
            return view('download.index', [
                'items' => $items,
                'category' => $category,
            ]);
        }
    }
}
