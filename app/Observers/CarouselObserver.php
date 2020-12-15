<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Carousel;

/**
 * 轮播观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CarouselObserver
{
    /**
     * 处理「saved」事件
     * @param Carousel $carousel
     * @return void
     */
    public function saved(Carousel $carousel)
    {
        Carousel::forgetCache($carousel->id);
    }

    /**
     * 处理「删除」事件
     *
     * @param \App\Models\Carousel $carousel
     * @return void
     * @throws \Exception
     */
    public function deleted(Carousel $carousel)
    {
        Carousel::forgetCache($carousel->id);
    }
}
