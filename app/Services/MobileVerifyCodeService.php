<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

use App\Jobs\MobileVerifyCodeSendJob;
use App\Sms\VerifyCodeMessage;
use Illuminate\Support\Facades\Cache;

/**
 * 手机验证码
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MobileVerifyCodeService
{
    /**
     * @var string
     */
    protected $mobile;

    /**
     * 两次获取验证码的等待时间
     * @var int
     */
    protected $waitTime;

    /**
     * 验证码有效期
     * @var int
     */
    protected $duration;

    /**
     * 验证码
     * @var int
     */
    protected $minLength;

    /**
     * 最长长度
     * @var int
     */
    protected $maxLength;

    /**
     * 静止验证码 功能测试时生成静止验证码
     * @var string
     */
    protected $fixedVerifyCode;

    /**
     * 允许尝试验证的次数
     * @var int
     */
    protected $testLimit;

    /**
     * @var string 请求的IP
     */
    protected $ip;

    /**
     * 缓存Tag
     * @var array
     */
    private $cacheTag;

    /**
     * 请求IPtag
     * @var array
     */
    private $ipTag;

    /**
     * SmsVerifyCode constructor.
     * @param string $mobile
     * @param int $minLength 验证码最短长度
     * @param int $maxLength 验证码最长长度
     * @param int $duration 验证码有效期
     * @param int $waitTime 两次获取验证码的等待时间
     * @param int $testLimit 允许的尝试次数
     * @param string $fixedVerifyCode 静态验证码
     */
    public function __construct($mobile, $minLength = 6, $maxLength = 6, $duration = 10, $waitTime = 120, $testLimit = 3, $fixedVerifyCode = null)
    {
        $this->mobile = $mobile;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->duration = $duration;
        $this->waitTime = $waitTime;
        $this->testLimit = $testLimit;
        $this->fixedVerifyCode = $fixedVerifyCode;
        $this->cacheTag = ['smsCaptcha', $mobile];
    }

    /**
     * 创建实例
     * @param string $mobile
     * @return $this
     */
    public static function make($mobile)
    {
        return new static($mobile);
    }

    /**
     * 设置静态验证码
     * @param string $code
     */
    public function setFixedVerifyCode($code)
    {
        $this->fixedVerifyCode = $code;
    }

    /**
     * 设置请求的IP地址
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        $this->ipTag = ['smsCaptcha', $ip];
        return $this;
    }

    /**
     * 发送验证码
     * @return array
     */
    public function send()
    {
        //两次获取间隔小于 指定的等待时间
        if (($waitTime = time() - Cache::tags($this->cacheTag)->get('sendTime')) < $this->waitTime) {
            $code = $this->getVerifyCode(false);
            return [
                'hash' => $this->generateValidationHash($code),
                'waitTime' => $this->waitTime - $waitTime,
                'mobile' => $this->mobile,
            ];
        } else {
            $sendCount = $this->getSendCount();
            $code = $this->getVerifyCode(true);
            Cache::tags($this->cacheTag)->set('sendCount', $sendCount + 1, 1440);//缓存1天

            $ipCount = $this->getIpSendCount();
            Cache::tags($this->ipTag)->set('ipCount', $ipCount + 1, 1440);//缓存1天

            //推到队列
            MobileVerifyCodeSendJob::dispatch($this->mobile, new VerifyCodeMessage(['code' => $code]));

            return [
                'hash' => $this->generateValidationHash($code),
                'waitTime' => $this->waitTime,
                'mobile' => $this->mobile,
            ];
        }
    }

    /**
     * 获取IP地址的发送次数
     * @return mixed
     */
    public function getIpSendCount()
    {
        return Cache::tags($this->ipTag)->get('sendCount', 0);
    }

    /**
     * 获取手机号发送次数
     * @return mixed
     */
    public function getMobileSendCount()
    {
        return Cache::tags($this->cacheTag)->get('sendCount', 0);
    }

    /**
     * 获取总发送次数
     * @return mixed
     */
    public function getSendCount()
    {
        return $this->getMobileSendCount() + $this->getIpSendCount();
    }

    /**
     * 获取验证码
     * @param boolean $regenerate 是否重新生成验证码
     * @return string 验证码
     */
    public function getVerifyCode($regenerate = false)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }
        $verifyCode = Cache::tags($this->cacheTag)->get('verifyCode');
        if ($verifyCode === null || $regenerate) {
            $verifyCode = $this->generateVerifyCode();
            Cache::tags($this->cacheTag)->set('verifyCode', $verifyCode, $this->waitTime);
            Cache::tags($this->cacheTag)->set('sendTime', time(), $this->waitTime);
            Cache::tags($this->cacheTag)->set('verifyCount', 0, $this->duration);
        }
        return $verifyCode;
    }

    /**
     * 验证输入，看看它是否与生成的代码相匹配
     * @param string $input user input
     * @param boolean $caseSensitive whether the comparison should be case-sensitive
     * @return boolean whether the input is valid
     */
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $count = Cache::tags($this->cacheTag)->get('verifyCount', 0);
        $count = $count + 1;
        if ($valid || $count > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }
        //更新计数器
        if (!$valid) {
            Cache::tags($this->cacheTag)->set('verifyCount', $count, $this->duration);
        } else {//验证通过清楚计时器
            Cache::tags($this->cacheTag)->forget('verifyCount');
        }
        return $valid;
    }


    /**
     * 生成一个可以用于客户端验证的哈希。
     * @param string $code 验证码
     * @return string 用户客户端验证的哈希码
     */
    public function generateValidationHash($code)
    {
        for ($h = 0, $i = strlen($code) - 1; $i >= 0; --$i) {
            $h += $code[$i];
        }
        return $h;
    }

    /**
     * 生成验证码
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 4) {
            $this->minLength = 4;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = '678906789067890678906';
        $vowels = '12345';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9) {
                $code .= $vowels[mt_rand(0, 4)];
            } else {
                $code .= $letters[mt_rand(0, 20)];
            }
        }
        return $code;
    }
}
