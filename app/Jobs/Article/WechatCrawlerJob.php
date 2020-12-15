<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Jobs\Article;

use App\Models\Article;
use App\Models\User;
use App\Services\FileService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use QL\QueryList;

/**
 * 微信内容爬虫
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WechatCrawlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var int
     */
    protected $userId;

    /**
     * Constructor.
     * @param string $url
     * @param int $category_id 文章栏目ID
     * @param int|null $user_id 文章作者ID
     */
    public function __construct($url, $category_id = 6, $user_id = null)
    {
        $this->url = $url;
        $this->categoryId = $category_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36'
        ])->get($this->url);
        if ($response->ok()) {
            $ql = QueryList::html($response->body());
            preg_match("#<meta property=\"og:image\" content=\"(.*?)\" />#i", $response->body(), $link);
            $title = $ql->find('.rich_media_title')->text();
            $author = $ql->find('.profile_nickname')->text();
            $wx = $ql->find('.profile_meta_value:eq(0)')->text();
            $bio = $ql->find('.profile_meta_value:eq(1)')->text();
            $content = str_replace('data-src', 'src', $ql->find('.rich_media_content')->html());
            $content = str_replace("preview.html", "player.html", $content);
            if (($user = User::query()->where('username', $author)->first()) == null) {//查找作者
                $user = UserService::createByUsernameAndEmail($author, $wx . '@com.cn', '');
                $user->profile->update(['bio' => $bio]);
            }
            if (!empty($title) && !Article::query()->where('title', $title)->exists()) {
                $article = new Article([
                    'title' => $title,
                    'category_id' => $this->categoryId,
                    'user_id' => $user->id,
                ]);

                if (!empty($this->userId)) {
                    $article->user_id = $this->userId;
                }
                if ($link && isset($link[1])) {
                    $article->thumb_path = FileService::saveRemoteFile($link[1]);
                }
                if ($article->save()) {
                    $article->detail()->create([
                        'content' => $content,
                        'extra' => [
                            'from' => $author
                        ],
                    ]);
                }
            }
        }
    }
}
