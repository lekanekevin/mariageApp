<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Wedding;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Affiche la liste des tâches d'un mariage
    public function index($weddingId)
    {
        $wedding = Wedding::with('tasks')->findOrFail($weddingId);
        return view('tasks.index', compact('wedding'));
    }

    // C'EST CETTE MÉTHODE QUI MANQUE :
    public function store(Request $request, $weddingId)
    {
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Création de la tâche
        $task = new Task();
        $task->title = $request->title;
        $task->wedding_id = $weddingId;
        $task->is_completed = false;
        $task->save();

        return redirect()->back()->with('success', 'Tâche ajoutée avec succès !');
    }

    // Pour cocher/décocher une tâche
    public function toggle(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->back();
    }
}
