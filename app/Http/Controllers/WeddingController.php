<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingController extends Controller
{
    // Affiche la liste de tous les mariages
    public function index()
    {
        $weddings = Wedding::all(); 
        $weddings = Auth::user()->weddings;
      
        return view('weddings.index', compact('weddings'));
    }

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
            'max_guests' => 'required|integer|min:1'
        ]);

        // 2. Création
        $wedding = new Wedding($validated);
        $wedding->user_id = Auth::id(); // On récupère l'ID de la session
        $wedding->save();

        // 3. Redirection
        return redirect()->route('weddings.index')->with('success', 'Mariage créé avec succès !');
    }

    // Affiche le formulaire de modification (Nouvelle méthode)
    public function edit(Wedding $wedding)
    {
        return view('weddings.edit', compact('wedding'));
    }

    // Met à jour le mariage (Nouvelle méthode)
    public function update(Request $request, Wedding $wedding)
    {
        // 1. Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'budget_total' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'max_guests' => 'required|integer|min:1'
        ]);

        // 2. Mise à jour
        $wedding->update($validated);

        return redirect()->route('weddings.index')->with('success', 'Le mariage a été mis à jour !');
    }

    // Supprime le mariage (Nouvelle méthode)
    public function destroy(Wedding $wedding)
    {
        $wedding->delete();
        return redirect()->route('weddings.index')->with('success', 'Mariage supprimé avec succès.');
    }
}