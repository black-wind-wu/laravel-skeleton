<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Passport\Client;

/**
 * Class PassportClient
 * @property int $id
 * @property string $name
 * @property string $secret
 * @property string $redirect
 * @property boolean $personal_access_client
 * @property boolean $password_client
 * @property boolean $revoked
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PassportClient extends Client
{
    use Traits\HasDateTimeFormatter;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //'secret',
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'personal_access_client' => false,
        'password_client' => false,
        'revoked' => false
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->secret)) {
                $model->secret = Str::random(40);
            }
        });

        static::updating(function ($model) {
            if (empty($model->secret)) {
                $model->secret = Str::random(40);
            }
        });
    }

    /**
     * 确定客户端是否应跳过授权提示
     *
     * @return bool
     */
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }

}
