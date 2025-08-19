<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Avocats;

class AvocatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $avocats = DB::select("select * from avocats order by idAvc asc");

        return view('avocats.list', compact('avocats'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAvocats($idAvocat)
    {
        $avocat = DB::select('select * from avocats where idAvc=?', [$idAvocat]);

        return response()->json([
            'avocat' => $avocat,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'prenomAvc' => 'required',
            'nomAvc' => 'required',

        ]);
        $avocat = new Avocats();
        if ($validate) {


            $avocat->prenomAvc = $request->prenomAvc;
            $avocat->nomAvc = $request->nomAvc;
            $avocat->telAvc_1 = $request->telAvc_1;
            $avocat->telAvc_2 = $request->telAvc_2;
            $avocat->emailAvc_1 = $request->emailAvc_1;
            $avocat->adresseAvc = $request->adresseAvc;
            $avocat->annee_entrer = $request->annee_entrer;

            $avocat->save();

            return back()->with('success', 'Avocat enregistré avec succès ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::select(
            'update avocats set 
        prenomAvc = ?,
        nomAvc = ?,
        telAvc_1 = ?,
        telAvc_2 = ?,
        emailAvc_1 = ?,
        adresseAvc = ?,
        annee_entrer=?
        where idAvc = ?
        ',
            [
                $request->prenomAvc,
                $request->nomAvc,
                $request->telAvc_1,
                $request->telAvc_2,
                $request->emailAvc,
                $request->adresseAvc,
                $request->annee_entrer,
                $request->idAvc,

            ]
        );
        return back()->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id =  $request->avocat;
        DB::delete("delete from avocats where idAvc=?", [$id]);
        return back()->with('success', 'Avocat supprimé  avec succès');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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