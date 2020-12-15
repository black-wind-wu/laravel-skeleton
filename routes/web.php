<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\MainController::class, 'index']);
Route::get('captcha', \App\Http\Controllers\CaptchaController::class)->name('captcha');

Illuminate\Support\Facades\Auth::routes(['verify' => true]);
Route::get('register/mobile', [\App\Http\Controllers\Auth\RegisterController::class, 'showMobileRegistrationForm'])->name('mobile.register');
Route::post('register/mobile', [\App\Http\Controllers\Auth\RegisterController::class, 'mobileRegister'])->name('mobile.register.store');

//社交账户登录
Route::get('auth/social/{provider}', [\App\Http\Controllers\Auth\SocialController::class, 'redirectToProvider']);
Route::get('auth/social/{provider}/callback', [\App\Http\Controllers\Auth\SocialController::class, 'handleProviderCallback']);
Route::get('auth/social/{provider}/binding', [\App\Http\Controllers\Auth\SocialController::class, 'handleProviderBinding']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//上传
Route::group(['prefix' => 'uploader', 'as' => 'uploader.'], function () {
    Route::post('ckeditor', [App\Http\Controllers\UploaderController::class, 'ckeditor'])->name('ckeditor');
});

/**
 * 单页面
 */
Route::get('about', [App\Http\Controllers\PageController::class, 'about'])->name('page.about');
Route::get('contact', [App\Http\Controllers\PageController::class, 'contact'])->name('page.contact');
Route::get('terms', [App\Http\Controllers\PageController::class, 'terms'])->name('page.terms');
Route::get('copyright', [App\Http\Controllers\PageController::class, 'copyright'])->name('page.copyright');
Route::get('privacy', [App\Http\Controllers\PageController::class, 'privacy'])->name('page.privacy');
Route::get('adm', [App\Http\Controllers\PageController::class, 'adm'])->name('page.adm');
Route::get('delete', [App\Http\Controllers\PageController::class, 'delete'])->name('page.delete');
Route::get('link', [App\Http\Controllers\PageController::class, 'link'])->name('page.link');

/**
 * 设置中心
 */
Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::get('profile', [App\Http\Controllers\SettingsController::class, 'profile'])->name('profile');
    Route::get('account', [App\Http\Controllers\SettingsController::class, 'account'])->name('account');
    Route::get('login-histories', [App\Http\Controllers\SettingsController::class, 'loginHistories'])->name('login-histories');
    Route::get('tokens', [App\Http\Controllers\SettingsController::class, 'tokens'])->name('tokens');
    Route::get('applications', [App\Http\Controllers\SettingsController::class, 'applications'])->name('applications');
    Route::get('authorization', [App\Http\Controllers\SettingsController::class, 'authorization'])->name('authorization');
    Route::get('balance', [App\Http\Controllers\SettingsController::class, 'balance'])->name('balance');
    Route::get('integral', [App\Http\Controllers\SettingsController::class, 'integral'])->name('integral');
    Route::get('settle', [App\Http\Controllers\SettingsController::class, 'settle'])->name('settle');
});

/**
 * 站内信
 */
Route::group(['prefix' => 'messages'], function () {
    Route::get('link', [App\Http\Controllers\MessageController::class, 'index'])->name('user.messages');
    Route::post('create', [App\Http\Controllers\MessageController::class, 'store'])->name('user.messages.store');
    Route::get('{user_id}', [App\Http\Controllers\MessageController::class, 'show'])->name('user.messages.show');
});

/**
 * 通知
 */
Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('user.notifications');

/**
 * 远程调用
 */
Route::group(['prefix' => 'ajax'], function () {
    Route::get('info', [App\Http\Controllers\AjaxController::class, 'info']);//获取用户登录状态
    Route::get('tags', [App\Http\Controllers\AjaxController::class, 'tags'])->name('ajax.tags');//获取用户登录状态
});

/**
 * 搜索
 */
Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    Route::get('', [App\Http\Controllers\SearchController::class, 'index'])->name('index');
    Route::get('{q}', [App\Http\Controllers\SearchController::class, 'query'])->name('query');
});

//栏目
Route::get('categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

//文章
Route::get('articles/{article}/amp', [App\Http\Controllers\ArticleController::class, 'showAmp'])->name('articles.show.amp');
Route::get('articles/{article}/mip', [App\Http\Controllers\ArticleController::class, 'showMip'])->name('articles.show.mip');
Route::get('articles/{article}.html', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.view');
Route::resource('articles', App\Http\Controllers\ArticleController::class);

//快讯
Route::get('news/{news}.html', [App\Http\Controllers\NewsController::class, 'show'])->name('news.view');
Route::resource('news', App\Http\Controllers\NewsController::class)->only(['index', 'show']);

//下载
Route::get('downloads/{download}.html', [App\Http\Controllers\DownloadController::class, 'show'])->name('downloads.view');
Route::resource('downloads', App\Http\Controllers\DownloadController::class);

/**
 * 标签
 */
Route::group(['prefix' => 'tags', 'as' => 'tag.'], function () {
    Route::get('/', [App\Http\Controllers\TagController::class, 'index'])->name('index');
    Route::get('{tag}', [App\Http\Controllers\TagController::class, 'show'])->name('show');
    Route::get('{tag}/articles', [App\Http\Controllers\ArticleController::class, 'tag'])->name('articles');
    Route::get('{tag}/news', [App\Http\Controllers\NewsController::class, 'tag'])->name('news');
    Route::get('{tag}/downloads', [App\Http\Controllers\DownloadController::class, 'tag'])->name('downloads');
});

/**
 * 空间
 */
Route::group(['prefix' => 'people', 'as' => 'space.'], function () {
    Route::get('{user}', [App\Http\Controllers\SpaceController::class, 'index'])->name('index');
    Route::get('{user}/articles', [App\Http\Controllers\SpaceController::class, 'articles'])->name('articles');
    Route::get('{user}/downloads', [App\Http\Controllers\SpaceController::class, 'downloads'])->name('downloads');
    Route::get('{user}/collections', [App\Http\Controllers\SpaceController::class, 'collections'])->name('collections');
});

/**
 * 站点地图
 */
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');//站点地图索引页
Route::group(['prefix' => 'sitemap', 'as' => 'sitemap.'], function () {
    Route::get('misc.xml', [App\Http\Controllers\SitemapController::class, 'misc'])->name('misc');//单页地图
    Route::get('articles-{page}.xml', [App\Http\Controllers\SitemapController::class, 'articles'])->name('article');//文章地图
    Route::get('tags-{page}.xml', [App\Http\Controllers\SitemapController::class, 'tags'])->name('tag');//Tag地图
});
