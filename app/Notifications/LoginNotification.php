<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Notifications;

use App\Models\UserLoginHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * 登录通知
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var UserLoginHistory
     */
    protected $loginHistory;

    /**
     * Create a new notification instance.
     *
     * @param UserLoginHistory $loginHistory
     */
    public function __construct(UserLoginHistory $loginHistory)
    {
        $this->loginHistory = $loginHistory;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('Your account successfully logged into :appName', ['appName' => config('app.name')]))
            ->line(Lang::get('Your account :username was successfully logged in at :time on IP :ip [:address]!', [
                'username' => $this->loginHistory->user->username,
                'time' => $this->loginHistory->created_at,
                'ip' => $this->loginHistory->ip,
                'address' => $this->loginHistory->address,
            ]))
            ->line(Lang::get('If this login is not yours, your account has been stolen!'));
    }
}
