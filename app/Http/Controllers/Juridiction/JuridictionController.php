<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use App\Models\Juriductions;
use Illuminate\Http\Request;

class JuridictionController extends Controller
{
        public function index()
    {
        $juridictions = Juriductions::all();
        return view('juridiction.index', compact('juridictions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type_tribunal' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500'
        ]);

        $juridiction = Juriductions::create([
            'nom' => $request->nom,
            'type_tribunal' => $request->type_tribunal,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse
        ]);

        return redirect()->back()->with('success', 'Juridiction ajoutée avec succès');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'nom' => 'required|string|max:255',
            'type_tribunal' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500'
        ]);

        $juridiction = Juriductions::findOrFail($request->id);
        $juridiction->update([
            'nom' => $request->nom,
            'type_tribunal' => $request->type_tribunal,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse
        ]);

        return redirect()->back()->with('success', 'Juridiction modifiée avec succès');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|string'
        ]);

        $juridiction = Juriductions::findOrFail($request->id);
        $juridiction->delete();

        return redirect()->back()->with('success', 'Juridiction supprimée avec succès');
    }
}