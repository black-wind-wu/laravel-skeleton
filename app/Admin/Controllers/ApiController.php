<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class ApiController
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ApiController extends Controller
{
    /**
     * 加载地区
     * @param Request $request
     * @return mixed
     */
    public function regions(Request $request)
    {
        $parent_id = $request->get('q');
        return \App\Models\Region::getRegion($parent_id, ['id', \Illuminate\Support\Facades\DB::raw('name as text')]);
    }

    /**
     * 按类别加载栏目
     * @param Request $request
     * @return array
     */
    public function categories(Request $request)
    {
        $type = $request->get('q');
        $categories = Category::selectOptions(function ($query) use ($type) {
            return $query->where('type', $type);
        });
        $options = [];
        foreach ($categories as $id => $category) {
            $options[] = ['id' => $id, 'text' => html_entity_decode($category)];
        }
        return $options;
    }

    /**
     * Tag Ajax加载
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function users(Request $request)
    {
        $query = \App\Models\User::query()->select(['id', 'username'])->orderByDesc('id');
        $q = $request->get('q');
        if (mb_strlen($q) >= 2) {
            $query->where('username', 'LIKE', '%' . $q . '%');
        }
        return $query->paginate(10);
    }

    /**
     * Tag Ajax加载
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function tags(Request $request)
    {
        $query = \App\Models\Tag::query()->select(['id', 'name', 'frequency'])->orderByDesc('frequency');
        $q = $request->get('q');
        if (mb_strlen($q) >= 1) {
            $query->where('name', 'LIKE', '%' . $q . '%');
        }
        return $query->paginate(10);
    }
}
