<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notaires;
use Illuminate\Support\Str;

class NotairesController extends Controller
{
    public function index()
    {
        $notaires = Notaires::all();

        return view('notaires.list', compact('notaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prenomNtr' => 'required|string|max:255',
            'nomNtr' => 'required|string|max:255',
            'telNtr_1' => 'nullable|string|max:20',
            'telNtr_2' => 'nullable|string|max:20',
            'emailNtr' => 'nullable|email|max:255',
            'adresseNtr' => 'nullable|string|max:500'
        ]);

        $notaire = Notaires::create([
            'prenomNtr' => $request->prenomNtr,
            'nomNtr' => $request->nomNtr,
            'telNtr_1' => $request->telNtr_1,
            'telNtr_2' => $request->telNtr_2,
            'emailNtr' => $request->emailNtr,
            'adresseNtr' => $request->adresseNtr,
            'slug' => Str::slug($request->prenomNtr . ' ' . $request->nomNtr)
        ]);

        return redirect()->back()->with('success', 'Notaire ajouté avec succès');
    }

    public function update(Request $request)
    {
        $request->validate([
            'idNtr' => 'required|string',
            'prenomNtr' => 'required|string|max:255',
            'nomNtr' => 'required|string|max:255',
            'telNtr_1' => 'nullable|string|max:20',
            'telNtr_2' => 'nullable|string|max:20',
            'emailNtr' => 'nullable|email|max:255',
            'adresseNtr' => 'nullable|string|max:500'
        ]);

        $notaire = Notaires::findOrFail($request->idNtr);
        $notaire->update([
            'prenomNtr' => $request->prenomNtr,
            'nomNtr' => $request->nomNtr,
            'telNtr_1' => $request->telNtr_1,
            'telNtr_2' => $request->telNtr_2,
            'emailNtr' => $request->emailNtr,
            'adresseNtr' => $request->adresseNtr,
            'slug' => Str::slug($request->prenomNtr . ' ' . $request->nomNtr)
        ]);

        return redirect()->back()->with('success', 'Notaire modifié avec succès');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'idNtr' => 'required|string'
        ]);

        $notaire = Notaires::findOrFail($request->idNtr);
        $notaire->delete();

        return redirect()->back()->with('success', 'Notaire supprimé avec succès');
    }
}