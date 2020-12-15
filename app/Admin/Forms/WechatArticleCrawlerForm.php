<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms;

use App\Jobs\Article\WechatCrawlerJob;
use App\Models\Category;
use Dcat\Admin\Widgets\Form;

/**
 * 微信文章导入表单
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WechatArticleCrawlerForm extends Form
{
    /**
     * 处理表单请求.
     *
     * @param array $input
     *
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function handle(array $input)
    {
        $url = trim($input['url']);
        $category_id = intval($input['category_id']);
        WechatCrawlerJob::dispatch($url, $category_id);
        return $this->response()->success('任务委派成功!')->refresh();
    }

    /**
     * 构建表单.
     */
    public function form()
    {
        $this->text('url')->required()->help('文章页面地址')->placeholder('https://mp.weixin.qq.com/s?src=11&timestamp=1607792402&ver=2762&signature=nA3FEF3Po=&new=1');
        $this->select('category_id', '导入栏目')->required()->options(Category::selectOptions());
    }

    /**
     * 返回表单数据.
     *
     * @return array
     */
    public function default()
    {
        return [
            'url' => '',
            'category_id' => 1,
        ];
    }
}
