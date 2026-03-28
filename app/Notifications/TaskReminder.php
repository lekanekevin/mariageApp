<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskReminder extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // On précise qu'on veut envoyer par Email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Rappel : Tâche urgente pour le mariage !')
                    ->greeting('Bonjour !')
                    ->line('Ceci est un rappel pour la tâche : ' . $this->task->title)
                    ->line('Date limite : ' . $this->task->due_date)
                    ->action('Voir mes tâches', url('/weddings'))
                    ->line('Bonne organisation !');
    }
}