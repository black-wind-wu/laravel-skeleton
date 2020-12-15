<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array 验证器
     */
    protected $validators = [
        'mobile' => \App\Validators\MobileValidator::class,
        'tel' => \App\Validators\TelPhoneValidator::class,
        'username' => \App\Validators\UsernameValidator::class,
        'nickname' => \App\Validators\NicknameValidator::class,
        'mobile_verify_code' => \App\Validators\MobileVerifyCodeValidator::class,
        'mail_verify_code' => \App\Validators\MailVerifyCodeValidator::class,
        'hash' => \App\Validators\HashValidator::class,
        'longitude' => \App\Validators\LongitudeValidator::class,//纬度
        'latitude' => \App\Validators\LatitudeValidator::class,//经度
        'ticket' => \App\Validators\TicketValidator::class,
        'keep_word' => \App\Validators\KeepWordValidator::class,//保留词
        'mobile_verify' => \App\Validators\MobileVerifyValidator::class,
        'mac_address' => \App\Validators\MacAddressValidator::class,//Mac 地址验证
        'captcha' => \App\Validators\CaptchaValidator::class,//验证码验证
        'id_card' => \App\Validators\IdCardValidator::class,//中国大陆身份证验证
    ];

    /**
     * @var array
     */
    protected $morphMap = [
        'article' => \App\Models\Article::class,
        'download' => \App\Models\Download::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //忽略 Passport 默认迁移
        \Laravel\Passport\Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Carbon::setLocale('zh');
        \Illuminate\Pagination\Paginator::useBootstrap();
        $this->registerObserve();
        $this->registerValidators();

        \Illuminate\Database\Eloquent\Relations\Relation::morphMap($this->morphMap);
    }

    /**
     * Register observes.
     */
    protected function registerObserve()
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);//用户
        \App\Models\UserLoginHistory::observe(\App\Observers\UserLoginHistoryObserver::class);//登录
        \App\Models\Tag::observe(\App\Observers\TagObserver::class);//标签
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);//栏目
        \App\Models\Article::observe(\App\Observers\ArticleObserver::class);//文章
        \App\Models\ArticleDetail::observe(\App\Observers\ArticleDetailObserver::class);//文章详情
        \App\Models\News::observe(\App\Observers\NewsObserver::class);//快讯
        \App\Models\Download::observe(\App\Observers\DownloadObserver::class);//下载
        \App\Models\Link::observe(\App\Observers\LinkObserver::class);//友情链接
        \App\Models\Carousel::observe(\App\Observers\CarouselObserver::class);//轮播
        \App\Models\Advertisement::observe(\App\Observers\AdvertisementObserver::class);//广告
    }

    /**
     * Register validators.
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            \Illuminate\Support\Facades\Validator::extend($rule, "{$validator}@validate");
        }
    }
}
