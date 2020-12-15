<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * RESTFul API common.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
//Route::get('config', [App\Http\Controllers\Api\MainController::class, 'config']);//应用配置
Route::post('phone-verify-code', [App\Http\Controllers\Api\MainController::class, 'phoneVerifyCode']);//短信验证码
Route::post('mail-verify-code', [App\Http\Controllers\Api\MainController::class, 'mailVerifyCode']);//邮件验证码
Route::get('country', [App\Http\Controllers\Api\MainController::class, 'country']);//国家列表
Route::post('idcard', [App\Http\Controllers\Api\MainController::class, 'idCard']);//身份证号码归属地
Route::any('dns-record', [App\Http\Controllers\Api\MainController::class, 'dnsRecord']);//远程DNS解析
Route::post('coding', App\Http\Controllers\Api\CodingController::class)->name('coding_webhook');//Coding接口
Route::get('config', [App\Http\Controllers\Api\MainController::class, 'config']);//App配置

/**
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1'], function (Illuminate\Contracts\Routing\Registrar $api) {

    /**
     * 用户接口
     */
    Route::group(['prefix' => 'user'], function () {
        Route::post('exists', [App\Http\Controllers\Api\V1\UserController::class, 'exists']);//账号邮箱手机号检查
        Route::post('phone-register', [App\Http\Controllers\Api\V1\UserController::class, 'phoneRegister']);//手机号注册
        Route::post('email-register', [App\Http\Controllers\Api\V1\UserController::class, 'emailRegister']);//邮箱注册
        Route::post('send-verification-mail', [App\Http\Controllers\Api\V1\UserController::class, 'sendVerificationMail']);//发送激活邮件
        Route::post('phone-reset-password', [App\Http\Controllers\Api\V1\UserController::class, 'resetPasswordByPhone']);//通过手机重置用户登录密码
        Route::get('profile', [App\Http\Controllers\Api\V1\UserController::class, 'profile']);//获取用户个人资料
        Route::get('extra', [App\Http\Controllers\Api\V1\UserController::class, 'extra']);//获取扩展资料
        Route::post('verify-phone', [App\Http\Controllers\Api\V1\UserController::class, 'verifyPhone']);//验证手机号码
        Route::post('email', [App\Http\Controllers\Api\V1\UserController::class, 'modifyEMail']);//修改邮箱
        Route::post('phone', [App\Http\Controllers\Api\V1\UserController::class, 'modifyPhone']);//修改手机号码
        Route::post('profile', [App\Http\Controllers\Api\V1\UserController::class, 'modifyProfile']);//修改用户个人资料
        Route::post('avatar', [App\Http\Controllers\Api\V1\UserController::class, 'modifyAvatar']);//修改头像
        Route::post('password', [App\Http\Controllers\Api\V1\UserController::class, 'modifyPassword']);//修改密码
        Route::get('search', [App\Http\Controllers\Api\V1\UserController::class, 'search']);//搜索用户
        Route::delete('', [App\Http\Controllers\Api\V1\UserController::class, 'destroy']);//注销并删除自己的账户
        Route::get('login-histories', [App\Http\Controllers\Api\V1\UserController::class, 'loginHistories']);//获取登录历史

        /**
         * 社交账户
         */
        Route::group(['prefix' => 'social'], function () {
            Route::get('accounts', [App\Http\Controllers\Api\V1\SocialController::class, 'socialAccounts']);//获取绑定的社交账户
            Route::delete('accounts/{provider}', [App\Http\Controllers\Api\V1\SocialController::class, 'destroySocial']);//解绑
            Route::get('bind/{provider}', [App\Http\Controllers\Api\V1\SocialController::class, 'bindSocial']);//绑定社交账户
        });

        /**
         * 私信
         */
        Route::group(['prefix' => 'messages'], function () {
            Route::get('', [App\Http\Controllers\Api\V1\MessageController::class, 'index']);//获取话题列表
            Route::post('', [App\Http\Controllers\Api\V1\MessageController::class, 'store']);//发送短消息
            Route::get('{user_id}', [App\Http\Controllers\Api\V1\MessageController::class, 'show']);//获取会话详情
            Route::delete('{id}', [App\Http\Controllers\Api\V1\MessageController::class, 'destroy']);//删除消息
        });

        /**
         * 通知
         */
        Route::group(['prefix' => 'notifications'], function () {
            Route::post('mark-read', [App\Http\Controllers\Api\V1\NotificationController::class, 'markAsRead']);//标记所有未读通知为已读
            Route::get('unread-count', [App\Http\Controllers\Api\V1\NotificationController::class, 'unreadCount']);// 通知统计
        });
    });

    /**
     * 设备接口
     */
    Route::group(['prefix' => 'device'], function () {
        Route::post('register', [App\Http\Controllers\Api\V1\DeviceController::class, 'register']);//设备注册
    });

    Route::post('support', App\Http\Controllers\Api\V1\SupportController::class);//点赞
    Route::post('collect', App\Http\Controllers\Api\V1\CollectionController::class);//收藏
    Route::post('follow', App\Http\Controllers\Api\V1\AttentionController::class);//关注
});
