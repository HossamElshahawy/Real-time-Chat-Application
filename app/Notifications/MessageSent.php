<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class MessageSent extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $user;
    public $message;
    public $conversation;
    public $receiverId;

    public function __construct(
        $user,
        $message,
        $conversation,
        $receiverId,

    )
    {
        //

        $this->user= $user;
        $this->message= $message;
        $this->conversation= $conversation;
        $this->receiverId= $receiverId;


    }


    public function via($notifiable)
    {
        return ['broadcast'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_id' => $this->user->id,
            'conversation_id' => $this->conversation->id,
            'message_id' => $this->message->id,
            'receiver_id' => $this->receiverId,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
