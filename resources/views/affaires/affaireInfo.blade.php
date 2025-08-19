@extends('layouts.base')
@section('title','Information de l\'affaire')
@section('content')
<div class="container-fluid" >
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs" id="pdfContent">
        <div class="col-md-10 align-self-center">
            <h5 class="theme-cl">
                @foreach ($infoClient as $client)
                <a class="load theme-cl" href="{{route('clientInfos', [$client->idClient,$client->slug])}}">
                    {{ $client->idClient }}
                </a>
                @endforeach
                >
                @foreach ($infoClient as $client)
                <a class="load theme-cl" href="{{route('clientInfos', [$client->idClient,$client->slug])}}">
                    {{ $client->prenom }} {{ $client->nom }} {{ $client->denomination }}
                </a>
                @endforeach
                >
                @foreach ($affaire as $affaire)
                <a class="load theme-cl" href="{{ route('showAffaire', [$affaire->idAffaire,$affaire->slug]) }}">
                    {{ $affaire->idAffaire }} {{ $affaire->nomAffaire }}
                </a>
                @endforeach
                >
                <span class="label bg-info"><b>Affaire</b></span>


            </h5>
            <br>
            Ouvert le : <span
                class="label bg-danger-light">{{ date('d-m-Y', strtotime($affaire->dateOuverture)) }}</span>
        </div>

        <div class="col-md-2 text-right">
            <div class="dropdown" style="float: right ;">
                <button class="btn btn-rounded theme-bg dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="load dropdown-item" href="{{ route('createAffaire') }}"><i
                            class=" ti-wand mr-2"></i>Créer</a>
                    <a class="load dropdown-item" href="#" data-toggle="modal" data-target="#update"><i
                            class="ti-pencil mr-2"></i>
                        Editer</a>

                    <a class="load dropdown-item" href="{{ route('allAfaires') }}"><i class="ti-list mr-2"></i>
                        Liste</a>
                    <a class="load dropdown-item" href="#" data-toggle="modal" data-target="#deleteAffaire"
                        style="color:red"><i class="ti-close mr-2"></i>Supprimer</a>

                    <div class="dropdown-item text-center">
                            <button class="btn btn-sm btn-primary hidden-print" onclick="exportDivToPDF2()">
                                <i class="ti-download mr-1"></i> Télécharger PDF
                            </button>
                        </div>   
                </div>
            </div>
        </div>

    </div>
    <!-- Title & Breadcrumbs-->

    <div class="col-md-12 col-sm-12">
        <div class="card ">
            <div class="tab" role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active" onclick="changeTab1()" id="t1"><a href="#Section1"
                            aria-controls="home" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-layers-alt"></i>
                            Tâches</a></li>
                    <li role="presentation" class="" onclick="changeTab2()" id="t2"><a href="#Section2" role="tab"
                            data-toggle="tab"> <i class="ti i-cl-0  fa fa-envelope"></i> Courriers</a></li>


                    @if(Auth::user()->role=='Administrateur')
                    <!--  <li role="presentation" class="" onclick="changeTab3()" id="t3"><a href="#Section3" role="tab"
                            data-toggle="tab"> <i class="fa fa-balance-scale"></i> Audiences</a></li> -->
                        <li role="presentation" class="" onclick="changeTab3()" id="t3"><a href="#Section3" role="tab"
                            data-toggle="tab"> <i class="fa fa-balance-scale"></i> Procédures</a></li>
                    <li role="presentation" class="" onclick="changeTab4()" id="t4"><a href="#Section4" role="tab"
                            data-toggle="tab"> <i class="ti i-cl-0 fa fa-money"></i> Factures</a></li>
                    <!-- <li role="presentation" class="" onclick="changeTab5()" id="t5"><a href="#Section5" role="tab"
                            data-toggle="tab"> <i class="ti i-cl-0  ti-alarm-clock"></i> Temps</a></li> -->

                    @else
                    @endif
                    <li role="presentation" onclick="changeTab6()" id="t6"><a href="#Section6" role="tab"
                            data-toggle="tab"> <i class="ti i-cl-0 ti-bookmark-alt"></i> Pièces</a></li>
                    <!-- <li role="presentation"><a href="#Section7" role="tab" data-toggle="tab"> <i class="ti i-cl-6  ti-clipboard"></i> Modèles</a></li> -->
                    <!--<li role="presentation" class="" onclick="changeTab7()" id="t7"><a href="#Section8" role="tab" data-toggle="tab"> <i class="ti i-cl-2 ti-notepad"></i> Requêtes</a></li>-->
                </ul>
                <div class="tab-content tabs" id="home">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <!-- Title & Breadcrumbs-->
                        <div class="row page-breadcrumbs">
                            <div class="col-md-5 align-self-center">
                               <!-- <h4 class="theme-cl"><i class="ti i-cl-0 ti-layers-alt"></i> Tâche du client</h4> -->
                            </div>
                            @if(Auth::user()->role=='Administrateur' || Auth::user()->role=='Assistant')
                            <div class="col-md-7 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('allTasks') }}" class="load btn btn-secondary">
                                        <i class="fa fa-eye ti i-cl-5"></i> &nbsp;Voir les tâches
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('taskForm', [$affaire->idAffaire,'affaire']) }}"
                                        class="load btn btn-secondary">
                                        <i class="ti-wand i-cl-4"></i> &nbsp;Créer une tâche
                                    </a>
                                </div>
                            </div>
                            @else
                            @endif
                        </div>
                        <!-- Title & Breadcrumbs-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card padd-15">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="category-filter">
                                                <select id="categoryFilter6" class="categoryFilter6 form-control">
                                                    <option value="">Tous</option>
                                                    <option value="validée">Validée</option>
                                                    <option value="En cours">En cours</option>
                                                    <option value="suspendu">Suspendu</option>
                                                    <option value="Hors Délais">Hors Délais</option>

                                                </select>
                                            </div>
                                            <table id="filterTable6"
                                                class="filterTable6 dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Nom de la tâche</th>
                                                        <th>Description</th>
                                                        <th>Date début</th>
                                                        <th>Date de fin</th>
                                                        <th>Statut</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($taches as $row)
                                                    <tr>
                                                        <td>
                                                            {{ $row->idTache }}
                                                        </td>
                                                        <td><a class="load"
                                                                href="{{ route('infosTask', [$row->slug]) }}">
                                                                {{ $row->titre }}</a></td>
                                                        <td>{{ $row->description }}</td>
                                                        @if(empty($row->dateDebut ))
                                                            <td>N/A</td>
                                                        @else

                                                            <td>{{ date('d-m-Y', strtotime($row->dateDebut)) }}</td>
                                                        @endif

                                                        @if(empty($row->dateFin ))
                                                            <td>N/A</td>
                                                        @else
                                                        
                                                        <td>{{ date('d-m-Y', strtotime($row->dateFin)) }}</td>
                                                        @endif
                                                            
                                                       <!-- <td>{{ date('d-m-Y', strtotime($row->dateDebut)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($row->dateFin)) }}</td> -->
                                                        <td>
                                                            <div class="label cl-success bg-success-light">
                                                                {{ $row->statut }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="load"
                                                                href="{{ route('infosTask', [$row->slug]) }}"
                                                                class="settings" title="Information"
                                                                data-toggle="tooltip"><i
                                                                    class="fa fa-info-circle"></i></a>
                                                            <a href="#" class="delete" title="Annulé"
                                                                data-toggle="tooltip"><i class="ti-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        <!-- Title & Breadcrumbs-->
                        <div class="row page-breadcrumbs">
                            <div class="col-md-5 align-self-center">
                              <!--  <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers de l'affaire</h4> -->
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('allCouriers') }}" class="load btn btn-secondary">
                                        <i class="ti-eye i-cl-2 "></i> Voir les courriers
                                    </a>
                                </div>
                                <!-- <div class="btn-group">
                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modal-5">
                                        Créer un courier arriver
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal-3">
                                        Créer un Courriers - Départ
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <!-- Title & Breadcrumbs-->
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card padd-15">
                                    <div class="panel-group accordion-stylist" id="accordion" role="tablist"
                                        aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseOne" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        <h4 class="theme-cl"> Courriers Arrivé</h4>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel"
                                                aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <div class="category-filter">
                                                                    <select id="categoryFilter3" class="categoryFilter3 form-control">
                                                                        <option value="">Tous</option>
                                                                        <option value="Reçu">Reçu</option>
                                                                        <option value="Lu">Lu</option>
                                                                        <option value="En Traitement">En traitement</option>
                                                                        <option value="Traité">Traité</option>
                                                                        <option value="Classé">Classé</option>
                                                                        <option value="Annulé">Annulé</option>

                                                                    </select>
                                                                </div>
                                                                <table id="filterTable3"
                                                                    class="filterTable3 dataTableExport table table-bordered table-hover"
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 10px;">N°</th>
                                                                            <th>Expéditeur</th>
                                                                            <th style="width: 100px;">Date du courrier
                                                                            </th>
                                                                            <th>Objet</th>
                                                                            <th>Statut</th>
                                                                            <th style="width: 100px;text-align:center">
                                                                                Voir
                                                                                / Suppr</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        @foreach($courierArriver as $row)

                                                                            @if($row->confidentialite=='on' &&
                                                                            Auth::user()->role!='Administrateur')
                                                                            <tr class="bg-warning-light">
                                                                                <td style="font-style:italic">
                                                                                    {{ $row->numero }}
                                                                                </td>

                                                                                <td
                                                                                    style="text-align:center ;font-style:italic">
                                                                                    <span>Confidentiel</span>
                                                                                </td>
                                                                                <td
                                                                                    style="text-align:center ;font-style:italic">
                                                                                    <span>Confidentiel</span>
                                                                                </td>
                                                                                <td
                                                                                    style="text-align:center ;font-style:italic">
                                                                                    <span>Confidentiel</span>
                                                                                </td>
                                                                                <td
                                                                                    style="text-align:center ;font-style:italic">
                                                                                    <span>Confidentiel</span>
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                            @else

                                                                            <tr
                                                                                class="@if($row->statut=='Annulé') bg-danger-light @else @endif">
                                                                                <td>
                                                                                    @if($row->confidentialite=='on')<i
                                                                                        class="fa fa-lock"
                                                                                        style="font-size:11px"></i>@endif
                                                                                    {{ $row->numero }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $row->expediteur }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ date('d-m-Y', strtotime($row->dateCourier))}}
                                                                                </td>

                                                                                <td><a
                                                                                        href="{{ route('detailCourierArriver', [$row->slug]) }}">{{ $row->objet }}</a>
                                                                                </td>
                                                                                <td style="text-align:center ;">
                                                                                    @if($row->statut=='Lu')
                                                                                    <div class="label  bg-warning">
                                                                                        {{ $row->statut }}</div>
                                                                                    @elseif($row->statut=='Reçu')
                                                                                    <div class="label bg-primary">
                                                                                        {{ $row->statut }}</div>
                                                                                    @elseif($row->statut=='En Traitement')
                                                                                    <div class="label bg-info">
                                                                                        {{ $row->statut }}</div>
                                                                                    @elseif($row->statut=='Annulé')
                                                                                    <div class="label bg-default">
                                                                                        {{ $row->statut }}</div>
                                                                                    @elseif($row->statut=='Traitement
                                                                                    annulé')
                                                                                    <div class="label bg-danger">
                                                                                        {{ $row->statut }}</div>
                                                                                    @else
                                                                                    <div class="label bg-success">
                                                                                        {{ $row->statut }}</div>
                                                                                    @endif
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <a href="{{ route('detailCourierArriver', [$row->slug]) }}"
                                                                                        title="Information"
                                                                                        data-toggle="tooltip"><i
                                                                                            class="fa fa-arrow-right"></i></a>
                                                                                    <a href="" data-toggle="modal"
                                                                                        id="{{ $row->slug }}"
                                                                                        data-target="#deleteCourierArriver"
                                                                                        onclick="var slug= this.id ; deleteCourierArriver(slug)"
                                                                                        title="Annulé" style="color:red"><i
                                                                                            class="ti-trash"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
                                                        <h4 class="theme-cl"> Courriers - Départ</h4>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                                aria-labelledby="headingTwo">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <div class="category-filter">
                                                                            <select id="categoryFilter4" class="categoryFilter4 form-control">
                                                                                <option value="">Tous</option>
                                                                                <option value="Transmis">Transmis</option>
                                                                                <option value="Approuvé">Approuvé</option>
                                                                                <option value="Désapprouvé">Désapprouvé</option>
                                                                                <option value="Terminé">Terminé</option>
                                                                                <option value="Annulé">Annulé</option>

                                                                            </select>
                                                                        </div>

                                                                        <table id="filterTable4"
                                                                            class="filterTable4 dataTableExport table table-bordered table-hover"
                                                                            style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 10px;">N°</th>
                                                                                    <th style="width: 100px;">Date du
                                                                                        courrier</th>
                                                                                    <th>Destinataire</th>
                                                                                    <th>Objet</th>
                                                                                    <th>Statut</th>
                                                                                    <th style="text-align: center;">Voir / Suppr</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                @foreach($courierDepart as $row)
                                                                                @if($row->statut=='Annulé')
                                                                                <tr class="bg-danger-light">
                                                                                    <td>
                                                                                        {{ $row->numCourier }}
                                                                                    </td>

                                                                                    <td>
                                                                                        {{ date('d-m-Y', strtotime($row->dateCourier)) }}
                                                                                    </td>
                                                                                    <td style="text-align:center ;">

                                                                                        <span
                                                                                            class="pull-right-container">
                                                                                            <small class="label"
                                                                                                style="color:black">{{ $row->destinataire }}</small>
                                                                                        </span>

                                                                                    </td>
                                                                                    <td><a href="#">{{ $row->objet }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($row->statut == 'Envoyé')
                                                                                        <div
                                                                                            class="label cl-info bg-info-light">
                                                                                            {{ $row->statut }}
                                                                                            <div>
                                                                                                @elseif($row->statut ==
                                                                                                'Transmis')
                                                                                                <div
                                                                                                    class="label cl-warning bg-warning-light">
                                                                                                    {{ $row->statut }}
                                                                                                    <div>
                                                                                                        @elseif($row->statut
                                                                                                        == 'Approuvé')
                                                                                                        <div
                                                                                                            class="label cl-primary bg-primary-light">
                                                                                                            {{ $row->statut }}
                                                                                                            <div>
                                                                                                                @elseif($row->statut
                                                                                                                ==
                                                                                                                'Terminé')
                                                                                                                <div
                                                                                                                    class="label bg-success">
                                                                                                                    {{ $row->statut }}
                                                                                                                    <div>
                                                                                                                        @elseif($row->statut
                                                                                                                        ==
                                                                                                                        'Désapprouvé')
                                                                                                                        <div
                                                                                                                            class="label bg-danger">
                                                                                                                            {{ $row->statut }}
                                                                                                                            <div>
                                                                                                                                @else
                                                                                                                                <div
                                                                                                                                    class="label bg-default">
                                                                                                                                    {{ $row->statut }}
                                                                                                                                    <div>
                                                                                                                                        @endif
                                                                                    <td
                                                                                        style="text-align: center;width:100px">
                                                                                        <a class=""
                                                                                            href="{{ route('infoCourierDepart', [$row->slug]) }}"
                                                                                            title="Information"
                                                                                            data-toggle="tooltip"><i
                                                                                                class="fa fa-arrow-right"></i></a>
                                                                                    </td>
                                                                                </tr>
                                                                                @elseif($row->confidentialite=='on' &&
                                                                                Auth::user()->role!='Administrateur')
                                                                                <tr class="bg-warning-light">
                                                                                    <td style="font-style:italic">
                                                                                        {{ $row->numCourier }}</td>

                                                                                    <td
                                                                                        style="text-align:center ;font-style:italic">
                                                                                        <span>Confidentiel</span>
                                                                                    </td>
                                                                                    <td
                                                                                        style="text-align:center ;font-style:italic">
                                                                                        <span>Confidentiel</span>
                                                                                    </td>
                                                                                    <td
                                                                                        style="text-align:center ;font-style:italic">
                                                                                        <span>Confidentiel</span>
                                                                                    </td>
                                                                                    <td
                                                                                        style="text-align:center ;font-style:italic">
                                                                                        <span>Confidentiel</span>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                @else
                                                                                <tr>
                                                                                    <td>
                                                                                        @if($row->confidentialite=='on')<i
                                                                                            class="fa fa-lock"
                                                                                            style="font-size:11px"></i>@endif
                                                                                        {{ $row->numCourier }}
                                                                                    </td>

                                                                                    <td>
                                                                                        {{ date('d-m-Y', strtotime($row->dateCourier))}}
                                                                                    </td>
                                                                                    <td style="text-align:center ;">

                                                                                        <span class="">
                                                                                            <small class="label"
                                                                                                style="color:black">{{ $row->destinataire }}</small>
                                                                                        </span>


                                                                                    </td>
                                                                                    <td><a
                                                                                            href="{{ route('infoCourierDepart', [$row->slug]) }}">{{ $row->objet }}</a>
                                                                                    </td>
                                                                                    <td>

                                                                                        @if ($row->statut == 'Envoyé')
                                                                                        <div
                                                                                            class="label cl-info bg-info-light">
                                                                                            {{ $row->statut }}
                                                                                            <div>
                                                                                                @elseif($row->statut ==
                                                                                                'Transmis')
                                                                                                <div
                                                                                                    class="label cl-warning bg-warning-light">
                                                                                                    {{ $row->statut }}
                                                                                                </div>
                                                                                                @elseif($row->statut ==
                                                                                                'Approuvé')
                                                                                                <div
                                                                                                    class="label cl-primary bg-primary-light">
                                                                                                    {{ $row->statut }}
                                                                                                </div>
                                                                                                @elseif($row->statut ==
                                                                                                'Terminé')
                                                                                                <div
                                                                                                    class="label bg-success">
                                                                                                    {{ $row->statut }}
                                                                                                </div>
                                                                                                @elseif($row->statut ==
                                                                                                'Désapprouvé')
                                                                                                <div
                                                                                                    class="label bg-danger">
                                                                                                    {{ $row->statut }}
                                                                                                </div>
                                                                                                @else
                                                                                                <div
                                                                                                    class="label bg-default">
                                                                                                    {{ $row->statut }}
                                                                                                </div>
                                                                                                @endif
                                                                                    </td>
                                                                                    <td
                                                                                        style="text-align: center;width:100px">
                                                                                        <a class=""
                                                                                            href="{{ route('infoCourierDepart', [$row->slug]) }}"
                                                                                            title="Information"
                                                                                            data-toggle="tooltip"><i
                                                                                                class="fa fa-arrow-right"></i></a>
                                                                                        <a class="" href=""
                                                                                            data-toggle="modal"
                                                                                            id="{{ $row->slug }}"
                                                                                            data-target="#deleteCourierDepart"
                                                                                            onclick="var slug= this.id ; deleteCourierDepart(slug)"
                                                                                            title="Supprimer"
                                                                                            style="color:red"><i
                                                                                                class="ti-trash"></i></a>
                                                                                    </td>
                                                                                </tr>
                                                                                @endif
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section3">
                        <!-- Title & Breadcrumbs-->
                        <div class="row page-breadcrumbs">
                            <div class="col-md-5 align-self-center">
                               <!-- <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Audiences du client</h4> -->
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('listAudience', 'generale') }}" class="load btn btn-secondary">
                                        <i class="ti-eye i-cl-5"></i> Voir les audiences
                                    </a>
                                </div>
                                <!--
                                <div class="btn-group">
                                    <a class="load" href="{{route('audienceAffaire',[$affaire->slug, $affaire->idAffaire ])}}" class="btn btn-secondary">
                                        <i class="ti-plus i-cl-3 "></i> Créer une audience
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <!-- Title & Breadcrumbs-->

                        <div class="panel-group accordion-stylist" id="accordion" role="tablist"
                            aria-multiselectable="true">
                            <!-- Title & Breadcrumbs-->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingone">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseone" aria-expanded="false"
                                            aria-controls="collapseone">
                                            <h4 class="theme-cl"> Procédures contraditoires</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseone" class="panel-collapse collapse" role="tabpanel"
                                            aria-labelledby="heading3">
                                    <div class="panel-body">
                                        <div class="row"  >
                                            <div class="col-md-12">
                                                <div class="card padd-15">
                                                    <div class="card-body">

                                                        <div class="table-responsive">

                                                        
                                                            <table id="filterTable"
                                                                class="filterTable dataTableExport table table-bordered table-hover"
                                                                style="width:100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>N°</th>
                                                                    <th>N°RG</th>
                                                                    <th>Parties</th>
                                                                    <th>Objet</th>
                                                                    <th>Niveau Procedural</th>
                                                                    <th>Prochaine audience</th>
                                                                    <th>Statut</th>
                                                                </tr> 
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($formattedAudiences as $row)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $row['numRg'] ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('detailAudience', ['id' => $row['idAudience'], 'slug' => $row['slugAud'], 'niveau' => $row['niveauProcedural']]) }}"
                                                                        data-toggle="tooltip" title="Voir plus de cette audience">
                                                                            <span>{{ $row['ministerePublic'] }}</span>
                                                                            <span>
                                                                                @if(is_array($row['parties']) && !empty($row['parties']))
                                                                                    {{ implode(', ', $row['parties']) }}
                                                                                @else
                                                                                {{ $row['parties'] }}
                                                                                @endif
                                                                            </span>
                                                                            
                                                                            <span>
                                                                                @if(is_array($row['partieCivile']) && !empty($row['partieCivile']))
                                                                                    Partie civile : {{ implode(', ', $row['partieCivile']) }}
                                                                                @else
                                                                                    {{ $row['partieCivile'] }}
                                                                                @endif
                                                                            </span>
                                                                            <span>
                                                                                @if(is_array($row['intervenant']) && !empty($row['intervenant']))
                                                                                    Intervenant : {{ implode(', ', $row['intervenant']) }}
                                                                                @else
                                                                                {{ $row['intervenant'] }}
                                                                                @endif
                                                                            </span>
                                                                            
                                                                        </a>
                                                                    </td>

                                                                    <td>
                                                                        <a href="{{ route('detailAudience', ['id' => $row['idAudience'], 'slug' => $row['slugAud'] ,$row['niveauProcedural'] ]) }}"
                                                                            data-toggle="tooltip" title="Voir plus de cette audience">
                                                                            {{ $row['objet'] }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <span>
                                                                            @if($row['niveauProcedural']=='1ère instance')
                                                                            <small class="label bg-success">{{ $row['niveauProcedural'] }}</small>
                                                                            @elseif($row['niveauProcedural']=='Appel')
                                                                            <small class="label bg-warning">{{ $row['niveauProcedural'] }}</small>
                                                                            @else
                                                                            <small class="label bg-danger">{{ $row['niveauProcedural'] }}</small>
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td>

                                                                    @php
                                                                        $dateAudience= $row['dateAudience'];
                                                                    @endphp

                                                                        
                                                                        
                                                                        @if ($row['dateAudience']=='' || $row['dateAudience']=='N/A')
                                                                            N/A
                                                                        @else
                                                                             @if (strtotime($dateAudience) < strtotime(date('Y-m-d')))
                                                                                <span class="label bg-danger">suivi incomplet</span>
                                                                            @else

                                                                                {{ date('d/m/Y', strtotime( $row['dateAudience'] ))}}
                                                                            @endif
                                                                        @endif
                                                                            
                                                                    </td>
                                                                    <td>
                                                                        <span>
                                                                            @if($row['statutAud']=='Terminée')
                                                                            <small class="label bg-success-light">{{ $row['statutAud'] }}</small>
                                                                            @elseif($row['statutAud']=='Jonction')
                                                                            <small class="label bg-blue">{{ $row['statutAud'] }}</small>
                                                                            @else
                                                                            <small class="label bg-warning-light">{{ $row['statutAud'] }}</small>
                                                                            @endif
                                                                        </span>
                                                                    </td>


                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-group accordion-stylist" id="accordion" role="tablist"
                            aria-multiselectable="true">
                            <!--  Procédure non contraditoire  -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingone">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapsetwo" aria-expanded="false"
                                            aria-controls="collapsetwo">
                                            <h4 class="theme-cl"> Procédures non  contraditoires</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsetwo" class="panel-collapse collapse" role="tabpanel"
                                            aria-labelledby="heading3">
                                    <div class="panel-body">
                                        <div class="row"  >
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">

                                                        <div class="table-responsive">
                                                            <div class="category-filter">
                                                                <select id="categoryFilter7" class="categoryFilter7 form-control">
                                                                    <option value="">Tous</option>
                                                                </select>
                                                            </div>
                                                        
                                                            <table id="filterTable7"
                                                                class="filterTable7 dataTableExport table table-bordered table-hover"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>N°</th>
                                                                        <th>Objet</th>
                                                                        <th>Type de requête</th>
                                                                        <!--<th>Juridiction présidentielle</th>-->
                                                                        <th>demande</th>
                                                                        <th>Parties</th>
                                                                        <th>Date requête</th>
                                                                        <th>Statut</th>
                                                                    </tr> 
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($requetes1 as $row)
                                                                    <tr>
                                                                        
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td><a href="{{ route('detailRequete', $row->slug) }}">{{ $row->objet }}</a></td>
                                                                        <td>{{ $row->typeRequete }}</td>
                                                                    <!-- <td>{{ $row->juridictionPresidentielle }}</td> -->
                                                                        <td>{{ $row->demandeRequete }}</td> 

                                                                        <td>
                                                                            <!-- Affichage du cabinet -->
                                                                            @foreach($cabinet1 as $c)
                                                                                    @if($row->idProcedure === $c->idRequete)
                                                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                                                    @endif
                                                                                @endforeach
                                                                                <!-- Affichage de l'entreprise adverse -->
                                                                                @foreach($entreprise_adverses1 as $e)
                                                                                    @if($row->idProcedure === $e->idRequete)
                                                                                        <span>c/ {{ $e->denomination }}</span>
                                                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                                                    @endif
                                                                                @endforeach

                                                                                <!-- Affichage de personne adverse -->
                                                                                @foreach($personne_adverses1 as $p)
                                                                                    @if($row->idProcedure === $p->idRequete)
                                                                                        <span>c/ {{ $p->prenom }} {{ $p->nom }}</span>
                                                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                                                    @endif
                                                                                @endforeach

                                                                                <!-- Affichage d'autres rôles -->
                                                                                @foreach($autreRoles1 as $r)
                                                                                    @if($row->idProcedure === $r->idRequete)
                                                                                        @if($r->autreRole === 'mp')
                                                                                            <span>c/ Ministère public</span>
                                                                                        @endif
                                                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                                                    @endif
                                                                                @endforeach

                                                                        </td>
                                                                        <td>
                                                                            @if(empty($row->dateRequete))
                                                                                <small>N/A</small>
                                                                            @else
                                                                                {{ date('d/m/Y', strtotime($row->dateRequete)) }}
                                                                            @endif
                                                                           <!-- {{ date('d/m/Y', strtotime($row->dateRequete)) }} -->
                                                                        </td>
                                                                        <td>
                                                                            <!--
                                                                                <span>
                                                                                        @if($row->statut=='Terminée')
                                                                                        <small class="label bg-success-light">{{ $row->statut }}</small>
                                                                                        @elseif($row->statut=='Jonction')
                                                                                        <small class="label bg-blue">{{ $row->statut }}</small>
                                                                                        @else
                                                                                        <small class="label bg-warning-light">{{ $row->statut }}</small>
                                                                                        @endif
                                                                                    </span> -->
                                                                            <span>
                                                                                @if($row->statut=='Terminée')
                                                                                    <small class="label bg-success">Terminée</small>
                                                                                @elseif($row->statut=='Déposée')
                                                                                    <small class="label bg-primary">Déposée</small>
                                                                                @elseif($row->statut=='Acceptée')
                                                                                    <small class="label bg-success">Acceptée</small>
                                                                                @elseif($row->statut=='Rejetée')
                                                                                    <small class="label bg-danger">Rejetée</small>

                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section4">
                        <div class="row page-breadcrumbs">
                            <div class="col-md-5 align-self-center">
                              <!--  <h4 class="theme-cl"><i class="fa fa-money"></i> Factures du client</h4> -->
                            </div>
                            <div class="col-md-7 text-right">
                                @if(Auth::user()->role=='Client')
                                @else

                                <div class="btn-group">

                                    <a href="{{ route('factureFormAffaire',[$infoClient[0]->idClient,$affaire->idAffaire]) }}"
                                        class="load btn btn-secondary">
                                        <i class="ti-wand i-cl-5"></i> Créer une facture
                                    </a>

                                </div>
                                @endif
                            </div>

                        </div>
                        <!-- Title & Breadcrumbs-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card padd-15">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <div class="category-filter">
                                            <select id="categoryFilter5" class="categoryFilter5 form-control">
                                                <option value="">Tous</option>
                                                <option value="Créée">Créée(s)</option>
                                               <!-- <option value="Envoyée">Envoyée(s)</option>-->
                                                <option value="Payée">Payée(s)</option>
                                                <option value="En cours de paiement">En cours de paiement</option>
                                                <option value="En retard">En retard</option>
                                                <option value="Annulée">Annulée(s)</option>

                                            </select>
                                        </div>

                                            <table id="filterTable5" class="filterTable5 dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">N°</th>
                                                        <th>Date facture</th>
                                                        <th>Date écheance</th>
                                                        <th>Montant TTC</th>
                                                        <th>Statut</th>
                                                        <th style="width: 50px">Detail</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($factures as $f)
                                                    <tr>
                                                        <td>{{$f->idFacture}}</td>

                                                        <td>
                                                            @if(empty($f->dateFacture))
                                                                <small>N/A</small>
                                                            @else
                                                                {{date('d-m-Y', strtotime($f->dateFacture))}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(empty($f->dateEcheance))
                                                                <small>N/A</small>
                                                            @else
                                                                 {{date('d-m-Y', strtotime($f->dateEcheance))}}</td>

                                                            @endif
                                                        </td>
                                                          <!--  {{date('d-m-Y', strtotime($f->dateEcheance))}}
                                                            {{date('d-m-Y', strtotime($f->dateFacture))}} -->

                                                        <td>{{$f->montantTTC}} {{$f->monnaie}}</td>
                                                        <td class="bg-warning-light" style="text-align:center">
                                                            <span>{{$f->statut}}</span>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <a class="" href="{{route('facture',$f->slug)}}"
                                                                title="Voir la facture" data-toggle="tooltip"><i
                                                                    class="fa fa-arrow-right"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section5">
                        <div class="text-center">
                            <h3>Les temps des affaire</h3>
                        </div>
                        <hr>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section6">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="invoice-table">
                                <div class="row page-breadcrumbs">
                                    <div class="col-md-5 align-self-center">
                                      <!--  <h4 class="theme-cl"><i class="fa fa-file"></i> Pièces du client</h4>-->
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <div class="btn-group">
                                            <a href="#" class="cl-white theme-bg btn btn-default" data-toggle="modal"
                                                data-target="#modal-6"
                                                title="Cliquer pour joindre une pièce à cette affaire">
                                                <i class="fa fa-file"></i> Joindre des pièces
                                            </a>
                                        </div>

                                    </div>
                                </div>

                                @if ($pieceAffaires== '' && $pieceTaches == '' && $pieceAudiences)
                                <h2>Aucune pièce disponible</h2>
                                @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="text-align:center">
                                        <h5>Autres pieces</h5>
                                        <thead>
                                            <tr>
                                                <th>N° de pièce</th>
                                                <th> Nom de la pièce</th>
                                                <th>fichier</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pieceAffaires as $file)
                                            <tr>
                                                <td>{{ $file->idFichier }}</td>
                                                <td>
                                                    <a href="{{route('readFile', [ $file->slug])}}"><span
                                                            style="font-size: 14px; font-weight: bold"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="cliquer pour ouverture le fichier">{{ $file->nomOriginal  }}</span></a>
                                                </td>
                                                <td>
                                                    <a class="load" href="{{route('readFile', [ $file->slug])}}">
                                                        <i class="fa fa-file-pdf-o"
                                                            style="font-size:1.5em; color:red;"></i>
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="{{route('deletePiece',$file->slug)}}" type="button"
                                                        class="btn btn-outline-danger btn-sm"><i
                                                            class="ti-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br />
                                </hr>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="text-align:center">
                                        <h5>Pièces liées aux tâches</h5>
                                        <thead>
                                            <tr>
                                                <th>N° de pièce</th>
                                                <th>tâche</th>
                                                <th>fichier</th>
                                                <!--<th>Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pieceTaches as $file)
                                                <tr>
                                                    <td>{{ $file->idFichier }}</td>
                                                    <td>
                                                        <a href="{{route('infosTask', [ $file->slug])}}"><span
                                                                style="font-size: 14px; font-weight: bold"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="cliquer pour ouverture le fichier">{{ $file->titre  }}</span></a>
                                                    </td>
                                                    <td>
                                                    
                                                        <a class="load" href="{{route('readFile', [ $file->slug_fichiers])}}">
                                                            <i class="fa fa-file-pdf-o"
                                                                style="font-size:1.5em; color:red;"></i>
                                                        </a>
                                                    </td>
                                                    <!--
                                                    <td>
                                                        <a href="{{route('deletePiece',$file->slug)}}" type="button"
                                                            class="btn btn-outline-danger btn-sm"><i
                                                                class="ti-trash"></i></a>
                                                    </td>-->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br />
                                </hr>
                                <!--
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="text-align:center">
                                        <h5>Pièces liées aux audiences</h5>
                                        <thead>
                                            <tr>
                                                <th>N° de pièce</th>
                                                <th>Objet de l'audiences</th>
                                                <th>fichier</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pieceAudiences as $file)
                                            <tr>
                                                <td>{{ $file->idFichier }}</td>
                                                <td>
                                                    <a href="{{route('readFile', [ $file->slug])}}"><span
                                                            style="font-size: 14px; font-weight: bold"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="cliquer pour ouverture le fichier">{{ $file->nomOriginal  }}</span></a>
                                                </td>
                                                <td>
                                                    <a class="load" href="{{route('readFile', [ $file->slug])}}">
                                                        <i class="fa fa-file-pdf-o"
                                                            style="font-size:1.5em; color:red;"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('deletePiece',$file->slug)}}" type="button"
                                                        class="btn btn-outline-danger btn-sm"><i
                                                            class="ti-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>-->

                                @endif
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section7">
                        <div class="text-center">
                            <h3>Les models</h3>
                        </div>
                        <hr>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section8">
                        <div class="text-center">
                            <h3>Les requêtes</h3>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal-tâche -->
