<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Message\SendMessageRequest;
use App\Http\Resources\Api\V1\Message\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * 站内信
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MessageController extends Controller
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 查询我发给别的或者别发给我的话题列表
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $messages = Message::byUserId($request->user()->id)->paginate();
        return MessageResource::collection($messages);
    }

    /**
     * 发送短消息
     * @param SendMessageRequest $request
     * @return MessageResource
     */
    public function store(SendMessageRequest $request)
    {
        $att = $request->validated();
        $att['from_user_id'] = $request->user()->id;
        $message = Message::create($att);
        return new MessageResource($message);
    }

    /**
     * 查看会话详情
     * @param Request $request
     * @param int $user_id 对方UID
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Request $request, $user_id)
    {
        $fromUser = User::query()->where(['id' => $user_id])->firstOrFail();
        $messages = Message::sessions($request->user()->id, $fromUser->id)->paginate();
        return MessageResource::collection($messages);
    }

    /**
     * 消息删除
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        /** @var Message $message */
        $message = Message::query()->where('id', '=', $id)->firstOrFail();

        if ($message->to_user_id === $request->user()->id) {
            $message->update(['to_deleted' => 1]);
        } else if ($message->from_user_id === $request->user()->id) {
            $message->update(['from_deleted' => 1]);
        }
        if ($message->to_deleted == 1 && $message->from_deleted == 1) {
            $message->delete();
        }
        return $this->withNoContent();
    }
}
