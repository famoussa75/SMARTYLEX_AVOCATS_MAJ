<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchNotif()
    {
        if (Session::has('idPersonnel')) {

            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
                $etat = 'vue';
                $idPerso = strval($id);
            }

          

            $newNotifs = DB::select("select * from notifications where etat='masquer' and idRecepteur=? order by id DESC", [$idPerso]);
            $bips = DB::select("select * from notifications where etat='masquer' and a_biper='non' and idRecepteur=? order by id DESC", [$idPerso]);

            //$newNotifAudience = DB::select("select urlParam,audiences.idAudience,audiences.slug,messages,niveauProcedural,id,categorie,audiences.objet from notifications,audiences where notifications.urlParam=audiences.slug and etat='masquer' and idRecepteur=? order by id DESC", [$idPerso]);
           // $newNotifRequete = DB::select("select urlParam,procedure_requetes.slug,messages,procedure_requetes.objet,id,categorie from notifications,procedure_requetes where notifications.urlParam=procedure_requetes.slug and etat='masquer' and idRecepteur=?  order by id DESC",[$idPerso]);
            $newNotifRequete = DB::select("select urlParam,procedure_requetes.slug,notifications.messages,notifications.id ,notifications.categorie, clients.nom as nomRequete,clients.prenom as prenomRequete,clients.idClient as idClientRequete,
             affaires.idAffaire as idAffaireRequete , affaires.nomAffaire  as nomAffaireRequete
            from notifications,procedure_requetes, parties_requetes, clients ,affaires where notifications.urlParam=procedure_requetes.slug and procedure_requetes.idProcedure= parties_requetes.idRequete and notifications.etat='masquer' and 
            clients.idClient=parties_requetes.idClient and affaires.idAffaire = parties_requetes.idAffaire and  notifications.idRecepteur=? order by notifications.id DESC",[$idPerso]);

            //$newNotifRequeteSuivi = DB::select("select urlParam,procedure_requetes.slug,messages,id,categorie,procedure_requetes.objet from notifications,procedure_requetes,suivit_requetes where notifications.urlParam=suivit_requetes.slug and suivit_requetes.idRequete=procedure_requetes.idProcedure and etat='masquer' and idRecepteur=? order by id DESC", [$idPerso]);

           /* $newNotifRequeteSuivi = DB::select("select notifications.urlParam,notifications.messages,notifications.id as id,notifications.categorie, clients.nom,clients.prenom,clients.idClient, affaires.idAffaire,affaires.nomAffaire,procedure_requetes.slug
            from notifications, parties_requetes, clients ,affaires,suivit_requetes,procedure_requetes where notifications.urlParam=suivit_requetes.slug  and notifications.etat='masquer' and 
            clients.idClient=parties_requetes.idClient and affaires.idAffaire= parties_requetes.idAffaire and suivit_requetes.idRequete= procedure_requetes.idProcedure and notifications.idRecepteur=? order by notifications.id DESC",[$idPerso]); */

            $newNotifRequeteSuivi = DB::select("
                SELECT  notifications.urlParam, notifications.messages,notifications.id AS id, notifications.categorie,  clients.nom, clients.prenom,  clients.idClient, affaires.idAffaire, affaires.nomAffaire, procedure_requetes.slug
                FROM notifications JOIN suivit_requetes ON notifications.urlParam = suivit_requetes.slug JOIN procedure_requetes ON suivit_requetes.idRequete = procedure_requetes.idProcedure JOIN parties_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
                JOIN clients ON clients.idClient = parties_requetes.idClient  JOIN affaires ON affaires.idAffaire = parties_requetes.idAffaire WHERE notifications.etat = 'masquer' and
                notifications.idRecepteur=? order by notifications.id DESC",[$idPerso]);


           // $newNotifSuivi = DB::select("select urlParam,audiences.idAudience,audiences.slug,messages,niveauProcedural,id,categorie,audiences.objet from notifications,suivit_audiences,audiences where notifications.urlParam=suivit_audiences.slug and suivit_audiences.idAudience=audiences.idAudience and etat='masquer' and idRecepteur=? order by id DESC", [$idPerso]);
           $newNotifSuivi = DB::select("
            SELECT audiences.niveauProcedural,notifications.urlParam,audiences.slug,notifications.messages,notifications.id AS id,notifications.categorie,clients.nom AS nom,clients.prenom AS prenom,clients.idClient, affaires.idAffaire,
                affaires.nomAffaire AS nomAffaire FROM notifications JOIN suivit_audiences ON notifications.urlParam = suivit_audiences.slug JOIN audiences ON suivit_audiences.idAudience = audiences.idAudience JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN clients ON parties.idClient = clients.idClient JOIN affaires ON parties.idAffaire = affaires.idAffaire WHERE notifications.etat = 'masquer' AND notifications.idRecepteur = ? ORDER BY notifications.id DESC ", [$idPerso]);

            //$newNotifSuiviAppel = DB::select("select urlParam,audiences.idAudience,audiences.slug,messages,niveauProcedural,id,categorie,audiences.objet from notifications,suivit_audience_appels,audiences where notifications.urlParam=suivit_audience_appels.slug and suivit_audience_appels.idAudience=audiences.idAudience and etat='masquer' and idRecepteur=? order by id DESC", [$idPerso]);
            $newNotifSuiviAppel = DB::select("select notifications.urlParam,audiences.idAudience,audiences.slug,notifications.messages,audiences.niveauProcedural,notifications.id,notifications.categorie ,clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            from notifications JOIN suivit_audience_appels ON notifications.urlParam = suivit_audience_appels.slug JOIN  audiences ON suivit_audience_appels.idAudience = audiences.idAudience JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN clients ON clients.idClient=parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire where  notifications.etat='masquer' and notifications.idRecepteur=? order by notifications.id DESC",[$idPerso]);

           // $newNotifsFacture = DB::select("select factures.slug,urlName,urlParam,idRecepteur,id,categorie,messages,etat,clients.nom ,clients.prenom from notifications,factures,clients where factures.slug=notifications.urlParam and clients.idClient= factures.idClient and etat='masquer' and  idRecepteur=? order by id DESC",[$idPerso]);
            $newNotifsFacture = DB::select("select factures.slug,notifications.urlName,notifications.urlParam,notifications.idRecepteur,notifications.id,notifications.categorie,notifications.messages,notifications.etat,clients.nom ,clients.prenom,clients.idClient, factures.idAffaire, affaires.nomAffaire from notifications,factures,clients,affaires where 
            factures.slug=notifications.urlParam and clients.idClient= factures.idClient and factures.idAffaire= affaires.idAffaire and notifications.etat='masquer' and  notifications.idRecepteur=? order by id DESC",[$idPerso]);

            $newNotifAudience = DB::select("
            SELECT  audiences.niveauProcedural,notifications.urlParam, audiences.slug, notifications.messages, notifications.id AS id, notifications.categorie, clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            FROM notifications JOIN audiences ON notifications.urlParam = audiences.slug JOIN parties ON audiences.idAudience = parties.idAudience JOIN clients ON clients.idClient = parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire
            WHERE notifications.etat = 'masquer' AND audiences.niveauProcedural != 'Appel' AND  notifications.idRecepteur =?  ORDER BY notifications.id DESC ", [$idPerso]);

            $newNotifAudience2 = DB::select("
            SELECT  audiences.niveauProcedural,notifications.urlParam, audiences.slug, notifications.messages, notifications.id AS id, notifications.categorie, clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            FROM notifications JOIN audiences ON notifications.urlParam = audiences.slug JOIN parties ON audiences.idAudience = parties.idAudience JOIN clients ON clients.idClient = parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire
            WHERE notifications.etat = 'masquer' AND  audiences.niveauProcedural = 'Appel' AND notifications.idRecepteur =?  ORDER BY notifications.id DESC ", [$idPerso]);
        

            $newNotifsTaches = DB::select("select taches.slug,notifications.urlParam,taches.idTache,notifications.id,notifications.categorie,notifications.messages,taches.titre ,clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire 
            from notifications,taches,affaires,clients where notifications.urlParam= taches.slug and notifications.etat='masquer' and clients.idClient=taches.idClient and affaires.idAffaire= taches.idAffaire and notifications.idRecepteur=? order by id DESC",[$idPerso]);

            $newNotifsCourierArriversCabinet = DB::select("
            SELECT  ca.slug, n.urlParam,n.id,  n.categorie, n.messages, c.idClient, c.nom, c.prenom,af.idAffaire,af.nomAffaire FROM notifications n INNER JOIN Courier_Arrivers ca ON n.urlParam = ca.slug
            LEFT JOIN clients c ON c.idClient = ca.idClient  LEFT JOIN affaires af ON af.idAffaire = ca.idAffaire  WHERE n.etat = 'masquer' AND (ca.idClient IS NULL OR ca.idAffaire IS NULL)
            AND n.idRecepteur = ? ORDER BY n.id DESC",[$idPerso]);

            $newNotifsCourierArriversClient = DB::select("
            SELECT  ca.slug,  n.urlParam, n.id,   n.categorie,  n.messages,  c.idClient, c.nom, c.prenom,af.idAffaire, af.nomAffaire FROM notifications n
            INNER JOIN Courier_Arrivers ca ON n.urlParam = ca.slug INNER JOIN clients c ON c.idClient = ca.idClient INNER JOIN affaires af ON af.idAffaire = ca.idAffaire  WHERE n.etat = 'masquer'
            AND n.idRecepteur = ? ORDER BY n.id DESC",[$idPerso]);


            $newNotifsCourierDepartsCabinet = DB::select("
            SELECT  cd.slug, n.urlParam,n.id,  n.categorie, n.messages, c.idClient, c.nom, c.prenom,af.idAffaire,af.nomAffaire FROM notifications n INNER JOIN `Courier_departs` cd ON n.urlParam = cd.slug
            LEFT JOIN clients c ON c.idClient = cd.idClient  LEFT JOIN affaires af ON af.idAffaire = cd.idAffaire  WHERE n.etat = 'masquer' AND (cd.idClient IS NULL OR cd.idAffaire IS NULL)
            AND  n.idRecepteur = ? ORDER BY n.id DESC",[$idPerso]);

            $newNotifsCourierDepartsClient = DB::select("
            SELECT  cd.slug,  n.urlParam, n.id,   n.categorie,  n.messages,  c.idClient, c.nom, c.prenom,af.idAffaire, af.nomAffaire FROM notifications n
            INNER JOIN Courier_departs cd ON n.urlParam = cd.slug INNER JOIN clients c ON c.idClient = cd.idClient INNER JOIN affaires af ON af.idAffaire = cd.idAffaire  WHERE n.etat = 'masquer'
            AND  n.idRecepteur = ? ORDER BY n.id DESC",[$idPerso]);



        } else {

            $newNotifs = DB::select("select * from notifications where etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
            $bips = DB::select("select * from notifications where etat='masquer' and a_biper='non' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
            //$newNotifAudience = DB::select("select urlParam,audiences.idAudience,audiences.slug,audiences.objet,messages,niveauProcedural,id,categorie from notifications,audiences where notifications.urlParam=audiences.slug and etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
            //$newNotifSuivi = DB::select("select urlParam,audiences.idAudience,audiences.slug,messages,niveauProcedural,id,categorie,audiences.objet from notifications,suivit_audiences,audiences where notifications.urlParam=suivit_audiences.slug and suivit_audiences.idAudience=audiences.idAudience and etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
           // $newNotifSuiviAppel = DB::select("select urlParam,audiences.idAudience,audiences.slug,messages,niveauProcedural,id,categorie from notifications,suivit_audience_appels,audiences where notifications.urlParam=suivit_audience_appels.slug and suivit_audience_appels.idAudience=audiences.idAudience and etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
           // $newNotifsFacture = DB::select("select factures.slug,urlName,urlParam,idRecepteur,id,categorie,messages,etat ,clients.nom ,clients.prenom from notifications,factures ,clients where factures.slug=notifications.urlParam and clients.idClient = factures.idClient and idRecepteur='admin' and idAdmin=? and etat='masquer' order by id DESC",[Auth::user()->id]);
           // $newNotifRequete = DB::select("select urlParam,procedure_requetes.slug,procedure_requetes.objet,messages,id,categorie from notifications,procedure_requetes where notifications.urlParam=procedure_requetes.slug and etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
           // $newNotifRequeteSuivi = DB::select("select urlParam,procedure_requetes.slug,procedure_requetes.objet,messages,id,categorie from notifications,procedure_requetes,suivit_requetes where notifications.urlParam=suivit_requetes.slug and suivit_requetes.idRequete=procedure_requetes.idProcedure  and etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
           

            $newNotifsFacture = DB::select("select factures.slug,notifications.urlName,notifications.urlParam,notifications.idRecepteur,notifications.id,notifications.categorie,notifications.messages,notifications.etat,clients.nom ,clients.prenom,clients.idClient, factures.idAffaire, affaires.nomAffaire from notifications,factures,clients,affaires where 
            factures.slug=notifications.urlParam and clients.idClient= factures.idClient and factures.idAffaire= affaires.idAffaire and notifications.etat='masquer'  and notifications.idRecepteur='admin' and  notifications.idAdmin=? order by id DESC",[Auth::user()->id]);

            $newNotifAudience = DB::select("
            SELECT  audiences.niveauProcedural,notifications.urlParam, audiences.slug, notifications.messages, notifications.id AS id, notifications.categorie, clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            FROM notifications JOIN audiences ON notifications.urlParam = audiences.slug JOIN parties ON audiences.idAudience = parties.idAudience JOIN clients ON clients.idClient = parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire
            WHERE notifications.etat = 'masquer' AND notifications.idRecepteur = 'admin' AND audiences.niveauProcedural != 'Appel' AND notifications.idAdmin = ?  ORDER BY notifications.id DESC ", [Auth::user()->id]);
        
            $newNotifSuivi = DB::select("
            SELECT audiences.niveauProcedural,notifications.urlParam,audiences.slug,notifications.messages,notifications.id AS id,notifications.categorie,clients.nom AS nom,clients.prenom AS prenom,clients.idClient, affaires.idAffaire,
                affaires.nomAffaire AS nomAffaire FROM notifications JOIN suivit_audiences ON notifications.urlParam = suivit_audiences.slug JOIN audiences ON suivit_audiences.idAudience = audiences.idAudience JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN clients ON parties.idClient = clients.idClient JOIN affaires ON parties.idAffaire = affaires.idAffaire WHERE notifications.etat = 'masquer' AND notifications.idRecepteur = 'admin' AND notifications.idAdmin = ?
            ORDER BY notifications.id DESC ", [Auth::user()->id]);
        

             $newNotifRequete = DB::select("select urlParam,procedure_requetes.slug,notifications.messages,notifications.id ,notifications.categorie, clients.nom as nomRequete,clients.prenom as prenomRequete,clients.idClient as idClientRequete,
             affaires.idAffaire as idAffaireRequete , affaires.nomAffaire  as nomAffaireRequete
            from notifications,procedure_requetes, parties_requetes, clients ,affaires where notifications.urlParam=procedure_requetes.slug and procedure_requetes.idProcedure= parties_requetes.idRequete and notifications.etat='masquer' and 
            clients.idClient=parties_requetes.idClient and affaires.idAffaire = parties_requetes.idAffaire and  notifications.idRecepteur='admin' and  notifications.idAdmin=? order by notifications.id DESC",[Auth::user()->id]);



           /* $newNotifRequeteSuivi = DB::select("select  notifications.urlParam,notifications.messages,notifications.id as id,notifications.categorie, clients.nom,clients.prenom,clients.idClient, affaires.idAffaire,affaires.nomAffaire,procedure_requetes.slug
            from notifications, parties_requetes, clients ,affaires,suivit_requetes,procedure_requetes where notifications.urlParam=suivit_requetes.slug  and notifications.etat='masquer' and 
            clients.idClient=parties_requetes.idClient and affaires.idAffaire= parties_requetes.idAffaire and suivit_requetes.idRequete= procedure_requetes.idProcedure and notifications.idRecepteur='admin' and  notifications.idAdmin=? order by notifications.id DESC",[Auth::user()->id]);*/

            $newNotifRequeteSuivi = DB::select("
                SELECT  notifications.urlParam,notifications.messages, notifications.id AS id,notifications.categorie, clients.nom,clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire, procedure_requetes.slug
                FROM notifications JOIN suivit_requetes ON notifications.urlParam = suivit_requetes.slug JOIN procedure_requetes ON suivit_requetes.idRequete = procedure_requetes.idProcedure  JOIN parties_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
                JOIN clients ON clients.idClient = parties_requetes.idClient JOIN affaires ON affaires.idAffaire = parties_requetes.idAffaire  WHERE notifications.etat = 'masquer' AND notifications.idRecepteur = 'admin' AND notifications.idAdmin = ?
                ORDER BY notifications.id DESC
            ", [Auth::user()->id]);

            $newNotifSuiviAppel = DB::select("select notifications.urlParam,audiences.idAudience,audiences.slug,notifications.messages,audiences.niveauProcedural,notifications.id,notifications.categorie,clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            from notifications JOIN suivit_audience_appels ON notifications.urlParam = suivit_audience_appels.slug JOIN  audiences ON suivit_audience_appels.idAudience = audiences.idAudience JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN clients ON clients.idClient=parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire where  notifications.etat='masquer' and idRecepteur='admin' AND audiences.niveauProcedural = 'Appel' and idAdmin=? order by notifications.id DESC",[Auth::user()->id]);


            $newNotifAudience2 = DB::select("
            SELECT  audiences.niveauProcedural,notifications.urlParam, audiences.slug, notifications.messages, notifications.id AS id, notifications.categorie, clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire
            FROM notifications JOIN audiences ON notifications.urlParam = audiences.slug JOIN parties ON audiences.idAudience = parties.idAudience JOIN clients ON clients.idClient = parties.idClient JOIN affaires ON affaires.idAffaire = parties.idAffaire
            WHERE notifications.etat = 'masquer' AND notifications.idRecepteur = 'admin' AND audiences.niveauProcedural = 'Appel' AND notifications.idAdmin = ?  ORDER BY notifications.id DESC ", [Auth::user()->id]);

            $newNotifsTaches = DB::select("select taches.slug,notifications.urlParam,taches.idTache,notifications.id,notifications.categorie,notifications.messages,taches.titre ,clients.nom, clients.prenom, clients.idClient, affaires.idAffaire, affaires.nomAffaire 
            from notifications,taches,affaires,clients where notifications.urlParam= taches.slug and notifications.etat='masquer' and clients.idClient=taches.idClient and affaires.idAffaire= taches.idAffaire and notifications.idRecepteur='admin' and notifications.idAdmin=? order by id DESC",[Auth::user()->id]);


            $newNotifsCourierArriversCabinet = DB::select("
            SELECT  ca.slug, n.urlParam,n.id,  n.categorie, n.messages, c.idClient, c.nom, c.prenom,af.idAffaire,af.nomAffaire FROM notifications n INNER JOIN Courier_Arrivers ca ON n.urlParam = ca.slug
            LEFT JOIN clients c ON c.idClient = ca.idClient  LEFT JOIN affaires af ON af.idAffaire = ca.idAffaire  WHERE n.etat = 'masquer' AND (ca.idClient IS NULL OR ca.idAffaire IS NULL)
            AND n.idRecepteur = 'admin' AND n.idAdmin = ? ORDER BY n.id DESC", [Auth::user()->id]);

            $newNotifsCourierArriversClient = DB::select("
            SELECT  ca.slug,  n.urlParam, n.id,   n.categorie,  n.messages,  c.idClient, c.nom, c.prenom,af.idAffaire, af.nomAffaire FROM notifications n
            INNER JOIN Courier_Arrivers ca ON n.urlParam = ca.slug INNER JOIN clients c ON c.idClient = ca.idClient INNER JOIN affaires af ON af.idAffaire = ca.idAffaire  WHERE n.etat = 'masquer'
            AND n.idRecepteur = 'admin' AND n.idAdmin = ? ORDER BY n.id DESC", [Auth::user()->id]);

            $newNotifsCourierDepartsCabinet = DB::select("
            SELECT  cd.slug, n.urlParam,n.id,  n.categorie, n.messages FROM notifications n INNER JOIN Courier_departs cd ON n.urlParam = cd.slug
            LEFT JOIN clients c ON c.idClient = cd.idClient  LEFT JOIN affaires af ON af.idAffaire = cd.idAffaire  WHERE n.etat = 'masquer' AND (cd.idClient IS NULL OR cd.idAffaire IS NULL)
            AND n.idRecepteur = 'admin' AND n.idAdmin = ? ORDER BY n.id DESC", [Auth::user()->id]);

            $newNotifsCourierDepartsClient = DB::select("
            SELECT  cd.slug,  n.urlParam, n.id,   n.categorie,  n.messages,  c.idClient, c.nom, c.prenom,af.idAffaire, af.nomAffaire FROM notifications n
            INNER JOIN Courier_departs cd ON n.urlParam = cd.slug INNER JOIN clients c ON c.idClient = cd.idClient INNER JOIN affaires af ON af.idAffaire = cd.idAffaire  WHERE n.etat = 'masquer'
            AND n.idRecepteur = 'admin' AND n.idAdmin = ? ORDER BY n.id DESC", [Auth::user()->id]);


        }

        foreach ($newNotifs as $n) {
            DB::update("update notifications set a_biper='oui' where id=?", [$n->id]);
        }

        return response()->json([
            'newNotif' => $newNotifs,
            'bips' => $bips,
            'newNotifAudience' => $newNotifAudience,
            'newNotifSuivi' => $newNotifSuivi,
            'newNotifSuiviAppel' => $newNotifSuiviAppel,
            'newNotifsFacture' => $newNotifsFacture,
            'newNotifRequete' => $newNotifRequete,
            'newNotifRequeteSuivi' => $newNotifRequeteSuivi,
            'newNotifsTaches' => $newNotifsTaches,
            'newNotifsCourierArriversCabinet' => $newNotifsCourierArriversCabinet,
            'newNotifsCourierArriversClient' => $newNotifsCourierArriversClient,
            'newNotifsCourierDepartsCabinet' => $newNotifsCourierDepartsCabinet,
            'newNotifsCourierDepartsClient' => $newNotifsCourierDepartsClient,
        ]);
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $idNotif)
    {
        DB::update("update notifications set etat='vue' where id=?", [$idNotif]);
        return redirect()->route('infosTask', $slug);
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