<div class="modal modal-box-1 fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="myModalLabel1">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center">Créer une nouvelle tâche</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- page creation-->
                    <div class="row page-breadcrumbs">
                        <div class="col-md-6 text-left">
                            <fieldset class="form-group">
                                <legend>Identité de la tâche</legend>
                                <div class="row mrg-0 text-left">
                                    <div class="form-group form-check">
                                        <label class="custom-control custom-checkbox">
                                            <input id="tacheSimple" name="categorie" type="radio"
                                                class="custom-control-input" checked>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Tâche simple </span>
                                        </label>
                                    </div>
                                    <div class=" form-group form-check">
                                        <label class="custom-control custom-checkbox">
                                            <input id="tacheConditionnelle" name="categorie" type="radio"
                                                class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Tâches conditionnelles /
                                                successives
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 text-left">
                            <div class="col-sm-12" id="rowParente" hidden>
                                <div class="form-group">
                                    <label for="R" class="control-label">Selectionner la tâche parente :</label>
                                    <select class="form-control select2"
                                        data-placeholder="selectionner la tâche parente" style="width: 100%;"
                                        name="idTacheParente" id="idTacheParente">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Title & Breadcrumbs-->
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form method="post" action="{{ route('addTask') }}" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mrg-0">
                                    <input type="text" name="categorie" id="categorie" hidden>
                                    <input type="text" name="idTache" id="parenteTache" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputP" class="control-label">Nom de la tâche :</label>
                                            <input type="text" class="form-control" id="inputP"
                                                placeholder="saisir le nom de la tâche"
                                                data-error=" veillez saisir le nom de la tâche" name="titre" required>
                                            <input type="text" name="type" value="modalTache" hidden>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Type de tâche :</label>

                                            <select class="form-control select2"
                                                data-placeholder="selectionner le client" style="width: 100%;"
                                                name="idTypeTache" id="" required>
                                                <option>Creation de courrier</option>
                                                <option>Creation d'entreprise</option>
                                                <option>Contrats</option>
                                                <option>Autres</option>

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputN" class="control-label">Date début de la tâche :</label>
                                            <input type="date" class="form-control" id="inputN" name="dateDebut"
                                                data-error=" veillez saisir la date début de la tâche" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="datepicker" class="control-label">Date fin de la tâche :</label>
                                            <input type="date" class="form-control" id="datepicker" name="dateFin"
                                                data-error=" veillez saisir la date de fin de la tâche" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Selectionner le client :</label>
                                            <select class="form-control" data-placeholder="selectionner le client"
                                                style="width: 100%;" name="idClient" id="client" required>
                                                @foreach ($infoClient as $client)
                                                <option value="{{ $client->idClient }}" selected>{{ $client->prenom }}
                                                    {{ $client->nom }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="aff" class="control-label">Affaire :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner une affaire" style="width: 100%;"
                                                name="idAffaire" id="aff" required>
                                                <option value="{{ $affaire->idAffaire }}" selected>
                                                    {{ $affaire->nomAffaire }}</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="personne" class="control-label">Assignation de la tâche:</label>
                                            <select multiple="" name="idPersonnel[]" class="form-control select2"
                                                data-placeholder="Selectionner les personnes concernées pour la tâche"
                                                style="width: 100%;" id="personne" data-error="erre" required>

                                                @foreach ($personnels as $personne)
                                                <option value="{{ $personne->id }}">{{ $personne->prenom }}
                                                    {{ $personne->nom }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="desc" class="control-label">Point :</label>
                                            <input type="number" name="point" min="1" class="form-control"
                                                style="height:30px" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="desc" class="control-label">Description de la tâche :</label>
                                            <textarea class="form-control" id="desc" rows="3" name="description"
                                                data-error=" veillez saisir une description de la tâche"
                                                required></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="header-title m-t-0">Joindre les fichiers</h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" class="fichiers form-control" name="filename"
                                                    id="files">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block "
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

<!-- modal-affaire -->
<div class="modal modal-box-2 fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center">Créer une nouvelle affaire</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form class="padd-20" method="post" action="{{ route('storeAffaire') }}">
                                <div class="text-center">
                                    @csrf
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Nom affaire </label>
                                            <input type="text" name="typePost" value="modalAffaire" hidden>
                                            <input type="text" class="form-control" placeholder="nom de l'affaire "
                                                data-error=" veillez saisir le nom de l'affaire" name="nom" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail" class="control-label">Date Ouverture</label>
                                            <input type="date" class="form-control" placeholder="date d'ouverture"
                                                name="dateOuverture" data-error=" veillez saisir la date d'ouverture"
                                                required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select class="form-control" name="idClient" required>
                                                @foreach ($infoClient as $data )
                                                <option value={{ $data->idClient }} selected>{{ $data->prenom }}
                                                    {{ $data->nom }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="type" class="control-label">Type affaire</label>
                                            <select class="form-control" name="type" required
                                                data-error="veuillez renseigner le type de l'affaire">
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                <option value="Contentieux">Contentieux</option>
                                                <option value="Conseil">Conseil</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    @if (sizeof($infoClient) > 0)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                                    style="width:50%;"> Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-affaire -->


<!-- modal-affaire -->
<div class="add-popup modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="deleteAffaire">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
            <div class="modal-header bg-info">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification de l'affaire</h4>
            </div>
            <div class="modal-body">
                <div class="card">
                    <!-- form start -->
                    <form class="" method="post" action="{{ route('updateAffaire', [$affaire->slug]) }}">
                        @csrf

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Nom de l'affaire </label>
                                    <input type="text" value="{{ $affaire->nomAffaire }}" class="form-control"
                                        id="inputPName" placeholder="nom de l'affaire "
                                        data-error=" veillez saisir le nom de l'affaire" name="nomAffaire" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEmail" class="control-label">Date Ouverture</label>
                                    <input type="date" class="form-control" id="inputEmail"
                                        value="{{ $affaire->dateOuverture }}" placeholder="date d'ouverture"
                                        name="dateOuverture" data-error=" veillez saisir la date d'ouverture" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Selectionner le client</label>
                                    <select class="form-control select2" name="idClient" style="width:100%" required
                                        reaonly>

                                        <option value={{ $affaire->idClient }} selected>
                                            {{ $affaire->prenom }}
                                            {{$affaire->nom }}
                                            {{ $affaire->denomination }}
                                        </option>

                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type" class="control-label">Type
                                        affaire</label>
                                    <select class="select2 form-control" id="type" name="type" required
                                        style="width:100%">
                                        <option value="{{ $affaire->type }}" selected>{{ $affaire->type }}</option>
                                        <option value="Contentieux">Contentieux
                                        </option>
                                        <option value="Conseil">Conseil</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-rounded btn-block btn-info"
                                            style="width:50%;"> Enregistrer les modifications</button>
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
<!-- End modal-affaire -->




<!-- modal-Jointure-du-fichier -->
<div class="modal modal-box-1 fade" id="modal-6" tabindex="-1" role="dialog" aria-labelledby="Jointure du fichier"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="Jointure du fichier">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-file"></i> Joignez des pièces à l'affaire</h4>
            </div>
            <div class="modal-body">
                <!-- row -->


                <!-- form start -->
                <form method="post" action="{{ route('addFile') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-12 col-sm-12">

                            <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]"
                                multiple required>
                            <input type="hidden" name="slug" value="{{$affaire->slug}}">


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


                <!-- row -->
            </div>
        </div>
    </div>
</div>
<!-- End modal-Jointure-du-fichier -->

<div class="add-popup modal fade" id="deleteAffaire" tabindex="-1" role="dialog" aria-labelledby="deleteAffaire">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header bg-warning">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"> Confirmez l'annulation</h4>
            </div>
            <div class="modal-body">
                <h5 class="header-title m-t-0 text-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h5>
                <p>Cette action est irreversible , vous perdrez toutes les données liées à cette affaire.</p>
                <p>Voulez-vous vraiment supprimer cette affaire ?</p>
                <div class="row mrg-0">
                    <div class="col-md-12 col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-" data-dismiss="modal" aria-label="Close">
                            NON
                        </a>

                        <a class="load" href="{{ route('deleteAffaire', [$affaire->slug]) }}"
                            class="btn btn-danger">OUI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteCourierDepart" tabindex="-1" role="dialog"
    aria-labelledby="deleteCourierDepart">
    <div class="modal-dialog modal-lg" role="document">
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
            <form method="post" action="{{route('deleteCourierDepart')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment annuler ce courrier ?</p>
                    <input type="hidden" id="slugCourier2" name="slug">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn " data-dismiss="modal" aria-label="Close">
                                NON
                            </a>

                            <button type="submit" class="btn btn-danger">OUI</button>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteCourierArriver" tabindex="-1" role="dialog" aria-labelledby="deleteCourierArriver">
    <div class="modal-dialog modal-lg" role="document">
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
            <form  method="post" action="{{route('deleteCourierArriver')}}" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment annuler ce courrier ?</p>
                    <input type="hidden" id="slugCourier" name="slug">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn " data-dismiss="modal" aria-label="Close">
                                NON
                            </a>

                            <button type="submit" class="btn btn-danger">OUI</button>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    console.warn = () => {};
});
</script>

<script>
// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {

    console.warn = () => {};

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

function changeTab1() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");
    id1.classList.add("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab2() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");
    id1.classList.remove("active");
    id2.classList.add("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab3() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.add("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab4() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.add("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab5() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.add("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab6() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.add("active");
    id7.classList.remove("active");

}

function changeTab7() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.add("active");

}
</script>

<script>
document.getElementById('aff').classList.add('active');
</script>

@endsection