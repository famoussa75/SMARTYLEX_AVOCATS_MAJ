@extends('layouts.base')
@section('title', 'Information du client')
@section('content')
<div class="container-fluid @if (Auth::user()->role=='Client') bg-secondary @else  @endif" style="padding-bottom:20px">
    <div class="row page-breadcrumbs" id="pdfContent">
        <div class="col-md-5">
          
            <div class="col-md-12">
                <div class="">
                    @foreach ($infoClient as $row)
                        
                            @if($row->typeClient == "Client Physique")
                                {{-- Bloc 1 --}}
                              <div class="col-md-12">
                                <h4>{{ $row->idClient }} - {{ $row->prenom }} {{ $row->nom }}</h4>
                              </div>
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        
                                        <p>
                                            <span><strong>Téléphone :</strong> {{ $row->telephone }}</span><br>
                                            <span><strong>E-mail :</strong> {{ $row->email }}</span><br>
                                            <span><strong>E-mail Facture :</strong> {{ $row->emailFacture }}</span><br>
                                            <span><strong>Adresse :</strong> {{ $row->adresse }}</span><br>
                                        </p>
                                    </div>
                                </div>
                            @else
                            <div class="col-md-12  mb-4">
                            <h4><img src="{{ URL::to('/') }}/{{ $row->logo }}" alt="" style="height: 60px;"><br>{{ $row->idClient }} - {{ $row->denomination }} </h4>
                            </div>
                           
                               <div class="row col-md-12">
                                
                                <div class="col-md-6 ">
                                       
                                        <p>
                                            <span><strong>Téléphone :</strong> {{ $row->telephoneEntreprise }}</span><br>
                                            <span><strong>E-mail :</strong> {{ $row->emailEntreprise }}</span><br>
                                            <span><strong>E-mail Facture :</strong> {{ $row->emailFacture }}</span><br>
                                            <span><strong>Adresse :</strong> {{ $row->adresseEntreprise }}</span><br>
                                        </p>
                                    </div>

                                
                                    <div class="col-md-6 ">
                                        <p>
                                        
                                            <span><strong>RCCM :</strong> {{ $row->rccm }}</span><br>
                                            <span><strong>NIF :</strong> {{ $row->nif }}</span><br>
                                            <span><strong>CNSS :</strong> {{ $row->cnss }}</span><br>
                                        </p>
                                    </div>
                               </div>
                               
                                
                            @endif
                        
                    @endforeach
                </div>
            </div>
            
        </div>
        <div class="col-md-7 text-right">
            @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant" )
            <a type="button" href="{{ route('allClient') }}" class="cl-white theme-bg btn btn-rounded">
                <i class="fa fa-navicon"></i> &nbsp;Liste des clients
            </a>
            @else
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;
            @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant" ||
            Auth::user()->role=="Collaborateur" )
            
            <div class="dropdown" style="float: right ;">
                <button class="theme-bg btn dropdown-toggle btn-rounded" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-info-circle"></i> Options
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">

                    <a class="load dropdown-item " href="#" data-toggle="modal" data-target="#updateClient"><i
                            class="ti-pencil-alt mr-2"></i>Editer</a>

                    <a class="load dropdown-item" href="#" data-toggle="modal" data-target="#deleteClient"
                        style="color:red"><i class="ti-close mr-2"></i>Supprimer</a>

                        <div class="dropdown-item text-center">
                                <button class="btn btn-sm btn-primary hidden-print" onclick="exportDivToPDF2()">
                                    <i class="ti-download mr-1"></i> Télécharger PDF
                                </button>
                            </div> 

                </div>


            </div>
            @endif
        </div>

    </div>


    <div class=" col-md-12 col-sm-12" >
        <div class="card">

        <div class="tab" role="tabpanel">


            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class=" @if(Auth::user()->role=='Client')  @else active @endif "
                    onclick="changeTab1()" id="t1"><a href="#Section2" role="tab" data-toggle="tab" class="theme-cl"
                        @if(Auth::user()->role=='Client') hidden @else @endif > <i class="fa fa-file"></i> Tâches</a>
                </li>
                <li role="presentation" class="@if(Auth::user()->role=='Client') active @else  @endif"
                    onclick="changeTab2()" id="t2"><a href="#Section3" role="tab" data-toggle="tab" class="theme-cl"> <i
                            class="fa fa-trello"></i> Affaires</a></li>
                <li role="presentation" class="" onclick="changeTab3()" id="t3"><a href="#Section4" role="tab"
                        data-toggle="tab" class="theme-cl" @if(Auth::user()->role=='Client') hidden @else @endif > <i
                            class="fa fa-envelope"></i> Courriers</a></li>
                <li role="presentation" class="" onclick="changeTab4()" id="t4"><a href="#Section5" role="tab"
                        data-toggle="tab" class="theme-cl"> <i class="fa fa-balance-scale"></i> Procédures</a></li>
                <li role="presentation" class="" onclick="changeTab6()" id="t6"><a href="#Section7" role="tab"
                        data-toggle="tab" class="theme-cl"> <i class="ti i-cl-0 fa fa-money"></i> Factures</a></li>
                <li role="presentation" class="" onclick="changeTab5()" id="t5"><a href="#Section6" role="tab"
                        data-toggle="tab" class="theme-cl" @if(Auth::user()->role=='Client') hidden @else @endif > <i
                            class="fa fa-users"></i> Employés</a></li>
                <li role="presentation" class="" onclick="changeTab7()" id="t7"><a href="#Section8" role="tab"
                        data-toggle="tab" class="theme-cl"> <i class="ti i-cl-0 fa fa-book"></i> Contacts</a></li>
            </ul>

            <div class="tab-content tabs" id="home">
                <div role="tabpanel" class="tab-pane fade in  @if(Auth::user()->role=='Client') @else active @endif "
                    id="Section2">
                    
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                          <!--   <h4 class="theme-cl"><i class="fa fa-file"></i> Tâche du client</h4>-->
                        </div>
                        @if(Auth::user()->role=="Administrateur")
                        <div class="col-md-7 text-right">
                            <div class="btn-group">
                                <a href="{{ route('allTasks') }}" class="load btn btn-secondary">
                                    <i class="fa fa-eye ti i-cl-5"></i> &nbsp;Voir les tâches
                                </a>
                            </div>
                            @foreach ($infoClient as $row)
                            <div class="btn-group">
                                <a href="{{ route('taskForm', [$infoClient[0]->idClient,'client']) }}"
                                    class="load btn btn-secondary">
                                    <i class="ti-wand i-cl-4"></i> &nbsp;Créer une tâche
                                </a>
                            </div>
                            @endforeach
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
                                            <select id="categoryFilter5" class="categoryFilter5 form-control">
                                                <option value="">Tous</option>
                                                <option value="validée">Validée</option>
                                                <option value="En cours">En cours</option>
                                                <option value="suspendu">Suspendu</option>
                                                <option value="Hors Délais">Hors Délais</option>

                                            </select>
                                        </div>
                                        <table id="filterTable5" class="filterTable5 dataTableExport table table-bordered table-hover" style="width:100%">
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
                                                @foreach($tacheClient as $row)
                                                <tr>
                                                    <td>
                                                        {{ $row->idTache }}
                                                    </td>
                                                    <td><a class="load" href="{{ route('infosTask', [$row->slug]) }}">
                                                            {{ $row->titre }}</a></td>
                                                    <td>{{ $row->description }}</td>

                                                    @if(empty($row->dateDebut))
                                                        <small>N/A</small>
                                                    @else
                                                        <td>{{ date('d-m-Y', strtotime($row->dateDebut)) }}</td>
                                                    @endif
                                                    @if(empty($row->dateFin))
                                                        <small>N/A</small>
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
                                                        <a class="load" href="{{ route('infosTask', [$row->slug]) }}"
                                                            class="settings" title="Information"
                                                            data-toggle="tooltip"><i class="fa fa-info-circle"></i></a>
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
                <div role="tabpanel" class="tab-pane fade in @if(Auth::user()->role=='Client') active @else  @endif"
                    id="Section3">
                   
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                            <!--  <h4 class="theme-cl"><i class="fa fa-suitcase"></i> @if(Auth::user()->role=='Client') Mes
                                affaires @else Affaires du client @endif</h4>-->
                        </div>
                        @if(Auth::user()->role=='Client')
                        @else
                        <div class="col-md-7 text-right">
                            <div class="btn-group">
                                <a href="{{ route('allAfaires') }}" class="load btn btn-secondary">
                                    <i class="fa fa-eye ti i-cl-5"></i> &nbsp;Voir les affaires
                                </a>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modal-2">
                                    <i class="ti-wand i-cl-6"></i> &nbsp;Créer une affaire pour ce
                                    client
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- Title & Breadcrumbs-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card padd-15">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        
                                        <table id="" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nom affaire</th>
                                                    <th>Type</th>
                                                    <th>Date Ouverture</th>
                                                    <!--<th>Statut</th>-->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($affaireClient as $row)
                                                <tr>
                                                    <td>
                                                        {{ $row->idAffaire }}
                                                    </td>
                                                    <td>
                                                        @if(Auth::user()->role=='Client')
                                                        {{ $row->nomAffaire }}
                                                        @else
                                                        <a class="load"
                                                            href="{{ route('showAffaire', [$row->idAffaire,$row->slug]) }}">
                                                            {{ $row->nomAffaire }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $row->type }}</td>
                                                    @if(empty($row->dateOuverture))
                                                        <small>N/A</small>
                                                    @else
                                                        <td>{{ date('d-m-Y', strtotime($row->dateOuverture)) }}</td>
                                                    @endif
                                                   <!-- <td>{{ date('d-m-Y', strtotime($row->dateOuverture)) }}</td> -->
                                                    <!--<td>
                                                        <div class="label cl-success bg-success-light">
                                                            {{ $row->etat }}
                                                        </div>
                                                    </td>-->
                                                    <td>
                                                        @if(Auth::user()->role=='Client')

                                                        @else
                                                        <a class="load"
                                                            href="{{ route('showAffaire', [$row->idAffaire,$row->slug]) }}"
                                                            class="settings" title="Information"
                                                            data-toggle="tooltip"><i class="fa fa-info-circle"></i>
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
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="Section4">
                    <!-- Title & Breadcrumbs-->
                    <div class="row page-breadcrumbs">
                        <div class="col-md-3 align-self-center">
                          <!--   <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers du client</h4>-->
                        </div>
                        @if(Auth::user()->role=="Collaborateur")
                        @else
                        <div class="col-md-9 text-right">
                            <div class="btn-group">
                                <a href="{{ route('allCouriers') }}" class="load btn btn-secondary">
                                    <i class="ti-eye i-cl-4"></i> Voir les courriers
                                </a>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modal-5">
                                    <i class="ti-wand i-cl-6"></i> Créer un Courrier - Arrivé
                                </a>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modal-3">
                                    <i class="ti-wand i-cl-3"></i> Créer un courrier - Départ
                                </a>
                            </div>
                        </div>
                        @endif
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
                                                            <select id="categoryFilter4" class="categoryFilter4 form-control">
                                                                <option value="">Tous</option>
                                                                <option value="Reçu">Reçu</option>
                                                                <option value="Lu">Lu</option>
                                                                <option value="En Traitement">En traitement</option>
                                                                <option value="Traité">Traité</option>
                                                                <option value="Classé">Classé</option>
                                                                <option value="Annulé">Annulé</option>

                                                            </select>
                                                        </div>
                                                            
                                                            
                                                            <table id="filterTable4" class="filterTable4 dataTableExport table table-bordered table-hover"
                                                                    style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10px;">N°</th>
                                                                        <th>Expéditeur</th>
                                                                        <th style="width: 100px;">Date du courrier</th>
                                                                        <th>Objet</th>
                                                                        <th>Statut</th>
                                                                        <th style="width: 100px;text-align:center">Voir
                                                                            / Suppr</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @foreach($courierArriverClient as $row)

                                                                    @if($row->confidentialite=='on' &&
                                                                    Auth::user()->role!='Administrateur')
                                                                    <tr class="bg-warning-light">
                                                                        <td style="font-style:italic">{{ $row->numero }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:center ;font-style:italic">
                                                                            <span>Confidentiel</span></td>
                                                                        <td
                                                                            style="text-align:center ;font-style:italic">
                                                                            <span>Confidentiel</span></td>
                                                                        <td
                                                                            style="text-align:center ;font-style:italic">
                                                                            <span>Confidentiel</span></td>
                                                                        <td
                                                                            style="text-align:center ;font-style:italic">
                                                                            <span>Confidentiel</span></td>
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
                                                                            @if(empty($row->dateCourier))
                                                                                <small>N/A</small>
                                                                            @else
                                                                                {{ date('d-m-Y', strtotime($row->dateCourier))}}
                                                                            @endif
                                                                            
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
                                                                            @elseif($row->statut=='Traitement annulé')
                                                                            <div class="label bg-danger">
                                                                                {{ $row->statut }}</div>
                                                                            @else
                                                                            <div class="label bg-success">
                                                                                {{ $row->statut }}</div>
                                                                            @endif
                                                                        </td>
                                                                        @if($row->statut=='Annulé')
                                                                        <td style="text-align: center;">
                                                                            <a href="{{ route('detailCourierArriver', [$row->slug]) }}"
                                                                                title="Information"
                                                                                data-toggle="tooltip"><i
                                                                                    class="fa fa-arrow-right"></i></a>
                                                                           
                                                                        </td>
                                                                        @else
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
                                                                        @endif
                                                                        
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
                                                    data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
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
                                                                    <select id="categoryFilter3" class="categoryFilter3 form-control">
                                                                        <option value="">Tous</option>
                                                                        <option value="Transmis">Transmis</option>
                                                                        <option value="Approuvé">Approuvé</option>
                                                                        <option value="Désapprouvé">Désapprouvé</option>
                                                                        <option value="Terminé">Terminé</option>
                                                                        <option value="Annulé">Annulé</option>

                                                                    </select>
                                                                </div>
                                                                   
                                                                    <table id="filterTable3"
                                                                        class="filterTable3 dataTableExport table table-bordered table-hover"
                                                                        style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 10px;">N°</th>
                                                                                <th style="width: 100px;">Date du
                                                                                    courrier</th>
                                                                                <th>Destinataire</th>
                                                                                <th>Objet</th>
                                                                                <th>Statut</th>
                                                                                <th style="text-align: center;">Voir /
                                                                                    Suppr</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            @foreach($courierDepartClient as $row)
                                                                            @if($row->statut=='Annulé')
                                                                            <tr class="bg-danger-light">
                                                                                <td>
                                                                                    {{ $row->numCourier }}
                                                                                </td>

                                                                                <td>
                                                                                    @if(empty($row->dateCourier))
                                                                                    <small>N/A</small>
                                                                                    @else
                                                                                         {{ date('d-m-Y', strtotime($row->dateCourier)) }}
                                                                                    @endif
                                                                                  
                                                                                </td>
                                                                                <td style="text-align:center ;">

                                                                                    <span class="pull-right-container">
                                                                                        <small class="label"
                                                                                            style="color:black">{{ $row->destinataire }}</small>
                                                                                    </span>

                                                                                </td>
                                                                                <td><a href="#">{{ $row->objet }}</td>
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
                                                                                    @if(empty($row->dateCourier))
                                                                                        <small>N/A</small>
                                                                                    @else
                                                                                        {{ date('d-m-Y', strtotime($row->dateCourier))}}
                                                                                    @endif
                                                                                   <!-- {{ date('d-m-Y', strtotime($row->dateCourier))}} -->
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
                                                                                                {{ $row->statut }}</div>
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
                </div>
                <div role="tabpanel" class="tab-pane fade" id="Section5">
                    <!-- Title & Breadcrumbs-->
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                          <!--  <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> @if(Auth::user()->role=='Client')
                                Mes audiences @else Audiences du client @endif</h4> -->
                        </div>
                        <div class="col-md-7 text-right">
                            @if(Auth::user()->role=='Client')
                            @else

                            <div class="btn-group">
                                <a href="{{ route('listAudience', 'generale') }}" class="load btn btn-secondary">
                                    <i class="ti-eye i-cl-8"></i> Voir les audiences
                                </a>
                            </div>
                            <div class="btn-group">

                                <a href="{{ route('addAudience') }}" class="load btn btn-secondary">
                                    <i class="ti-wand i-cl-5"></i> Créer une audience
                                </a>

                            </div>
                            @endif

                        </div>
                    </div>
                    
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
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="table-responsive">
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
                                                                        $dateAudience= $row['prochaineAudience'];
                                                                    @endphp

                                                                    @if (empty($dateAudience) || $dateAudience == 'N/A')
                                                                        N/A
                                                                    @else
                                                                        @if (strtotime($dateAudience) < strtotime(date('Y-m-d')))
                                                                            <span class="label bg-danger">suivi incomplet</span>
                                                                        @else
                                                                            {{ date('d/m/Y', strtotime($dateAudience)) }}
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
                                                                       <!-- {{ date('d/m/Y', strtotime($row->dateRequete)) }}-->
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
                </div>
                <div role="tabpanel" class="tab-pane fade" id="Section7">
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                          <!--  <h4 class="theme-cl"><i class="fa fa-money"></i> @if(Auth::user()->role=='Client') Mes
                                factures @else Factures du client @endif</h4>  -->
                        </div>
                        <div class="col-md-7 text-right">
                            @if(Auth::user()->role=='Client')
                            @else

                            <div class="btn-group">

                                <a href="{{ route('factureFormClient',[$infoClient[0]->idClient]) }}"
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
                                            <select id="categoryFilter6" class="categoryFilter6 form-control">
                                                <option value="">Tous</option>
                                                <option value="Créée">Créée(s)</option>
                                                <!--<option value="Envoyée">Envoyée(s)</option>-->
                                                <option value="Payée">Payée(s)</option>
                                                <option value="En cours de paiement">En cours de paiement</option>
                                                <option value="En retard">En retard</option>
                                                <option value="Annulée">Annulée(s)</option>

                                            </select>
                                        </div>
                                        <table id="filterTable6"
                                            class="filterTable6 dataTableExport table table-bordered table-hover"
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
                                                       <!--  {{date('d-m-Y', strtotime($f->dateFacture))}}-->
                                                    </td>
                                                    <td>
                                                        @if(empty($f->dateEcheance))
                                                            <small>N/A</small>
                                                        @else
                                                            {{date('d-m-Y', strtotime($f->dateEcheance))}}
                                                        @endif
                                                        <!-- {{date('d-m-Y', strtotime($f->dateEcheance))}}-->
                                                    </td>

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
                <div role="tabpanel" class="tab-pane fade" id="Section6">
                    <!-- Title & Breadcrumbs-->
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                          <!--  <h4 class="theme-cl"><i class="fa fa-users"></i> Employés du client</h4> -->
                        </div>
                        <div class="col-md-7 text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#importData">
                                    <i class=" ti-import i-cl-4"></i> Importer une base
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Title & Breadcrumbs-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card padd-15">
                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table id=""
                                            class="filterTable dataTableExport table table-bordered table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>N° Ordre</th>
                                                    <th>N° Matricule</th>
                                                    <th>Prenom & nom</th>
                                                    <th>Telephone</th>
                                                    <th>Residence</th>
                                                    <th>Durée du contrat</th>
                                                    <th style="text-align: center;">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($personnelClient as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $row->matricule }}</td>
                                                    <td><a
                                                            href="{{route('infoPersonnelClient',$row->slug)}}">{{ $row->prenomEtNom }}</a>
                                                    </td>
                                                    <td>{{ $row->telephone }}</td>
                                                    <td>{{ $row->residence }}</td>
                                                    <td>{{ $row->dureeContrat }}</td>
                                                    <td style="text-align: center;">
                                                        <a class="load"
                                                            href="{{route('infoPersonnelClient',$row->slug)}}"
                                                            class="show-more" data-toggle="tooltip" title=""><i
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
                </div>

                <div role="tabpanel" class="tab-pane fade" id="Section8">
                    <!-- Title & Breadcrumbs-->
                    <div class="row page-breadcrumbs">
                        <div class="col-md-5 align-self-center">
                         <!--   <h4 class="theme-cl"><i class="fa fa-book"></i> Contacts liés au client</h4> -->
                        </div>
                        <div class="col-md-7 text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modal-3">
                                    <i class="i-cl-6 fa fa-plus"></i> &nbsp;Ajouter un contact
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Title & Breadcrumbs-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card padd-15">
                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table  class="filterTable dataTableExport table table-bordered table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Societe/Client</th>
                                                    <th>Prenoms & Noms</th>
                                                    <th>Position</th>
                                                    <th>Telephone</th>
                                                    <th>Email</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($annuaires as $row)
                                                <tr>
                                                    <td>{{ $row->id }}</td>
                                                    <td>{{ $row->societe }}</td>
                                                    <td>{{ $row->prenom_et_nom }}</td>
                                                    <td>{{ $row->poste_de_responsabilite }}</td>
                                                    <td>{{ $row->telephone }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td><a href="" data-toggle="modal" id="{{ $row->id }}"
                                                            data-target="#updateContact"
                                                            onclick="var id= this.id ; updateContact(id)"><i
                                                                class="fa fa-pencil" style="color:dodgerblue ;"></i></a>
                                                        <a href="" data-toggle="modal" id="{{ $row->id }}"
                                                            data-target="#deleteContact"
                                                            onclick="var id= this.id ; deleteContact(id)"><i
                                                                class="fa fa-trash" style="color:brown ;"></i></a>

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

    </div>
</div>



<!-- modal-affaire -->
<div class="add-popup modal fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="modal-2">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
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
                            <form class="padd-20" method="post" action="{{ route('storeAffaire') }}"
                                enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Nom affaire </label>
                                            <input type="text" name="typePost" value="modalAffaire" hidden>
                                            <input type="text" class="form-control" id="inputPName"
                                                placeholder="nom de l'affaire "
                                                data-error=" veillez saisir le nom de l'affaire" name="nom" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail" class="control-label">Date Ouverture</label>
                                            <input type="date" class="form-control" id="inputEmail"
                                                placeholder="date d'ouverture" name="dateOuverture"
                                                data-error=" veillez saisir la date d'ouverture" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select class="form-control select2" name="idClient" required
                                                style="width:100%">
                                                @foreach ($infoClient as $data )
                                                <option value={{ $data->idClient }} selected>{{ $data->prenom }}
                                                    {{ $data->nom }} {{ $data->denomination }}
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
                                            <select class="form-control select2" id="type" name="type" required
                                                style="width:100%">
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                <option value="Contentieux">Contentieux</option>
                                                <option value="Conseil">Conseil</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="type" class="control-label">Piece(s) jointe(s) ( Facultatif
                                                )</label>
                                            <input type="file" class="fichiers form-control" name="fichiers[]" multiple>
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

<div class="add-popup modal fade" id="modal-3" tabindex="-1" role="dialog" aria-labelledby="modal-3">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-plus"></i> Nouveau contact</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form method="post" action="{{route('contact.create')}}" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mrg-0">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="description">Société/Client</label>
                                                    <input type="text" class="form-control" name="societe" value="{{ $infoClient[0]->prenom }} {{ $infoClient[0]->nom }} {{ $infoClient[0]->denomination }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Prénom et Nom</label>
                                                    <input type="text" class="form-control" name="prenom_et_nom"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Position</label>
                                                    <input type="text" class="form-control"
                                                        name="poste_de_responsabilite">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Téléphone</label>
                                                    <input type="text" class="form-control" name="telephone" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Email</label>
                                                    <input type="email" class="form-control" name="email" required>
                                                </div>
                                                <input type="hidden" name="idClient"
                                                    value="{{$infoClient[0]->idClient}}">

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

<div class="add-popup modal fade" id="updateContact" tabindex="-1" role="dialog" aria-labelledby="updateContact">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification du contact</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('contact.update')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Société/Client</label>
                                        <input type="text" class="form-control" name="societe" id="societeContact">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Prénom et Nom</label>
                                        <input type="text" class="form-control" name="prenom_et_nom"
                                            id="prenom_et_nomContact" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Position</label>
                                        <input type="text" class="form-control" name="poste_de_responsabilite"
                                            id="poste_de_responsabiliteContact">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Téléphone(s)</label>
                                        <input type="text" class="form-control" name="telephone" id="telephoneContact">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="email" class="form-control" name="email" id="emailContact"
                                            required>
                                    </div>
                                    <input type="hidden" name="idContact" id="idContact">

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

<div class="add-popup modal fade" id="deleteContact" tabindex="-1" role="dialog" aria-labelledby="deleteContact">
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
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez la suppression</h4>
            </div>
            <form method="post" action="{{route('contact.delete')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment supprimer ce contact du systeme ?</p>
                    <input type="hidden" id="idContactDelete" name="idContact">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal"
                                aria-label="Close">
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
<!-- End modal-affaire -->
<!-- modal-courier-depart -->
<div class="add-popup modal fade" id="modal-3" tabindex="-1" role="dialog" aria-labelledby="courier depart">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="courier depart">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-envelope"></i> Créer un Courriers - Départ</h4>
            </div>
            <div class="modal-body">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">

                        <div class="card-body">
                            <div class="col-md-12 col-sm-12">



                                <form class="padd-20" method="post" action=" {{ route('storeCourierDepart') }}"
                                    enctype="multipart/form-data">
                                    <div class="text-center">
                                        @csrf
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Destinataire :</label>
                                                <input type="text" class="form-control" id="inputPName" placeholder=""
                                                    data-error=" veillez saisir le nom du destinataire"
                                                    name="destinataire" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputEmail" class="control-label">Date du courrier :</label>
                                                <input type="date" class="form-control" id="inputEmail"
                                                    name="dateCourier" data-error=" veillez saisir la date du courrier"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Projet préparé par :</label>
                                                <select class="form-control select2" name="idPersonnel" id="preparant">
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach ($personnels as $row)
                                                    <option value={{ $row->idPersonnel }}>{{ $row->prenom }}
                                                        {{ $row->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Objet : </label>
                                                <textarea class="form-control" id="desc" rows="1" name="objet"
                                                    data-error=" veillez saisir l'objet du courrier"
                                                    required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label>Selectionner le client</label>
                                                <select class="form-control select2" name="idClient" id="client">
                                                    @foreach ($infoClient as $client)
                                                    <option value={{ $client->idClient }} selected>
                                                        {{ $client->prenom }}
                                                        {{ $client->nom }} {{ $client->denomination }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">N° du courrier : </label>
                                                <input type="number" name="idCourier" class="form-control"
                                                    value="{{$idCourier}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="affaireContent">
                                        <input type="text" id="typeContent" value="audience" name="typeContent" hidden>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="affaire" class="control-label">Affaire
                                                    du client concernés :</label>
                                                <select class="form-control select2"
                                                    data-placeholder="Affaire du client concerné" style="width: 100%;"
                                                    name="idAffaire" id="affaireClient" required>
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach ($affaireClient as $row)
                                                    <option value="{{ $row->idAffaire }}">{{ $row->nomAffaire }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="card-actions icons right-top">
                                                <li>
                                                    <a href="javascript:void(0)" class="text-white" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <h4 class="modal-title">Joindre la pièce</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="alert alert-success alert-dismissable">
                                                    <div class="text-center">
                                                        <span id="initPersonne">Ceci est le N° du document : <h3
                                                                style="font-family: 'Times New Roman', Times, serif;">
                                                                {{ $idCourier }}
                                                            </h3> </span>
                                                    </div>
                                                </div>
                                                <input type="text" value="{{ $idCourier }}" name="idCourier" hidden>
                                                <label for="">Fichier</label>
                                                <input type="file" class="fichiers form-control" name="fichiers[]"
                                                    multiple id="files" required>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-12">
                                            <button type="submit"
                                                class="btn btn-rounded btn-block ">Enregistrer</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</div>
<!-- End modal-courier-depart -->

<!-- modal-courier-arriver -->
<div class="add-popup modal fade" id="modal-5" tabindex="-1" role="dialog" aria-labelledby="courier arriver">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="courier arriver">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-envelope"></i> Créer un courier arrivé</h4>
            </div>
            <div class="modal-body">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form method="post" action=" {{ route('storeCourierArriver')}}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPN" class="control-label">Expéditeur :</label>
                                            <input type="text" class="form-control" id="inputPN"
                                                placeholder="nom de l'expéditeur "
                                                data-error=" veillez saisir le nom expéditeur" name="expediteur"
                                                required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputEmail" class="control-label">Date du courrier :</label>
                                            <input type="date" class="form-control" id="inputEmail" name="dateCourier"
                                                data-error=" veillez saisir la date du courrier" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputEmail" class="control-label">Date arriver :</label>
                                            <input type="date" class="form-control" id="inputEmail" name="dateArriver"
                                                data-error=" veillez saisir la date arriver du courrier" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">N° ordre :</label>
                                            <input type="text" class="form-control" id="inputPName" name="numero"
                                                value="{{ $numero }}" readOnly>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">

                                        <div class="form-group">
                                            <label for="clients" class="control-label">Selectionner le client :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner le client" style="width: 100%;"
                                                name="idClient" id="clients" required>
                                                @foreach ($infoClient as $client)
                                                <option value="{{ $client->idClient }}" selected>{{ $client->prenom }}
                                                    {{ $client->nom }} {{ $client->denomination }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Objet : </label>
                                            <textarea class="form-control" id="desc" rows="3" name="objet"
                                                data-error=" veillez saisir objet du courrier" required></textarea>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row mrg-0" id="affaireContent">
                                    <input type="text" id="typeContent" value="courier arriver" name="typeContent"
                                        hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="af" class="control-label">selectionner une affaire :</label>
                                            <select class="form-control select2"
                                                data-placeholder="selectionner une affaire" style="width: 100%;"
                                                name="idAffaire" id="af" required>
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                @foreach ($affaireClient as $row)
                                                <option value="{{ $row->idAffaire }}">{{ $row->nomAffaire }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="header-title m-t-0">Joindre la Pièce</h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" class="fichiers form-control" name="fichiers[]"
                                                    multiple id="files"
                                                    accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                            style="width:50%;"> Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</div>
<!-- End modal-courier-arriver -->


<div class="add-popup modal fade" id="updateClient" tabindex="-1" role="dialog" aria-labelledby="updateClient">
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
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification du client</h4>
            </div>
            <div class="modal-body">
                <div class="card">
                    <!-- form start -->
                    @foreach ( $infoClient as $client )
                    @if($client->typeClient =="Client Physique")
                    <form class="padd-20" method="post" action="{{ route('updateClient', [$client->slug]) }}">
                        <div class="text-center">
                            <h2>Client Physique (Personne) </h2>
                            <br>
                            @csrf
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Prénom</label>
                                    <input type="text" class="form-control" id="inputPName" placeholder="prenom"
                                        name="prenom" value="{{$client->prenom}}" placeholderrequired>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">Nom</label>
                                    <input type="text" class="form-control" id="inputName" placeholder="nom"
                                        value="{{$client->nom}}" name="nom" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEmail" class="control-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" placeholder="email"
                                        name="email" value="{{$client->email}}"
                                        data-error="Cette saisie est invalide, veillez saisir une adresse email valide"
                                        required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputTelephone" class="control-label">Email de facture</label><br>
                                    <input type="email" class="form-control" name="emailFacture"
                                        value="{{ $client->emailFacture }}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputadresse" class="control-label">Adresse</label>
                                    <input type="text" class="form-control" id="inputadresse" placeholder="adresse"
                                        value="{{$client->adresse}}" name="adresse" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputTelephone" class="control-label">Téléphone</label><br>
                                    <input type="text" class="form-control phone" id="inputTelephone"
                                        placeholder="téléphone" value="{{ $client->telephone }}" name="telephone"
                                        required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                          
                            <div class="col-sm-6" hidden>
                                <div class="form-group">
                                    <label for="typeClient" class="control-label">Type Client</label>
                                    <select class="form-control" id="typeClient" name="typeClient">
                                        <option value="Client Physique" selected>Client Physique (Personne)</option>
                                    </select>
                                </div>
                            </div>

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
                    @elseif ($client->typeClient == "Client Moral")
                    <form class="padd-20" method="post" action="{{ route('updateClient', [$client->slug]) }}"
                        enctype="multipart/form-data">
                        <div class="text-center">
                            <h2>Client Moral (Entreprise)</h2>
                            <br>
                            @csrf
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="entreprise" class="control-label">Dénomination</label>
                                    <input type="text" class="form-control" name="denomination"
                                        value="{{ $client->denomination }}" id="entreprise" placeholder="nom entreprise"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSt" class="control-label">RCCM de l'entreprise</label>
                                    <input type="text" class="form-control" id="inputSt" value="{{ $client->rccm }}"
                                        name="rccm" placeholder="RCCM de l'entreprise" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="entreprise" class="control-label">Capital social</label>
                                    <input type="number" class="form-control" name="capitalSocial"
                                        value="{{ $client->capitalSocial }}" id="entreprise"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputs" class="control-label">Adresse de l'entreprise</label>
                                    <input type="text" class="form-control" value="{{ $client->adresseEntreprise }}"
                                        name="adresseEntreprise" id="inputs" placeholder="adresse entreprise" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="entreprise" class="control-label">NIF</label>
                                    <input type="text" class="form-control" name="nif"
                                        value="{{ $client->nif }}" id="entreprise"
                                        placeholder="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputs" class="control-label">CNSS</label>
                                    <input type="text" class="form-control" value="{{ $client->cnss }}"
                                        name="cnss" id="inputs" placeholder="adresse entreprise" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSta" class="control-label">Email de contact</label>
                                    <input type="email" class="form-control" value="{{ $client->emailEntreprise }}"
                                        name="emailEntreprise" id="inputSta" placeholder="email entreprise"
                                        data-error="cette adresse email de l'entreprise est invalid" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputTelephone" class="control-label">Email de facturation</label><br>
                                    <input type="email" class="form-control" name="emailFacture"
                                        value="{{ $client->emailFacture }}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            
                          
                            <div class="col-sm-6" hidden>
                                <div class="form-group">
                                    <label for="typeClient" class="control-label">Type Client</label>
                                    <select class="form-control" id="typeClient" name="typeClient">
                                        <option value="Client Moral" selected>Client Moral (Entreprise)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputAd" class="control-label">Téléphone entreprise</label><br>
                                    <input type="text" class="form-control phone"
                                        value="{{ $client->telephoneEntreprise }}" name="telephoneEntreprise"
                                        id="inputAd" placeholder="téléphone entreprise" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type" class="control-label">Logo du client ( Facultatif )</label>
                                    <input type="file" class="fichiers form-control" name="logo" accept="image/*">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h2 class="text-center">Représentant</h2>
                        @foreach ($representant as $info)

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEmailR" class="control-label">Prénom</label>
                                    <input type="text" class="form-control" value="{{ $info->prenom }}" name="prenom"
                                        id="inputEmailR" placeholder="prénom répresentant" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEs" class="control-label">Nom</label>
                                    <input type="text" class="form-control" id="inputEs" value="{{ $info->nom }}"
                                        name="nom" placeholder="nom répresentant" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $info->email }}"
                                        id="inputM" placeholder="email répresentant"
                                        data-error="cette adresse email est invalid" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputA" class="control-label">Téléphone</label>
                                    <input type="text" class="form-control" id="inputA"
                                        placeholder="téléphone répresentant" value="{{ $info->telephone }}"
                                        name="telephone" required>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                        style="width:50%;"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @endif
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <span>&nbsp;&nbsp;</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteClient" tabindex="-1" role="dialog" aria-labelledby="deleteClient">
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
                <p>Cette action est irreversible , vous perdrez toutes les données liées à ce client.</p>
                <p>Voulez-vous vraiment supprimer ce client ?</p>

                <div class="row mrg-0">
                    <div class="col-md-12 col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                            NON
                        </a>
                        @foreach ($infoClient as $row)
                        <a href="{{ route('deleteClient', [$row->slug]) }}" class="btn btn-danger">OUI</a>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- modal-affaire -->
<div class="add-popup modal fade" id="importData" tabindex="-1" role="dialog" aria-labelledby="importData">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class=" ti-import"></i> Importer une base des Employés</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form class="padd-20" method="post" action="{{ route('importEmployeeData') }}"
                                enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <h5><i class="fa fa-info-circle"></i> Instructions :</h5>
                                        <p><b>1.</b> Telechargez le format appropié du fichier <b>EXCEL</b> pour la base
                                            de donnée. <a href="{{URL::to('/')}}/assets/format_database/employees.xlsx"
                                                download="employees.xlsx"><i class="fa fa-download"></i> Telecharger le
                                                format ici </a></p>
                                        <p><b>2.</b> Importez la base de données <b>EXCEL</b> après avoir remplis la
                                            liste des Employés du client en respectant le format.</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="number" value="{{$infoClient[0]->idClient}}" name="idClient"
                                                hidden>
                                            <label for="" class="label-control"> Importer le fichier ici</label>
                                            <input type="file" accept=".xls,.xlsx," class="fichiers form-control"
                                                name="fichiers" required>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-rounded btn-block "
                                                    style="width:50%;"><i class=" ti-import"></i> Importer</button>
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
    id7.classList.remove("active");
    id6.classList.add("active");


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
document.getElementById('clt').classList.add('active');
</script>
@endsection