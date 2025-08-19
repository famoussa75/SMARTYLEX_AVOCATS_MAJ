<?php

namespace App\Http\Controllers;

use App\Models\Affaires;
use App\Models\Fichiers;
use App\Models\CourierArriver;
use App\Models\CourierDepart;
use App\Models\Personnels;
use App\Models\Taches;
use App\Models\CompteBancaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Storage;
use Str;


class AdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recuperation des informations des personnels du cabinet 
        $personnel = Personnels::all();

        // recuperation des informations des couriers depart
        $courierDepart = CourierDepart::all();

        // recuperation des informations des Courriers - Arrivée
        $courierArriver = CourierArriver::all();

        // recuperation des informations des Tachess effectuées
        $Tachess = Taches::all();

        //Recuperation des informations Affaires effectuées par le cabinet
        $Affairess = Affaires::all();

        return view('administration.index', compact(
            'courierDepart',
            'courierArriver',
            'Tachess',
            'Affairess',
            'personnel'
        ));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paramAvance()
    {
        $email = Auth::user()->email;
        $cabinet = DB::select("select * from cabinets");
        $admin = DB::select("select * from users where role='Administrateur' and email=?", [$email]);
        $monnaies = DB::select("select * from monnaies");
        $compteBancaires = DB::select("select * from compte_bancaires");
        return view('administration.parametrage', compact('cabinet', 'admin','monnaies','compteBancaires'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCabinet(Request $request)
    {
        
        
        // Modification des informations du cabinet
        $cabinet = DB::select("select * from cabinets");
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $request->file('logo')->extension();
            $path = 'assets/upload/photos/'.$filename;
            $file->move(public_path('assets/upload/photos'), $filename);
        } else {
            $path =$cabinet[0]->logo;
        }
        
        DB::select(
           'update cabinets set 
            nomCabinet = ?,
            nomCourt = ?,
            emailContact = ?,
            emailAudience = ?,
            emailFinance = ?,
            adresseCabinet = ?,
            tel1 = ?,
            tel2 = ?,
            siteweb = ?,
            nif = ?,
            numTva = ?,
            termesFacture = ?,
            cleContact = ?,
            cleAudience = ?,
            cleFinance = ?,
            monnaieParDefaut = ?,
            logo = ?,
            totalComptes = ?,
            signature = ?,
            slogan = ?,
            rapportTache = ?,
            frequenceRapport = ?,
            numToge = ?',
            [
                $request->nomCabinet,
                $request->nomCourt,
                $request->emailContact,
                $request->emailAudience,
                $request->emailFinance,
                $request->adresseCabinet,
                $request->tel1,
                $request->tel2,
                $request->siteweb,
                $request->nif,
                $request->numTva,
                $request->termesFacture,
                $request->cleContact,
                $request->cleAudience,
                $request->cleFinance,
                $request->monnaieParDefaut,
                $path,
                $request->totalComptes,
                $request->signature,
                $request->slogan,
                $request->rapportTache,
                $request->frequenceRapport,
                $request->numToge,
                
            ]
        );



        // Modification du taux de change
        DB::select(
            "update monnaies set 
             tauxEchangeGn = ?,
             valeurTaux = ?
             Where description='GNF' ",
             [
                 $request->tauxEchangeGNF,
                 $request->valeurTauxGNF,
             ]
         );

         DB::select(
            "update monnaies set 
             tauxEchangeGn = ?,
             valeurTaux = ?
             Where description='EURO' ",
             [
                 $request->tauxEchangeEURO,
                 $request->valeurTauxEURO,

             ]
         );

         DB::select(
            "update monnaies set 
             tauxEchangeGn = ?,
             valeurTaux = ?
             Where description='USD' ",
             [
                 $request->tauxEchangeUSD,
                 $request->valeurTauxUSD,

             ]
         );

         DB::select(
            "update monnaies set 
             tauxEchangeGn = ?,
             valeurTaux = ?
             Where description='FCFA' ",
             [
                 $request->tauxEchangeCFA,
                 $request->valeurTauxCFA,

             ]
         );

         //Redefinition des comptes bancaires
         $idCabinet = DB::select("select * from cabinets");

         foreach ($request->formset as $key => $value) {

            if (isset($value['_delete']) && $value['_delete']) {
                // Supprimer en base
                CompteBancaires::where('idCompteBank', $value['idCompteBank'])->delete();
                continue;
            }
            if ($value['nomBank']=='') {
                # code...
            } else {
                CompteBancaires::updateOrCreate(
                    [ 'idCompteBank' => $value['idCompteBank']],
                    [
                   
                    'idCabinet' => $idCabinet[0]->id,
                    'nomBank' => $value['nomBank'],
                    'devise' => $value['devise'],
                    'codeBank' => $value['codeBank'],
                    'codeGuichet' => $value['codeGuichet'],
                    'numCompte' => $value['numCompte'],
                    'cleRib' => $value['cleRib'],
                    'iban' => $value['iban'],
                    'codeBic' => $value['codeBic'],
                ]);        
            }
            
            
        }


         // Modification des informations de l'Administrateur
         $user = DB::select("select * from users where email=?",[Auth::user()->email]);
         if ($request->file('photo')) {
             $file = $request->file('photo');
             $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $request->file('photo')->extension();
             $path = 'assets/upload/photos/'.$filename;
             $file->move(public_path('assets/upload/photos'), $filename);
         } else {
             $path =$user[0]->photo;
         }
         
         DB::select(
            'update users set 
             name = ?,
             email = ?,
             initial = ?,
             photo = ?
             where email =?',
            
             [
                 $request->name,
                 $request->email,
                 $request->initial,
                 $path,
                 Auth::user()->email,
             ]
         );
        return back()->with('success', 'Deconnectez et reconnectez vous pour la prise en compte des modifications');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requetes(Request $request)
    {
       

          // $courierDepart = DB::select("select idFichier,filename,nomFiles,courier_departs.slug,objet from fichiers,courier_files,courier_departs2 where courier_files.idCourier=courier_departs2.idCourierDep and fichiers.slugSource=courier_departs2.slug and typeCourier='Courier Depart' order by idFichier Desc");
        //  $courierDepart = DB::select("select objet,courier_departs2.slug,nomFiles,accuse_reception,idCourierDep from courier_departs2,courier_files where courier_departs2.idCourierDep=courier_files.idCourier and courier_files.typeCourier='Courier Depart' order by courier_departs2.idCourierDep Desc");
        
     
        
        //     foreach ($courierDepart as $c) {

        //      $slugAccuser  = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi');


           
        //     $files = Storage::files("assets/upload/files");

           
            
        //     foreach ($files as $file)
        //     {
        //         // to get the content the file, we need to get it from public/storage
        //         // so change the path to public/storage folder
        //         $file = Str::of($file)->replace("/assets/upload/", "/assets/upload/");
            
        //         // get the content of file
        //         $file_content = file_get_contents($file);

               
            
        //         // extract the file name from path
        //         $file_name_parts = explode("/", $file);

              
        //         if (count($file_name_parts) > 0)
        //         {
        //             // name is at the last index of array
        //             $file_name = $file_name_parts[count($file_name_parts) - 1];

        //            if ($file_name==$c->nomFiles) {

                  
        //              // set destination path
        //              $file_path = "assets/upload/courierD/" . $file_name;


        //             Storage::put($file_path, $file_content);
                  
        //             $courierFile = new Fichiers();

        //             $courierFile->nomOriginal = $c->objet;
        //             $courierFile->slugSource = $c->slug;
        //             $courierFile->filename = $c->nomFiles;
        //             $courierFile->slug = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi');
        //             $courierFile->path = 'assets/upload/fichiers/courier-departs/' . $c->nomFiles;
        //             $courierFile->save();


                    
        //            }
            
                   
        //         }else {
        //             dd($file_name_parts);
        //         }
        //     }
            
            

          

      // }

       //$fichiers = DB::select("select * from fichiers");

       //foreach ($fichiers as  $u) {

                // $aff = DB::select("select idClient from affaires where idAffaire=?",[$u->idAffaire]);

                // if (!empty($aff)) {
                //     DB::select("update courier_departs set idClient=? where idCourierDep=?",[$aff[0]->idClient,$u->idCourierDep]);
                // } else {
                //     DB::select("update courier_departs set idClient=? where idCourierDep=?",[NULL,$u->idCourierDep]);
                // }
                
                // if (is_null($u->idClient)) {
                //     $idClient = NULL;
                // } else {
                //     $idClient = intval($u->idClient);
                // }

                // if (is_null($u->idAffaire)) {
                //     $idAffaire = NULL;
                // } else {
                //     $idAffaire = intval($u->idAffaire);
                // }
                
 
                        // DB::select(
                        //     'INSERT INTO fichiers2(idFichier,nomOriginal,path,slugSource,filename,slug,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?)',
                        //     [
                        //         $u->idFichier,"$u->nomOriginal","$u->path",$u->slugSource,$u->filename,$u->slug,$u->created_at,$u->updated_at
                        //     ]
                        // );
                    
                

               

          
     // }

    //     $users2 = DB::select("select * from users2");

    //    foreach ($users2 as  $u) {


    //             DB::select(
    //                 'INSERT INTO users(id, name, email, statut,role,photo,initial,theme,lastConnexion,email_verified_at,password,remember_token,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
    //                 [
    //                     $u->id, "$u->name", "$u->email", "$u->status", "$u->role", "", "", "", NULL, NULL, "$u->password", "$u->remember_token", "$u->created_at", "$u->updated_at"
    //                 ]
    //             );

          
    //    }


    //    $clientsLast = DB::select("select * from clientsLast");

    //    foreach ($clientsLast as  $c) {

    //         if ($c->typeClient=='Client Physique') {

    //             if ($c->idRepresentant=='') {
    //                $idRepresentant = NULL;
    //             }else {
    //                 $idRepresentant = intval($c->idRepresentant);
    //             }

    //         DB::select(
    //             'INSERT INTO clients(idClient, typeClient, prenom, nom,adresse,email,telephone,idRepresentant,adresseEntreprise,emailEntreprise,telephoneEntreprise,denomination,rccm,logo,slug,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
    //             [
    //                 $c->id, "$c->typeClient", "$c->prenomClient", "$c->nomClient", "$c->adresseClient", "$c->emailClient", "$c->telephoneClient",$idRepresentant,NULL, NULL, NULL, NULL, NULL, NULL, "$c->slug", "$c->created_at", "$c->updated_at"
    //             ]
    //         );

    //         }else {

    //             if ($c->idRepresentant=='') {
    //                 $idRepresentant = NULL;
    //              }else {
    //                  $idRepresentant = intval($c->idRepresentant);
    //              }

    //             DB::select(
    //                 'INSERT INTO clients(idClient, typeClient, prenom, nom,adresse,email,telephone,idRepresentant,adresseEntreprise,emailEntreprise,telephoneEntreprise,denomination,rccm,logo,slug,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
    //                 [
    //                     $c->id, "$c->typeClient", NULL, NULL, NULL, NULL, NULL, $idRepresentant, "$c->adresseClient", "$c->emailClient", "$c->telephoneClient", "$c->nomClient", "$c->rccmClient", '', "$c->slug", "$c->created_at", "$c->updated_at"
    //                 ]
    //             );

    //         }
    //    }
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
