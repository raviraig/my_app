<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateUserNotification extends Notification
{
    use Queueable;

     private $userDetalis;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userDetalis)
    {
        $this->userDetalis = $userDetalis;
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
        return (new MailMessage)
                    ->line('The introduction to the notification, that your detalis has been updates as follows')
                    ->line('First Name : '.$this->userDetalis['first_name'])
                    ->line('Last Name : '.$this->userDetalis['last_name'])
                    ->line('Email : '.$this->userDetalis['email'])
                    ->line('Password : '.$this->userDetalis['password'])
                    ->line('Role : '.$this->userDetalis['role'])
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
