<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url= url(route('password.reset', [
            'token' => $notifiable->remember_token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
        return (new MailMessage)
            ->subject(' رمز عبور را تغییر دهید - ' . config('app.name'))
            ->line('شما این ایمیل را دریافت می کنید زیرا ما درخواست بازنشانی رمزعبور را برای حساب شما دریافت کردیم.')
            ->action('تغییر پسورد', $url)
            ->line('این پیوند تنظیم مجدد گذرواژه در 60 دقیقه منقضی می شود. اگر درخواست بازنشانی گذرواژه را نکردید ، دیگر نیازی به اقدامات لازم نیست');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
