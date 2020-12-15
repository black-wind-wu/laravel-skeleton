<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Larva\Sms\BaseMessage;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

/**
 * 短信验证码发送任务
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MobileVerifyCodeSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * 手机号
     * @var string
     */
    protected $mobile;

    /**
     * @var BaseMessage
     */
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param string $mobile
     * @param BaseMessage $message
     */
    public function __construct($mobile, BaseMessage $message)
    {
        $this->mobile = $mobile;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws NoGatewayAvailableException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function handle()
    {
        try {
            app('sms')->send($this->mobile, $this->message);
        } catch (NoGatewayAvailableException $exception) {
            foreach ($exception->getExceptions() as $e) {
                Log::error($e);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
