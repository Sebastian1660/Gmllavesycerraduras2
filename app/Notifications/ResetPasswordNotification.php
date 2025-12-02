<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Recuperar Contraseña - GM Llaves y Cerraduras')
            ->greeting('¡Hola!')
            ->line('Estás recibiendo este correo porque recibimos una solicitud de recuperación de contraseña para tu cuenta.')
            ->action('Restablecer Contraseña', $url)
            ->line('Este enlace de recuperación expirará en ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' minutos.')
            ->line('Si no solicitaste restablecer tu contraseña, no es necesario realizar ninguna acción.')
            ->salutation('Saludos, GM Llaves y Cerraduras');
    }
}