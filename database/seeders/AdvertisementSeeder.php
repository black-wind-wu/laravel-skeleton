<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

/**
 * 广告填充
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::create(['id' => 1, 'name' => '边栏上', 'body' => '边栏广告上']);
        Advertisement::create(['id' => 2, 'name' => '边栏下', 'body' => '边栏广告下']);
        Advertisement::create(['id' => 3, 'name' => '内容页上', 'body' => '内容广告上']);
        Advertisement::create(['id' => 4, 'name' => '内容页下', 'body' => '内容广告下']);
        Advertisement::create(['id' => 5, 'name' => '首页内容穿插', 'body' => '首页内容穿插']);
    }
}
