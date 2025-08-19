<?php

namespace App\Http\Controllers;

use App\Models\Fichiers;
use App\Models\TacheFile;
use App\Models\tachefileTmp;
use Illuminate\Http\Request;

class TacheFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addFileTache(Request $request)
    {

        $taskFile = new Fichiers();
        if($request){
            
                            // Creation des fichiers
                // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                if ($request->file('fichiers') != null) {

                    $fichiers = request()->file('fichiers');


                    foreach ($fichiers as $fichier) {

                        $tacheFile = new Fichiers();

                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $tacheFile->nomOriginal = $fichier->getClientOriginalName();
                        $tacheFile->filename =$filename;
                        $tacheFile->slugSource = $request->slugTache;
                        $tacheFile->slug = $request->_token . "" . rand(1234, 3458);
                        $tacheFile->path = 'assets/upload/fichiers/taches/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/taches'), $filename);
                        $tacheFile->save();
                    }
                }


            return back()->with('success','Fichier join avec succès');
        }
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
