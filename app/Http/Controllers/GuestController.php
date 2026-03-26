<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    /**
     * Affiche la liste des invités d'un mariage spécifique.
     */
    public function index($weddingId)
    {
        $wedding = Wedding::findOrFail($weddingId);
        $guests = $wedding->guests;

        // Calcul du remplissage des tables pour les badges visuels
        $tableCounts = $wedding->guests()
            ->whereNotNull('table_number')
            ->select('table_number', DB::raw('count(*) as total'))
            ->groupBy('table_number')
            ->pluck('total', 'table_number');

        return view('guests.index', compact('wedding', 'guests', 'tableCounts'));
    }

    /**
     * Enregistre un nouvel invité avec doubles validations de sécurité.
     */
    public function store(Request $request, $weddingId)
    {
        $wedding = Wedding::findOrFail($weddingId);

        // SÉCURITÉ 1 : Vérification de la capacité totale du mariage
        if ($wedding->guests()->count() >= $wedding->max_guests) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Limite atteinte : Ce mariage ne peut pas dépasser {$wedding->max_guests} invités.");
        }

        // Validation des données entrantes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:en attente,confirmé,refusé',
            'table_number' => 'nullable|integer|min:1',
        ]);

        // SÉCURITÉ 2 : Vérification de la limite de 10 personnes par table
        if ($request->filled('table_number')) {
            $currentCount = $wedding->guests()
                ->where('table_number', $request->table_number)
                ->count();

            if ($currentCount >= 10) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "La table n°{$request->table_number} est déjà complète (max 10).");
            }
        }

        // Création
        $guest = new Guest($validated);
        $guest->wedding_id = $wedding->id;
        $guest->save();

        return redirect()->back()->with('success', "{$request->name} a été ajouté avec succès.");
    }

    /**
     * Affiche le formulaire de modification d'un invité.
     */
    public function edit(Guest $guest)
    {
        $wedding = $guest->wedding; // Récupère le mariage via la relation
        return view('guests.edit', compact('guest', 'wedding'));
    }

    /**
     * Met à jour les informations d'un invité.
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:en attente,confirmé,refusé',
            'table_number' => 'nullable|integer|min:1',
        ]);

        // SÉCURITÉ : Vérifier si le changement de table est possible
        if ($request->filled('table_number') && $request->table_number != $guest->table_number) {
            $tableCount = Guest::where('wedding_id', $guest->wedding_id)
                ->where('table_number', $request->table_number)
                ->count();

            if ($tableCount >= 10) {
                return redirect()->back()
                    ->with('error', "Impossible de déplacer l'invité : la table {$request->table_number} est pleine.");
            }
        }

        $guest->update($validated);

        return redirect()->route('guests.index', $guest->wedding_id)
            ->with('success', "Les informations de {$guest->name} ont été mises à jour.");
    }

    /**
     * Supprime un invité de la base de données.
     */
    public function destroy(Guest $guest)
    {
        $weddingId = $guest->wedding_id;
        $guest->delete();

        return redirect()->route('guests.index', $weddingId)
            ->with('success', "L'invité a été retiré de la liste.");
    }
}