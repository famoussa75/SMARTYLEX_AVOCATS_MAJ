<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use App\Http\Controllers\Controller;
use App\Models\Personnels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClockController extends Controller
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

    

    // fonction permettante d'enregistrer les clocks
    public function getClock(){

        // recuperation de l'idenfiant du personnel
        //$idPersonnel = DB::select('select personnels.id from personnels where email =? ',[Auth::user()->email]);
        $idPersonnel = DB::select('select personnels.id from personnels where email =? ',['akouyate@ask-avocats.com']);
        if($idPersonnel[0]->id !=null || $idPersonnel[0]->id != ""){
            $clock = new Clock();
            $clock->idPersonnel = $idPersonnel[0]->id;
            $clock->dateArriver = date('d-m-Y H:i:s');
            $clock->dateDepart = '';
            $clock->statut = '1';
            $clock->slug = str_shuffle(Hash::make('amet consectetur adipisicing elit. Ratione sequi '));
            $clock->save();
            return response()->json([
                'success' => 'OK',
            ]);
        }
    }

    // Fonction permettante de verifier le clock d'un utilisateur
    public function getClockCheck(){

        // recuperation de l'idenfiant du personnel
        //$idPersonnel = DB::select('select personnels.id from personnels where email =? ',[Auth::user()->email]);
        $idPersonnel = DB::select('select personnels.id from personnels where email =? ',['akouyate@ask-avocats.com']);
        $dateArriver='';
        if($idPersonnel[0]->id !=null || $idPersonnel[0]->id != ""){
            $data = DB::select('select * from clocks where clocks.idPersonnel =? and clocks.statut = ? order by id desc LIMIT 1', [$idPersonnel[0]->id, '1']);
            if($data[0]->statut =='1'){
                $dateArriver = $data[0]->dateArriver;
            }
            return response()->json([
                'message' => $dateArriver,
                'success' => 'OK',
            ]);
        }
        
        return response()->json([
            'success' => 'OK',
        ]);
    }

    // Fonction permettante de faire le clockOut d'un utilisateur
    public function doClockOut($dateArriver, $dateDepart){

        // recuperation de l'idenfiant du personnel
        //$idPersonnel = DB::select('select personnels.id from personnels where email =? ',[Auth::user()->email]);
        $idPersonnel = DB::select('select personnels.id from personnels where email =? ',['akouyate@ask-avocats.com']);
        if($idPersonnel[0]->id !=null || $idPersonnel[0]->id != ""){
            $data = DB::select('select * from clocks where clocks.idPersonnel =? clocks.dateArriver=? order by id desc LIMIT 1', [$idPersonnel[0]->id, $dateArriver]);
            if($data[0]->statut =='1'){
                DB::select('update clocks set clocks.dateDepart=? and clocks.statut=? where clocks.dateArriver =?', [$dateDepart, 'Terminer']);
            }
            return response()->json([
                'message' => $dateDepart,
                'success' => 'OK',
            ]);
        }
        
        return response()->json([
            'success' => 'OK',
        ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clock  $clock
     * @return \Illuminate\Http\Response
     */
    public function show(Clock $clock)
    {
        //
    }

}
