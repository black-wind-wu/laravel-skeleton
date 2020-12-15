<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Category;
use App\Services\FileService;

/**
 * Class CategoryObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CategoryObserver
{
    /**
     * 处理「强制删除」事件
     *
     * @param Category $category
     * @return void
     * @throws \Exception
     */
    public function forceDeleted(Category $category)
    {
        //删除缩略图
        if ($category->image) {
            FileService::deleteFile($category->image);
        }
    }
}
