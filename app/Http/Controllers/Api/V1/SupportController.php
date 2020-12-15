<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Support\StoreRequest;
use App\Models\Support;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 赞
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SupportController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 处理点赞
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $request)
    {
        $source = Support::getSourceModel($request->type, $request->id);
        if (!$source) {
            throw new NotFoundHttpException(404);
        }
        if ($source->supported($request->user())) {
            return response()->json(['status' => 'supported']);
        }
        $source->supports()->create(['user_id' => $request->user_id]);
        return response('success')->json(['status' => 'success']);
    }
}
