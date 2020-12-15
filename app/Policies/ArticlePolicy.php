<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

/**
 * 文章策略
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticlePolicy extends Policy
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
     * @param \App\Models\User $user
     * @param \App\Models\Article $article
     * @return mixed
     */
    public function view(?User $user, Article $article)
    {
        if (!$article->isApproved) {
            if (!$user) {
                return $this->deny('该内容待审核！');
            } else if ($user && $user->id != $article->user_id) {
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
     * @param \App\Models\Article $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Article $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Article $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Article $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
