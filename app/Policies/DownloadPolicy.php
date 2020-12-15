<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

/**
 * 下载策略
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DownloadPolicy extends Policy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Download $download
     * @return mixed
     */
    public function view(?User $user, Download $download)
    {
        if (!$download->isApproved) {
            if (!$user) {
                return $this->deny('该内容待审核！');
            } else if ($user && $user->id != $download->user_id) {
                return $this->deny('该内容待审核！');
            }
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
//        if (!$user->hasVerifiedMobile()) {
//            return $this->deny('您的邮箱还未验证，验证后才能进行该操作！');
//        } else if (!$user->hasVerifiedEmail()) {
//            return $this->deny('您的手机还未验证，验证后才能进行该操作！');
//        }
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param Download $download
     * @return mixed
     */
    public function update(User $user, Download $download)
    {
        return $user->id === $download->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param Download $download
     * @return mixed
     */
    public function delete(User $user, Download $download)
    {
        return $user->id === $download->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param Download $download
     * @return mixed
     */
    public function restore(User $user, Download $download)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param Download $download
     * @return mixed
     */
    public function forceDelete(User $user, Download $download)
    {
        //
    }
}
