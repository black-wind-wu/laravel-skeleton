<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ConfigResource;
use Illuminate\Http\Request;

/**
 * Class MainController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except([
            'config', 'mobileVerifyCode', 'mailVerifyCode', 'country', 'idCard', 'dnsRecord',
        ]);
    }

    /**
     * @return ConfigResource
     */
    public function config()
    {
        return new ConfigResource([
            'adsense_client' => settings('system.adsense_client'),
        ]);
    }

    /**
     * 短信验证码
     * @param \App\Http\Requests\Api\Main\MobileVerifyCodeRequest $request
     * @return mixed
     */
    public function mobileVerifyCode(\App\Http\Requests\Api\Main\MobileVerifyCodeRequest $request)
    {
        $verifyCode = \App\Services\MobileVerifyCodeService::make($request->mobile);
        $verifyCode->setIp($request->getClientIp());//记录客户端IP
        return $verifyCode->send();
    }

    /**
     * Mail验证码
     * @param \App\Http\Requests\Api\Main\MailVerifyCodeRequest $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function mailVerifyCode(\App\Http\Requests\Api\Main\MailVerifyCodeRequest $request)
    {
        $verifyCode = \App\Services\MailVerifyCodeService::make($request->email);
        $verifyCode->setIp($request->getClientIp());//记录客户端IP
        return $verifyCode->send();
    }

    /**
     * 获取国家列表
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function country(\Illuminate\Http\Request $request)
    {
        $items = \Larva\Supports\ISO3166::$countries;
        $countries = [];
        foreach ($items as $code => $value) {
            $country = [
                'label' => \Larva\Supports\ISO3166::country($code, \Illuminate\Support\Facades\App::getLocale()),
                'value' => $code
            ];
            $countries[] = $country;
        }
        return $countries;
    }

    /**
     * 身份证号码归属地
     * @param \App\Http\Requests\Api\Main\IDCardRequest $request
     * @return array|false
     */
    public function idCard(\App\Http\Requests\Api\Main\IDCardRequest $request)
    {
        return \Larva\Supports\IDCard::getInfo($request->id);
    }

    /**
     * 远程DNS解析
     * @param Request $request
     * @return array|string
     */
    public function dnsRecord(Request $request)
    {
        return \Larva\Supports\IPHelper::dnsRecord($request->input('host'), DNS_A, $request->input('only-ip', false));
    }
}
