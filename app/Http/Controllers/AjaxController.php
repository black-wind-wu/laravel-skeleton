<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class AjaxController
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AjaxController extends Controller
{
    /**
     * 前端 Ajax 获取用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $result = ['isLogin' => false];
        if (($user = $request->user()) != null) {
            $result = [
                'isLogin' => true,
                'id' => $user->id,
                'username' => $user->username,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'unreadNotificationCount' => $user->unreadNotifications()->count()
            ];
        }
        return response()->json($result);
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
}
