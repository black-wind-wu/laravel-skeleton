<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

/**
 * Class LinkSeeder
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::create([
            'title' => '拉瓦科技',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.larva.com.cn'
        ]);
        Link::create([
            'title' => '天智软件',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.tintsoft.com'
        ]);
        Link::create([
            'title' => 'YUNCMS',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.yuncms.net'
        ]);
        Link::create([
            'title' => '科技资讯',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.larvacent.com'
        ]);
        Link::create([
            'title' => 'Wifi管家',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.wifimanager.cn'
        ]);
        Link::create([
            'title' => '王者目录',
            'type' => Link::TYPE_HOME,
            'url' => 'https://www.wzdir.cn'
        ]);
    }

}
