<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\TaskReminder;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $user = User::find(1); // On récupère l'organisateur
        $user->notify(new TaskReminder($task)); // On envoie l'e-mail !
        // Récupère les tâches qui expirent demain et qui ne sont pas terminées
        $tasks = Task::where('due_date', Carbon::today())
                    ->where('status', '!=', 'terminé')
                    ->get();

        foreach ($tasks as $task) {
            // Ici, on envoie un email à l'utilisateur (user_id = 1 pour l'instant)
            $task->wedding->user->notify(new TaskReminder($task));
            $this->info("Rappel envoyé pour : " . $task->title);
        }
    }
}
