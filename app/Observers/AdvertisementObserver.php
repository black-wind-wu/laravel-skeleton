<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Advertisement;

/**
 * Class AdvertisementObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AdvertisementObserver
{
    /**
     * 处理「saved」事件
     * @param Advertisement $advertisement
     * @return void
     */
    public function saved(Advertisement $advertisement)
    {
        Advertisement::forgetCache($advertisement->id);
    }

    /**
     * 处理「删除」事件
     *
     * @param \App\Models\Advertisement $advertisement
     * @return void
     * @throws \Exception
     */
    public function deleted(Advertisement $advertisement)
    {
        Advertisement::forgetCache($advertisement->id);
    }
}
