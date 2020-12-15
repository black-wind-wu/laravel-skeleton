<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * 验证码控制器
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CaptchaController extends Controller
{
    /**
     * The name of the GET parameter indicating whether the CAPTCHA image should be regenerated.
     */
    const REFRESH_GET_VAR = 'refresh';

    /**
     * The response factory implementation.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * CodeController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Runs the action.
     * @param Request $request
     * @return array|string
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        if ($request->get(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = CaptchaService::make()->getVerifyCode(true);
            return $this->response->json([
                'hash1' => CaptchaService::make()->generateValidationHash($code),
                'hash2' => CaptchaService::make()->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::current() . '?v=' . uniqid('', true),
            ]);
        }
        return $this->response->make(CaptchaService::make()->renderImage(CaptchaService::make()->getVerifyCode()), 200, [
            'Pragma' => 'public',
            'Expires', '0',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Transfer-Encoding' => 'binary',
            'Content-type' => 'image/png',
        ]);
    }
}
