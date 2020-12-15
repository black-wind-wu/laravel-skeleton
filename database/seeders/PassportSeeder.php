<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Passport;

/**
 * Class PassportSeeder
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Passport::client()->forceFill([
            'name' => '测试项目',
            'secret' => '4RY5mYUz95kmufjqCJvo2KxMw2yCe1WrZcEqc94C',
            'redirect' => 'https://dev.larvacms.cn',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ])->save();
    }
}
