@extends('layouts.base')
@section('title', 'Information')
@section('content')
<div class="container-fluid">
    @foreach ($personnel as $person)
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-user"></i> RH > <span class="label bg-info"><b>Profil utilisateur</b></span></h4>
        </div>
        @if(Auth::user()->role=='Administrateur')
        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a href="{{ route('allPersonnel') }}" class="cl-white theme-bg btn btn-rounded"
                    title="Enregistrer un personnel">
                    <i class="fa fa-navicon"></i>
                    Liste du personnel
                </a>
            </div>
        </div>
        @else
        @endif
    </div>
    <!-- Title & Breadcrumbs-->

    <!-- row -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-img-overlap" style="text-align:center">
                    @if(Session::has('cabinetLogo'))
                    @foreach (Session::get('cabinetLogo') as $logo)
                    <img src="{{URL::to('/')}}/{{$logo->logo}}" class="" alt="Logo Icon" style="height:150px">

                    @endforeach
                    @endif
                </div>
                <div class="card-detail-block padd-0 translateY-50 text-center  mrg-bot-0">
                    <div class="card-avatar style-2">
                        <img src="/{{$person->photo}}" class="img-circle img-responsive" alt="" style="width: auto; height: 80px; object-fit: cover;"/>
                    </div>
                    <h5 class="font-normal mrg-bot-0 font-18 card-block-title">{{ $person->prenom }} {{ $person->nom }}
                    </h5>
                    <p class="card-small-text mrg-bot-0"><a href="#" class="__cf_email__"
                            data-cfemail="81e5e0efe8e4edc1e4f9f1e4f3f5e5e4f2e8e6efe4f3afe2eeec">[&#160;{{ $person->fonction }}]</a>
                    </p>

                </div>

            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-8">
            <div class="card card-body" style="height:290px">

                <div class="card-detail-block">


                    <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Matricule :</b>
                        <span class="card-small-text"> &#160;{{ $person->matricules }} </span>
                    </p>
                    <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Initial :</b>
                        <span class="card-small-text"> &#160;{{ $person->initialPersonnel }} </span>
                    </p>
                    <div class="flex-box">
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Adresse :</b>
                            <span class="card-small-text"> &#160;{{ $person->adresse }} </span>
                        </p>
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Email :</b>
                            <span class="card-small-text"> &#160;{{ $person->email }} </span>
                        </p>
                    </div>
                    <div class="flex-box">
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Telephone :</b>
                            <span class="card-small-text"> &#160;{{ $person->telephone }} </span>
                        </p>
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Urgence :</b>
                            <span class="card-small-text"> &#160;{{ $person->numeroUrgence }} </span>
                        </p>
                    </div>
                    <div class="flex-box">
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Date Naissance :</b>
                            <span class="card-small-text"> &#160;{{ $person->dateNaissance }} </span>
                        </p>
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Sexe :</b>
                            <span class="card-small-text"> &#160;{{ $person->sexe }} </span>
                        </p>
                    </div>


                </div>
                <div class="bottom">
                    <ul class="social-detail">
                        <li>{{$totalTV}}<span>Tâches Validées</span></li>
                        <li>{{$totalE}}<span>Tâches Encours</span></li>
                        <li>{{ $person->score }}<span>Score</span></li>
                    </ul>
                </div>

                </hr>
                @if($person->email==Auth::user()->email)
                <a href="#" class="cl-white theme-bg btn" data-toggle="modal" data-target="#updatePersonnel"> <i
                        class="fa fa-pencil"></i> &nbsp;&nbsp; Editer mon profil</a>
                @else
                <a href="#" class="cl-white theme-bg btn " data-toggle="modal" data-target="#updatePersonnel"> <i
                        class="fa fa-pencil"></i> &nbsp;&nbsp; Editer les informations</a>
                @endif

            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-4 -->

        <div class=" col-md-12">
            <div class="card nav-tabs-custom bg-white">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tache" data-toggle="tab">Tâches</a></li>
                    <li><a href="#infoPersonnel" data-toggle="tab">Informations Personnelles</a></li>
                    <li><a href="#contrat" data-toggle="tab">Contrat</a></li>
                    <!--  <li><a href="#salaire" data-toggle="tab">Augmentation de salaire</a></li>-->
                    <!-- <li><a href="#discipline" data-toggle="tab">Procedure disciplinaire</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="tache">
                        <h3>Tâches</h3>
                        <div class="table-responsive" style="margin-top:10px">
                            <div class="category-filter">
                                <select id="categoryFilter" class="categoryFilter form-control">
                                    <option value="">Tous</option>
                                    <option value="validée">Validée</option>
                                    <option value="En cours">En cours</option>
                                    <option value="suspendu">Suspendu</option>
                                    <option value="Hors Délais">Hors Délais</option>

                                </select>
                            </div>
                            <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:10px;">N°</th>
                                        <th>Tâche</th>
                                        <th>Affaire</th>
                                        <th>Deadline</th>
                                        <th>Fonction</th>
                                        <th>Statut</th>
                                        <th style="width:10px;">Action</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($taches as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td><a class="load" href="{{ route('infosTask', [$row->slug]) }}">
                                                {{ $row->titre }}</a></td>
                                        @if(is_null($row->idAffaire))
                                        <td>Cabinet</td>
                                        @else
                                        <td>{{ $row->idClient }} - {{ $row->prenom }} - {{ $row->nom }}
                                            {{ $row->denomination }}
                                        </td>
                                        @endif
                                        <td>
                                            @if(empty($row->dateFin))
                                                <small>N/A</small>
                                            @else
                                                {{ date('d-m-Y', strtotime($row->dateFin)) }}
                                            @endif
                                           
                                        </td>
                                        <td>
                                            <span class="btn btn-small font-midium font-13 btn-rounded @if($row->fonction=='Responsable')bg-primary-light @else bg-default-light @endif"> 
                                                {{ $row->fonction }}
                                            </span>
                                        </td>
                                       
                                        <td>
                                            @if($row->statut =='validée')
                                            <div class="label" style="background-color:green ;">{{ $row->statut }}</div>
                                            @elseif($row->statut =='En cours')
                                            <div class="label" style="background-color:aqua ;color:green">
                                                {{ $row->statut }}</div>
                                            @elseif($row->statut =='suspendu')
                                            <div class="label" style="background-color:grey ;">{{ $row->statut }}</div>
                                            @else
                                            <div class="label" style="background-color:red ;">{{ $row->statut }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="load" href="{{ route('infosTask', [$row->slug]) }}"><i
                                                    class="fa fa-info-circle"></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane" id="infoPersonnel">
                        <h3>Informations Personnelles</h3><br>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="initP" class="control-label">Intial de la personne :</label>
                                    <input type="text" class="form-control" id="initP" placeholder=""
                                        data-error=" veillez saisir l'initial de la personne exemple (AD)"
                                        name="initialPersonnel" value="{{$personnel[0]->initialPersonnel}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="initP" class="control-label">SSN :</label>
                                    <input type="text" class="form-control" id="initP" placeholder=""
                                        data-error=" veillez saisir le SSN" name="ssn" value="{{$personnel[0]->ssn}}"
                                        disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" value="matricule" name="matricules" hidden>
                                    <input type="text" value="slugs" name="slug" hidden>
                                    <label for="inputP" class="control-label">Prénom :</label>
                                    <input type="text" class="form-control" id="inputP"
                                        placeholder="prénom de la personne"
                                        data-error=" veillez saisir le prénom de la personne" name="prenom"
                                        value="{{$personnel[0]->prenom}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputN" class="control-label">Nom :</label>
                                    <input type="text" class="form-control" id="inputN" placeholder="nom de la personne"
                                        name="nom" data-error=" veillez saisir le nom de la personne"
                                        value="{{$personnel[0]->nom}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sexe" class="control-label">Sexe :</label>
                                    <input type="text" class="form-control" id="inputN" placeholder="" name="nom"
                                        data-error=" veillez saisir le nom de la personne"
                                        value="{{$personnel[0]->sexe}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datepicker" class="control-label">Date de naissance :</label>
                                    <input type="text" class="form-control" id="datepicker" name="dateNaissance"
                                        value="{{$personnel[0]->dateNaissance}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row mrg-0">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="" class="control-label">Téléphone </label><br>

                                    <input type="text" class="form-control" id="datepicker" name="telephone"
                                        data-error="" value="{{$personnel[0]->telephone}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="inputFAV" class="control-label">Numero d'urgence : </label><br>

                                    <input type="text" class="form-control" id="datepicker" name="numeroUrgence"
                                        data-error="" value="{{$personnel[0]->numeroUrgence}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>



                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputA" class="control-label">Adresse :</label>
                                    <input type="text" class="form-control" id="inputA" placeholder=""
                                        data-error=" veillez saisir l'adresse" name="adresse"
                                        value="{{$personnel[0]->adresse}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputF" class="control-label">Fonction : </label>
                                    <input type="text" class="form-control" id="inputF" placeholder="" name="fonction"
                                        data-error=" veillez saisir la fonction" value="{{$personnel[0]->fonction}}"
                                        disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Salaire brut :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="salaire de la personne " data-error="" name="salaire"
                                        value="{{$personnel[0]->salaire}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">E-mail :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder="" name="email"
                                        value="{{$personnel[0]->email}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="text-center">
                            <h3 class="mt-2">Personne à appeler en cas d'urgence</h3>
                            <br>
                        </div>

                        <div class="row mrg-0 mb-5">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Prenom & Nom :</label>
                                    <input type="text" class="form-control" id="" placeholder="" data-error=""
                                        name="nomPersonneUrgence" value="{{$personnel[0]->nomPersonneUrgence}}"
                                        disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Telephone :</label>
                                    <input type="text" class="form-control" id="" placeholder=""
                                        name="telPersonneUrgence" value="{{$personnel[0]->telPersonneUrgence}}"
                                        disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="tab-pane" id="contrat">
                        <h3>Contrat</h3><br>
                        <div class="card">
                            <div class="col-md-12 row">
                                <div class="col-md-4" style="border-right:2px dotted; dotted;padding: 20px">
                                    <div class="form-check has-success mb-4">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="option1"
                                                id="checkbox1">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Contrat daté signé et
                                                cacheté</span>
                                        </label>
                                    </div>
                                    <div id="elementContratDate">
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Date</label>
                                            <div class="col-9">
                                                <input class="form-control" type="date" value=""
                                                    id="example-text-input">
                                            </div>

                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Contrat</label>
                                            <div class="col-9">
                                                <input class="fichiers form-control" type="file" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-check has-success">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="option1"
                                                id="checkbox2">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"> Accord de confidentialité</span>
                                        </label>
                                    </div>
                                    <div id="elementAccord">
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Date</label>
                                            <div class="col-9">
                                                <input class="form-control" type="date" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-4" style="border-right:2px dotted ;padding: 20px">
                                    <div class="form-check has-success">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="option1"
                                                id="checkbox3">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Modification contrat</span>
                                        </label>

                                    </div>
                                    <div id="elementContraModif">
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Date</label>
                                            <div class="col-9">
                                                <input class="form-control" type="date" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Nature</label>
                                            <div class="col-9">
                                                <select class="form-control select2" style="width: 100%;" name="nature"
                                                    id="R" required>
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    <option value="CDD">CDD</option>
                                                    <option value="CDI">CDI</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Avenant</label>

                                            <div class="col-9 row" style="padding-top:5px">
                                                <div class="col-md-6" id="">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-radio">
                                                            <input id="CheckboxRediger" name="typeAvenant" onclick=""
                                                                type="radio" class="custom-control-input"
                                                                value="rediger" required>
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"> Je veux
                                                                rediger</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-radio">
                                                            <input id="CheckboxImporter" name="typeAvenant" onclick=""
                                                                type="radio" class="custom-control-input"
                                                                value="Requete">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Je veux
                                                                importer</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3"></div>
                                            <div class="col-9">
                                                <div id="divImporter">
                                                    <input class="fichiers form-control" type="file" value=""
                                                        id="example-text-input">
                                                </div>
                                                <div id="divRediger">
                                                    <button class="theme-bg btn btn-rounded"><i
                                                            class="fa fa-pencil"></i>
                                                        Rediger</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 20px">
                                    <div class="form-check has-success">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="option1"
                                                id="checkbox4">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Contrat terminé</span>
                                        </label>
                                    </div>
                                    <div id="elementContratTerminer">
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Date</label>
                                            <div class="col-9">
                                                <input class="form-control" type="date" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Motif</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input"
                                                class="col-3 col-form-label">Document</label>
                                            <div class="col-9">
                                                <input class="fichiers form-control" type="file" value=""
                                                    id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="height:300px">
                            <h1 style="text-align:center;margin-top:100px">CONTRAT - AVENANT - DOC FIN DE CONTRAT</h1>
                        </div>
                    </div>



                    <div class="tab-pane" id="salaire">
                        <h3>Augmentation de salaire </h3>


                    </div>

                    <div class="tab-pane" id="discipline">
                        <h3>Procedure disciplinaire</h3>


                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col-md-8 -->
    </div>
    <!-- /row -->

    <!-- Modification du personnel -->
    <div class="add-popup modal fade" id="updatePersonnel" tabindex="-1" role="dialog" aria-labelledby="update">
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
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification du profil personnel</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <!-- form start -->
                        <form method="post" action="{{ route('updatePersonnel', [$person->slug]) }}"
                            enctype="multipart/form-data">

                            @csrf


                            <div class="row mrg-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="initP" class="control-label">Intial de la personne :</label>
                                        <input type="text" class="form-control" id="initP"
                                            placeholder="Initial de la personne exemple (AD)"
                                            data-error=" veillez saisir l'initial de la personne exemple (AD)"
                                            name="initialPersonnel" required value="{{ $person->initialPersonnel }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="initP" class="control-label">SSN :</label>
                                        <input type="text" class="form-control" id="initP" placeholder=""
                                            data-error=" veillez saisir l'initial de la personne exemple (AD)"
                                            name="ssn" required value="{{ $person->ssn }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" value="matricule" name="matricules" hidden>
                                        <input type="text" value="slugs" name="slug" hidden>
                                        <label for="inputP" class="control-label">Prénom :</label>
                                        <input type="text" class="form-control" id="inputP"
                                            placeholder="prénom de la personne"
                                            data-error=" veillez saisir le prénom de la personne" name="prenom" required
                                            value="{{ $person->prenom }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputN" class="control-label">Nom :</label>
                                        <input type="text" class="form-control" id="inputN"
                                            placeholder="nom de la personne" name="nom"
                                            data-error=" veillez saisir le nom de la personne" required
                                            value="{{ $person->nom }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mrg-0">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sexe" class="control-label">Sexe :</label>
                                        <select class="form-control select2" placeholder="selectionner le sexe"
                                            style="width: 100%;" name="sexe" id="sexe" required
                                            value="{{ $person->sexe }}">
                                            <option>Masculin</option>
                                            <option>Feminin</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="datepicker" class="control-label">Date de naissance :</label>
                                        <input type="date" class="form-control" id="datepicker" name="dateNaissance"
                                            data-error=" veillez saisir la date de naissance" required
                                            value="{{ $person->dateNaissance }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mrg-0">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="inputFAV" class="control-label">Téléphone </label><br>

                                        <input type="text" class="form-control phone"
                                            data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="phoneP"
                                            name="telephone" data-error=" veillez saisir le téléphone" required
                                            value="{{ $person->telephone }}">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="inputFAV" class="control-label">N° d'urgence : </label><br>

                                        <input type="tel" class="form-control phone1"
                                            data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="phoneUP"
                                            name="numeroUrgence" data-error=" veillez saisir le téléphone" required
                                            value="{{ $person->numeroUrgence }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>



                            <div class="row mrg-0">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputA" class="control-label">Adresse :</label>
                                        <input type="text" class="form-control" id="inputA"
                                            placeholder="adresse de la personne" data-error=" veillez saisir l'adresse"
                                            name="adresse" required value="{{ $person->adresse }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputF" class="control-label">Fonction : </label>
                                        <input type="text" class="form-control" id="inputF"
                                            placeholder="fonction de la personne" name="fonction"
                                            data-error=" veillez saisir la fonction" required
                                            value="{{ $person->fonction }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mrg-0">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputSa" class="control-label">Salaire brut:</label>
                                        <input type="text" class="form-control" id="inputSa"
                                            placeholder="salaire de la personne "
                                            data-error=" veillez saisir le salaire de la personne" name="salaire"
                                            required value="{{ $person->salaire }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputEM" class="control-label">E-mail :</label>
                                        <input type="mail" class="form-control" id="inputEM"
                                            placeholder="e-mail de la personne" name="email"
                                            data-error="Cet adresse n'est pas valide" required
                                            value="{{ $person->email }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0">
                                <div class="col-md-12 col-sm-12">

                                    <div class="form-group">
                                        <label for="inputF" class="control-label">Changer la photo : </label>
                                        <input type="file" name="photo" id="files" class="fichiers form-control"
                                            accept="image/*">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <h5 class="mt-2">Personne à appeler en cas d'urgence</h5>
                                <br>
                            </div>

                            <div class="row mrg-0 mb-5">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputSa" class="control-label">Prenom & Nom :</label>
                                        <input type="text" class="form-control" id="" placeholder="" data-error=""
                                            name="nomPersonneUrgence" value="{{$personnel[0]->nomPersonneUrgence}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputEM" class="control-label">Telephone :</label>
                                        <input type="text" class="form-control" id="" placeholder=""
                                            name="telPersonneUrgence" value="{{$personnel[0]->telPersonneUrgence}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mrg-0">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <input type="submit" class="cl-white theme-bg btn btn-rounded btn-block "
                                                style="width:50%;" value="Enregistrer les modifications" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    @endforeach
</div>
<!-- /.content-wrapper-->

<script>
document.getElementById('rh').classList.add('active');

// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");
   
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function (e) {
           
            var fichiersInput = this.querySelectorAll(".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name + " est trop volumineux. Veuillez choisir un fichier plus petit.");
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