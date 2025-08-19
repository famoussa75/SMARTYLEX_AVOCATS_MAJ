@extends('layouts.base')
@section('title','Détail de la requête')
@section('content')

<style>
    /* Styles pour le bouton */
    .non-cliquable {
        cursor: default; /* Curseur par défaut */
        pointer-events: none; /* Désactiver les événements de pointer */
    }

    /* Styles pour le curseur au survol */
    .non-cliquable:hover {
        cursor: not-allowed; /* Curseur "non autorisé" au survol */
    }

    @keyframes clignotement {
        0% { background-color: #ffcc00; } /* Couleur initiale */
        50% { background-color: #ffffff; } /* Couleur de clignotement */
        100% { background-color: #ffcc00; } /* Couleur initiale */
    }

    /* Appliquer l'animation à la classe .clignotante */
    .clignotante {
        animation: clignotement 1s infinite;
    }
</style>

 <div class="container-fluid @if (Auth::user()->role=='Client') bg-secondary @else  @endif ">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="row col-md-12 align-self-center">
            <div class="col-md-8">
                @empty($cabinet)
                <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Details de la requête</h4>
                @else
                <h5 class="theme-cl">
                    <b> {{ $cabinet[0]->idClient }}</b>
                    >
                    <a class="load theme-cl"
                        href="{{route('clientInfos', [$cabinet[0]->idClient, $cabinet[0]->clientslug])}}">
                        {{ $cabinet[0]->prenom }} {{ $cabinet[0]->nom }} {{ $cabinet[0]->denomination }}
                    </a>
                    
                    >
                    @if (Auth::user()->role=='Client')
                        <a class="load theme-cl" href="#">
                            {{ $cabinet[0]->idAffaire }} {{ $cabinet[0]->nomAffaire }}
                        </a>
                    @else
                        <a class="load theme-cl"
                            href="{{ route('showAffaire', [$cabinet[0]->idAffaire,$cabinet[0]->affaireslug]) }}">
                            {{ $cabinet[0]->idAffaire }} {{ $cabinet[0]->nomAffaire }}
                        </a>
                       
                    @endif
                    >
                    <span class="label bg-info"><b>Requête</b></span>

                </h5>
                @endif
            </div>
       
            <div class="col-md-4 text-right" style="float:right">
                <div class=" btn-group">
                    <a href="{{ route('listRequete') }}" class="load btn btn-secondary">
                        <i class="fa fa-eye"></i> Voir les requêtes
                    </a>
                </div>
                &nbsp;&nbsp;
                <div class="dropdown" style="float: right ;">
                    <button class="btn btn-rounded theme-bg dropdown-toggle @if($requete[0]->statut=='Jonction') non-cliquable bg-secondary @endif" type="button" id="dropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                        style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class=" dropdown-item " href="{{ route('addAudience') }}" title="Nouvelle requête"><i
                                class="ti-plus mr-2"></i>Créer une procédure</a>
                        <!-- <a class=" dropdown-item " href="#" title="Modifier cette requête"><i
                                class="ti-pencil mr-2"></i>Editer</a> -->
                        <a class=" dropdown-item " href="{{route('deleteReq',[$requete[0]->idProcedure])}}"
                            title="Reprendre cet audience"><i class="ti-trash mr-2"></i>Supp & Reprendre</a>

                       <!-- <a class="dropdown-item" href="{{route('terminerRequete',[$requete[0]->slug])}}"
                            title="Terminé la requête"><i class="fa fa-check"></i> Terminé la requête</a> -->

                            <div class="dropdown-item text-center">
                                <button class="btn btn-sm btn-primary hidden-print" onclick="exportDivToPDF()">
                                    <i class="ti-download mr-1"></i> Télécharger PDF
                                </button>
                            </div>
                       
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row" id="pdfContent1">
        <div class="col-md-12">

            <div class="card box">
                <div class="ruban left @if ($requete[0]->statut=='Déposée') rubanEncour @elseif ($requete[0]->statut=='Jonction') rubanJonction @else rubanTerminer @endif ">
                @if(isset($requete[0]->statut))
                    @if($requete[0]->statut == 'Rejetée')
                        <span class="bg-danger"><b>Rejetée</b></span>
                    @elseif($requete[0]->statut == 'Acceptée')
                        <span class="bg-success"><b>Acceptée</b></span>
                    @elseif($requete[0]->statut == 'Déposée')
                        <span class="bg-primary"><b>Déposée</b></span>
                    @elseif($requete[0]->statut == 'Terminée')
                        <span class="text-white"><b>Terminée</b></span>
                    @endif
                @else
                    <span class="text-muted"><b>Statut non défini</b></span>
                @endif

                    <!-- <span><b>{{ $requete[0]->statut }}</b></span> -->
                </div>
                <div class="detail-wrapper padd-top-30">
                    <div class="row text-center">
                        <div class="col-md-12">
                            &nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="row  mrg-0 detail-invoice">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-1"
                                    style="text-align: right;border-right:1px solid;padding-top:20px;">
                                    <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12" style="font-size:medium;text-align:center">
                                    <p><b>Juridiction :</b> {{ $requete[0]->nom }} | <b>Objet :</b>
                                        {{ $requete[0]->objet }} 
                                    </p>
                                    <p>
                                        <b>Juridiction présidentielle :</b> <span
                                            class="label cl-success bg-success-light"><b>{{ $requete[0]->juridictionPresidentielle }}</b></span>
                                        |
                                        <b>Date de création:</b> <span
                                            class="label cl-success bg-success-light"><b>{{ date('d/m/Y', strtotime($requete[0]->created_at)) }}</b></span>
                                    </p>

                                </div>
                                <div class="col-md-1" style="text-align: left;border-left:1px solid;padding-top:20px;">
                                    <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                                </div>

                            </div>
                        </div>
                        <hr />
                    </div>
                   
                    <div class="row mrg-0 mb-5">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 mb-5">
                          <!--  <a href="#" class="fa fa-angle-double-up" style="font-size:7ch; text-align:center;"
                                id="up"></a>
                            <a href="#" class="fa fa-angle-double-down" style="font-size:7ch; text-align:center;"
                                id="down"></a> -->
                            <a href="" class="" style="font-size:7ch; text-align:center;"
                                id=""></a>
                            <a href="" class="" style="font-size:7ch; text-align:center;"
                                id=""></a>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                        </div>
                    </div>
                    
                    
                </div>
            </div>
          
            <div class="card">
                <div class="col-md-12 mt-4 mb-4">
                   
                    @if($requete[0]->createur=='')
                    @else
                    <p style="text-align:right">Requête créée par : <b>{{$requete[0]->createur}}</b></p>
                    @endif
                    
                </div>
                <div class="row mrg-0">
                    <div class="col-md-12">
                        <br>
                        <!-- The timeline -->
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="bg-purple">Suivi de la requête</span>
                                @if (Auth::user()->role=='Client')
                                @else
                                @if ($requete[0]->statut=='Terminée')
                                @else
                                <div class="btn-group text-right">

                                    <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modal-2"
                                        title="Ajouter un suivi">
                                        <i class="fa  fa-plus-circle ti i-cl-4"></i> Ajouter un suivi
                                    </a>

                                </div>
                                @endif
                                @endif
                            </li>
                            <li>
                                <div class="timeline-item">

                                    @if(empty($suiviRequete))
                                    <div class="timeline-body">
                                        <h4 class="text-center">
                                            <span class="label bg-warning">Aucun suivi effectué pour le moment</span>
                                        </h4>
                                    </div>
                                    @else
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table id="" class=" dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Décision</th>
                                                        <th style="width: 220px;">Reférence</th>
                                                        <th>Date décision</th>
                                                        <th>Date reception</th>
                                                        <th>Piēce(s)</th>
                                                        <th>Suivi par</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($suiviRequete as $suivi )
                                                    <tr  class="@if(Auth::user()->role == 'Administrateur' && in_array($suivi->idSuivit, $tacheSuivit)) bg-secondary  text-muted @endif">
                                                   
                                                        <td>{{ $loop->iteration }} </td>
                                                        
                                                        <td>
                                                            @if($suivi->reponse=='Acceptée')
                                                                <small class="label bg-success">Acceptée</small>
                                                            @elseif($suivi->reponse=='Rejetée')
                                                            <small
                                                                class="label bg-danger">Rejetée</small>
                                                           
                                                            @elseif($suivi->reponse=='Terminée')
                                                            <small
                                                                class="label bg-success">Terminée</small>
                                                            @else
                                                                <small
                                                                class="label bg-primary">Déposée</small>
                                                            @endif
                                                        </td>
                                                        <td> {{ $suivi->reference }} </td>
                                                        <td>
                                                            @if(empty($suivi->dateDecision))
                                                                N/A
                                                            @else
                                                            <small class="">{{ date('d/m/Y', strtotime($suivi->dateDecision))}}</small>
                                                            @endif
                                                           
                                                        </td>
                                                        <td>
                                                            @if(empty($suivi->dateReception))
                                                                N/A
                                                            @else
                                                            <small class="">{{ date('d/m/Y', strtotime($suivi->dateReception))}}</small>
                                                            @endif
                                                                
                                                        </td>
                                                        <td>
                                                            @foreach($pieceOrd as $p)
                                                                @if($p->slugSource==$suivi->slug)
                                                                <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td> {{ $suivi->suiviPar }}</td>

                                                        <td style="text-align: center;">
                                                            @if(!in_array($suivi->idSuivit, $tacheSuivit))
                                                                {{-- Lien pour créer une tâche si elle n'existe pas --}}
                                                                <small>
                                                                    <a href="{{ route('taskForm', [$suivi->idSuivit, 'requetes']) }}" 
                                                                    title="Créer une tâche"
                                                                    style="font-size:5px;">
                                                                        <i class="fa fa-legal"></i>
                                                                    </a>
                                                                </small>
                                                            @else
                                                               @if( in_array($suivi->idSuivit, $tacheSuivit))
                                                                <small>
                                                                        <a href="{{ route('infosTaskFromAudience2', [$suivi->idSuivit]) }}"
                                                                        class="@if(!empty($requete) && isset($requete[0]->statut) && $requete[0]->statut == 'Jonction') non-cliquable bg-secondary @endif"
                                                                        title="Voir la tâche"
                                                                        style="font-size:5px;">
                                                                            <i class="fa fa-mail-forward"></i>
                                                                        </a>
                                                                    </small>
                                                                @else
                                                                
                                                                @endif
                                                            @endif


                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                                @if($suivi->suiviPar==Auth::user()->name)
                                                                <small>
                                                                    <a href="{{route('deleteSuiviRequete',$suivi->slug)}}"
                                                                        type="" class="" title="supprimer"   onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                        style="font-size:5px;color:red"><i
                                                                            class="ti-trash"></i></a>
                                                                </small>

                                                                @endif
                                                            @endif
                                                           
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                    

                                </div>
                            </li>
                         

                        </ul>
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="bg-blue" style="color:white">Parties concernées</span>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th>Parties</th>
                                                        <th>Role</th>
                                                        <th>Avocats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($cabinet as $c )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($c->role=='Autre')
                                                            @if($c->autreRole=='in')
                                                            <small class="label bg-success">Intervenant</small>
                                                            @elseif($c->autreRole=='pc')
                                                            <small class="label bg-success">Partie civile</small>
                                                            @elseif($c->autreRole=='mp')
                                                            <small class="label bg-success">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-success">{{ $c->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(Session::has('cabinetSession'))
                                                            @foreach (Session::get('cabinetSession') as $cab)
                                                            <span>{{$cab->nomCourt}}</span>
                                                            @endforeach
                                                            @else
                                                            <span>Le cabinet</span>
                                                            @endif
                                                            @foreach($avocats as $a1)
                                                            @if($a1->idPartie==$c->idPartie)
                                                             <span>{{$a1->prenomAvc}} {{$a1->nomAvc}}</span>
                                                            @else
                                                            @endif
                                                            @endforeach
                                                            @if(empty($avocats))
                                                            <b>N/A</b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($personne_adverses as $p )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $p->prenom }} {{ $p->nom }}
                                                        </td>
                                                        <td>
                                                            @if($p->role=='Autre')
                                                            @if($p->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($p->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($p->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $p->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($avocats as $a2)
                                                            @if($a2->idPartie==$p->idPartie)
                                                            <span>{{$a2->prenomAvc}} {{$a2->nomAvc}}</span>
                                                            @else
                                                            @endif
                                                            @endforeach
                                                            @if(empty($avocats))
                                                            <b>N/A</b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($entreprise_adverses as $e )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $e->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($e->role=='Autre')
                                                            @if($e->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($e->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($e->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $e->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($avocats as $a3)
                                                                @if($a3->idPartie==$e->idPartie)
                                                                <span>{{$a3->prenomAvc}} {{$a3->nomAvc}}</span>
                                                                @else
                                                                @endif
                                                            @endforeach
                                                            @if(empty($avocats))
                                                            <b>N/A</b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach

                                                    <!-- <tr style="text-align: center;">
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                    </tr> -->


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </li>

                        </ul>
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="bg-red" style="color:white">Acte introductif d'instance</span>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h3>Requête</h3>
                                            <hr>
                                            <!-- <h5><b>Nature de l'action :</b> </h5>
                                            <hr> -->
                                        </div>
                                    
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° d'Enregistrement
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="numRgRequete"
                                                        value="{{$requete[0]->numRgRequete}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                             <!--<input type="text" class="form-control" id=""
                                                                data-error=" veillez saisir la date" name="dateRequete"
                                                                  value="{{date('d/m/Y', strtotime($requete[0]->dateRequete))}}"
                                                                 disabled>
                                                            <div class="help-block with-errors"></div> -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de la requete
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateRequete"
                                                        value="{{ !empty($requete[0]->dateRequete) ? date('d/m/Y', strtotime($requete[0]->dateRequete)) : '' }}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date d'arrivée (Greffe)
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateArriver"
                                                        value="{{ !empty($requete[0]->dateRequete) ? date('d/m/Y', strtotime($requete[0]->dateRequete)) : '' }}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" hidden>
                                                <div class="form-group">
                                                    <label for="" class="control-label">Juridiction presidentielle
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ"
                                                        name="juriductionPresidentielle"
                                                        value="{{$requete[0]->juridictionPresidentielle}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Demande
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ"
                                                        name="juriductionPresidentielle"
                                                        value="{{$requete[0]->demandeRequete}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièce(s) de la requête :</label>
                                                    <hr style="margin-top:-5px">
                                                    @foreach($pieceREQ as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button"   onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger  btn-sm"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <hr>
                                                    <div class="btn-group text-right">
                                                        <a href="#" class="btn btn-secondary" data-toggle="modal"
                                                            data-target="#modal-fichier" title="Ajouter un suivi">
                                                            <i class="fa  fa-plus-circle ti i-cl-4"></i> Ajouter une pièce
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>                                    

                                </div>
                            </li>
                          
                        </ul>
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="bg-success" style="color:white">Autres procédures liées</span>
                                <div class="btn-group text-right">
                                    <a href="#" class="btn btn-secondary" data-toggle="modal"
                                        data-target="#modal-requeteLier" title="Ajouter un suivi">
                                        <i class="fa  fa-link ti i-cl-4"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="col-md-12">
                                            <br>
                                           
                                            <h4 class=" text text-center bg-primary  text-white m-2 p-2" >Procédures non contraditoires </h4>
                                            <br>
                                        @if(empty($procedure_requete) && empty($procedure_requete2))
                                            <h4 class="text-center">
                                                <span class="label bg-warning">aucune liaisons effectué </span>
                                            </h4>
                                        @else
                                            @foreach($procedure_requete as $r)
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                   <!-- <a class="" href="{{ route('detailRequete', $r->slug) }}"
                                                        class="toggle"
                                                        title="Cliquer pour afficher le contenu du fichier">{{ $r->objet }} - {{ date('d/m/Y', strtotime($r->dateRequete))}}</a>  -->
                                                        
                                                    <a class="" href="{{ route('detailRequete', $r->slugProcedure) }}"
                                                        class="toggle"
                                                        title="Cliquer pour afficher le contenu du fichier">

                                                    
                                                        
                                                        @foreach($procedure_requete_client as $client)
                                                    
                                                        
                                                            @if($client->idProcedure == $r->idProcedure)
                                                                {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                c/ 
                                                                @foreach($requete_autreRole as $p1)
                                                                  
                                                                    @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                   
                                                                        @if($p1->autreRole == 'pc')
                                                                            <small>(Partie civile)</small>
                                                                        @elseif($p1->autreRole == 'in')
                                                                            <small>(Intervenant)</small>
                                                                        @elseif($p1->autreRole == 'mp')
                                                                            <small>(Ministère public)</small>
                                                                        @endif
                                                                    @endif
                                                                @endforeach 

                                                                
                                                            @endif
                                                        @endforeach

                                                        

                                                        {{-- Personnes adverses liées à l'audience --}}
                                                        @foreach($procedure_requete_personne_adverses as $personne)
                                                        
                                                            @if($personne->idProcedure == $r->idProcedure)
                                                                {{ $personne->prenom ?? '' }} {{ $personne->nom  ??  '' }},
                                                            @endif
                                                        @endforeach
                                                    

                                                        {{-- Entreprises adverses liées à l'audience --}}
                                                            @foreach($procedure_requete_entreprise_adverses_requete as $entreprise)

                                                                @if($entreprise->idProcedure ==$r->idProcedure)
                                                                    {{ $entreprise->denomination ?? ''  }} 
                                                                @endif
                                                            @endforeach


                                                    </a>
                                                
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                
                                                        <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"  type="button" class="btn btn-outline-danger" onclick="event.preventDefault(); confirmDelete(this.href)"><i class="ti-trash"></i> </a>
   

                                                </div>
                                            </div>
                                            @endforeach

                                            @foreach ($procedure_requete2 as $r)
                                               
                                               <div class="mb-2 p-2 border rounded">
                                                  
                                                    <a href="{{ route('detailRequete', [
                                                       
                                                        'slug' => $r->slug,
                                                        ]) }}">
                                                        
                                                        {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                            @foreach($procedure_requete_client2 as $client)
                                                            
                                                            @if($client->idProcedure == $r->idProcedure)
                                                                {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}

                                                                
                                                                @foreach($procedure_autreRole1 as $p1)
                                                                  
                                                                  @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                 
                                                                      @if($p1->autreRole == 'pc')
                                                                          <small>(Partie civile)</small>
                                                                      @elseif($p1->autreRole == 'in')
                                                                          <small>(Intervenant)</small>
                                                                      @elseif($p1->autreRole == 'mp')
                                                                          <small>(Ministère public)</small>
                                                                      @endif
                                                                  @endif
                                                              @endforeach 
                                                            @endif
                                                        @endforeach

                                                        c/
                                                        {{-- Entreprises adverses liées à l'audience --}}
                                                        @foreach($procedure_requete_entreprise_adverses_requete2 as $entreprise)

                                                            @if($entreprise->idProcedure ==$r->idProcedure)
                                                                {{ $entreprise->denomination ?? '' }}
                                                            @endif
                                                        @endforeach

                                                        
                                                        {{-- Entreprises adverses liées à l'audience --}}
                                                        @foreach($procedure_requete_personne_adverses_requete2 as $personne)

                                                            @if($personne->idProcedure ==$r->idProcedure)
                                                                {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                            @endif
                                                        @endforeach
                                                    </a>

                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"
                                                        type="button"
                                                        class="btn btn-outline-danger"
                                                        onclick="event.preventDefault(); confirmDelete(this.href)">
                                                            <i class="ti-trash"></i>
                                                    </a>
                                               </div>
                                           @endforeach
                                        @endif
                                      
                                           
                                                
                                        
                                              <br>
                                            <h4 class=" text text-center bg-primary  text-white m-2 p-2" > Procédures contraditoires </h4>
                                            <br>

                                            @if(empty($audience_contraditoire2) && empty($audience_contraditoire))
                                               
                                            @else
                                        
                                                @foreach($audience_contraditoire2 as $r)

                                                    <div class="row mb-2">
                                                        <div class="col-md-12">

                                                       
                                                            
                                                            <!-- <a class="" href="{{ route('detailAudience', ['id' => $r->idAudience, 'slug' => $r->slug, 'niveau' => $r->niveauProcedural]) }}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier">{{ $r->objet }} - {{ date('d/m/Y', strtotime($r->prochaineAudience))}}</a> -->
                                                                <a class="" href="{{ route('detailAudience', ['id' => $r->idAudience, 'slug' => $r->slugProcedure, 'niveau' => $r->niveauProcedural]) }}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier">
                                                                
                                                               
                                                                {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                                @foreach($audience_contraditoire_client2 as $client)
                                                                
                                                                    @if($client->idAudience == $r->idAudience)
                                                                        {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                        
                                                                        c/

                                                                        @foreach($procedure_autreRole as $p1)
                                                                    
                                                                            @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                            
                                                                                @if($p1->autreRole == 'pc')
                                                                                    <small>(Partie civile)</small>
                                                                                @elseif($p1->autreRole == 'in')
                                                                                    <small>(Intervenant)</small>
                                                                                @elseif($p1->autreRole == 'mp')
                                                                                    <small>(Ministère public)</small>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach 
                                                                    @endif
                                                                  
                                                                @endforeach

                                                               
                                                                {{-- Personnes adverses liées à l'audience --}}
                                                                @foreach($audience_contraditoire_personne_adverses2 as $personne)
                                                                    @if($personne->idAudience == $r->idAudience)
                                                                        {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                    @endif
                                                                @endforeach

                                                                
                                                                {{-- Entreprises adverses liées à l'audience --}}
                                                                @foreach($audience_contraditoire_entreprise_adverses2 as $entreprise)
                                                               
                                                                    @if($entreprise->idAudience == $r->idAudience)
                                                                        {{ $entreprise->denomination ?? '' }}
                                                                    @endif
                                                                @endforeach
                                                                 

                                                            </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"  onclick="event.preventDefault(); confirmDelete(this.href)" type="button" class="btn btn-outline-danger"><i class="ti-trash"></i> </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if( empty($audience_contraditoire))
                                                <h4 class="text-center">
                                                    <span class="label bg-warning">aucune liaisons effectué </span>
                                                </h4>
                                            @else

                                                @foreach ($audience_contraditoire as $audience)
                                                <div class="mb-2 p-2 border rounded">
                                                    <a href="{{ route('detailAudience', [
                                                        'id' => $audience->idAudience,
                                                        'slug' => $audience->slugSource,
                                                        'niveau' => $audience->niveauProcedural
                                                    ]) }}">

                                                        <!-- {{ $audience->objet }} — {{ date('d/m/Y', strtotime($audience->prochaineAudience)) }}-->
                                                        
                                                        {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                            @foreach($audience_contraditoire_client as $client)

                                                                @if($client->idAudience == $audience->idAudience)
                                                                    {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}

                                                                    c/
                                                                    @foreach($procedure_autreRole1 as $p1)
                                                                       
                                                                       @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                       
                                                                           @if($p1->autreRole == 'pc')
                                                                               <small>(Partie civile)</small>
                                                                           @elseif($p1->autreRole == 'in')
                                                                               <small>(Intervenant)</small>
                                                                           @elseif($p1->autreRole == 'mp')
                                                                               <small>(Ministère public)</small>
                                                                           @endif
                                                                       @endif
                                                                   @endforeach 
                                                                  
                                                                @endif
                                                              
                                                               
                                                            
                                                               
                                                            @endforeach

                                                            

                                                            {{-- Entreprises adverses liées à l'audience --}}
                                                            @foreach($audience_contraditoire_entreprise_adverses as $entreprise)
                                                            
                                                                @if($entreprise->idAudience == $audience->idAudience)
                                                                    {{ $entreprise->denomination ?? '' }}
                                                                @endif
                                                            @endforeach

                                                            {{-- Personnes adverses liées à l'audience --}}
                                                            @foreach($audience_contraditoire_personne_adverses as $personne)
                                                           
                                                                @if($personne->idAudience == $audience->idAudience)
                                                                    {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                @endif
                                                            @endforeach
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="{{ route('deleteRequeteLier', $audience->idProcedureLier) }}"  onclick="event.preventDefault(); confirmDelete(this.href)" 
                                                    type="button" class="btn btn-outline-danger"><i class="ti-trash"></i> </a>
                                                </div>
                                            @endforeach
                                            @endif


                                           
                                           

                                          

                                        </div>
                                    </div>                                    

                                </div>
                            </li>
                          
                        </ul>
   
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="add-popup modal fade" id="modal-fichier" tabindex="-1" role="dialog" aria-labelledby="addcontact">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-file"></i> Joindre un fichier</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('addFileAudience') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-12 col-sm-12">

                            <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]"
                                multiple required>
                            <input type="hidden" name="slugAudience" value="{{$requete[0]->slug}}">


                        </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="" class="theme-bg btn btn-rounded btn-block " style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal-suivi audience -->
<div class="modal modal-box-2 fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Ajouter un suivi à la requête</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <form class="padd-20" method="post" action="{{route('suiviRequete')}}"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="idRequete" value={{$requete[0]->idProcedure}}>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Réponse</label>
                                            <select class="form-control select" id="reponse"
                                                data-placeholder="" style="width: 100%;" name="reponse" required>
                                                <option value="" selected disabled selected>-- Choisissez --</option>
                                                <option value="Acceptée">Acceptée</option>
                                                <option value="Rejetée">Rejetée</option>
                                            </select>

                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Reférence</label>
                                            <input type="text" class="form-control" name="reference">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Date de la decision</label>
                                            <input type="date" class="form-control" name="dateDecision">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Date de reception</label>
                                            <input type="date" class="form-control" name="dateReception">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                </div>
                              
                                
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Ordonnance</label>
                                            <input type="file" accept="image/*,.pdf," class="form-control"
                                                name="ordonnance"  required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                                    style="width:50%;"> Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-suivi audience -->

<div class="add-popup modal fade" id="modal-requeteLier" tabindex="-1" role="dialog" aria-labelledby="addRequete">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-link"></i> Lier cette procédure à une autre</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('lierRequeteManuelContraditoire') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-4 cacher" id="clientContent-req" >
                            <div class="form-group">
                                <label for="client" class="control-label">Selectionner le
                                    client*
                                    :</label>
                                    <select class="form-control select2" name="idClient" id="client"  onchange="var idclient=$(this).val(); clientReqFunction(idclient)" style="width:100%" data-placeholder="Selectionner le client">
                                        <option value=""> </option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->idClient }}">
                                            {{ $client->prenom }}
                                            {{ $client->nom }}
                                            {{ $client->denomination }}
                                        </option>
                                        @endforeach
                                    </select>
                            </div>

                        </div>
                        <div class="col-md-4 cacher" id="affaireContent-req" hidden>

                            <div class="form-group">
                                <label for="affaire" class="control-label">Affaire du client
                                    concerné*
                                    :</label>
                                <select data-placeholder="Affaire du client concerné" style="width: 100%;height:28px" name="" id="affaireClient-req" >

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="affaire" class="control-label">Procédure(s)
                                    concernant le client*
                                    :</label>
                                <select multiple class="form-control select2" data-placeholder=""  style="width: 100%;height:28px" name="contraditoireLier[]" id="requeteClient" required>
                                    <option value="" disabled>-- Choisissez --</option>
                                   
                                </select>
                                <input type="hidden" name="slugProcedure"  id="currentSlug" value="{{$requete[0]->slug}}">

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="" class="theme-bg btn btn-rounded btn-block " style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function(e) {

            var fichiersInput = this.querySelectorAll(
                ".fichiers"
                ); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name +
                            " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});


function closeMail(params) {
    $('#message-box').html("");
}
</script>

<script>
document.getElementById('aud').classList.add('active');
</script>


@endsection