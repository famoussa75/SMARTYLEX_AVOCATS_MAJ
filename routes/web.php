<?php

use App\Http\Controllers\AdministrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AffaireController;
use App\Http\Controllers\AnnuairesController;
use App\Http\Controllers\AudiencesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvocatsController;
use App\Http\Controllers\CourierArriverController;
use App\Http\Controllers\CourierDepartController;
use App\Http\Controllers\CourierFilesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HuissiersController;
use App\Http\Controllers\NotairesController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\TacheFileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacturationController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\TwoFAController;
use App\Models\clients;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Auth\NewPasswordController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




     Route::get('/', [TwoFAController::class, 'index'])->name('endPoint');

     //Route::get('/', [AdministrationController::class, 'requetes'])->name('requetes');




    /* Module utilisateur */

    Route::middleware(['auth', 'verified'])->group(function () {


    Route::controller(TwoFAController::class)->group(function(){
        Route::get('two-factor-authentication', 'doubleFacteur')->name('2fa.index');
        Route::post('two-factor-authentication/store', 'store')->name('2fa.store');
        Route::get('two-factor-authentication/resend', 'resend')->name('2fa.resend');
    });

    // Les routes permettant d'effectuer la gestion des utilisateurs
    Route::get('/administration', [AdministrationController::class, 'index'])->name('gestion');

    // Les routes permettant d'effectuer la gestion des utilisateurs
    Route::get('/parametrage', [AdministrationController::class, 'paramAvance'])->name('paramAvance');

    // Modification du cabinet
    Route::post('/enregistrement', [AdministrationController::class, 'updateCabinet'])->name('updateCabinet');

    // La route permettant d'afficher le formulaire d'ajout d'un utilisateur
    Route::get('/user/form', [UserController::class, 'create'])->name('userForm');

    // Fonction permettant d'enregistrer l'utilisateur
    Route::post('/user/saveform', [UserController::class, 'store'])->name('postUser');

    // Changement de theme
    Route::get('/user/theme/{theme}', [UserController::class, 'setTheme'])->name('setTheme');


    /* Fin Module utilisateur */

    /* Module personnel */
    
    // La route permettant de trouver les matricules
    Route::get('/Personnel/getMatriculePersonne', [PersonnelController::class, 'getMatriculePersonnel'])->name('getMatricule');

    // La route permettantes d'afficher la Liste du personnel
    Route::get('/personnel/list', [PersonnelController::class, 'index'])->name('allPersonnel');

    // La route permettantes d'afficher la Liste du personnel en card
    Route::get('/personnel/cards', [PersonnelController::class, 'personnelCard'])->name('personneCard');

    // La route permettantes d'afficher le formulaire d'enregistrement d'un personnel
    Route::get('/personnel/form', [PersonnelController::class, 'create'])->name('formPersonnel');

    // La route permettantes d'effectuer l'action d'enregistrement du personnel
    Route::post('/personnel/save', [PersonnelController::class, 'store'])->name('addPersonnel');

    // La route permettantes d'effectuer la modification des informations du personnels
    Route::post('/personnel/update/{slug}', [PersonnelController::class, 'updatePersonnel'])->name('updatePersonnel');

    // Formulaire pour editer le password
    Route::get('/personnel/edit/{email}', [PersonnelController::class, 'editPassword'])->name('editPassword');

    // La route permettantes d'effectuer la modification du mot de passe du personnels
    Route::post('/personnel/update/password', [PersonnelController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update-password', [UserController::class, 'update'])->name('password.update');


    // La route permettantes d'afficher les informations d'un personnel spécifique
    Route::get('/personnel/view/{slugs}', [PersonnelController::class, 'show'])->name('infosPersonne');

    Route::get('/personnel/bloquer/{email}', [PersonnelController::class, 'blockPersonnel'])->name('blockPersonnel');

    Route::get('/personnel/debloquer/{email}', [PersonnelController::class, 'deblockPersonnel'])->name('deblockPersonnel');

    // La route permettantes d'afficher les informations d'un personnel spécifique a partir du header
    Route::get('/personnel/viewByHeader/{email}', [PersonnelController::class, 'show2'])->name('infosPersonne2');

    // La route permettantes de supprimer un personnel
    Route::get('/personnel/delete/{slugs}', [PersonnelController::class, 'destroy'])->name('deletePersonne');

    // form et list d'affectation d'un client a un personnel
    Route::get('/personnel/affectation', [PersonnelController::class, 'clientPersonnel'])->name('clientPersonnel');

    // les clients du personnel
    Route::get('/personnel/client', [PersonnelController::class, 'CollabClient'])->name('CollabClient');

    // affaires du personnel
    Route::get('/personnel/affaire', [PersonnelController::class, 'CollabAffaires'])->name('CollabAffaires');

    // audiences du personnel
    Route::get('/personnel/audience', [PersonnelController::class, 'CollabAudiences'])->name('CollabAudiences');

    // enregistrement d'une assignation
    Route::post('/personnel/save_assignment', [PersonnelController::class, 'addAffectation'])->name('addAffectation');

    // La route permettante de d'annuler l'affectation d'un personnel au dossier d'un client
    Route::get('/personnel/cancel_assignment/{slug}', [PersonnelController::class, 'destroyAffectation'])->name('deleteGranted');

    /* Fin Module personnel */


    /* Module Client */

    // Formulaire d'enregistrement d'un client
    Route::get('/client/form', [ClientController::class, 'create'])->name('clientForme');

    // Enregistrement du client
    Route::post('/client/save', [ClientController::class, 'store'])->name('addClient');

    // Modification du client
    Route::post('/client/update{slug}', [ClientController::class, 'update'])->name('updateClient');

    // Suppression du client
    Route::get('/client/delete/{slug}', [ClientController::class, 'deleteClient'])->name('deleteClient');

    // La route permettantes d'afficher la liste des clients
    Route::get('/client/list', [ClientController::class, 'index'])->name('allClient');

    // List des clients style card
    Route::get('/client/cardList', [ClientController::class, 'card'])->name('clientListe');

    // Liste de client des collaborateurs
    Route::get('/client/collaborateurs', [ClientController::class, 'collabList'])->name('clientListeCollab');

    // La route permettantes d'afficher les informations d'un client
    Route::get('/client/view/{id}/{slug}', [ClientController::class, 'clientInfo'])->name('clientInfos');

    // Importation des emmployees du client
    Route::post('/client/import', [ClientController::class, 'importEmployeeData'])->name('importEmployeeData');

    // Contrat du personnel du client.
    Route::get('/client/contrat/{slug}', [ClientController::class, 'contratEmployee'])->name('contratEmployee');

    Route::get('/client/infoPersonnel/{slug}', [ClientController::class, 'infoPersonnel'])->name('infoPersonnelClient');

    // Enregistrement du contrat date signer
    Route::post('/client/contratSigner/save', [ClientController::class, 'addContratSignerClient'])->name('addContratSignerClient');

    // Supprimer le contrat signer du client
    Route::get('/client/contratSigner/delete/{slug}', [ClientController::class, 'deleteContraSignerClient'])->name('deleteContraSignerClient');


     // Enregistrement d'un avenant
     Route::post('/client/avenant/save', [ClientController::class, 'addContratAvenantClient'])->name('addContratAvenantClient');

      // Supprimer un avenant signer du client
    Route::get('/client/avenant/delete/{slug}', [ClientController::class, 'deleteContraAvenantClient'])->name('deleteContraAvenantClient');

    // Enregistrement de fin de contrat
    Route::post('/client/finContrat/save', [ClientController::class, 'addFinContratClient'])->name('addFinContratClient');

        // Supprimer un fin de contrat.
    Route::get('/client/finContrat/delete/{slug}', [ClientController::class, 'deleteFinContratClient'])->name('deleteFinContratClient');



    /* 
    -------------- UTILISABLE PLUTARD---------------------------
    La route permettantes d'envoyé le message (SMS) à un client
    Route::post('/clientSentSMS/data', [ClientController::class, 'sentSMS'])->name('clientSentSMS');
    */

    /* Fin Module Client */

    /* Routes AJAX */

   // routes/web.php
   

   // liste courrier->affaire->client
    Route::get('/fetch-affaire-couriers/{id}', [CourierArriverController::class, 'fetchAffaireCouriers']);
    Route::get('/fetch-courriers-cabinet', [CourierArriverController::class, 'fetchCourriersCabinet']);



    // Reccuperer une seule affaire
    Route::get('/fetch-affaire/{id}', [AffaireController::class, 'fetchAffaire'])->name('fetchAffaire');

    Route::get('/fetch-requete/{id}', [AudiencesController::class, 'fetchRequete'])->name('fetchRequete');

    Route::post('/store-lier-requete', [AudiencesController::class, 'lierRequeteManuel'])->name('lierRequeteManuel');

    Route::post('/store-lier-requete-contraditoire', [AudiencesController::class, 'lierRequeteManuelContraditoire'])->name('lierRequeteManuelContraditoire');

    Route::get('/requete-lier/delete/{id}', [AudiencesController::class, 'deleteRequeteLier'])->name('deleteRequeteLier');

    Route::get('/fetch-clientName/{denomination}', [ClientController::class, 'fetchClientName'])->name('fetchClientName');

    Route::get('/fetch-clientName/{prenom}/{nom}', [ClientController::class, 'fetchClientName2'])->name('fetchClientName2');

    // Reccuperer un seule suivit
    Route::get('/fetch-suivitAudience/{id}', [ClientController::class, 'fetchSuivit'])->name('fetchSuivit');

    Route::get('/fetch-suivitAudienceAppel/{id}', [ClientController::class, 'fetchSuivitAppel'])->name('fetchSuivitAppel');

    Route::get('/info-client/{id}', [ClientController::class, 'fetchClient'])->name('fetchClient');

    // Reccuperer toutes les notifications
    Route::get('/fetch-notif', [NotifController::class, 'fetchNotif'])->name('fetchNotif');

    // Recupperer l'initial d'un seule personnel
    Route::get('/initQersy/{id}/', [PersonnelController::class, 'initial'])->name('initPersonnel');

    // Recuperer l'initial d'un seul admin
    Route::get('/initAdmin/{id}/', [PersonnelController::class, 'initialAdmin'])->name('initAdmin');

    // Reccuperer un seule utilisateur
    Route::get('/check-user/{email}', [UserController::class, 'checkUser'])->name('checkUsers');

    // La route permettantes de retourner la tâche parente selectionner'
    Route::get('/tache/clientAffaire/{slugTache}/{titre}/', [TacheController::class,  'getOneTache'])->name('getOneTache');

    // La route permettante de retouner la liste des tâches disponible pour la recherche utilisateur'
    Route::get('/taches/task', [TacheController::class,  'getAllTache'])->name('allTask');

    // La route permettante de retouner la liste des tâches disponible pour la recherche utilisateur'
    Route::get('/getTaskSearch/{search}', [TacheController::class,  'getAllTacheForSearch'])->name('allTaskSearch');

    // Recherche des affaires
    Route::get('/getAffaireSearch/{search}', [AffaireController::class,  'getAllAffaireForSearch'])->name('allAffaireSearch');

    // Recherche des couriers départ
    Route::get('/getCourierDepartSearch/{search}', [CourierDepartController::class,  'getAllCourierDepartForSearch'])->name('allCourierDepartSearch');

    // Recherche des couriers arrivers
    Route::get('/getCourierArriverSearch/{search}', [CourierArriverController::class,  'getAllCourierArriverForSearch'])->name('allCourierArriverSearch');

     // Recherche des clients
     Route::get('/getClientSearch/{search}', [ClientController::class,  'getAllClientForSearch'])->name('allClientSearch');

    /* Fin Route AJAX */


    /* Module Affaire */

    // Supprimer une affaire
    Route::get('/affaire/delete/{slug}', [AffaireController::class, 'deleteAffaire'])->name('deleteAffaire');

    // la route permettantes d'afficher le formulaire d'enregistrer d'une affaire'
    Route::get('/affaire/form', [AffaireController::class, 'create'])->name('createAffaire');

    // la route permettantes d'enregistrer une affaire'
    Route::post('/affaire/save', [AffaireController::class, 'store'])->name('storeAffaire');

    // Toutes les affaires
    Route::get('/affaire/list', [AffaireController::class, 'affaireListe'])->name('affaireListe');

    // Les affaires du collaborateur
    Route::get('/affaire/collaborateur/list', [PersonnelController::class, 'affaireListeCollab'])->name('affaireListeCollab');

    // La route permettante de faire la modification des informations d'une affaire
    Route::post('/affaire/edit/{slug}', [AffaireController::class, 'update'])->name('updateAffaire');

    // Routes les affaires style card
    Route::get('/affaire/cardList', [AffaireController::class, 'index'])->name('allAfaires');


    // Routes les affaires style card pour le portail client
    Route::get('/affaire/cardList/client', [AffaireController::class, 'allAffaireClient'])->name('affaireClient');
    

    // Detail de l'affaire
    Route::get('/affaire/view/{id}/{slug}', [AffaireController::class, 'show'])->name('showAffaire');

    /* Fin Module Affaire */



    /* Module Tâche */

    // La route permettantes d'affichier le formulaire d'enregistrment de la tâche et a partir de la page affaire/client
    Route::get('/tache/form/{idModule}/{typeModule}', [TacheController::class,  'create'])->name('taskForm');

    // Suppression du traitement par son createur
    Route::get('/tache/traitement/delete/{idTraitement}', [TacheController::class,  'deleteTraitement'])->name('deleteTraitement');

    // Enregistrement d'une tache
    Route::post('/tache/save', [TacheController::class,  'store'])->name('addTask');

    // La route permettantes d'afficher la liste de tâches disponible'
    Route::get('/tache/list', [TacheController::class,  'index'])->name('allTasks');

    // La route permettantes d'afficher la liste de tâches pour les employees'
    Route::get('/tache_personnel', [TacheController::class,  'employeeTask'])->name('employeeTask');

    // La route permettantes d'afficher toutes les informations de la tâches selectionner'
    Route::get('/tache/view/{slug}', [TacheController::class, 'show'])->name('infosTask');

    Route::get('/tache/view/audience/{idSuivit}', [TacheController::class, 'showFromAud'])->name('infosTaskFromAudience');
    Route::get('/tache/view/requete/{idSuivitRequete}', [TacheController::class, 'showFromAud2'])->name('infosTaskFromAudience2');

    // La route permettantes d'afficher toutes les informations de la tâches en attente'
    Route::get('/tache/temporaire/view/{slug}', [TacheController::class, 'show2'])->name('infosTask2');

    // voir les notifications des taches
    Route::get('/tache/notification/{slug}/{idNotif}', [NotifController::class, 'show'])->name('vueNotif');

    // La route permettantes d'ajouter un fichier a une tâche'
    Route::post('/tache/addFile', [TacheFileController::class, 'addFileTache'])->name('joinFile');


    // La route permettantes d'ajouter un traitement a la tâche
    Route::post('/tache/addTraitement', [TacheController::class, 'addTaskTraitement'])->name('traitementTache');

    // La route permettantes de valider une tache
    Route::get('/tache/valider/{slug}/{slugFille}', [TacheController::class, 'valideTask'])->name('valideTask');

    // La route permettantes de supprimer une tache
    Route::get('/tache/delete/{slug}', [TacheController::class, 'deleteTask'])->name('deleteTask');

    // La route permettantes de supprimer une personne sur la tache
    Route::get('/tache/delete_personnel/{idTache}/{idPersonnel}', [TacheController::class, 'deletePersonnelTask'])->name('deletePersonnelTask');

     // La route permettantes de monter une personne sur la tache
     Route::get('/tache/responsable_personnel/{idTache}/{idPersonnel}', [TacheController::class, 'responsablePersonnelTask'])->name('responsablePersonnelTask');

     // La route permettantes de retrograder une personne sur la tache
     Route::get('/tache/participant_personnel/{idTache}/{idPersonnel}', [TacheController::class, 'participantPersonnelTask'])->name('participantPersonnelTask');

    // La route permettantes de supprimer une tache
    Route::get('/tache/temporaire/deleteTask_2/{slug}', [TacheController::class, 'deleteTask2'])->name('deleteTask2');

    // La route permettant de suspendre une tache
    Route::get('/tache/stop/{slug}', [TacheController::class, 'suspendreTache'])->name('stopTask');

    // La route permettante de reprendre une tache stopper
    Route::get('/tache/start/{slug}', [TacheController::class, 'startingTache'])->name('startStask');

    // La route permettante de modifier une tâche selectionner
    Route::post('/tache/update/{slug}/', [TacheController::class, 'updateTask'])->name('updateTaskSelected');

    // La route permettante de modifier une tâche en attente
    Route::post('/tache/temporaire/update/{slug}/', [TacheController::class, 'updateTask2'])->name('updateTaskSelected2');

    // La route permettante d'assigner une tache a un employee
    Route::post('/tache/assigner/{id}/{slug}/', [TacheController::class, 'updateAssignation'])->name('assigneTaskPersonne');

    // La route permettante d'assigner une tache en attante a un employee
    Route::post('/tache/temporaire/assigner/{id}/{slug}/', [TacheController::class, 'updateAssignation2'])->name('assigneTaskPersonne2');

    /* Fin Module Tâche */

    /* Module couriers */

    // La route permettantes d'afficher la liste de tous les couriers départ et arriver dans le système
    Route::get('/courier/list', [CourierArriverController::class, 'allDutys'])->name('allCouriers');

    Route::get('/courier/deleteLiaison/{slugCourierLier}', [CourierArriverController::class, 'deleteLiaisonCourier'])->name('deleteLiaisonCourier');

    Route::post('/courier/saveLiaison', [CourierArriverController::class, 'saveCourierLier'])->name('saveCourierLier');

    // couriers arrivers

    // La route permettantes d'envoyer le formulaire d'enregistrement du Courriers - Arrivée
    Route::get('/courier_arriver/form', [CourierArriverController::class, 'create'])->name('createCourierArriver');

    // Classer les couriers arrivers
    Route::get('/courier_arriver/classer/{slug}', [CourierArriverController::class, 'classer'])->name('classerCourrier');

    // La route permettantes d'enregistrer le courier d'arriver
    Route::post('/courier_arriver/save', [CourierArriverController::class, 'store'])->name('storeCourierArriver');

    // La route permettantes d'afficher la liste des Courriers - Arrivée'
    Route::get('/courier_arriver/list', [CourierArriverController::class, 'index'])->name('listCourierArriver');

    // La route permettantes d'afficher les informations d'un courier selectionner
    Route::get('/courier_arriver/view/{slug}', [CourierArriverController::class, 'show'])->name('detailCourierArriver');

    // delete courier arriver
    Route::post('/courier_arriver/delete', [CourierArriverController::class, 'deleteCourierArriver'])->name('deleteCourierArriver');

    // desactiver la confidentialite
    Route::get('/courier_arriver/desactiverConf/{slug}', [CourierArriverController::class, 'offConfArriver'])->name('offConfArriver');

    // activer la confidentialite
    Route::get('/courier_arriver/activerConf/{slug}', [CourierArriverController::class, 'onConfArriver'])->name('onConfArriver');

    // Courier Depart

    // La route permettantes de reprendre un courier desaprouver
    Route::get('/courier_depart/reprise/{slug}', [CourierDepartController::class, 'reprendreCourier'])->name('reprendreCourier');

    Route::post('/courier_depart/LT/word', [CourierDepartController::class, 'downloadWordLT'])->name('downloadWordLT');

    Route::post('/courier_depart/LCP/word', [CourierDepartController::class, 'downloadWordLCP'])->name('downloadWordLCP');

    Route::post('/courier_depart/LCS/word', [CourierDepartController::class, 'downloadWordLCS'])->name('downloadWordLCS');

    Route::post('/courier_depart/DAP/word', [CourierDepartController::class, 'downloadWordDAP'])->name('downloadWordDAP');

    Route::post('/courier_depart/DAS/word', [CourierDepartController::class, 'downloadWordDAS'])->name('downloadWordDAS');

    Route::post('/courier_depart/LDC/word', [CourierDepartController::class, 'downloadWordLDC'])->name('downloadWordLDC');

    // La route permettantes d'afficher les informations d'un courier depart selectionner
    Route::get('/courier_depart/viewFonction/{slug}', [CourierDepartController::class, 'show'])->name('infoCourierDepart');

    // La route permettantes d'afficher le formulaire d'enregistrement du courrier d'envoi
    Route::get('/courier_depart/form/{slug?}', [CourierDepartController::class, 'create'])->name('createCourierDepart');


    // La route permettant d'enregistrer le courier depart
    Route::post('/courier_depart/save', [CourierDepartController::class, 'store'])->name('storeCourierDepart');

    // Niveau d'envoie du courrier depart
    Route::post('/courier_depart/envoi/', [CourierDepartController::class, 'envoiCourier'])->name('onApprouve');

    // Desapprobation du courrier depart
    Route::post('/courier_depart/desapprouver/', [CourierDepartController::class, 'desapprouveCourier'])->name('desapprouver');

    // Niveau accusé reception 
    Route::post('/courier_depart/completer/[slug]', [CourierDepartController::class, 'completCourier'])->name('completeCourier');

    // La route permettantes d'afficher la liste des couriers depart'
    Route::get('/courier_depart/list', [CourierDepartController::class, 'index'])->name('listCourierDepart');

    // La route permettantes d'ajouter l'accuser reception d'un courier depart
    Route::post('/courier_depart/accuser_reception/save', [CourierDepartController::class, 'accuserCourier'])->name('accuserReception');

    // La route permettant d'afficher le formulaire pour l'enregistrement de l'accuser de reception
    Route::get('/courier_depart/accuser_reception/form/{slug}', [CourierDepartController::class, 'accuser'])->name('createAccuserReception');

    // La route permettant d'afficher le courier depart
    Route::get('/courier_depart/view/{slug}', [CourierDepartController::class, 'informationDuty'])->name('detailCourierDepart');

    // delete courier depart
    Route::post('/courier_depart/delete', [CourierDepartController::class, 'deleteCourierDepart'])->name('deleteCourierDepart');

    // desactiver la confidentialite
    Route::get('/courier_depart/desactiverConf/{slug}', [CourierDepartController::class, 'offConfDepart'])->name('offConfDepart');

    // activer la confidentialite
    Route::get('/courier_depart/activerConf/{slug}', [CourierDepartController::class, 'onConfDepart'])->name('onConfDepart');


    /* Module audience */

    // La route permettantes d'afficher le formulaire de création de l'audiences
    Route::get('/audience/form', [AudiencesController::class, 'audiences'])->name('addAudience');
    // La route permettant d'afficher le formulaire d'un nouveau level d'audience.
    Route::get('/audience/formLevel/{slug}/{idAudience}', [AudiencesController::class, 'audienceNewLevel'])->name('newLevel');

    // Recupperation des champs premiere instance civile
    Route::get('/premiereInstanceCivile', function () {
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $natureActions = DB::select('select * from nature_actions');
        return view('audiences.formAudiences.premiereInstanceCivile', compact('clients', 'avocats', 'huissiers', 'juriductions', 'natureActions'));
    });

    // Recupperation des champs premiere instance penale
    Route::get('/premiereInstancePenale', function () {
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $natureActions = DB::select('select * from nature_actions');
        return view('audiences.formAudiences.premiereInstancePenale', compact('clients', 'avocats', 'huissiers', 'juriductions', 'natureActions'));
    });



    // Recupperation des champs appel civile/penale
    Route::get('/appel', function () {
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $natureActions = DB::select('select * from nature_actions');
        return view('audiences.formAudiences.appel', compact('clients', 'avocats', 'huissiers', 'juriductions', 'natureActions'));
    });

    // Recupperation des champs appel civile/penale
    Route::get('/cassation', function () {
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $natureActions = DB::select('select * from nature_actions');
        return view('audiences.formAudiences.cassation', compact('clients', 'avocats', 'huissiers', 'juriductions', 'natureActions'));
    });


     // Recupperation des champs du formulaire de requete
     Route::get('/requeteForm', function () {
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $natureActions = DB::select('select * from nature_actions');
        return view('audiences.formRequetes.requete', compact('clients', 'avocats', 'huissiers', 'juriductions', 'natureActions'));
    });


    // Enregistrement de l'audience
    Route::post('/audience/save', [AudiencesController::class, 'store'])->name('storeAudience');

    Route::post('/audience/save/level', [AudiencesController::class, 'storeNewLevel'])->name('storeNewLevel');

    // La route permettantes d'afficher toutes les audiences
    Route::get('/audience/list/{typeListe}', [AudiencesController::class, 'index'])->name('listAudience');

    Route::get('/requete/list', [AudiencesController::class, 'listRequetes'])->name('listRequete');

    Route::get('/requete/detail/{slug}', [AudiencesController::class, 'detailRequete'])->name('detailRequete');

    Route::post('/audience/filtre-periode/list', [AudiencesController::class, 'filtreAudience'])->name('filtreAudience');

    // La route permettantes d'afficher les informations d'une audiences
    Route::get('/audience/view/{id}/{slug}/{niveau}', [AudiencesController::class, 'show'])->name('detailAudience');


    // La route permettantes d'afficher les informations d'une audience de jonction
    Route::get('/audience_jonction/view/{id}/{slug}/{niveau}', [AudiencesController::class, 'showJonction'])->name('detailAudienceJonction');

    // Terminer une audience
    Route::get('/audience/terminer/{slug}', [AudiencesController::class, 'terminer'])->name('terminerAudience');

    Route::get('/requete/terminer/{slug}', [AudiencesController::class, 'terminerRequete'])->name('terminerRequete');

    // La route permettantes d'afficher les informations d'une audiences pour un client selectionner
    Route::get('/audience_client/view/{slug}/{id}', [AudiencesController::class, 'audienceClient'])->name('audienceClient');

    // La route permettante de retourner le formulaire de création d'une audience lié a une affaire
    Route::get('/audience_affaire/form/{slug}/{id}', [AudiencesController::class, 'audienceAffaire'])->name('audienceAffaire');

    // La route retournante le formulaire permettant de modifie les information d'une audience selectionner
    Route::get('/audience/edit/{slug}/{id}', [AudiencesController::class, 'pubUpdate'])->name('editAudience');

    // La route permettante de mettre à jours les informations d'une audience selectionner
    Route::post('/audience/update/{slug}/{id}', [AudiencesController::class, 'editAudience'])->name('updateAudience');

    Route::post('/audience/saveJonction', [AudiencesController::class, 'saveJonction'])->name('saveJonction');

    // La route permettante de lié un fichier a une audience deja assigner
    Route::post('/audience/add_file', [AudiencesController::class, 'autreFichier'])->name('addFileAudience');

    // ajout d'autre fichier sur la platform
    Route::post('/fichiers/new', [FileController::class, 'addFile'])->name('addFile');

    // La route permettante d'ajouter un suivi a une audience deja assigner
    Route::post('/audience/save_suivi', [AudiencesController::class, 'suiviAudience'])->name('suiviAudience');

    // ajouter un suivi de type appel
    Route::post('/audience/suivi_appel', [AudiencesController::class, 'suiviAudienceAppel'])->name('suiviAudienceAppel');

    Route::post('/audience/suivi_requete', [AudiencesController::class, 'suiviRequete'])->name('suiviRequete');

    // Suppression de l'audience
    Route::get('/audience/delete_audience/{id}', [AudiencesController::class, 'deleteAud'])->name('deleteAud');

    Route::get('/requete/delete_requete/{id}', [AudiencesController::class, 'deleteReq'])->name('deleteReq');

    // Suppression du suivi
    Route::get('/audience/delete_suivi/{slug}', [AudiencesController::class, 'deleteSuiviAud'])->name('deleteSuiviAud');

    // Suppression du suivi appel
    Route::get('/audience/delete_suivi_appel/{slug}', [AudiencesController::class, 'deleteSuiviAppel'])->name('deleteSuiviAppel');

    Route::get('/audience/delete_requete/{slug}', [AudiencesController::class, 'deleteSuiviRequete'])->name('deleteSuiviRequete');

    // Suppression du fichier de l'audience
    Route::get('/audience/delete_file/{slug}', [AudiencesController::class, 'deletePiece'])->name('deletePiece');

    // Envoi de mail
    Route::POST('sendMail', [AudiencesController::class, 'sendMail'])->name('sendMail');

    Route::POST('sendCourrierMail', [CourierDepartController::class, 'sendCourrierMail'])->name('sendCourrierMail');

    Route::get('/jonction/etape1', [AudiencesController::class, 'createJonctionEtape1'])->name('createJonctionEtape1');

    Route::post('/jonction/etape2', [AudiencesController::class, 'createJonctionEtape2'])->name('createJonctionEtape2');

    Route::get('/fetch-audienceJonction/{idJuridiction}', [AudiencesController::class, 'fetchAudienceJonction'])->name('fetchAudienceJonction');

    // Ne pas faire appel
    Route::get('/audience/annuler_appel/{slugSuivi}', [AudiencesController::class, 'annulerAppel'])->name('annulerAppel');

    Route::get('/audience/annuler_signification/{slugSuivi}', [AudiencesController::class, 'annulerSignification'])->name('annulerSignification');

    Route::post('/audience/save_signification', [AudiencesController::class, 'saveSignification'])->name('saveSignification');





    /* Fin Module audience */

    /* Module Facturation */

    Route::get('/facturation/creation', [FacturationController::class, 'create'])->name('factureForm');

    Route::get('/facturation/creation/{idClient}', [FacturationController::class, 'createFromClient'])->name('factureFormClient');

    Route::get('/facturation/creation/{idClient}/{idAffaire}', [FacturationController::class, 'createFromAffaire'])->name('factureFormAffaire');
    
    Route::get('/facturation/historique', [FacturationController::class, 'list'])->name('histoFacture');

    Route::post('/facturation/store', [FacturationController::class, 'store'])->name('storeFacture');

    Route::get('/facturation/show/{slug}', [FacturationController::class, 'show'])->name('facture');

    Route::post('/facturation/envoi', [FacturationController::class, 'envoiFacture'])->name('envoiFacture');

    Route::post('/paiement/store', [FacturationController::class, 'storePaiement'])->name('storePaiement');

    Route::get('/paiement/valider/{idFacture}/{montantPayer}/{montantRestant}/{idPaiementFacture}', [FacturationController::class, 'validePaiement'])->name('validePaiement');

    Route::get('/paiement/supparimer/{idPaiementFacture}/{idFacture}', [FacturationController::class, 'deletePaiement'])->name('deletePaiement');

    Route::get('/facture/annuler/{idFacture}', [FacturationController::class, 'deleteFacture'])->name('deleteFacture');

    Route::post('/facturation/historiqueFiltre', [FacturationController::class, 'factureFilter'])->name('factureFilter');



    

    /* Fin Module Facturation */


    /* Module authentification */

    Route::get('/home', [HomeController::class, 'index'])->middleware(['2fa'])->name('home');

    /* Fin Module authentification */


    /* Autres routes */

    // Lecteur de PDF
    Route::get('/reader/{slug}', [ReaderController::class, 'index'])->name('readFile');

    // route permettantes de retourner en arriere apres la lecture du document
    Route::get('{old}', [ReaderController::class, 'backRead'])->name('backReadFile');

    /* Fin Autres routes */

    /* Données externes */

     // annuaires
     Route::get('/annuaires/list', [AnnuairesController::class, 'list'])->name('annuaires.list');

     Route::post('/annuaires/create', [AnnuairesController::class, 'create'])->name('contact.create');

     Route::post('/annuaires/update', [AnnuairesController::class, 'update'])->name('contact.update');

     Route::post('/annuaires/delete', [AnnuairesController::class, 'delete'])->name('contact.delete');



    Route::post('/annuaires/import', [AnnuairesController::class, 'importAnnuaireData'])->name('importAnnuaireData');

    



    // Tous les avocats
    Route::get('/avocats/list', [AvocatsController::class, 'list'])->name('avocats.list');

    // Enregistrement d'un avocat
    Route::post('/avocats/create', [AvocatsController::class, 'create'])->name('avocats.create');

    // Modification de l'avocat
    Route::post('/avocats/update', [AvocatsController::class, 'update'])->name('avocats.update');

    // Suppression de l'avocat
    Route::post('/avocats/delete', [AvocatsController::class, 'delete'])->name('avocats.delete');

    // Tous les huissiers
    Route::get('/huissiers/list', [HuissiersController::class, 'list'])->name('huissiers.list');

    // Enregistrement d'un huissier
    Route::post('/huissiers/create', [HuissiersController::class, 'create'])->name('huissiers.create');

    // Modification de l'huissier
    Route::post('/huissier/update', [HuissiersController::class, 'update'])->name('huissier.update');

    // Suppression de l'huissier
    Route::post('/huissier/delete', [HuissiersController::class, 'delete'])->name('huissier.delete');

    // Tous les notaires 
    Route::get('/notaires/list', [NotairesController::class, 'list'])->name('notaires.list');

    // Route ajax pour recupperer l'avocat
    Route::get('/fetch-avocats/{idAvocat}', [AvocatsController::class, 'fetchAvocats'])->name('fetchAvocats');

    Route::get('/fetch-contacts/{id}', [AnnuairesController::class, 'fetchContacts'])->name('fetchContacts');

    // Route ajax pour recupperer l'huissier
    Route::get('/fetch-huissiers/{idHuissier}', [HuissiersController::class, 'fetchHuissiers'])->name('fetchHuissiers');


    // Changement de langue
    Route::get('/translations/{locale}', function (string $locale) {
        if (! in_array($locale, ['en','fr'])) {
            abort(400);
        }
     
        App::setLocale($locale);
        $locale = App::currentLocale();
        
     
        return redirect()->back();
    })->name('changeLang');



    /* Fin Données externes */
    Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::post('/soumetre-courrier', [CourierDepartController::class, 'soumetre'])
    ->name('soumetre');
    Route::post('/soumetre-courrier-Arrivers', [CourierArriverController::class, 'soumetre'])
    ->name('soumetreCourierArrivers');


});

Route::post('reset-password', [NewPasswordController::class, 'store'])
->name('password.update2');