@extends('layouts.base')
@section('title','Détail de la tâche')
@section('content')
<div class="container-fluid">


    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs ">
        <div class="col-md-9 align-self-center">
            <h4 class="theme-cl">
                @if (is_null($tache[0]->idAffaire))
                <span class="label bg-info"><b>Tâche Cabinet</b></span>
                @else
                <b>

                    @foreach ($clients as $c)
                    <span class="pdf-title1">{{ $c->idClient }}</span>

                    @endforeach
                    >
                    @foreach ($clients as $client)
                    <a class="load" href="{{route('clientInfos', [$client->idClient, $client->slug])}}"
                        class="theme-cl pdf-title2">
                        {{ $client->prenom }} {{ $client->nom }} {{ $client->denomination }}</a>
                    @endforeach
                    >
                    @foreach ($affaires as $affaire)
                    <a class="load" href="{{route('showAffaire', [$affaire->idAffaire, $affaire->slug])}}"
                        class="theme-cl pdf-title3">
                        {{ $affaire->nomAffaire }}</a>
                    @endforeach
                    >
                    <span class="label bg-info"><b>Tâche</b></span>
                </b>
                @endif
            </h4>
        </div>
        <div class="col-md-3">
            @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant")
            <div class="dropdown" style="float: right ;">
                <button class="theme-bg btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                </button>
                @if($tache[0]->statut == 'suspendu')
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item " href="{{route('startStask', [$slug])}}"><i
                            class="ti-control-play mr-2"></i>Reprendre</a>
                </div>
                @elseif($tache[0]->statut == 'validée')
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item " href="#" onclick="getPDF()"><i class="ti-file mr-2"></i>Page en PDF</a>
                </div>
                @else
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                    @if($tache[0]->statut =='validée')
                    @else
                        @if(Auth::user()->role=="Administrateur")
                        <a class="load dropdown-item" href="{{ route('valideTask', [$slug, $tache[0]->slugFille]) }}"><i
                                class="ti-check mr-2"></i>Valider</a>
                        @endif
                    @endif
                    <a class=" dropdown-item " href="#" data-toggle="modal" data-target="#editTask"><i
                            class="ti-pencil-alt mr-2"></i>Editer</a>
                    <a class="load dropdown-item " href="{{ route('stopTask', [$slug]) }}"><i
                            class="ti-control-pause mr-2"></i>Suspendre</a>
                    <a class="dropdown-item " href="#" onclick="getPDF()"><i class="ti-file mr-2"></i>Page en PDF</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteTask"
                        href="{{route('deleteTask',[$slug])}}" style="color:red"><i
                            class="ti-close mr-2"></i>Supprimer</a>

                </div>

                @endif
            </div>
            @else
            @endif

        </div>

    </div>
    <!-- Title & Breadcrumbs-->



    <script>
    function suggestion() {
        var time = 0;
        $('#typeTraitement').val('suggestion');
        $('#time').val(time);
        $('#unite').val('h');
        $('#time').hide();
        $('#unite').hide();
        $('#labeltime').hide();
    }

    function traitement() {
        $('#typeTraitement').val('traitement');
    }
    </script>
    <div class="row">
        <div class="col-md-12">
            <div class="card pdf-content">
                <div class="detail-wrapper padd-top-30">

                    <div class="row  mrg-0 detail-invoice">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">

                                    <h4 class="pdf-title4">
                                        <b>
                                            @if($tache[0]->titre=='Rédaction du PV et les Statuts')
                                                N° 1 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Enregistrement des PV et Statuts à l’impôt")
                                                N° 2 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Ouverture de compte bancaire pour la société en formation")
                                                N° 3 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Libération du capital social")
                                                N° 4 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Délivrance de l’attestation du dépôt de capital social")
                                                N° 5 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Création de la société sur la plateforme de l’APIP (SYNERGUI)")
                                                N° 6 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Rédaction de la lettre de transmission des pièces suivantes")
                                                N° 7 : {{ $tache[0]->titre }}
                                            @elseif($tache[0]->titre=="Récupération des documents suivants contre reçu de paiement")
                                                N° 8 : {{ $tache[0]->titre }}
                                            @else
                                            {{ $tache[0]->titre }}
                                            @endif
                                        </b>
                                    </h4>
                                    <p> {{ $tache[0]->description }}</p>
                                    @if($tache[0]->created_by)
                                    <p> Tâche créée par : {{ $tache[0]->created_by }} </p>
                                    @endif
                                    <p>
                                        <b><i class="fa fa-calendar-plus-o"></i> Date début</b> :
                                        {{ date('d-m-Y', strtotime($tache[0]->dateDebut))}} |
                                        <b><i class="fa fa-calendar-minus-o"></i> Date de fin</b> :
                                        <span style="color:red">{{ date('d-m-Y', strtotime($tache[0]->dateFin))}}</span>
                                        | <b><i class="fa fa-circle-o"></i> Point</b> : {{ $tache[0]->point }}
                                        &nbsp;&nbsp; <br><br>
                                        <b style="color:green ;"><i class="fa  fa-hourglass"></i> Temps passé :
                                            {{$timesheetJ}} Jours - {{$timesheetH}} Heures - {{$timesheetM}} Minutes</b>
                                        &nbsp;&nbsp;

                                        @if($tache[0]->statut =='validée')
                                    <div class="label" style="background-color:green ;">{{ $tache[0]->statut }}</div>
                                    @elseif($tache[0]->statut =='En cours')
                                    <div class="label" style="background-color:aqua ;color:green">
                                        {{ $tache[0]->statut }}
                                    </div>
                                    @elseif($tache[0]->statut =='suspendu')
                                    <div class="label" style="background-color:grey ;">{{ $tache[0]->statut }}</div>
                                    @else
                                    <div class="label" style="background-color:red ;">{{ $tache[0]->statut }}</div>
                                    @endif
                                    <div class="label" style="background-color:orange ;"><b>Categorie :</b>
                                        {{ $tache[0]->categorie }}
                                    </div>

                                    </p>
                                    <hr>


                                </div>



                            </div>
                            <div class="row">
                                @if(empty($tacheCond))
                                @else
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <h4 class="pdf-title4"><b>Sous-tâches</b></h4>
                                </div>

                                <ul>
                                    @foreach($tacheCond as $t)
                                    <li><a class="load" href="{{ route('infosTask', [$t->slug]) }}">{{$t->titre}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @if(empty($tacheFille))
                            @else
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    @if($tache[0]->statut =='validée')
                                    <h3 class="box-title m-t-40 bg-info">Tâche(s) liée(s)</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($tacheLiers as $row)
                                                <tr>
                                                    <td style="width:100px">
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                    @if($row->titre=='Rédaction du PV et les Statuts')
                                                        N° 1 : 
                                                    @elseif($row->titre=="Enregistrement des PV et Statuts à l’impôt")
                                                        N° 2 : 
                                                    @elseif($row->titre=="Ouverture de compte bancaire pour la société en formation")
                                                        N° 3 : 
                                                    @elseif($row->titre=="Libération du capital social")
                                                        N° 4 : 
                                                    @elseif($row->titre=="Délivrance de l’attestation du dépôt de capital social")
                                                        N° 5 : 
                                                    @elseif($row->titre=="Création de la société sur la plateforme de l’APIP (SYNERGUI)")
                                                        N° 6 : 
                                                    @elseif($row->titre=="Rédaction de la lettre de transmission des pièces suivantes")
                                                        N° 7 : 
                                                    @elseif($row->titre=="Récupération des documents suivants contre reçu de paiement")
                                                        N° 8 : 
                                                    @else
                                                    
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <a class="load"
                                                            href="{{ route('infosTask', [$row->slug]) }}">{{ $row->titre }}</a>
                                                    </td>
                                                    <!-- <td> <a href="#" style="color:red" class="toggle"
                                                            title="Cliquer pour dissocié cette personne à la tâche">Dissocié</a>
                                                    </td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <h3 class="box-title m-t-40 bg-warning">Tâche(s) en attente(s)</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($tacheFille as $row)
                                                <tr>
                                                    
                                                    <td style="width:100px">
                                                    @if($row->titre=='Rédaction du PV et les Statuts')
                                                        N° 1 : 
                                                    @elseif($row->titre=="Enregistrement des PV et Statuts à l’impôt")
                                                        N° 2 : 
                                                    @elseif($row->titre=="Ouverture de compte bancaire pour la société en formation")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 3 : 
                                                    @elseif($row->titre=="Libération du capital social")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 4 : 
                                                    @elseif($row->titre=="Délivrance de l’attestation du dépôt de capital social")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 5 : 
                                                    @elseif($row->titre=="Création de la société sur la plateforme de l’APIP (SYNERGUI)")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 6 : 
                                                    @elseif($row->titre=="Rédaction de la lettre de transmission des pièces suivantes")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 7 : 
                                                    @elseif($row->titre=="Récupération des documents suivants contre reçu de paiement")
                                                    <a href="javascript:history.back()" title="Page précédente"><i class="fa fa-arrow-left"  style="font-size:14px;"></i></a> &nbsp;&nbsp;
                                                        N° 8 : 
                                                    @else
                                                  
                                                    @endif
                                                   </td>
                                                    <td>
                                                         @if(Auth::user()->role=='Administrateur')
                                                        <a class="load"
                                                            href="{{ route('infosTask2', [$row->slug]) }}">{{ $row->titre }}</a>
                                                        @else
                                                        <a class="load"
                                                            href="#">{{ $row->titre }}</a>
                                                        @endif
                                                    </td>
                                                   
                                                    <!-- <td> <a href="#" style="color:red" class="toggle"
                                                            title="Cliquer pour dissocié cette personne à la tâche">Dissocié</a>
                                                    </td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h3 class="box-title m-t-40">Personne(s) assignée(s) &nbsp;&nbsp;&nbsp;
                                        @if(Auth::user()->role=='Administrateur')
                                        @if($tache[0]->statut =='validée')
                                            @else
                                                <a href="#" data-toggle="modal" data-target="#jointureMultiple"
                                                    type="btn btn-success"><i class="fa fa-plus-circle"
                                                        style="font-size:x-large;color:white"></i></a>
                                            @endif
                                        @else
                                        @endif
                                    </h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($personnels as $row)
                                                <tr>
                                                    <td>{{ $row->prenom }} {{ $row->nom }}</td>
                                                    <td>
                                                    <span class="btn btn-small font-midium font-13 btn-rounded @if($row->fonction=='Responsable')bg-primary-light @else bg-default-light @endif"> 
                                                        {{ $row->fonction }}
                                                    </span>
                                                       
                                                    </td>
                                                    @if(Auth::user()->role=='Administrateur')
                                                        @if($tache[0]->statut =='validée')
                                                        @else
                                                            <td>
                                                                @if($row->fonction=='Responsable')
                                                                <a href="{{route('participantPersonnelTask',[$tache[0]->idTache, $row->idPersonnel])}}" type="button" class="btn btn-outline-danger"><i class="fa fa-arrow-down"></i></a>
                                                                @else
                                                                <a href="{{route('responsablePersonnelTask',[$tache[0]->idTache, $row->idPersonnel])}}" type="button" class="btn btn-outline-primary"><i class="fa fa-arrow-up"></i> </a>
                                                                @endif
                                                            </td>
                                                            <td> 
                                                                <a href="{{route('deletePersonnelTask',[$tache[0]->idTache, $row->idPersonnel])}}" style="color:red" class="toggle" title="Cliquer pour dissocié cette personne à la tâche"><i class="fa fa-times-circle"></i> </a>
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-6">

                                    <h3 class="box-title m-t-40">Ressources de la tâche &nbsp;&nbsp;&nbsp;
                                        @if(Auth::user()->role=='Administrateur')
                                            @if($tache[0]->statut =='validée')
                                            @else 
                                                <a href="#" type="btn btn-success" data-toggle="modal"
                                                    data-target="#addcontact"><i class="fa fa-plus-circle"
                                                        style="font-size:x-large;color:white"></i></a>
                                            @endif 
                                        @else
                                        @endif
                                    </h3>
                                    <div class="table-responsive">
                                        
                                        <table class="table">
                                            <tbody>
                                               
                                                
                                                    @foreach ($tacheAud as $c)
                                                        <tr>
                                                        @if(empty($taskFileAud))
                                                        @else
                                                            <td style="width:25px">
                                                                @foreach ($taskFileAud as $c2)
                                                                <span class="heading-name-meta">
                                                                    <a class="load"
                                                                        href="{{route('readFile', [$c2->fileSlug])}}"
                                                                        class="toggle"
                                                                        title="Cliquer pour afficher le contenu du fichier"><i
                                                                            class="fa  fa-file-pdf-o"
                                                                            style="color:red; font-size:1.5em;"></i>
                                                                    </a>
                                                                </span>
                                                                <span> {{$c2->nomOriginal}}</span>
                                                                @endforeach

                                                            </td>
                                                            @endif

                                                            <td>
                                                                <a class="load"
                                                                    href="{{ route('detailAudience', ['id' => $c->idAudience, 'slug' => $c->slugAud, $c->niveauProcedural ]) }}">Voir
                                                                    l'audience <span class="fa fa-arrow-right"></span></a>
                                                                

                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                
                                                    @foreach ($tacheAud2 as $procedure)
                                                        @if(!empty($taskFileReq))
                                                            <td style="width:25px">
                                                                @foreach ($taskFileReq as $c2)
                                                                    <span class="heading-name-meta">
                                                                        <a class="load"
                                                                            href="{{route('readFile', [$c2->fileSlugReq])}}"
                                                                            class="toggle"
                                                                            title="Cliquer pour afficher le contenu du fichier">
                                                                            <i class="fa fa-file-pdf-o" style="color:red; font-size:1.5em;"></i>
                                                                        </a>
                                                                    </span>
                                                                    <b>{{$c2->nomOriginal}}</b>
                                                                @endforeach
                                                            </td>
                                                        @endif

                                                        <td>
                                                            <a class="load"
                                                                href="{{ route('detailRequete', [
                                                                    'id' => $procedure->idProcedure,
                                                                    'slug' => $procedure->slug,
                                                                    'niveau' => $procedure->niveau ?? 'default' // adapte selon les données
                                                                ]) }}">
                                                                     <b>Voir l'audience</b> <span class="fa fa-arrow-right"></span>
                                                            </a>
                                                        </td>
                                                    @endforeach
                                               
                                            </tbody>
                                          
                                            @if(empty($taskFile) && $taskFileCourier=='' && $taskFileAud=='' )
                                            <h4 style="text-align:center ;color:red; margin-bottom:30px">Aucun
                                                fichier n'est
                                                lié à
                                                cette tâche . . .
                                            </h4>
                                            @else

                                            <table class="table">
                                                <tbody>
                                                    @foreach ($fichiers as $t)
                                                    <tr>
                                                       
                                                        <td style="width:5px ;"><span class="heading-name-meta">
                                                                <a class="load"
                                                                    href="{{route('readFile', [$t->slug, 'x'])}}"
                                                                    class="toggle"
                                                                    title="Cliquer pour afficher le contenu du fichier"><i
                                                                        class="fa  fa-file-pdf-o"
                                                                        style="color:red; font-size:1.5em;"></i>
                                                                </a>
                                                            </span>
                                                        </td>
                                                        <td> {{$t->nomOriginal}}</td>

                                                        <td>
                                                            <span
                                                                class="label cl-info bg-primary-ligth">{{ date('H:m', strtotime($t->created_at))}}</span>
                                                            <span
                                                                class="label cl-info bg-primary-ligth">{{ date('d-m-Y', strtotime($t->created_at))}}</span>
                                                        </td>


                                                    </tr>
                                                </tbody>
                                                @endforeach
                                                @foreach ($taskFileCourier as $c)
                                                <tr>
                                                    <td style="width:10px ;">
                                                        {{$c->idCourierArr}}

                                                    </td>
                                                    <td>
                                                        <span class="heading-name-meta">
                                                            <a class="load" href="{{route('readFile', [$c->fileSlug])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>
                                                            </a>
                                                        </span>

                                                    </td>

                                                    <td>
                                                        Courriers - Arrivée
                                                    </td>
                                                    <td>
                                                        <a class="load"
                                                            href="{{ route('detailCourierArriver', [$c->courierSlug]) }}">Voir
                                                            le courrier <span class="fa fa-arrow-right"></span></a>
                                                    </td>


                                                </tr>
                                                @endforeach
                                                
                                                </tbody>
                                            </table>
                                            @endif
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-6">

                                    <h3 class="box-title m-t-40">Traitements & Suggestions &nbsp;&nbsp;&nbsp;
                                        @if($tache[0]->statut == 'suspendu' || $tache[0]->statut == 'validée' ||
                                        $tache[0]->statut == 'Hors Délais')
                                        &nbsp;
                                        @else
                                        <a href="#" type="btn btn-success" data-toggle="modal" data-target="#addtraiter"
                                            onclick="traitement()"><i class="fa fa-plus-circle"
                                                style="font-size:x-large;color:white"></i>
                                        </a>
                                        @endif
                                    </h3>
                                    @if($tache[0]->statut == 'suspendu' || $tache[0]->statut == 'validée' ||
                                    $tache[0]->statut == 'Hors Délais')
                                    &nbsp;
                                    @else
                                    @if(Auth::user()->role=='Administrateur')
                                    <a href="" data-toggle="modal" data-target="#addtraiter"
                                        class="btn label label-warning"
                                        style="color:white; float:right;margin-bottom:10px;" onclick="suggestion()"><i
                                            class="fa  ti-light-bulb" title="faire une suggestion"></i> Suggerer</a>
                                    @else
                                    @endif

                                    @endif

                                    <div class="table-responsive" style="margin-top:4em">

                                        <div class="category-filter">
                                            <select id="categoryFilter" class="categoryFilter form-control">
                                                <option value="">Tous</option>

                                            </select>
                                        </div>
                                        <table id="filterTable"
                                            class="filterTable dataTableExport table table-bordered table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>T/S</th>
                                                    <th>Initial</th>
                                                    <th>Description</th>
                                                    <th>Fichiers</th>
                                                    <th style="width:150px ;">Date</th>
                                                    <th>Option</th>

                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach ($traitements as $t)
                                                <tr>
                                                    <td style="width:10px ;">
                                                        @if($t->type=='suggestion')
                                                        <i class="fa  ti-light-bulb"
                                                            style="color: orange ;font-size:large"></i>
                                                        @else
                                                        <i class="fa  ti-write"
                                                            style="color:cadetblue; font-size:large"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($t->initialAdmin===null)
                                                        <span class="heading-name-meta">
                                                            {{$t->initial}}
                                                        </span>
                                                        @else
                                                        <span class="heading-name-meta">{{$t->initialAdmin}} </span>
                                                        @endif

                                                    </td>
                                                    <td>{{$t->description}}</td>
                                                    <td>
                                                        @foreach($fichiersTraitement as $f)
                                                        @if($f->slugSource==$t->slug)
                                                        <a class="load" href="{{route('readFile', [$f->slug])}}"
                                                            class="toggle"
                                                            title="Cliquer pour afficher le contenu du fichier"><i
                                                                class="fa  fa-file-pdf-o"
                                                                style="color:red; font-size:1.5em;"></i></a>
                                                        @else
                                                        @endif
                                                        @endforeach
                                                    </td>
                                                    <td style="width:80px ;">
                                                        <b style="color:rgb(255, 42, 42) ;">Timesheet :
                                                            {{ $t->timesheet }} {{ $t->uniteTime }} </b>
                                                        <span
                                                            class="label cl-info bg-primary-ligth">{{ date('d-m-Y', strtotime($t->created_at))}}
                                                            {{ date('H:m', strtotime($t->created_at))}}</span>
                                                    </td>
                                                    <td>
                                                        @if($t->initial==$idPersonConnected)
                                                            @if($tache[0]->statut =='validée')
                                                                
                                                            @else 
                                                                <a class="load"
                                                                    href="{{route('deleteTraitement',$t->idTraitement)}}"
                                                                    type="button"
                                                                    class="btn btn-outline-danger btn-sm">Retirer</a>
                                                            @endif 

                                                        @else

                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="addcontact" tabindex="-1" role="dialog" aria-labelledby="addcontact">
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
                <h4 class="modal-title"><i class="fa fa-file"></i> Gestionnaire de fichier</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('joinFile') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0">Joindre un fichier à la tâche</h4>
                                </div>
                                <div class="card-body">


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="slugTache" hidden="true"
                                                value="{{ $tache[0]->slug }}">
                                            <label for="fileInput" class="custom-file-label">Piece(s) jointe(s) (
                                                Facultatif ) . . .</label>
                                            <input type="file" id="inputRPAV" class="fichiers form-control"
                                                name="fichiers[]" multiple accept="image/*,.pdf, .doc, docx" id="files">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class=" theme-bg btn btn-rounded btn-block"
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

