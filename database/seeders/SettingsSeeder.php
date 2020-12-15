<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Larva\Settings\Settings;

/**
 * 默认设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //基本设置
        Settings::set('system.title', 'LarvaCMS内容管理系统');
        Settings::set('system.keywords', 'LarvaCMS内容管理系统');
        Settings::set('system.description', 'LarvaCMS内容管理系统');
        Settings::set('system.icp_record', '京ICP备00000001号');
        Settings::set('system.police_record', '');
        Settings::set('system.support_email', 'support@email.com');
        Settings::set('system.lawyer_email', 'lawyer@email.com');

        //系统设置
        Settings::set('system.download_remote_pictures', '1');
        Settings::set('system.local_censor', '1');
        Settings::set('system.tencent_censor', '0');
        Settings::set('system.baidu_censor', '0');

        Settings::set('system.sitemap_cache', '60');
        Settings::set('system.sitemap_static', '1');
        Settings::set('system.sitemap_chunk', '2000');

        //用户设置
        Settings::set('user.enable_registration', '1');//启用注册
        Settings::set('user.enable_socialite_auto_registration', '1');
        Settings::set('user.enable_sms_auto_registration', '1');
        Settings::set('user.enable_password_recovery', '1');
        Settings::set('user.enable_welcome_email', '1');
        Settings::set('user.enable_login_email', '0');
        Settings::set('user.enable_register_ticket', '0');
        Settings::set('user.enable_login_ticket', '0');

    }
}
