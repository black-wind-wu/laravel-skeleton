<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Coding 接口
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CodingController extends Controller
{
    protected $command = 'cd {base_path} & make reload 2>&1';

    /**
     * 处理回调
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        if ($request->header('x-coding-event') && $request->header('x-coding-signature')) {
            $signature = hash_hmac('sha1', $request->getContent(), settings('system.coding_token'));
            if ('sha1=' . $signature == $request->header('x-coding-signature')) {//检测签名
                switch ($request->header('x-coding-event')) {
                    case 'ping':
                        $message = 'pong';
                        break;
                    case 'push':
                        $repository = $request->post('repository');
                        if (!empty($repository['ssh_url'])) {
                            $command = strtr($this->command, [
                                '{base_path}' => escapeshellarg(base_path()),
                            ]);
                            $message = shell_exec($command);
                        } else {
                            $message = '版本错误!';
                        }
                        break;
                    default:
                        $message = '不支持处理该事件！';
                }
            } else {
                $message = '签名错误！';
            }
        } else {
            $message = '非法请求！';
        }
        return compact('message');
    }

    /**
     * 处理Ping事件
     * @return string
     */
    public function handlePing()
    {
        return 'pong';
    }

    /**
     * 处理 Push 事件
     * @param Request $request
     */
    public function handlePush(Request $request)
    {
        $repository = $request->post('repository');
        if (!empty($repository['ssh_url'])) {
            //重新加载本地代码
            $command = 'cd ' . str_replace('\\', '/\\', base_path()) . ' & make reload 2>&1';
            $message = shell_exec($command);
        } else {
            $message = '版本错误!';
        }
    }
}
