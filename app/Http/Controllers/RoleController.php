<?php

namespace App\Http\Controllers;

use App\Models\AffairesRole;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (isset(Auth::user()->privilege) && Auth::user()->privilege == "superAdmin") {
            $roles = DB::select("select nom,roles.id as id,juriduction,president,greffier,section,jugeConsulaire,dateEnregistrement,slug from roles,juriductions where roles.juriduction = juriductions.id");
        } elseif (isset(Auth::user()->privilege) && Auth::user()->privilege == "admin") {
            $roles = DB::select("select nom,roles.id as id,roles.juriduction,president,greffier,section,jugeConsulaire,dateEnregistrement,roles.slug from roles,users,juriductions where  roles.juriduction = juriductions.id and roles.juriduction=users.juriduction and roles.juriduction = juriductions.id and users.id=? ", [Auth::user()->id]);
        }

        return view('admin.gestion-role', compact('roles'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (isset(Auth::user()->privilege) && Auth::user()->privilege == "superAdmin") {
            $juriductions = DB::select("select * from juriductions");
        } elseif (isset(Auth::user()->privilege) && Auth::user()->privilege == "admin") {
            $juriductions = DB::select("select * from juriductions,users where juriductions.id=users.juriduction and users.id=?", [Auth::user()->id]);
        }

        return view('admin.new-role', compact('juriductions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Roles();


        if ($request) {
            //Enregistrement du role
            $role->juriduction = $request->juriduction;
            $role->section = $request->section;
            $role->dateEnregistrement = $request->dateEnregistrement;
            $role->president = $request->president;
            $role->jugeConsulaire = $request->jugeConsulaire;
            $role->greffier = $request->greffier;
            $role->slug = $request->_token . '' . rand(1234, 3458);

            //fichier
            $file = $request->file('fichier');
            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $request->file('fichier')->extension();
            $role->fichier = $filename;
            $file->move(public_path('assets/upload/roles'), $filename);
            $role->save();

            //Enregistrement des affaires du role
            $request->validate([
                'formset.*.numOrdre' => 'required',
                'formset.*.numRg' => 'required',
                'formset.*.demandeur' => 'required',
                'formset.*.defendeur' => 'required',
                'formset.*.objet' => 'required',
            ]);


            foreach ($request->formset as $key => $value) {
                AffairesRole::create([
                    'idRole' => $role->id,
                    'numOrdre' => $value['numOrdre'],
                    'numRg' => $value['numRg'],
                    'demandeur' => $value['demandeur'],
                    'defendeur' => $value['defendeur'],
                    'objet' => $value['objet'],
                ]);
            }
        }
        return redirect()->route('gestionRole')->with('success', 'Rôle d\'audience enregistré avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $role = DB::select("select nom,roles.id as id,juriduction,president,greffier,section,jugeConsulaire,dateEnregistrement,fichier from roles,juriductions where roles.juriduction = juriductions.id");
        $idRole =$role[0]->id;
        $affairesRoles = DB::select("select * from roles,affaires_roles where roles.id = affaires_roles.idRole and idRole=?",[$idRole]);
        return view('role.details', compact('role', 'affairesRoles'));
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