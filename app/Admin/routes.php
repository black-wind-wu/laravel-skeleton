<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'as' => 'admin.',
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('settings', 'HomeController@settings')->name('settings');

    //Api
    $router->get('api/tags', 'ApiController@tags');
    $router->get('api/users', 'ApiController@users');
    $router->get('api/regions', 'ApiController@regions');
    $router->get('api/categories', 'ApiController@categories');

    //数据管理
    $router->resource('dictionary/stop-words', 'Dictionary\StopWordController');
    $router->resource('dictionary/region', 'Dictionary\RegionController');
    $router->resource('dictionary/mail-codes', 'Dictionary\MailCodeController')->only(['index']);
    $router->resource('dictionary/mobile-codes', 'Dictionary\MobileCodeController')->only(['index']);

    //内容
    $router->resource('content/categories', 'Content\CategoryController');
    $router->resource('content/articles', 'Content\ArticleController');
    $router->resource('content/downloads', 'Content\DownloadController');
    $router->resource('content/news', 'Content\NewsController');
    $router->resource('content/tags', 'Content\TagController');

    //用户
    $router->resource('user/clients', 'User\ClientController');
    $router->resource('user/members', 'User\MemberController');
    $router->resource('user/socials', 'User\SocialController')->only(['index', 'show']);

    //模块
    $router->resource('module/links', 'Module\LinkController');
    $router->resource('module/baidu-push', 'Module\BaiduPushController');
    $router->resource('module/bing-push', 'Module\BingPushController');
    $router->resource('module/advertisements', 'Module\AdvertisementController');
    $router->resource('module/carousels', 'Module\CarouselController');

});
