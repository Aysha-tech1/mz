<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPassword extends ResetPassword
{
    public string $url;

    protected function resetUrl($notifiable): string
    {
        return $this->url;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('استعادة كلمة مرور لوحة التحكم')
            ->greeting('مرحباً')
            ->line('وصلك هذا الإيميل لأنك طلبت إعادة تعيين كلمة مرور حساب الأدمن.')
            ->action('تعيين كلمة مرور جديدة', $this->resetUrl($notifiable))
            ->line('الرابط صالح لمدة 60 دقيقة.')
            ->line('إذا لم تطلب ذلك، تجاهل هذه الرسالة.');
    }
}
