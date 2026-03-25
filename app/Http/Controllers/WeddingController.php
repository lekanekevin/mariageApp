<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingController extends Controller
{
    // Affiche le formulaire de création
    public function create()
    {
        return view('weddings.create');
    }

    // Enregistre le mariage dans la base de données
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'budget_total' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
        ]);

        // 2. Création du mariage lié à l'utilisateur connecté
        // Note : Pour l'instant on simule l'ID 1 si tu n'as pas encore d'auth
        $wedding = new Wedding($validated);
        $wedding->user_id = 1; // On changera ça en Auth::id() plus tard
        $wedding->save();
    

        // 3. Redirection avec un message de succès
        return redirect()->route('weddings.index')->with('success', 'Mariage créé avec succès !');

    }
    public function index()
    {
        $weddings = Wedding::all(); // On récupère tous les mariages
        return view('weddings.index', compact('weddings'));
    }
}