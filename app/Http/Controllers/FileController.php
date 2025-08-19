<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fichiers;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function addFile(Request $request)
    {
        $slugSource = $request->slug;
        // enregistrement des informations du fichier
        if ($request->file('fichiers') != null) {

            $fichiers = request()->file('fichiers');


            foreach ($fichiers as $fichier) {

                $otherFile = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $otherFile->nomOriginal = $fichier->getClientOriginalName();
                $otherFile->filename = $filename;
                $otherFile->slugSource = $slugSource;
                $otherFile->slug = $request->_token . "" . rand(1234, 3458);
                $otherFile->path = 'assets/upload/fichiers/autres/' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/autres'), $filename);
                $otherFile->save();
            }
        }
        return back()->with('success', 'Fichier(s) join avec succès');
    }

    /**
     * Afficher the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Afficher the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
