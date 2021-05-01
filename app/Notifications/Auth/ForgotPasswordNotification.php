<?php

namespace App\Notifications\Auth;

use Sqware\Auth\Models\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    const DOMAIN_ADMIN = 'admin';

    protected $passwordReset;
    protected $domain;

    /**
     * Create a new notification instance.
     *
     * @param PasswordReset $passwordReset
     * @param string $domain
     */
    public function __construct(PasswordReset $passwordReset, string $domain = null)
    {
        $this->passwordReset = $passwordReset;
        $this->domain = $domain;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = $this->getResetLink($notifiable);

        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $link)
            ->line('If you did not request a password reset, no further action is required.');
    }

    private function getResetLink($notifiable) : string
    {
        return $this->domain === static::DOMAIN_ADMIN
            ? adminUrl("password/reset?email={$notifiable->email}&token={$this->passwordReset->token}")
            : clientUrl("password/reset?email={$notifiable->email}&token={$this->passwordReset->token}");
    }
}
