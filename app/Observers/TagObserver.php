<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

/**
 * 标签观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TagObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param Tag $tag
     * @return void
     */
    public function created(Tag $tag)
    {

    }

    /**
     * 处理「强制删除」事件
     *
     * @param Tag $tag
     * @return void
     * @throws \Exception
     */
    public function forceDeleted(Tag $tag)
    {
        //清理数据库 Tag 关联
        DB::table('taggables')->where('tag_id', $tag->id)->delete();
    }
}
