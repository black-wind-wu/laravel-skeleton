<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

/**
 * 图形验证码服务
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CaptchaService
{
    /**
     * @var int how many times should the same CAPTCHA be displayed. Defaults to 3.
     * A value less than or equal to 0 means the test is unlimited (available since version 1.1.2).
     */
    public $testLimit = 3;

    /**
     * @var int the width of the generated CAPTCHA image. Defaults to 120.
     */
    public $width = 120;

    /**
     * @var int the height of the generated CAPTCHA image. Defaults to 50.
     */
    public $height = 50;

    /**
     * @var int padding around the text. Defaults to 2.
     */
    public $padding = 2;

    /**
     * @var int the background color. For example, 0x55FF00.
     * Defaults to 0xFFFFFF, meaning white color.
     */
    public $backColor = 0xFFFFFF;

    /**
     * @var int the font color. For example, 0x55FF00. Defaults to 0x2040A0 (blue color).
     */
    public $foreColor = 0x2040A0;

    /**
     * @var bool whether to use transparent background. Defaults to false.
     */
    public $transparent = false;

    /**
     * @var int the minimum length for randomly generated word. Defaults to 6.
     */
    public $minLength = 6;

    /**
     * @var int the maximum length for randomly generated word. Defaults to 7.
     */
    public $maxLength = 7;

    /**
     * @var int the offset between characters. Defaults to -2. You can adjust this property
     * in order to decrease or increase the readability of the captcha.
     */
    public $offset = -2;

    /**
     * @var string the TrueType font file. This can be either a file path or [path alias](guide:concept-aliases).
     */
    public $fontFile;

    /**
     * @var string the fixed verification code. When this property is set,
     * [[getVerifyCode()]] will always return the value of this property.
     * This is mainly used in automated tests where we want to be able to reproduce
     * the same verification code each time we run the tests.
     * If not set, it means the verification code will be randomly generated.
     */
    public $fixedVerifyCode;

    /**
     * @var string the rendering library to use. Currently supported only 'gd' and 'imagick'.
     * If not set, library will be determined automatically.
     */
    public $imageLibrary;

    /**
     * @var $this
     */
    private static $object;

    /**
     * Constructor.
     * @param int $minLength 验证码最短长度
     * @param int $maxLength 验证码最长长度
     * @param int $testLimit 允许的尝试次数
     * @param string|null $fixedVerifyCode 静态验证码(用于单元测试)
     */
    public function __construct($minLength = 6, $maxLength = 6, $testLimit = 3, $fixedVerifyCode = null)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->testLimit = $testLimit;
        $this->fixedVerifyCode = $fixedVerifyCode;
        $this->fontFile = resource_path('fonts/SpicyRice.ttf');
    }

    /**
     * 创建实例
     * @return $this
     */
    public static function make()
    {
        if (!static::$object) {
            static::$object = new static();
        }
        return static::$object;
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
     * Generates a hash code that can be used for client-side validation.
     * @param string $code the CAPTCHA code
     * @return string a hash code generated from the CAPTCHA code
     */
    public function generateValidationHash($code)
    {
        for ($h = 0, $i = strlen($code) - 1; $i >= 0; --$i) {
            $h += ord($code[$i]);
        }
        return $h;
    }

    /**
     * Gets the verification code.
     * @param bool $regenerate whether the verification code should be regenerated.
     * @return string the verification code.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getVerifyCode($regenerate = false)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }
        $session = session();
        $name = $this->getSessionKey();
        if ($session->get($name) === null || $regenerate) {
            $session->put($name, $this->generateVerifyCode());
            $session->put($name . 'count', 1);
        }
        return $session->get($name);
    }

    /**
     * Validates the input to see if it matches the generated code.
     * @param string $input user input
     * @param bool $caseSensitive whether the comparison should be case-sensitive
     * @return bool whether the input is valid
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = session();
        $name = $this->getSessionKey() . 'count';
        $session->put($name, $session->get($name) + 1);
        if ($valid || $session->get($name) > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }

    /**
     * Generates a new verification code.
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 3) {
            $this->minLength = 3;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = 'bcdfghjklmnpqrstvwxyz';
        $vowels = 'aeiou';
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

    /**
     * Returns the session variable name used to store verification code.
     * @return string the session variable name
     */
    protected function getSessionKey()
    {
        return '__captcha';
    }

    /**
     * Renders the CAPTCHA image.
     * @param string $code the verification code
     * @return string image contents
     * @throws \Exception if imageLibrary is not supported
     */
    public function renderImage($code)
    {
        if (isset($this->imageLibrary)) {
            $imageLibrary = $this->imageLibrary;
        } else {
            $imageLibrary = $this->checkRequirements();
        }
        if ($imageLibrary === 'gd') {
            return $this->renderImageByGD($code);
        } elseif ($imageLibrary === 'imagick') {
            return $this->renderImageByImagick($code);
        }

        throw new \Exception("Defined library '{$imageLibrary}' is not supported");
    }

    /**
     * Renders the CAPTCHA image based on the code using GD library.
     * @param string $code the verification code
     * @return string image contents in PNG format.
     */
    protected function renderImageByGD($code)
    {
        $image = imagecreatetruecolor($this->width, $this->height);
        $backColor = imagecolorallocate(
            $image,
            (int)($this->backColor % 0x1000000 / 0x10000),
            (int)($this->backColor % 0x10000 / 0x100),
            $this->backColor % 0x100
        );
        imagefilledrectangle($image, 0, 0, $this->width - 1, $this->height - 1, $backColor);
        imagecolordeallocate($image, $backColor);

        if ($this->transparent) {
            imagecolortransparent($image, $backColor);
        }

        $foreColor = imagecolorallocate(
            $image,
            (int)($this->foreColor % 0x1000000 / 0x10000),
            (int)($this->foreColor % 0x10000 / 0x100),
            $this->foreColor % 0x100
        );

        $length = strlen($code);
        $box = imagettfbbox(30, 0, $this->fontFile, $code);
        $w = $box[4] - $box[0] + $this->offset * ($length - 1);
        $h = $box[1] - $box[5];
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 10;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $fontSize = (int)(mt_rand(26, 32) * $scale * 0.8);
            $angle = mt_rand(-10, 10);
            $letter = $code[$i];
            $box = imagettftext($image, $fontSize, $angle, $x, $y, $foreColor, $this->fontFile, $letter);
            $x = $box[2] + $this->offset;
        }

        imagecolordeallocate($image, $foreColor);

        ob_start();
        imagepng($image);
        imagedestroy($image);

        return ob_get_clean();
    }

    /**
     * Renders the CAPTCHA image based on the code using ImageMagick library.
     * @param string $code the verification code
     * @return string image contents in PNG format.
     * @throws \ImagickException
     */
    protected function renderImageByImagick($code)
    {
        $backColor = $this->transparent ? new \ImagickPixel('transparent') : new \ImagickPixel('#' . str_pad(dechex($this->backColor), 6, 0, STR_PAD_LEFT));
        $foreColor = new \ImagickPixel('#' . str_pad(dechex($this->foreColor), 6, 0, STR_PAD_LEFT));

        $image = new \Imagick();
        $image->newImage($this->width, $this->height, $backColor);

        $draw = new \ImagickDraw();
        $draw->setFont($this->fontFile);
        $draw->setFontSize(30);
        $fontMetrics = $image->queryFontMetrics($draw, $code);

        $length = strlen($code);
        $w = (int)$fontMetrics['textWidth'] - 8 + $this->offset * ($length - 1);
        $h = (int)$fontMetrics['textHeight'] - 8;
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 10;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $draw = new \ImagickDraw();
            $draw->setFont($this->fontFile);
            $draw->setFontSize((int)(mt_rand(26, 32) * $scale * 0.8));
            $draw->setFillColor($foreColor);
            $image->annotateImage($draw, $x, $y, mt_rand(-10, 10), $code[$i]);
            $fontMetrics = $image->queryFontMetrics($draw, $code[$i]);
            $x += (int)$fontMetrics['textWidth'] + $this->offset;
        }

        $image->setImageFormat('png');
        return $image->getImageBlob();
    }

    /**
     * Checks if there is graphic extension available to generate CAPTCHA images.
     * This method will check the existence of ImageMagick and GD extensions.
     * @return string the name of the graphic extension, either "imagick" or "gd".
     * @throws \Exception if neither ImageMagick nor GD is installed.
     */
    public static function checkRequirements()
    {
        if (extension_loaded('imagick')) {
            $imagickFormats = (new \Imagick())->queryFormats('PNG');
            if (in_array('PNG', $imagickFormats, true)) {
                return 'imagick';
            }
        }
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
            if (!empty($gdInfo['FreeType Support'])) {
                return 'gd';
            }
        }
        throw new \Exception('Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required.');
    }
}
