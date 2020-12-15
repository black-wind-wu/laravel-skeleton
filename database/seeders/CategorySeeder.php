<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Class CategorySeeder
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => '默认文章栏目',
            'description' => '默认栏目',
            'type' => Category::TYPE_ARTICLE
        ]);
        Category::create([
            'name' => '默认下载栏目',
            'description' => '默认栏目',
            'type' => Category::TYPE_DOWNLOAD
        ]);
    }
}
