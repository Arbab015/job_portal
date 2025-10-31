<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdateNotification extends Notification
{
    use Queueable;
    protected $user;
    protected $change_types;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $change_type)
    {
        $this->user = $user;
        $this->change_types = $change_type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';
        if (count($this->change_types) > 1) {
            $message = "Your Profile has been updated. ";
        } else {
            $change_type = implode($this->change_types);
            $message = "Your {$change_type} has been updated ";
        }
        return [$message] ;
    }



    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
