<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

/**
 * Class UsernameValidator
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UsernameValidator
{
    public $pattern = '/^[-a-zA-Z0-9_]+$/u';


    public function validate($attribute, $value, $parameters, $validator)
    {
        return preg_match($this->pattern, $value);
    }
}
