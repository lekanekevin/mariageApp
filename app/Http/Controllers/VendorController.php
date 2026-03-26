<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Wedding;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index($weddingId)
    {
        $wedding = Wedding::findOrFail($weddingId);
        $vendors = $wedding->vendors;
        
        // Calcul des totaux pour le budget
        $totalSpent = $vendors->sum('price');
        $totalPaid = $vendors->sum('paid_amount');
        $remainingBudget = $wedding->budget_total - $totalSpent;

        return view('vendors.index', compact('wedding', 'vendors', 'totalSpent', 'totalPaid', 'remainingBudget'));
    }

    public function store(Request $request, $weddingId)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        $vendor = new Vendor($request->all());
        $vendor->wedding_id = $weddingId;
        $vendor->save();

        return redirect()->back()->with('success', 'Prestataire ajouté au budget !');
    }
    
    public function destroy(Vendor $vendor)
        {
            $vendor->delete();
            return redirect()->back()->with('success', 'Prestataire supprimé.');
        }

    public function edit(Vendor $vendor)
        {
            $wedding = $vendor->wedding;
            return view('vendors.edit', compact('vendor', 'wedding'));
        }

    public function update(Request $request, Vendor $vendor)
        {
            $validated = $request->validate([
                'name' => 'required|string',
                'category' => 'required',
                'price' => 'required|numeric|min:0',
                'paid_amount' => 'required|numeric|min:0',
            ]);

            $vendor->update($validated);

            return redirect()->route('vendors.index', $vendor->wedding_id)
                            ->with('success', 'Prestataire mis à jour avec succès.');
        }
}