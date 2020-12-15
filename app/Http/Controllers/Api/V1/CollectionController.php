<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Collection\StoreRequest;
use App\Models\UserCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 收藏
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CollectionController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 处理收藏
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $request)
    {
        $source = UserCollection::getSourceModel($request->type, $request->id);
        if (!$source) {
            throw new NotFoundHttpException(404);
        }
        if (($collection = $source->getCollection($request->user())) != null) {
            $collection->delete();
            return response()->json(['status' => 'uncollect']);
        }
        $source->collections()->create(['user_id' => $request->user_id]);
        return response()->json(['status' => 'collected']);
    }
}
