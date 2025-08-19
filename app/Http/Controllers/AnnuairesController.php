<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\ExcelImportAnnuaire;
use App\Models\Annuaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class AnnuairesController extends Controller
{
    public function list()
    {
        $annuaires = DB::select("select * from annuaires order by id asc");
        $clients = DB::select("select * from clients");


        return view('annuaires.list', compact('annuaires','clients'));
    }

    public function importAnnuaireData(Request $request)
    {
        $file = $request->file('fichiers');

        if ($file) {
            Excel::import(new ExcelImportAnnuaire, $file);
            DB::select("DELETE a1
            FROM annuaires a1
            LEFT JOIN (
                SELECT email, MAX(id) AS max_id
                FROM annuaires
                GROUP BY email
            ) a2 ON a1.email = a2.email AND a1.id = a2.max_id
            WHERE a2.max_id IS NULL;            
            ");
          

            return redirect()->back()->with('success', 'Import effectué avec succès.');
        }

        return redirect()->back()->with('error', 'Erreur d\import veuillez respecter le format.');
        
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'prenom_et_nom' => 'required',

        ]);
        $contact = new Annuaires();
        if ($validate) {


            $contact->societe = $request->societe;
            $contact->prenom_et_nom = $request->prenom_et_nom;
            $contact->poste_de_responsabilite = $request->poste_de_responsabilite;
            $contact->telephone = $request->telephone;
            $contact->email = $request->email;
            $contact->idClient = $request->idClient;

            $contact->save();

            return back()->with('success', 'Contact enregistré avec succès ');
        }
    }

    public function fetchContacts($id)
    {
        $contact = DB::select('select * from annuaires where id=?', [$id]);

        return response()->json([
            'contact' => $contact,
        ]);
    }

    public function update(Request $request)
    {
        DB::select(
            'update annuaires set 
        societe = ?,
        prenom_et_nom = ?,
        poste_de_responsabilite = ?,
        telephone = ?,
        email = ?
        where id = ?
        ',
            [
                $request->societe,
                $request->prenom_et_nom,
                $request->poste_de_responsabilite,
                $request->telephone,
                $request->email,
                $request->idContact,

            ]
        );
        return back()->with('success', 'Modification effectuée avec succès');
    }

    public function delete(Request $request)
    {
        $id =  $request->idContact;
        DB::delete("delete from annuaires where id=?", [$id]);
        return back()->with('success', 'Contact supprimé  avec succès');
    }

}
