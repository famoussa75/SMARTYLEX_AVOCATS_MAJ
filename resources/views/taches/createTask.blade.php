
@extends('layouts.base')
@section('title','Création de tâche')
@section('content')

<div class="container-fluid">
    <!-- Title & Breadcrumbs-->

    <!-- page creation-->
    <div class="row page-breadcrumbs ">
    @if($tacheAff==false)
    <div class="col-md-5 align-self-center">
            <h5 class="theme-cl"><i class="ti i-cl-0 ti-layers"></i> Tâches > <span class="label bg-info"><b>Nouvelle de Tâche</b></span></h5>
    </div>
    @else
    <div class="col-md-5 align-self-center">
        <h5 class="theme-cl">
            @foreach ($clients as $data )
                {{ $data->idClient }} > {{$data->prenom}} {{$data->nom}} {{$data->denomination}} >
            @endforeach
            @foreach ($affaire as $aff)
                {{ $aff->idAffaire }} {{ $aff->nomAffaire }} >
            @endforeach
            <span class="label bg-info-light"><b>Nouvelle de tâche</b></span>
        </h5>
    </div>
  
    @endif
       
        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a type="button" href="{{ route('allTasks') }}" class="cl-white theme-bg btn btn-rounded" title="Voir la liste des tâches">
                    <i class="fa fa-navicon"></i>
                    Liste des Tâches
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    <!-- page creation-->
    <div class="row card page-breadcrumbs">
        <div class="col-md-6 text-left">
            <fieldset class="form-group">
                <label class="label-control">Categorie de la tâche</label>
                <div class="row mrg-0 text-left" style="border: 1px solid black; padding-top: 15px;padding-left:15px;">
                    <div class="form-group form-check">
                        <label class="custom-control custom-checkbox">
                            <input id="tacheSimple" name="categorie_tache" type="radio" class="custom-control-input" value="Simple" checked>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Tâche simple </span>
                        </label>
                    </div>
                    <div class=" form-group form-check">
                        <label class="custom-control custom-checkbox">
                            <input id="tacheConditionnelle" name="categorie_tache" type="radio" class="custom-control-input" value="Conditionnelle">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Tâches conditionnelles / successives </span>
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6 text-left">
            <div class="col-sm-12" id="rowParente" hidden>
                <div class="form-group">
                    <label for="R" class="control-label">Selectionner la tâche parente :</label>
                    <select class="form-control select2" data-placeholder="selectionner la tâche parente" style="width: 100%;" name="" id="idTacheParente" required>

                    </select>

                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <label class="label-control">Priorité de la tâche</label>
                <select class="form-control select2"  data-placeholder="" style="width: 100%;" id="prioriteSelect" required>
                    <option>Faible</option>
                    <option>Moyenne</option>
                    <option>Élevé</option>
                    <option>Autres</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>

    <!-- Title & Breadcrumbs-->

    <script>
        function changeClass1() {

            var index = -1;

            var tousLesFormulaires = document.forms;
            for (var i = 0; i < tousLesFormulaires.length; i++) {
                tousLesFormulaires[i].reset();
            }
            $('#tacheSimple').click();

            var select = $('.select');
            var select2 = $('.select2');

            select.val(index);
            select2.val(index).trigger('change.select2');


            var id = document.getElementById("section1");
            var id2 = document.getElementById("section2");
            id.classList.add("active");
            id2.classList.remove("active");
            $('#client').attr('required', true);
        }

        function changeClass2() {
            

            var index = -1;

            var tousLesFormulaires = document.forms;
            for (var i = 0; i < tousLesFormulaires.length; i++) {
                tousLesFormulaires[i].reset();
            }

            $('#tacheSimple').click();

            var select = $('.select');
            var select2 = $('.select2');

            select.val(index);
            select2.val(index).trigger('change.select2');

            var id = document.getElementById("section2");
            var id1 = document.getElementById("section1");
            id.classList.add("active");
            id1.classList.remove("active");
            $('#client').removeAttr('required');


        }
    </script>

    <div class="row" id="tacheRow">
        <div class="col-md-12 col-sm-12">
            <div class="card padd-15">
                <div class="tab" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @if(empty($clients))
                        <li role="presentation" class="active" id="section2"><a href="#Section2" role="tab" data-toggle="tab" onclick="changeClass2()"><b>Tâche Cabinet</b></a></li>
                        @else
                        <li role="presentation" class="active" id="section1"><a href="#Section1" onclick="changeClass1()" aria-controls="home" role="tab" data-toggle="tab"><b>Tâche Client</b></a></li>
                        <li role="presentation" class="" id="section2"><a href="#Section2" role="tab" data-toggle="tab" onclick="changeClass2()"><b>Tâche Cabinet</b></a></li>
                        @endif

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs" id="home">
                        @if(empty($clients))
                        <div role="tabpanel" class="tab-pane active" id="Section2">
                            <div class="card" style="padding: 10px;">
                                <!-- form start -->
                                <form   method="post" action="{{ route('addTask') }}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="categorie" class="categorie" hidden>
                                    <input type="text" name="slugTache" class="parenteTache" hidden>
                                    <input type="hidden" name="idCourier" value="{{$idCourier}}">
                                    <input type="hidden" name="idAudience" value="{{$idAudience}}">
                                    <input type="hidden" name="idSuivit" value="{{$idSuivit}}">
                                    <input type="hidden" name="idSuivitRequete" value="{{$idSuivitRequete}}">

                                   
                                    <div class="row mrg-0">
                                       
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="R" class="control-label">Type de tâche :</label>

                                                <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idTypeTache"  required>
                                                    <option value=1>Tâche ordinaire</option>

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputP" class="control-label">Nom de la tâche :</label>
                                                <input type="text" class="form-control" id="inputP" placeholder="saisir le nom de la tâche" data-error="veillez saisir le nom de la tâche" name="titre" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="idClient" value="0">
                                    <input type="hidden" name="idAffaire" value="0">
                                    <input type="hidden" name="priorite" class="priorite">
                                    <div class="row mrg-0 tacheSimpleDate">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <input type="date" class="form-control dateDebutTa" id="dateDebutTa2" name="dateDebut" data-error=" veillez saisir la date début de la tâche" required><br>
                                                <span id="m1" class="m1" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                    :</label>
                                                <input type="date" class="form-control dateFinTa" id="dateFinTa2" name="dateFin" data-error=" veillez saisir la date de fin de la tâche" required><br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mrg-0 tacheConditionnelDate" hidden>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <p style="color:orange;font-weight:bold">La date de début correspond à
                                                    la date de validation de la tâche principale. </p>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                    :</label>

                                                <input type="number" class="form-control" min="1" id="dateFinCond2" placeholder="Nombre de jour après validation" data-placeholder="Choisissez un délais" data-error=" veillez saisir le nom de la tâche" name="dateFin2" >
                                                </br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc" class="control-label">Description de la tâche
                                                    :</label>
                                                <textarea class="form-control" id="desc" rows="3" name="description" data-error=" veillez saisir une description de la tâche" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Responsable(s):</label>
                                                <select multiple="" name="idPersonnelResponsable[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" required>
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Participant(s):</label>
                                                <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" >
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="personnePoint" class="control-label">Point :</label>
                                                <input type="number" min="1" class="form-control" name="point" required id="personnePoint" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="type" class="control-label">Piece(s) jointe(s) ( Facultatif )</label>
                                                <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]" multiple>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;" id="addTache"> Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <div role="tabpanel" class="tab-pane active" id="Section1">
                            <div class="card" style="padding: 10px;">
                                <!-- form start -->
                                <form method="post" action="{{ route('addTask') }}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="categorie" class="categorie" hidden>
                                    <input type="text" name="slugTache" class="parenteTache" hidden>
                                    <input type="hidden" name="priorite" class="priorite">
                                    <input type="hidden" name="idCourier" value="{{$idCourier}}">
                                    <input type="hidden" name="idAudience" value="{{$idAudience}}">
                                    <input type="hidden" name="idSuivit" value="{{$idSuivit}}">
                                    <input type="hidden" name="idSuivitRequete" value="{{$idSuivitRequete}}">

                                    <div class="row mrg-0">
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="R" class="control-label">Type de tâche :</label><br>
                                                <select class="select-control select" style="width:100%;height:35px" name="idTypeTache" id="typeTache" required>
                                                   
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach($typeTaches as $t)
                                                        @if($t->idTypeTache != 0)
                                                        <option value={{$t->idTypeTache}} data-type="{{$t->descriptionType}}">{{$t->descriptionType}}</option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="divNomTache">
                                                <label for="inputP" class="control-label">Nom de la tâche :</label>
                                                <input type="text" class="form-control" id="nomTache" placeholder="saisir le nom de la tâche" data-error=" veillez saisir le nom de la tâche" name="titre" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                    </div>

                                    @if($tacheAff==false)
                                    <div class="row mrg-0 tacheSimpleClient">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="client" class="control-label">Selectionner le client:</label>

                                                <select class="form-control  select2" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client" required>

                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach ($clients as $data )
                                                    <option value={{ $data->idClient }}>
                                                        {{$data->prenom}} {{$data->nom}} {{$data->denomination}}
                                                    </option>
                                                    @endforeach

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="affaireContent" hidden>
                                            <input type="text" id="typeContent" value="taches" name="typeContent" hidden>
                                            <div class="form-group">
                                                <label for="affaire" class="control-label">Affaire du client concerné
                                                    :</label>
                                                <select class="form-control select2" data-placeholder="Affaire du client concerné" style="width: 100%;" name="idAffaire" id="affaireClient" required>
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>

                                    </div>
                                    @else
                                    <div class="row mrg-0 tacheSimpleClient">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="client" class="control-label">Selectionner le client
                                                    :</label>

                                                <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client">

                                                    @foreach ($clients as $data )
                                                    <option value={{ $data->idClient }}>
                                                        {{$data->prenom}} {{$data->nom}} {{$data->denomination}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="affaireContent">
                                            <input type="text" id="typeContent" value="taches" name="typeContent" hidden>
                                            <div class="form-group">
                                                <label for="affaire" class="control-label">Affaire du client concerné
                                                    :</label>
                                                <select class="form-control select" data-placeholder="Affaire du client concerné" style="width: 98%;margin-left:-8px" name="idAffaire" >
                                                    @foreach ($affaire as $aff)
                                                    <option value="{{ $aff->idAffaire }}">{{ $aff->nomAffaire }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>

                                    </div>
                                    @endif

                                    <div class="row col-md-12" id="tacheEntreprise" hidden>
                                        <p class="col-md-12" style="text-align: center;"><i class="fa fa-info-circle"></i> La tâche <b>Creation d'entreprise</b> comporte plusieurs taches successives</p>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card padd-15">
                                                <div class="panel-group accordion-stylist" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="">
                                                                    Tache 1
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" class="form-control" value="Rédaction du PV et les Statuts" name="titre1">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc1"  cols="40" rows="5" class="form-control">2 exemplaires originaux du PV ; 2 exemplaires originaux des statuts ;Signature des PV et les statuts.</textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" min="1" name="delais1" value="2" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" min="1" value="5" name="point1" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    Tache 2
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" class="form-control" name="titre2" value="Enregistrement des PV et Statuts à l’impôt">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc2"  cols="40" rows="5" class="form-control">Achat des timbres fiscaux ; Dépôt de 2 exemplaires des PV et Statuts signés et timbrés à l’impôt.</textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" min="1" name="delais2" value="2" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" min="1" name="point2" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingThree">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    Tache 3
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" name="titre3" value="Ouverture de compte bancaire pour la société en formation" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc3"  cols="40" rows="5" class="form-control">Signature des documents bancaires par le ou les gérants ;Rédaction de la lettre d’ouverture de compte ; Une copie des PV et Statuts ; 2 photos d’identité du ou des gérants ; Une copie de la carte d’identité ou passeport du ou des gérants ; Un certificat de résidence du ou des gérants ;</textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" name="delais3" min="1" value="1" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" name="point3" min="1" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingFour">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                                    Tache 4
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" class="form-control" name="titre4" value="Libération du capital social">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc4"  cols="40" rows="5" class="form-control"></textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" name="delais4" min="1" value="2" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" name="point4" min="1" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card padd-15">
                                                <div class="panel-group accordion-stylist" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive" class="">
                                                                    Tache 5
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" name="titre5" class="form-control" value="Délivrance de l’attestation du dépôt de capital social">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc5"  cols="40" rows="5" class="form-control"></textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" min="1" name="delais5" value="4" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" min="1" name="point5" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                                    Tache 6
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" class="form-control" name="titre6" value="Création de la société sur la plateforme de l’APIP (SYNERGUI)">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc6"  cols="40" rows="5" class="form-control">Scanne de tout le fond de dossier ; dépôt ; Caisse ; saisie suivie de la soumission.</textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" name="delais6" min="1" value="1" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" name="point6" min="1" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingThree">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseThree">
                                                                    Tache 7
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" name="titre7" class="form-control" value="Rédaction de la lettre de transmission des pièces suivantes">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc7"  cols="40" rows="10" class="form-control">Une copie des Statuts de la société ; Une copie du procès-verbal de constitution ; Une copie de l’attestation du compte bancaire portant libération du capital social ; La décharge de la lettre d’ouverture de compte ; Une copie de la pièce d'identité du ou des gérants ; Deux (2) photos d'identité du ou des gérants. </textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input type="number" name="delais7" min="1" value="2" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" min="1" name="point7" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingFour">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseFour">
                                                                    Tache 8
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseEight">
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Titre</label>
                                                                    <input type="text" name="titre8" value="Récupération des documents suivants contre reçu de paiement" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="label-control">Description</label>
                                                                    <textarea name="desc8"  cols="40" rows="5" class="form-control">Le RCCM de la Société ; Le numéro d’immatriculation fiscale de la société (NIF) ; 	Publication légale de la société.</textarea>
                                                                </div>
                                                                <div class="row col-md-12">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Délais (Jours)</label>
                                                                        <input name="delais8" type="number" min="1" value="3" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="" class="label-control">Point</label>
                                                                        <input type="number" name="point8" min="1" value="5" class="form-control" style="width: 90px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mrg-0 tacheSimpleDate">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <input type="date" class="dateDebutTa form-control" id="dateDebutTa" name="dateDebut" data-error=" veillez saisir la date début de la tâche" required><br>
                                                <span id="m1" class="m1" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche :</label>
                                                <input type="date" class="dateFinTa form-control" id="dateFinTa" name="dateFin" data-error=" veillez saisir la date de fin de la tâche" required><br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mrg-0 tacheConditionnelDate" hidden>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <p style="color:orange;font-weight:bold">La date de début correspond à
                                                    la date de validation de la tâche principale. </p>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                    :</label>
                                                <input type="number" min="1" class="form-control" id="dateFinCond1" placeholder="Nombre de jour après validation" data-placeholder="Choisissez un délais" data-error="" name="dateFin2" required></br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mrg-0 tacheConditionnelClient">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="client" class="control-label">Le client :</label>

                                                <select class="form-control select clientCond" data-placeholder="selectionner le client" style="width: 95%;margin-left:-8px" name="idClient2" id="clientConditionnel">

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="affaire" class="control-label">Affaire du client concerné
                                                    :</label>
                                                <select class="form-control select idAffaireCond" data-placeholder="Affaire du client concerné" style="width: 95%;margin-left:-8px" name="idAffaire2" id="affaireConditionnel">

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row mrg-0" id="descOrdinaire">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc" class="control-label">Description de la tâche
                                                    :</label>
                                                <textarea class="form-control" id="desc" rows="3" name="description" data-error=" veillez saisir une description de la tâche" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Responsable(s):</label>
                                                <select multiple="" name="idPersonnelResponsable[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" required>
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Participant(s):</label>
                                                <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" >
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group" id="divPersonnePoint">
                                                <label for="personnePoint" class="control-label">Point :</label>
                                                <input type="number" min="1" class="form-control" name="point" required id="personnePoint">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="type" class="control-label">Piece(s) jointe(s) ( Facultatif )</label>
                                                <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]" multiple>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;" id="addTache"> Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="Section2">
                            <div class="card" style="padding: 10px;">
                                <!-- form start -->
                                <form   method="post" action="{{ route('addTask') }}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf

                                    <input type="text" name="categorie" class="categorie" hidden>
                                    <input type="text" name="slugTache" class="parenteTache" hidden>
                                    <input type="text" name="idCourier" value="{{$idCourier}}" hidden>
                                    <input type="hidden" name="idAudience" value="{{$idAudience}}">
                                    <input type="hidden" name="idSuivit" value="{{$idSuivit}}">
                                    <input type="hidden" name="idSuivitRequete" value="{{$idSuivitRequete}}">

                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputP" class="control-label">Nom de la tâche :</label>
                                                <input type="text" class="form-control" id="inputP" placeholder="saisir le nom de la tâche" data-error=" veillez saisir le nom de la tâche" name="titre" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="R" class="control-label">Type de tâche :</label>

                                                <select class="form-control select2" style="width: 100%;" name="idTypeTache" id="typeTache" required>
                                                    <option value="1">Tâche cabinet</option>

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="idClient" value="0">
                                    <input type="hidden" name="idAffaire" value="0">
                                    <input type="hidden" name="priorite" class="priorite">
                                    <div class="row mrg-0 tacheSimpleDate">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <input type="date" class="form-control dateDebutTa" id="dateDebutTa2" name="dateDebut" data-error=" veillez saisir la date début de la tâche"><br>
                                                <span id="m1" class="m1" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                    :</label>
                                                <input type="date" class="form-control dateFinTa" id="dateFinTa2" name="dateFin" data-error=" veillez saisir la date de fin de la tâche" required><br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mrg-0 tacheConditionnelDate" hidden>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                    :</label>
                                                <p style="color:orange;font-weight:bold">La date de début correspond à
                                                    la date de validation de la tâche principale. </p>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                    :</label>

                                                <input type="number" min="1" class="form-control" id="dateFinCond2" placeholder="Nombre de jour après validation" data-placeholder="Choisissez un délais" data-error=" veillez saisir le nom de la tâche" name="dateFin2" required>
                                                </br>
                                                <span id="m2" class="m2" style=" color:red"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mrg-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc" class="control-label">Description de la tâche
                                                    :</label>
                                                <textarea class="form-control" id="desc" rows="3" name="description" data-error=" veillez saisir une description de la tâche" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Responsable(s):</label>
                                                <select multiple="" name="idPersonnelResponsable[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" required>
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="personne" class="control-label">Participant(s):</label>
                                                <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" >
                                                    @foreach ($personnels as $personne)
                                                    <option value="{{ $personne->idPersonnel }}">{{ $personne->prenom }}
                                                        {{ $personne->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="personnePoint" class="control-label">Point :</label>
                                                <input type="number" min="1" class="form-control" name="point" required id="personnePoint">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="type" class="control-label">Piece(s) jointe(s) ( Facultatif )</label>
                                                <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]" multiple>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;" id="addTache"> Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('tch').classList.add('active');


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

//Mise a jour 
 // Fonction pour masquer ou afficher "Création d'entreprise" 

 document.addEventListener('DOMContentLoaded', function () {
    const radioConditionnelle = document.getElementById('tacheConditionnelle');
    const radioSimple = document.getElementById('tacheSimple');
    const selectTypeTache = document.getElementById('typeTache');
    
    // Fonction pour masquer ou afficher "Création d'entreprise"
    const toggleOption = () => {
        const showConditionnelle = radioConditionnelle.checked;
        
        Array.from(selectTypeTache.options).forEach(option => {
            if (option.dataset.type === "Création d'entreprise") {
                // Masque si "Tâches conditionnelles" est sélectionné
                option.style.display = showConditionnelle ? 'none' : '';
            }
        });
    };

    // Ajout d'événements sur les boutons radio
    radioConditionnelle.addEventListener('change', toggleOption);
    radioSimple.addEventListener('change', toggleOption);

    // Initialisation : appel de la fonction au chargement
    toggleOption();
});

document.querySelector('form').addEventListener('submit', function (event) {
        const select = document.getElementById('personne');
        const selectedOptions = Array.from(select.selectedOptions);

        if (selectedOptions.length === 0) {
            event.preventDefault(); // Empêche l'envoi du formulaire
            alert('Veuillez sélectionner au moins un responsable.');
            select.focus();
        }
    });
</script>

<script>
    // Validation avant la soumission du formulaire
    document.querySelector('form').addEventListener('submit', function (event) {
        const select = document.getElementById('personne');
        const selectedOptions = Array.from(select.selectedOptions);

        if (selectedOptions.length === 0) {
            event.preventDefault(); // Empêche l'envoi du formulaire
            alert('Veuillez sélectionner au moins un participant.');
            select.focus(); // Met le focus sur le champ
        }
    });
</script>

<!-- End Add Contact Popup -->
@endsection