<div class="add-popup modal fade" id="jointureMultiple" tabindex="-1" role="dialog" aria-labelledby="addcontact">
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
                <h4 class="modal-title">Assignation multiple des personnes</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('assigneTaskPersonne', [$tache[0]->idTache, $slug]) }}"
                    accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mrg-0">
                                        <div class="col-sm-12">
                                            <label for="personne" class="control-label"> selectionner les personnes
                                                concernés pour la tâche</label>
                                            <div class="form-group">
                                                <select multiple="" name="idPersonnel[]" class="form-control select2"
                                                    data-placeholder="selectionner ..." style="width: 100%;"
                                                    id="personne" data-error="" required>
                                                    @foreach ($allPersonnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">
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

<div class="add-popup modal fade" id="addtraiter" tabindex="-1" role="dialog" aria-labelledby="addtraiter">
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
                <h4 class="modal-title">Traitement de tâche</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('traitementTache')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0" style="text-align:center ;">Traitement / Suggestion
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <label for="description">Description (Obligatoire)</label>
                                    <textarea name="description" class="form-control" id="" cols="30"
                                        placeholder="Saisissez quelques mots pour plus de details..." rows="10"
                                        required></textarea>
                                    <label for="heureDebut" class="control-label mt-3" id="labeltime">Temps
                                        d'execution</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control select" data-placeholder="unite"
                                                style="width: 100%;" name="uniteTime" id="unite" required
                                                style="color:blue;">
                                                <option value=''>Choisissez une unité</option>
                                                <option value='m'>Minute</option>
                                                <option value='h'>Heure</option>
                                                <option value='j'>Jour</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" min="0" class="form-control" id="time" name="timesheet"
                                                required>
                                        </div>
                                    </div>

                                    <input type="number" name="idTache" hidden="true" value="{{ $tache[0]->idTache }}">
                                    <input type="hidden" id="typeTraitement" name="type">


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fileInput" class="custom-file-label">Piece(s) jointe(s) (
                                                Facultatif ) . . .</label>
                                            <input type="file" id="inputRPAV" class="fichiers form-control"
                                                name="fichiers[]" multiple accept="image/*,.pdf, .doc, docx" id="files">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">
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

