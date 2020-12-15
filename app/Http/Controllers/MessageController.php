<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.arva.com.cn/
 * @license http://www.arva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Http\Requests\User\SendMessageRequest;
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
     * MessageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 收件箱
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $messages = Message::byUserId($request->user()->id)->paginate();
        return view('message.index', [
            'messages' => $messages,
        ]);
    }

    /**
     * 保存回信
     * @param SendMessageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SendMessageRequest $request)
    {
        $message = $request->validated();
        $message['from_user_id'] = $request->user()->getAuthIdentifier();
        Message::create($message);
        return redirect()->back();
    }

    /**
     * 查看会话
     * @param Request $request
     * @param int $user_id 发件人ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $user_id)
    {
        $fromUser = User::query()->where(['id' => $user_id])->firstOrFail();
        $messages = Message::sessions($request->user()->getAuthIdentifier(), $fromUser->id)->paginate();

        $messages->map(function ($message) use ($request) {
            if ($message->to_user_id == $request->user()->id) {
                $message->setRead();//设为已读
            }
        });

        return view('message.show', [
            'from' => $fromUser,
            'messages' => $messages
        ]);
    }
}
