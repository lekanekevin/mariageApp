<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($weddingId)
    {
        $wedding = Wedding::with(['guests', 'vendors', 'tasks'])->findOrFail($weddingId);

        // 1. Calcul des jours restants
        $daysRemaining = 0;
        if ($wedding->date) {
            $weddingDate = Carbon::parse($wedding->date);
            $daysRemaining = Carbon::now()->diffInDays($weddingDate, false);
        }

        // 2. Statistiques Invités
        $totalGuests = $wedding->guests->count();
        $confirmedGuests = $wedding->guests->where('status', 'confirmé')->count();

        // 3. Statistiques Budget
        $totalSpent = $wedding->vendors->sum('price');
        $budgetPercentage = $wedding->budget_total > 0 
            ? min(($totalSpent / $wedding->budget_total) * 100, 100) 
            : 0;

        // 4. Statistiques Tâches
        $totalTasks = $wedding->tasks->count();
        $pendingTasks = $wedding->tasks->where('status', '!=', 'terminé')->count();

        return view('dashboard', compact(
            'wedding', 
            'daysRemaining', 
            'confirmedGuests', 
            'totalGuests', 
            'totalSpent', 
            'budgetPercentage', 
            'pendingTasks',
            'totalTasks'
        ));
    }
}