<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Sms;

use Larva\Sms\BaseMessage;
use Overtrue\EasySms\Contracts\GatewayInterface;

/**
 * 短信验证码
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class VerifyCodeMessage extends BaseMessage
{
    /**
     * @var int 验证码
     */
    protected $code;

    /**
     * @var array 可用网关
     */
    protected $gateways = ['qcloud', 'aliyun'];

    /**
     * @var array 短信模板ID
     */
    protected $templateCodes = [
        'aliyun' => 'SMS_176526437',
        'qcloud' => '485911',
        'yunpian' => '3354192'
    ];

    /**
     * 定义直接使用内容发送平台的内容
     * @param GatewayInterface|null $gateway
     * @return string
     */
    public function getContent(GatewayInterface $gateway = null)
    {
        if (!is_null($gateway) && $gateway->getName() == 'qcloud') {
            return sprintf('您的验证码为：%s，该验证码5分钟内有效，请勿泄漏于他人！', $this->code);
        } else if (!is_null($gateway) && $gateway->getName() == 'yunpian') {
            return sprintf('验证码：%s，如非本人操作，请忽略此短信。', $this->code);
        } else if (!is_null($gateway) && $gateway->getName() == 'aliyun') {
            return sprintf('验证码：%s，如非本人操作，请忽略此短信。', $this->code);
        }
        return null;
    }

    /**
     * 定义使用模板发送方式平台所需要的模板 ID
     * @param GatewayInterface|null $gateway
     * @return string
     */
    public function getTemplate(GatewayInterface $gateway = null)
    {
        return $this->templateCodes[$gateway->getName()];
    }

    /**
     * 模板参数
     * @param GatewayInterface|null $gateway
     * @return array
     */
    public function getData(GatewayInterface $gateway = null)
    {
        if (!is_null($gateway) && $gateway->getName() == 'qcloud') {
            return [$this->code];
        } else if (!is_null($gateway) && $gateway->getName() == 'yunpian') {
            return [$this->code];
        }else if (!is_null($gateway) && $gateway->getName() == 'aliyun') {
            return [$this->code];
        }
        return null;
    }
}