<!-- modal-tâche -->
<div class="modal modal-box-1 fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="editTask"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel1">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-pencil"></i> Modification de la tâche</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title m-t-0 text-center">
                                    @if ($tache[0]->idTypeTache ==0)
                                    Tâche du cabinet
                                    @else
                                    &nbsp;
                                    @endif
                                </h4>
                            </div>
                            <!-- form start -->
                            <form method="post" action="{{ route('updateTaskSelected', [$slug]) }}"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf

                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="iputP" class="control-label">Nom de la tâche :</label>
                                            <input type="text" class="form-control" id="iputP"
                                                data-error=" veillez saisir le nom de la tâche" name="titre" required
                                                placeholder="" style="color:blue;" value="{{ $tache[0]->titre }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <!--$tache[0]->idTypeTache ==0 -->
                                    <!-- 
                                    @if ($tache[0]->idAffaire == null )
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Type de tâche :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner le client" style="width: 100%;"
                                                name="idTypeTache" id="" required style="color:blue;">
                                                <option>Cabinet</option>

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Type de tâche :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner le client" style="width: 100%;"
                                                name="idTypeTache" id="" required>
                                                <option value={{ $tache[0]->idTypeTache }}>
                                                    {{ $tache[0]->descriptionType }}</option>
                                                @foreach($typeTaches as $t)
                                                @if($t->idTypeTache != 0)
                                                <option value={{$t->idTypeTache}}>{{$t->descriptionType}}</option>
                                                @endif
                                                @endforeach

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    @endif-->
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputN" class="control-label">Date début de la tâche :</label>
                                            <input type="date" class="dateDebutTa form-control" id="inputN"
                                                name="dateDebut" data-error=" veillez saisir la date début de la tâche"
                                                required placeholder="" style="color:blue;"
                                                value="{{ $tache[0]->dateDebut }}">
                                            <span id="m1" class="m1" style=" color:red"></span>

                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="datepicker" class="control-label">Date fin de la tâche :</label>
                                            <input type="date" class="dateFinTa form-control" id="datepicker"
                                                name="dateFin" data-error=" veillez saisir la date de fin de la tâche"
                                                required placeholder="" style="color:blue;"
                                                value="{{ $tache[0]->dateFin }}">
                                            <span id="m2" class="m2" style=" color:red"></span>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                     <!--$tache[0]->idTypeTache ==0 -->
                                    @if ($tache[0]->idAffaire == null)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Client :</label>
                                            <select class="form-control" data-placeholder=""
                                                style="width: 100%; color:blue" name="idClient">
                                                <option value="Cabinet" selected>
                                                    Cabinet
                                                </option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    @else
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Selectionner le client :</label>
                                            <select class="form-control" data-placeholder="selectionner le client"
                                                style="width: 100%;" name="idClient" id="client" required
                                                style="color:blue">
                                                @foreach ($clients as $client)
                                                <option value="{{ $client->idClient }}" selected>{{ $client->prenom }}
                                                    {{ $client->nom }} {{ $client->denomination }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="desc" class="control-label">Point :</label>
                                            <input type="number" name="point" min="1" class="form-control"
                                                style="height:30px" required placeholder="" style="color:blue;"
                                                value="{{ $tache[0]->point }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                @if (is_null($tache[0]->idAffaire))
                                &nbsp;
                                @else
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="aff" class="control-label">Affaire :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner une affaire" style="width: 100%;"
                                                name="idAffaire" id="aff" required style="color:blue;">
                                                <option value="{{ $affaire->idAffaire }}" selected>
                                                    {{ $affaire->nomAffaire }}</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="desc" class="control-label">Description de la tâche :</label>
                                            <textarea class="form-control" id="desc" rows="3" name="description"
                                                placeholder="" data-error=" veillez saisir une description de la tâche"
                                                required style="color:blue;">
                                            {{ $tache[0]->description }}
                                            </textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-12">
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
<!-- End modal-tâche -->

<div class="add-popup modal fade" id="deleteTask" tabindex="-1" role="dialog" aria-labelledby="deleteTask">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gray;">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez l'annulation</h4>
            </div>
            <div class="modal-body">
                <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                <p>Voulez-vous vraiment supprimer cette tache ?</p>

                <div class="row mrg-0">
                    <div class="col-md-12">
                        <a href="javascript:void(0)" class="btn " data-dismiss="modal" aria-label="Close">NON</a>
                        <a type="button" href="{{ route('deleteTask', [$slug]) }}" class="load btn btn-danger">OUI</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script>
function getPDF() {
    document.body.style.background = 'blue';
    var HTML_Width = $(".pdf-content").width();
    var HTML_Height = $(".pdf-content").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;
    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;
    return html2canvas($('.pdf-content'), {
        background: "#ffffff",
        onrendered: function(canvas) {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);

            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);

            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                canvas_image_height);

            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4),
                    canvas_image_width, canvas_image_height);
            }
            pdf.save(
                `${$('.pdf-title1').text()} ${$('.pdf-title2').text()} ${$('.pdf-title3').text()} ${$('.pdf-title4').text()}.pdf`
            );

        }
    });
}
</script>

<script>
document.getElementById('tch').classList.add('active');

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
</script>

@endsection