<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use App\Services\UserService;
use Illuminate\Database\Seeder;

/**
 * Class UsersSeeder
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserService::createByUsernameAndEmail('root', 'root@larva.com.cn', '12345678');
    }
}
