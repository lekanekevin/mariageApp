<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Wedding;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($weddingId)
    {
        $wedding = Wedding::findOrFail($weddingId);
        $tasks = $wedding->tasks()->orderBy('due_date', 'asc')->get();
        return view('tasks.index', compact('wedding', 'tasks'));
    }

    public function store(Request $request, $weddingId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        $task = new Task($validated);
        $task->wedding_id = $weddingId;
        $task->status = 'à faire';
        $task->save();

        return redirect()->back()->with('success', 'Tâche ajoutée !');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée.');
    }
    // Affiche le formulaire de modification
    public function edit(Task $task)
    {
        $wedding = $task->wedding;
        return view('tasks.edit', compact('task', 'wedding'));
    }

    // Enregistre les modifications
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'status' => 'required|in:à faire,en cours,terminé',
            'description' => 'nullable|string'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index', $task->wedding_id)
                        ->with('success', 'La tâche a été mise à jour.');
    }
}