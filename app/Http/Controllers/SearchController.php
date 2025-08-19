<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function Termwind\render;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->typeSearch;

        DB::update("update admis set telephone =replace(telephone,' ','')");

        if ($type == "pre") {
            $search = strtolower($request->valeurSearch);
            $admis = DB::select("select LOWER(prenom) as prenom,numRg,nom,dateNaiss,lieuNaiss,sexe,pere,mere,categorie,optionAdmis,diplome,age,telephone,ecole from admis where prenom like '%$search%'");
        } else {
            $search = $replaced = str_replace(' ', '', $request->valeurSearch);
            $admis = DB::select("select TRIM(telephone) as telephone,prenom,numRg,nom,dateNaiss,lieuNaiss,sexe,pere,mere,categorie,optionAdmis,diplome,age,ecole from admis where telephone like '%$search%'");
        }
        return view('pages.resultats', compact('admis', 'search'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}