# Laravel 8 基础模板

[![License](https://poser.pugx.org/larvacloud/laravel-skeleton/license.svg)](https://packagist.org/packages/larvacloud/laravel-skeleton)
[![Latest Stable Version](https://poser.pugx.org/larvacloud/laravel-skeleton/v/stable.png)](https://packagist.org/packages/larvacloud/laravel-skeleton)
[![Total Downloads](https://poser.pugx.org/larvacloud/laravel-skeleton/downloads.png)](https://packagist.org/packages/larvacloud/laravel-skeleton)
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5e5655b5100a1eafc2f6)

开箱即用的 Laravel 8 基础结构，只需很少的代码即可快速构建出一个功能完善的高颜值系统。内置丰富的常用组件，开箱即用，让开发者告别冗杂的代码，对 RESTFul 开发者非常友好。

## 环境
 - PHP >= 7.3
 - Fileinfo PHP Extension
 - Redis PHP Extension(短信、邮件验证码必须)
 
## 功能特性
- [x] 内置 laravel/passport 的授权机制；
- [x] 扩充 laravel/passport 短信验证码登录；
- [x] 扩充 laravel/passport 社交账户登录（App）；
- [x] 可选扩充 laravel/passport App扫码登录；
- [x] 高度完善的控制器、模型、模块模板；
- [x] 集成常用基础扩展；
- [x] 内置模型通用高阶 Traits 封装;
- [x] 自动注册 Policies；
- [x] 内置用户系统和基础接口；
- [x] 内置社交账户登录；
- [x] 内置 `DcatAdmin` 管理后台；
- [x] 内置图形验证码；
- [x] 内置支持邮件验证码(需要Redis)；
- [x] 内置支持短信验证码(需要Redis)；
- [x] 内置支持栏目管理、Tag管理、文章管理；
- [x] 内置支持文本反垃圾（根据命中的词自动选择是审核还是拒绝）；
- [x] 内置 Sitemap 支持；

## 可选支持（默认未安装）
- [短信接口](https://github.com/larvacent/laravel-sms)
- [小程序登录](https://github.com/larvacent/laravel-passport-miniprogram)
- [签名的开放API接口](https://github.com/larvacent/laravel-auth-signature-guard)
- [微信通知](https://github.com/larvacent/laravel-wechat-notification-channel)
- [友盟通知](https://github.com/larvacent/laravel-umeng-notification-channel)
- [微信支付宝收款](https://github.com/larvacent/laravel-transaction)
 
## 安装

1. 创建项目

```bash
$ composer create-project larvacloud/laravel-skeleton -vv
```


2. 创建配置文件

```bash
$ cp .env.develop .env
```

3. 创建数据表和测试数据

```bash
$ php artisan migrate --seed
```

4. 配置任务调度

```bash
* * * * * cd /app/path/project && php artisan schedule:run >> /dev/null 2>&1
```

然后访问 `http://laravel-skeleton.test/` 将会看到网站信息。 

## License
------------
`laravel-skeleton` is licensed under [The MIT License (MIT)](LICENSE).
