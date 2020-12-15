<?php

namespace App\Admin\Actions;

use App\Admin\Forms\WechatArticleCrawlerForm;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * 微信文章导入
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WechatArticleCrawler extends Action
{
    /**
     * @return string
     */
    protected $title = '导入微信文章';

    /**
     * @return string|void
     */
    public function render()
    {
        $modal = Modal::make()
            ->title($this->title())
            ->body(WechatArticleCrawlerForm::make())
            ->lg()
            ->button(
                <<<HTML
<button class="btn btn-primary grid-refresh btn-mini btn-outline">{$this->title}</button>
HTML
            );

        return $modal->render();
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }
}
