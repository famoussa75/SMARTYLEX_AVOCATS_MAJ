<?php

namespace App\Http\Controllers\Publicite;

use App\Models\Publicite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PubliciteController extends Controller
{
    public function index()
    {
        $publicites = Publicite::orderBy('created_at', 'desc')->get();
        return view('publicite.pub', compact('publicites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lien' => 'nullable|url',
            'statut' => 'required|in:actif,inactif',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut'
        ]);

        $uuidName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uuidName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('publicites', $uuidName, 'public');
        }

        $publicite = Publicite::create([
            'titre' => $request->titre,
            'image' => $uuidName,
            'lien' => $request->lien,
            'statut' => $request->statut,
            'debut' => $request->debut,
            'fin' => $request->fin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Publicité créée avec succès'
        ]);
    }

    public function update(Request $request, Publicite $publicite)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lien' => 'nullable|url',
            'statut' => 'required|in:actif,inactif',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut'
        ]);

        $uuidName = $publicite->image;
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($publicite->image) {
                Storage::disk('public')->delete('publicites/' . $publicite->image);
            }
            
            $file = $request->file('image');
            $uuidName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('publicites', $uuidName, 'public');
        }

        $publicite->update([
            'titre' => $request->titre,
            'image' => $uuidName,
            'lien' => $request->lien,
            'statut' => $request->statut,
            'debut' => $request->debut,
            'fin' => $request->fin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Publicité modifiée avec succès'
        ]);
    }

    public function destroy(Publicite $publicite)
    {
        // Suppression de l'image si elle existe
        if ($publicite->image) {
            Storage::disk('public')->delete('publicites/' . $publicite->image);
        }
        
        $publicite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Publicité supprimée avec succès'
        ]);
    }
}