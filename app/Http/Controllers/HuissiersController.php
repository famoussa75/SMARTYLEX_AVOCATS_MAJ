<?php

namespace App\Http\Controllers;

use App\Models\Huissiers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HuissiersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $huissiers = DB::select("select * from huissiers");

        return view('huissiers.list', compact('huissiers'));
    }

    public function fetchHuissiers($idHuissier)
    {
        $huissier = DB::select('select * from huissiers where idHss=?', [$idHuissier]);

        return response()->json([
            'huissier' => $huissier,
        ]);
    }


    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'prenomHss' => 'required',
            'nomHss' => 'required',

        ]);
        $huissier = new Huissiers();
        if ($validate) {


            $huissier->prenomHss = $request->prenomHss;
            $huissier->nomHss = $request->nomHss;
            $huissier->telHss_1 = $request->telHss_1;
            $huissier->telHss_2 = $request->telHss_2;
            $huissier->emailHss = $request->emailHss;
            $huissier->adresseHss = $request->adresseHss;
            $huissier->rattachement = $request->rattachement;

            $huissier->save();

            return back()->with('success', 'Huissier enregistré avec success ');
        }
    }

    public function update(Request $request)
    {
        DB::select(
            'update huissiers set 
        prenomHss = ?,
        nomHss = ?,
        telHss_1 = ?,
        telHss_2 = ?,
        emailHss = ?,
        adresseHss = ?,
        rattachement=?
        where idHss = ?
        ',
            [
                $request->prenomHss,
                $request->nomHss,
                $request->telHss_1,
                $request->telHss_2,
                $request->emailHss,
                $request->adresseHss,
                $request->rattachement,
                $request->idHss,

            ]
        );
        return back()->with('success', 'modification effectuées avec succès');
    }

    public function delete(Request $request)
    {
        $id =  $request->huissier;
        DB::delete("delete from huissiers where idHss=?", [$id]);
        return back()->with('success', 'Huissier supprimé  avec succès');
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