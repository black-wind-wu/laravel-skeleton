<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Laravelium\Sitemap\Sitemap;

/**
 * 站点地图
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SitemapController extends Controller
{
    /**
     * @var int 每页数量
     */
    protected $mapChunk;

    /**
     * @var int 缓存分钟数
     */
    protected $cacheMinutes;

    /**
     * @var boolean 智能静态化
     */
    protected $smartStatic;

    /**
     * SitemapController constructor.
     */
    public function __construct()
    {
        $this->cacheMinutes = settings('system.sitemap_cache', 60);
        $this->smartStatic = settings('system.sitemap_static', false);
        $this->mapChunk = settings('system.sitemap_chunk', 2000);
    }

    /**
     * 站点地图首页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');
        $sitemap->setCache('sitemap', now()->addMinutes($this->cacheMinutes));
        if (!$sitemap->isCached()) {
            $sitemap->addSitemap(route('sitemap.misc'), now()->toRfc3339String());
            //文章总页数
            $articlePageNum = ceil(Article::getTotal() / $this->mapChunk);
            for ($i = 1; $i <= $articlePageNum; $i++) {
                $sitemap->addSitemap(route('sitemap.article', ['page' => $i]), now()->toRfc3339String());
            }
            //Tag 总页数
            $tagPageNum = ceil(Tag::getTotal() / $this->mapChunk);
            for ($i = 1; $i <= $tagPageNum; $i++) {
                $sitemap->addSitemap(route('sitemap.tag', ['page' => $i]), now()->toRfc3339String());
            }
        }
        /** @var \Illuminate\Http\Response $response */
        $response = $sitemap->render('sitemapindex');
        return $response;
    }

    /**
     * 单页地图
     * @return \Illuminate\Http\Response
     */
    public function misc()
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');
        $sitemap->setCache('sitemap.misc', 60);
        if (!$sitemap->isCached()) {
            // add items to the sitemap (url, date, priority, freq)
            $sitemap->add(URL::to('/'), now()->toRfc3339String(), '1.0', 'daily');
            $sitemap->add(URL::route('articles.index'), now()->toRfc3339String(), '0.8', 'always');
            $sitemap->add(URL::route('tag.index'), now()->toRfc3339String(), '0.8', 'always');
        }
        /** @var \Illuminate\Http\Response $response */
        $response = $sitemap->render('xml');
        return $response;
    }

    /**
     * 获取文章地图
     * @param Request $request
     * @param int $page
     * @return \Illuminate\Http\Response
     */
    public function articles(Request $request, $page = 1)
    {
        //总页数
        $totalPage = ceil(Article::getTotal() / $this->mapChunk);
        $offset = ($page - 1) * $this->mapChunk;
        if ($page < $totalPage) {//不是最后一页,不走缓存
            $storeFile = true;
            $items = Article::query()->take($this->mapChunk)->offset($offset)->get();
        } else {
            $items = Cache::store('file')->remember('sitemap:articles:' . $page, now()->addMinutes($this->cacheMinutes), function () use ($offset) {
                return Article::query()->take($this->mapChunk)->offset($offset)->get();
            });
        }

        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');
        foreach ($items as $item) {
            $sitemap->add($item->link, $item->created_at->toRfc3339String(), '0.8', 'daily');
        }
        /** @var \Illuminate\Http\Response $response */
        $response = $sitemap->render('xml');
        if (isset($storeFile) && $this->smartStatic) {
            $fileName = public_path($request->path());
            $this->storeFile($fileName, $response->getContent());
        }
        return $response;
    }

    /**
     * 获取 Tag 地图
     * @param Request $request
     * @param int $page
     * @return \Illuminate\Http\Response
     */
    public function tags(Request $request, $page = 1)
    {
        //总页数
        $totalPage = ceil(Tag::getTotal() / $this->mapChunk);
        $offset = ($page - 1) * $this->mapChunk;
        if ($page < $totalPage) {//不是最后一页,不走缓存
            $storeFile = true;
            $items = Tag::query()->take($this->mapChunk)->offset($offset)->get();
        } else {
            $items = Cache::store('file')->remember('sitemap:tags:' . $page, now()->addMinutes($this->cacheMinutes), function () use ($offset) {
                return Tag::query()->take($this->mapChunk)->offset($offset)->get();
            });
        }

        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');
        foreach ($items as $item) {
            $sitemap->add($item->link, $item->created_at->toRfc3339String(), '0.8', 'daily');
        }
        /** @var \Illuminate\Http\Response $response */
        $response = $sitemap->render('xml');
        if (isset($storeFile) && $this->smartStatic) {
            $fileName = public_path($request->path());
            $this->storeFile($fileName, $response->getContent());
        }
        return $response;
    }

    /**
     * 保存站点地图文件
     * @param string $fileName
     * @param string $content
     */
    protected function storeFile($fileName, $content)
    {
        $filePath = dirname($fileName);
        if (!File::isDirectory($filePath)) {
            File::makeDirectory($filePath, 0755, true);
        }
        File::put($fileName, $content);
    }
}
