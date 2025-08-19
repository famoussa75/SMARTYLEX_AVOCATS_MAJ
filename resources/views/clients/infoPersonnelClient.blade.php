@extends('layouts.base')
@section('title', 'Information')
@section('content')
<div class="container-fluid">
    @foreach ($personnel as $person)
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-user"></i> Profil utilisateur</h4>
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
                        <img src="{{URL::to('/')}}/assets/upload/photo.jpg" class="img-circle img-responsive" alt="" />
                    </div>
                    <h5 class="font-normal mrg-bot-0 font-18 card-block-title">{{ $person->prenomEtNom }}
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
                        <span class="card-small-text"> &#160;{{ $person->matricule }} </span>
                    </p>
                    <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Departement :</b>
                        <span class="card-small-text"> &#160;{{ $person->departement }} </span>
                    </p>
                    <div class="flex-box">
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Residence :</b>
                            <span class="card-small-text"> &#160;{{ $person->residence }} </span>
                        </p>
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Nationnalite :</b>
                            <span class="card-small-text"> &#160;{{ $person->nationalite }} </span>
                        </p>
                    </div>
                    <div class="flex-box">
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>Telephone :</b>
                            <span class="card-small-text"> &#160;{{ $person->telephone }} </span>
                        </p>
                        <p class="font-normal mrg-bot-0 font-16 card-block-title"><b>NSS :</b>
                            <span class="card-small-text"> &#160;{{ $person->numSecuriteSociale }} </span>
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

                </hr>

                <a href="#" class="cl-white theme-bg btn " data-toggle="modal" data-target="#updatePersonnel"> <i
                        class="fa fa-pencil"></i> &nbsp;&nbsp; Editer les informations</a>


            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-4 -->

        <div class="col-md-12">
            <div class="nav-tabs-custom bg-white">
                <ul class="nav nav-tabs">

                    <li class="active" id="tab1" onclick="changeTab1()"><a href="#infoPersonnel"
                            data-toggle="tab">Informations Personnelles</a></li>
                    <li id="tab2" onclick="changeTab2()"><a href="#contrat" data-toggle="tab">Contrat</a></li>
                   <!-- <li id="tab3" onclick="changeTab3()"><a href="#salaire" data-toggle="tab">Augmentation de
                            salaire</a></li>-->
                   <!-- <li id="tab4" onclick="changeTab4()"><a href="#discipline" data-toggle="tab">Procedure
                            disciplinaire</a></li>-->
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="infoPersonnel">
                        <h3>Informations Personnelles</h3><br>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="initP" class="control-label">Prenom et Nom :</label>
                                    <input type="text" class="form-control" id="initP" placeholder="" name="prenomEtNom"
                                        value="{{$personnel[0]->prenomEtNom}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="initP" class="control-label">SSN :</label>
                                    <input type="text" class="form-control" id="initP" placeholder=""
                                        data-error=" veillez saisir le SSN" name="numSecuriteSociale"
                                        value="{{$personnel[0]->numSecuriteSociale}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" value="matricule" name="matricules" hidden>
                                    <input type="text" value="slugs" name="slug" hidden>
                                    <label for="inputP" class="control-label">Statut du contrat :</label>
                                    <input type="text" class="form-control" id="inputP" name="statutContrat"
                                        value="{{$personnel[0]->statutContrat}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputN" class="control-label">Filiation :</label>
                                    <input type="text" class="form-control" id="inputN" placeholder="" name="filiation"
                                        data-error=" veillez saisir le nom de la personne"
                                        value="{{$personnel[0]->filiation}}" disabled>
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
                                    <label for="datepicker" class="control-label">Prefix :</label>
                                    <input type="text" class="form-control" id="datepicker" name="prefix"
                                        value="{{$personnel[0]->prefix}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row mrg-0">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="" class="control-label">Statut Matrimonial </label><br>

                                    <input type="text" class="form-control" id="datepicker" name="statutMatrimonial"
                                        data-error="" value="{{$personnel[0]->statutMatrimonial}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="inputFAV" class="control-label">Date naissance : </label><br>

                                    <input type="text" class="form-control" id="datepicker" name="dateNaissance"
                                        data-error="" value="{{$personnel[0]->dateNaissance}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>



                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputA" class="control-label">Lieu de naissance :</label>
                                    <input type="text" class="form-control" id="inputA" placeholder=""
                                        data-error=" veillez saisir l'adresse" name="lieuNaissance"
                                        value="{{$personnel[0]->lieuNaissance}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputF" class="control-label">Pays de naissance : </label>
                                    <input type="text" class="form-control" id="inputF" placeholder=""
                                        name="paysNaissance" data-error=" veillez saisir la fonction"
                                        value="{{$personnel[0]->paysNaissance}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Residence :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="salaire de la personne " data-error="" name="residence"
                                        value="{{$personnel[0]->residence}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Telephone :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder="" name="telephone"
                                        value="{{$personnel[0]->telephone}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Numero de la pièce :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="salaire de la personne " data-error="" name="numPiece"
                                        value="{{$personnel[0]->numPiece}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Nature de la pièce :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder=""
                                        name="naturePiece" value="{{$personnel[0]->naturePiece}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Date exp :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="salaire de la personne " data-error="" name="dateExPiece"
                                        value="{{$personnel[0]->dateExPiece}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Nationnalite :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder=""
                                        name="nationnalite" value="{{$personnel[0]->nationalite}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Profession :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="" data-error="" name="profession"
                                        value="{{$personnel[0]->profession}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Fonction :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder="" name="fonction"
                                        value="{{$personnel[0]->fonction}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSa" class="control-label">Departement :</label>
                                    <input type="text" class="form-control" id="inputSa"
                                        placeholder="salaire de la personne " data-error="" name="departement"
                                        value="{{$personnel[0]->departement}}" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Grade :</label>
                                    <input type="mail" class="form-control" id="inputEM" placeholder="" name="grade"
                                        value="{{$personnel[0]->grade}}" disabled>
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
                                        name="nomPersonneUrgence" value="" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEM" class="control-label">Telephone :</label>
                                    <input type="text" class="form-control" id="" placeholder=""
                                        name="telPersonneUrgence" value="" disabled>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="tab-pane" id="contrat">
                        <h3>Contrat</h3><br>
                        <div class="card">
                            <div class="col-md-12 row">
                                <!-- CONTRAT SIGNER -->
                                <div class="col-md-4" style="border-right:2px dotted; dotted;padding: 20px">
                                    <form method="POST" action="{{route('addContratSignerClient')}}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        @if(empty($contratSigner))
                                        <div class="form-check has-success mb-4">

                                            <label class="custom-control custom-checkbox">

                                                <input type="checkbox" class="custom-control-input" value="oui"
                                                    id="checkbox1" required>


                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Contrat daté signé et
                                                    cacheté</span>
                                            </label>

                                        </div>
                                        <div id="elementContratDate">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="date" value=""
                                                        id="example-text-input" name="dateSignature">
                                                </div>

                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input" class="col-3 col-form-label">Contrat
                                                    signé</label>
                                                <div class="col-9">
                                                    <input class="fichiers form-control" type="file" name="fichierContratSigner"
                                                        id="example-text-input">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-check has-success">

                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="oui"
                                                    id="checkbox2" name="accordConf">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"> Accord de
                                                    confidentialité</span>
                                            </label>
                                        </div>
                                        <div id="elementAccord">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="date" value=""
                                                        id="example-text-input" name="dateAccord">
                                                </div>
                                            </div>

                                        </div>
                                        <input type="hidden" name="idPersonnelClient"
                                            value={{ $person->idPersonnelClient }}>
                                        <button type="submit" class="theme-bg btn btn-rounded mt-4"><i
                                                class="fa fa-plus"></i>
                                            Ajouter</button>

                                        @else

                                        <div class="form-check has-success mb-4">

                                            <label class="custom-control custom-checkbox">

                                                <input type="checkbox" class="custom-control-input" value="oui"
                                                    id="checkbox1" required checked disabled>


                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Contrat daté signé et
                                                    cacheté</span>
                                            </label>

                                        </div>
                                        <div id="">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="text"
                                                        value="{{date('d-m-Y', strtotime($contratSigner[0]->dateSignature))}}"
                                                        id="example-text-input" name="dateSignature" disabled>
                                                </div>

                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input" class="col-3 col-form-label">Contrat
                                                    signé</label>
                                                <div class="col-9">
                                                    <p>- Vous trouverez le fichier dans le panel <b>Contrat signé / non
                                                            signé</b></p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-check has-success">
                                            @if($contratSigner[0]->accordConf=='oui')
                                            <label class="custom-control custom-checkbox">

                                                <input type="checkbox" class="custom-control-input" value="oui"
                                                    id="checkbox2" name="accordConf" checked disabled>

                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"> Accord de
                                                    confidentialité</span>
                                            </label>

                                            <div id="">
                                                <div class="row">
                                                    <label for="example-text-input"
                                                        class="col-3 col-form-label">Date</label>
                                                    <div class="col-9">
                                                        <input class="form-control" type="text"
                                                            value="{{date('d-m-Y', strtotime($contratSigner[0]->dateAccord))}}"
                                                            id="example-text-input" name="dateAccord" disabled>
                                                    </div>
                                                </div>

                                            </div>
                                            @else
                                            <label class="custom-control custom-checkbox">

                                                <input type="checkbox" class="custom-control-input" value="oui"
                                                    id="checkbox2" name="accordConf" disabled>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"> Accord de
                                                    confidentialité</span>
                                            </label>
                                            @endif
                                        </div>
                                        <hr>
                                        <p class="theme-cl"><i class="fa fa-info-circle"></i> Pour changer ce contrat
                                            veuillez supprimer d'abord le contrat ci-dessous.</p>

                                        @endif

                                    </form>

                                </div>
                                <!-- FIN CONTRAT SIGNER -->

                                <div class="col-md-4" style="border-right:2px dotted ;padding: 20px">
                                    @if(empty($avenantSigner))
                                    <form method="POST" action="{{route('addContratAvenantClient')}}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-check has-success">

                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="option1"
                                                    id="checkbox3" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Modification contrat</span>
                                            </label>

                                        </div>
                                        <div id="elementContraModif">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="date" value=""
                                                        id="example-text-input" name="dateAvenant">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Nature</label>
                                                <div class="col-9">
                                                    <select class="form-control select2" style="width: 100%;"
                                                        name="nature" id="R" required>
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        <option value="CDD">CDD</option>
                                                        <option value="CDI">CDI</option>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input" class="col-3 col-form-label">Avenant
                                                    signé</label>

                                                <div class="col-9 row" style="padding-top:5px">
                                                    <input class="fichiers form-control" type="file" value=""
                                                        id="example-text-input" name="fichierAvenant">

                                                </div>


                                            </div>

                                        </div>
                                        <input type="hidden" name="idPersonnelClient"
                                            value={{ $person->idPersonnelClient }}>
                                        <button class="theme-bg btn btn-rounded mt-4"><i class="fa fa-plus"></i>
                                            Ajouter</button>
                                    </form>
                                    @else

                                    <div class="form-check has-success">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="option1"
                                                id="checkbox3" required checked disabled>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Modification contrat</span>
                                        </label>

                                    </div>
                                    <div id="">
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Date</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text"
                                                    value="{{date('d-m-Y', strtotime($avenantSigner[0]->dateAvenant))}}"
                                                    id="example-text-input" name="dateAvenant" disabled>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Nature</label>
                                            <div class="col-9">
                                                <select class="form-control select2" style="width: 100%;" name="nature"
                                                    id="R" required disabled>
                                                    <option value="{{$avenantSigner[0]->nature}}" selected disabled>
                                                        {{$avenantSigner[0]->nature}}</option>

                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label for="example-text-input" class="col-3 col-form-label">Avenant
                                                signé</label>

                                            <div class="col-9 row" style="padding-top:5px">
                                                <p>- Vous trouverez le fichier dans le panel <b>Modification du
                                                        contrat</b></p>

                                            </div>


                                        </div>
                                        <p class="theme-cl"><i class="fa fa-info-circle"></i> Pour changer cet avenant
                                            veuillez supprimer d'abord l'avenant ci-dessous.</p>


                                    </div>

                                    @endif
                                </div>
                                <div class="col-md-4" style="padding: 20px">
                                @if(empty($finContrat))
                                    <form method="POST" action="{{route('addFinContratClient')}}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-check has-success">

                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="option1"
                                                    id="checkbox4" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Contrat terminé</span>
                                            </label>
                                        </div>
                                        <div id="elementContratTerminer">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="date" value=""
                                                        id="example-text-input" name="dateTerminer">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Motif</label>
                                                <div class="col-9">
                                                    <textarea class="form-control" name="motif" id="" cols="30" rows="3"
                                                        name="motif"></textarea>

                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Document</label>
                                                <div class="col-9">
                                                    <input class="fichiers form-control" type="file" value=""
                                                        id="example-text-input" name="fichierFinContrat" required>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="idPersonnelClient"
                                            value={{ $person->idPersonnelClient }}>
                                        <button class="theme-bg btn btn-rounded mt-4"><i class="fa fa-plus"></i>
                                            Ajouter</button>
                                    </form>
                                    @else
                                    <div class="form-check has-success">

                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="option1"
                                                    id="checkbox4" required checked disabled>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Contrat terminé</span>
                                            </label>
                                        </div>
                                        <div id="">
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Date</label>
                                                <div class="col-9">
                                                    <input class="form-control" type="text" value="{{$finContrat[0]->dateTerminer}}"
                                                        id="example-text-input" name="dateTerminer">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Motif</label>
                                                <div class="col-9">
                                                    <textarea class="form-control" name="" id="" cols="30" rows="3"
                                                        name="motif">{{$finContrat[0]->motif}}</textarea>

                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <label for="example-text-input"
                                                    class="col-3 col-form-label">Document</label>
                                                <div class="col-9" style="padding-top:5px">
                                                <p>- Vous trouverez le fichier dans le panel <b>Fin de contrat</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card padd-15">
                            <div class="tab" role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active" onclick="changeT1()" id="t1"><a
                                            href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i
                                                class="fa fa-file"></i> Contrat signée / non
                                            signée</a></li>
                                    <li role="presentation" onclick="changeT2()" id="t2"><a href="#Section2" role="tab"
                                            data-toggle="tab" class="" aria-selected="true"><i class="fa fa-pencil"></i>
                                            Modification du contrat</a></li>
                                    <li role="presentation" onclick="changeT3()" id="t3"><a href="#Section3" role="tab"
                                            data-toggle="tab" class="" aria-selected="false"><i class="fa fa-close"></i>
                                            Fin de contrat</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs" id="home" style="">

                                    <div role="tabpanel" class="tab-pane fade active in" id="Section1">
                                        @if($fichierContratSigner=='')
                                        <div class="card padd-10" style="background-color:whitesmoke;">
                                            @if($contrat[0]->dureeContrat=='Indéterminé')
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:white;padding-top:20px">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION NON SIGNÉE DU
                                                    CONTRAT</h1>
                                                <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt=""
                                                    style="height: 80px;margin-bottom:20px">
                                                <div class="col-md-12"
                                                    style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                                                    <h4>CONTRAT DE TRAVAIL</h4>
                                                    <h4>À DURÉE INDÉTERMINÉE</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5><b style="text-decoration: underline black;">Entre les sousignés
                                                            :</b></h5>
                                                    <p>La société {{ $contrat[0]->denomination }} au Capital Social de
                                                        {{ $contrat[0]->capitalSocial }} GNF
                                                        immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }},
                                                        ayant son siège
                                                        social sis à
                                                        {{ $contrat[0]->adresseEntreprise }}, représentée par son
                                                        dirigent légal,
                                                        ci-après désignée
                                                        <b>‘’Employeur’’</b>
                                                    </p>
                                                    <p style="text-align: right;"><b>D'une part</b></p>
                                                    <p style="text-align: left;"><b>Et</b></p>
                                                    <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen
                                                        de nationalité
                                                        {{ $contrat[0]->nationalite }} né le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                                                        {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins
                                                        des présentes au
                                                        siège social de
                                                        l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }}
                                                        N°{{ $contrat[0]->numPiece }} valable
                                                        jusqu’au
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }}
                                                        ci-après «
                                                        <b>Employé</b> » ;
                                                    </p>
                                                    <p>Lequel déclare être libre de tout engagement autre que celui
                                                        prévu dans le
                                                        présent contrat ;</p>
                                                    <p style="text-align: right;"><b> D’autre part </b></p>
                                                    <p>L’Employeur et l’Employé, étant désignés collectivement les «
                                                        Parties » et
                                                        individuellement la «
                                                        Partie » ;</p>
                                                    <h4
                                                        style="text-decoration: underline black;text-align:center;margin-top:50px">
                                                        Il
                                                        EST CONVENU ET ARRÊTÉ
                                                        CE QUI SUIT :</h4>
                                                    <p>Le présent contrat est régi par les dispositions de la loi
                                                        N°L/2014/072/CNT du 10
                                                        janvier 2014
                                                        portant Code du Travail de la République de Guinée (ci-après, «
                                                        Code du Travail
                                                        ») et les textes
                                                        pris en vue de son application ainsi que le règlement intérieur
                                                        de la COMPAGNIE.
                                                    </p>
                                                    <h4>ARTICLE 1 : ENGAGEMENT</h4>
                                                    <p>L’Employé est engagé par l’Employeur à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous
                                                        réserve (i)
                                                        qu’il soit déclaré apte
                                                        à l’issue d’un examen médical organisé par l’Employeur dans les
                                                        plus brefs
                                                        délais et compte tenu des
                                                        contraintes liées à la maladie du coronavirus 2019 (Covid 19) et
                                                        (ii) qu’il
                                                        fournisse dans le délai
                                                        imparti tous les documents demandés en vue de l’embauche.
                                                        Il reste entendu que l’Employé est tenu de se soumettre à
                                                        l’examen médical et
                                                        que toute
                                                        communication par lui d’un document dont le caractère faux est
                                                        découvert par
                                                        l’Employeur après
                                                        l’embauche, constitue une faute grave au sens du présent contrat
                                                        et justifie de
                                                        ce fait une
                                                        cessation immédiate du lien de travail sans indemnité ni
                                                        préavis.</p>
                                                    <p>L’Employé déclare être libre de tout engagement, et s’oblige :
                                                    </p>
                                                    <ul>
                                                        <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances,
                                                            les missions
                                                            qui lui seront
                                                            confiées par l’Employeur et/ou ses représentants ;</li>
                                                        <li>●&nbsp;&nbsp;À respecter la discipline et les directives de
                                                            ses supérieurs
                                                            hiérarchiques ;</li>
                                                        <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles
                                                            et usages en
                                                            vigueur au sein de
                                                            l’entreprise.</li>
                                                    </ul>
                                                    <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke
                                                        des données
                                                        personnelles le
                                                        concernant, y compris des données sur la santé et la sécurité au
                                                        travail, pour
                                                        satisfaire aux
                                                        exigences légales ainsi que dans le cadre de la conduite des
                                                        affaires de
                                                        l’Employeur.</p>
                                                    <p>En outre, l’Employé s’engage expressément à adhérer et respecter
                                                        le Code de
                                                        conduite et le Règlement
                                                        Intérieur mis en place par l’Employeur.</p>
                                                    <p>L’Employé est tenu de connaître l’intégralité de la teneur
                                                        desdits documents dont
                                                        une copie de chaque
                                                        sera tenue à sa disposition par l’Employeur à partir de la date
                                                        d’embauche.</p>
                                                    <h4>ARTICLE 2 : DUREE DU CONTRAT ET PERIODE D’ESSAI</h4>
                                                    <p>Le présent Contrat est conclu pour une durée indéterminée. </p>
                                                    <p>La prise de fonction du salarié débutera par une période d’essai
                                                        de
                                                        {{ $contrat[0]->dureePeriodeEssai }}. Chaque partie sera libre
                                                        de mettre un
                                                        terme au contrat durant
                                                        cette période, sans versement d’indemnités, en respectant le
                                                        délai de préavis.
                                                    </p>
                                                    <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                                                    <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                                                    <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à
                                                        ce poste de
                                                        gérant dans le cadre de
                                                        sa fonction.</p>
                                                    <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                                                    <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les
                                                        besoins de la
                                                        société, il pourrait
                                                        être affecté en tout autre lieu du territoire de la République
                                                        de Guinée.</p>
                                                    <p>L’Employé pourra en outre être amené, en cas de nécessité pour la
                                                        société, à
                                                        effectuer des
                                                        déplacements ponctuels à l’étranger ou à l’intérieur du pays ne
                                                        nécessitant pas
                                                        le changement de sa
                                                        résidence habituelle. </p>
                                                    <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                                                    <p>Le présent contrat de travail est soumis au régime de quarante
                                                        (40) heures de
                                                        travail par semaine à
                                                        raison de huit (08) heures de travail par jour.
                                                        Le Code du travail prévoie la possibilité de réaliser des heures
                                                        supplémentaires.
                                                    </p>
                                                    <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                                                    <p>En contrepartie de son activité professionnelle, l’employé
                                                        percevra un salaire
                                                        mensuel composé comme
                                                        suit :</p>
                                                    <ul>
                                                        <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                                                        <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}
                                                        </li>
                                                        <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}
                                                        </li>
                                                        <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                                                    </ul>
                                                    <p>pour un salaire net de ...... francs guinéens, versé le dernier
                                                        jour du mois.</p>
                                                    <h4>ARTICLE 7 : CONGÉS</h4>
                                                    <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours
                                                        ouvrables par mois
                                                        de travail effectif.
                                                    </p>
                                                    <p>La période de ce congé sera fixée compte tenu des nécessités du
                                                        service et devra
                                                        faire l’objet d’une
                                                        demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                                                    <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                                                    <p>L’employé bénéficiera du régime d’assurances sociales prévu par
                                                        la réglementation
                                                        en vigueur en
                                                        République de Guinée (Soins médicaux, accident de travail,
                                                        maladie
                                                        professionnelle, prestations
                                                        familiales, retraite).</p>
                                                    <p>Il sera immatriculé à la Caisse nationale de sécurité sociale
                                                        (CNSS).</p>
                                                    <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                                                    <p>L’employé s’engage à observer toutes les instructions et
                                                        consignes particulières
                                                        de travail ayant
                                                        trait à sa fonction. Il s’engage également à consacrer tout son
                                                        temps, toute son
                                                        activité et toutes
                                                        ses connaissances à l’exercice de ses fonctions et à ne
                                                        s’occuper exclusivement,
                                                        pendant la durée du
                                                        présent contrat, que des activités de l’Employeur, s’interdisant
                                                        formellement de
                                                        s’intéresser
                                                        directement ou indirectement à d’autres affaires, sauf accord
                                                        exprès et
                                                        préalable de l’employeur.
                                                    </p>
                                                    <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                                                    <p>L’employé s’engage pendant la durée de son contrat de travail, et
                                                        après sa
                                                        rupture à ne pas divulguer
                                                        des informations confidentielles sur la société, qu’elles soient
                                                        en rapport ou
                                                        non avec sa fonction.
                                                        Et ceci par quelque moyen que ce soit : oral, verbal,
                                                        informatique, écrit… et
                                                        que ce soit à
                                                        l’intérieur ou à l’extérieur de l’entreprise.</p>
                                                    <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                                                    <p>Le présent contrat peut être rompu, dans les conditions prévues
                                                        par la loi :</p>
                                                    <ul>
                                                        <li>1. D’un commun accord entre les Parties ;</li>
                                                        <li>2. En cas de faute grave de l’Employé ou de force majeure.
                                                            Est considéré
                                                            comme cas de force
                                                            majeure, tout événement imprévisible, irrésistible et
                                                            extérieur à la Partie
                                                            qui l’invoque et
                                                            dont la survenance empêche l’exécution totale de ses
                                                            obligations ; </li>
                                                        <li>3. En cas de cessation d'activité de l'Employeur.</li>
                                                    </ul>
                                                    <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                                                    <p>Les Parties s’obligent à rechercher une solution amiable à tout
                                                        différend
                                                        résultant de
                                                        l'interprétation ou de l'exécution du présent contrat de
                                                        travail, dans un délai
                                                        de trente (30) jours
                                                        à compter de la réception par l’une d’entre elles de la demande
                                                        de règlement
                                                        amiable adressée par
                                                        l’autre. </p>
                                                    <p>En cas d’échec du règlement amiable ou à l’expiration du délai
                                                        susmentionné de
                                                        trente (30) jours,
                                                        chacune des Parties pourra, sauf accord contraire, porter le
                                                        différend devant la
                                                        juridiction
                                                        territorialement compétente en matière sociale, conformément aux
                                                        articles 520.1
                                                        et suivants du Code
                                                        du Travail.</p>
                                                    <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                    </p>
                                                    <p style="text-align: right;">Fait en deux (02) exemplaires
                                                        originaux</p>
                                                    <div class="row col-md-12"
                                                        style="margin-top: 50px;text-align:center">
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYEUR</h4>
                                                            <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYE</h4>
                                                            <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}
                                                            </h5>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            @else
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:white;padding-top:20px">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION NON SIGNÉE DU
                                                    CONTRAT</h1>
                                                <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt=""
                                                    style="height: 80px;margin-bottom:20px">
                                                <div class="col-md-12"
                                                    style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                                                    <h4>CONTRAT DE TRAVAIL</h4>
                                                    <h4>À DURÉE DÉTERMINÉE</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5><b style="text-decoration: underline black;">Entre les sousignés
                                                            :</b></h5>
                                                    <p>La société {{ $contrat[0]->denomination }} au Capital Social de
                                                        {{ $contrat[0]->capitalSocial }} GNF
                                                        immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }},
                                                        ayant son siège
                                                        social sis à
                                                        {{ $contrat[0]->adresseEntreprise }}, représentée par son
                                                        dirigent légal,
                                                        ci-après désignée
                                                        <b>‘’Employeur’’</b>
                                                    </p>
                                                    <p style="text-align: right;"><b>D'une part</b></p>
                                                    <p style="text-align: left;"><b>Et</b></p>
                                                    <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen
                                                        de nationalité
                                                        {{ $contrat[0]->nationalite }} né le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                                                        {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins
                                                        des présentes au
                                                        siège social de
                                                        l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }}
                                                        N°{{ $contrat[0]->numPiece }} valable
                                                        jusqu’au
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }}
                                                        ci-après «
                                                        <b>Employé</b> » ;
                                                    </p>
                                                    <p>Lequel déclare être libre de tout engagement autre que celui
                                                        prévu dans le
                                                        présent contrat ;</p>
                                                    <p style="text-align: right;"><b> D’autre part </b></p>
                                                    <p>L’Employeur et l’Employé, étant désignés collectivement les «
                                                        Parties » et
                                                        individuellement la «
                                                        Partie » ;</p>
                                                    <h4
                                                        style="text-decoration: underline black;text-align:center;margin-top:50px">
                                                        Il
                                                        EST CONVENU ET ARRÊTÉ
                                                        CE QUI SUIT :</h4>
                                                    <p>Le présent contrat est régi par les dispositions de la loi
                                                        N°L/2014/072/CNT du 10
                                                        janvier 2014
                                                        portant Code du Travail de la République de Guinée (ci-après, «
                                                        Code du Travail
                                                        ») et les textes
                                                        pris en vue de son application ainsi que le règlement intérieur
                                                        de la COMPAGNIE.
                                                    </p>
                                                    <h4>ARTICLE 1 : ENGAGEMENT</h4>
                                                    <p>L’Employé est engagé par l’Employeur à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous
                                                        réserve (i)
                                                        qu’il soit déclaré apte
                                                        à l’issue d’un examen médical organisé par l’Employeur dans les
                                                        plus brefs
                                                        délais et compte tenu des
                                                        contraintes liées à la maladie du coronavirus 2019 (Covid 19) et
                                                        (ii) qu’il
                                                        fournisse dans le délai
                                                        imparti tous les documents demandés en vue de l’embauche.
                                                        Il reste entendu que l’Employé est tenu de se soumettre à
                                                        l’examen médical et
                                                        que toute
                                                        communication par lui d’un document dont le caractère faux est
                                                        découvert par
                                                        l’Employeur après
                                                        l’embauche, constitue une faute grave au sens du présent contrat
                                                        et justifie de
                                                        ce fait une
                                                        cessation immédiate du lien de travail sans indemnité ni
                                                        préavis.</p>
                                                    <p>L’Employé déclare être libre de tout engagement, et s’oblige :
                                                    </p>
                                                    <ul>
                                                        <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances,
                                                            les missions
                                                            qui lui seront
                                                            confiées par l’Employeur et/ou ses représentants ;</li>
                                                        <li>●&nbsp;&nbsp;À respecter la discipline et les directives de
                                                            ses supérieurs
                                                            hiérarchiques ;</li>
                                                        <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles
                                                            et usages en
                                                            vigueur au sein de
                                                            l’entreprise.</li>
                                                    </ul>
                                                    <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke
                                                        des données
                                                        personnelles le
                                                        concernant, y compris des données sur la santé et la sécurité au
                                                        travail, pour
                                                        satisfaire aux
                                                        exigences légales ainsi que dans le cadre de la conduite des
                                                        affaires de
                                                        l’Employeur.</p>
                                                    <p>En outre, l’Employé s’engage expressément à adhérer et respecter
                                                        le Code de
                                                        conduite et le Règlement
                                                        Intérieur mis en place par l’Employeur.</p>
                                                    <p>L’Employé est tenu de connaître l’intégralité de la teneur
                                                        desdits documents dont
                                                        une copie de chaque
                                                        sera tenue à sa disposition par l’Employeur à partir de la date
                                                        d’embauche.</p>
                                                    <h4>ARTICLE 2 : DUREE DU CONTRAT</h4>
                                                    <p>Le présent Contrat est conclu pour une durée de
                                                        {{ $contrat[0]->dureeContrat }},
                                                        à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                        et prendra fin
                                                        le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateFinContrat)) }} </p>
                                                    <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                                                    <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                                                    <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à
                                                        ce poste de
                                                        gérant dans le cadre de
                                                        sa fonction.</p>
                                                    <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                                                    <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les
                                                        besoins de la
                                                        société, il pourrait
                                                        être affecté en tout autre lieu du territoire de la République
                                                        de Guinée.</p>
                                                    <p>L’Employé pourra en outre être amené, en cas de nécessité pour la
                                                        société, à
                                                        effectuer des
                                                        déplacements ponctuels à l’étranger ou à l’intérieur du pays ne
                                                        nécessitant pas
                                                        le changement de sa
                                                        résidence habituelle. </p>
                                                    <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                                                    <p>Le présent contrat de travail est soumis au régime de quarante
                                                        (40) heures de
                                                        travail par semaine à
                                                        raison de huit (08) heures de travail par jour.
                                                        Le Code du travail prévoie la possibilité de réaliser des heures
                                                        supplémentaires.
                                                    </p>
                                                    <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                                                    <p>En contrepartie de son activité professionnelle, l’employé
                                                        percevra un salaire
                                                        mensuel composé comme
                                                        suit :</p>
                                                    <ul>
                                                        <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                                                        <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}
                                                        </li>
                                                        <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}
                                                        </li>
                                                        <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                                                    </ul>
                                                    <p>pour un salaire net de ...... francs guinéens, versé le dernier
                                                        jour du mois.</p>
                                                    <h4>ARTICLE 7 : CONGÉS</h4>
                                                    <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours
                                                        ouvrables par mois
                                                        de travail effectif.
                                                    </p>
                                                    <p>La période de ce congé sera fixée compte tenu des nécessités du
                                                        service et devra
                                                        faire l’objet d’une
                                                        demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                                                    <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                                                    <p>L’employé bénéficiera du régime d’assurances sociales prévu par
                                                        la réglementation
                                                        en vigueur en
                                                        République de Guinée (Soins médicaux, accident de travail,
                                                        maladie
                                                        professionnelle, prestations
                                                        familiales, retraite).</p>
                                                    <p>Il sera immatriculé à la Caisse nationale de sécurité sociale
                                                        (CNSS).</p>
                                                    <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                                                    <p>L’employé s’engage à observer toutes les instructions et
                                                        consignes particulières
                                                        de travail ayant
                                                        trait à sa fonction. Il s’engage également à consacrer tout son
                                                        temps, toute son
                                                        activité et toutes
                                                        ses connaissances à l’exercice de ses fonctions et à ne
                                                        s’occuper exclusivement,
                                                        pendant la durée du
                                                        présent contrat, que des activités de l’Employeur, s’interdisant
                                                        formellement de
                                                        s’intéresser
                                                        directement ou indirectement à d’autres affaires, sauf accord
                                                        exprès et
                                                        préalable de l’employeur.
                                                    </p>
                                                    <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                                                    <p>L’employé s’engage pendant la durée de son contrat de travail, et
                                                        après sa
                                                        rupture à ne pas divulguer
                                                        des informations confidentielles sur la société, qu’elles soient
                                                        en rapport ou
                                                        non avec sa fonction.
                                                        Et ceci par quelque moyen que ce soit : oral, verbal,
                                                        informatique, écrit… et
                                                        que ce soit à
                                                        l’intérieur ou à l’extérieur de l’entreprise.</p>
                                                    <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                                                    <p>Le présent contrat peut être rompu, dans les conditions prévues
                                                        par la loi :</p>
                                                    <ul>
                                                        <li>1. D’un commun accord entre les Parties ;</li>
                                                        <li>2. En cas de faute grave de l’Employé ou de force majeure.
                                                            Est considéré
                                                            comme cas de force
                                                            majeure, tout événement imprévisible, irrésistible et
                                                            extérieur à la Partie
                                                            qui l’invoque et
                                                            dont la survenance empêche l’exécution totale de ses
                                                            obligations ; </li>
                                                        <li>3. En cas de cessation d'activité de l'Employeur.</li>
                                                    </ul>
                                                    <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                                                    <p>Les Parties s’obligent à rechercher une solution amiable à tout
                                                        différend
                                                        résultant de
                                                        l'interprétation ou de l'exécution du présent contrat de
                                                        travail, dans un délai
                                                        de trente (30) jours
                                                        à compter de la réception par l’une d’entre elles de la demande
                                                        de règlement
                                                        amiable adressée par
                                                        l’autre. </p>
                                                    <p>En cas d’échec du règlement amiable ou à l’expiration du délai
                                                        susmentionné de
                                                        trente (30) jours,
                                                        chacune des Parties pourra, sauf accord contraire, porter le
                                                        différend devant la
                                                        juridiction
                                                        territorialement compétente en matière sociale, conformément aux
                                                        articles 520.1
                                                        et suivants du Code
                                                        du Travail.</p>
                                                    <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                    </p>
                                                    <p style="text-align: right;">Fait en deux (02) exemplaires
                                                        originaux</p>
                                                    <div class="row col-md-12"
                                                        style="margin-top: 50px;text-align:center">
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYEUR</h4>
                                                            <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYE</h4>
                                                            <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}
                                                            </h5>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            @endif

                                        </div>
                                        @else
                                        <div class="card padd-10" style="">
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; background-color:white;padding-top:20px;text-align:center">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION SIGNÉE DU CONTRAT
                                                </h1>
                                                <p><i class="fa fa-info-circle"></i> Veuillez cliquer sur l'icone
                                                    ci-dessous pour voir le contrat.</p>

                                                <a class="load"
                                                    href="{{route('readFile', [$fichierContratSigner[0]->slug,'x'])}}">
                                                    <img src="{{URL::to('/')}}/assets/upload/contrat.png" alt=""
                                                        style="height:400px">
                                                </a> <br>
                                                <a href="{{route('deleteContraSignerClient',$contratSigner[0]->slug)}}"
                                                    type="button" class="btn btn-outline-danger  btn-sm"><i
                                                        class="ti-trash"></i></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                                        @if($fichierAvenant=='')
                                        <div class="card padd-10" style="background-color:whitesmoke;">
                                            @if($contrat[0]->dureeContrat=='Indéterminé')
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:white;padding-top:20px">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION NON SIGNÉE DE
                                                    L'AVENANT</h1>
                                                <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt=""
                                                    style="height: 80px;margin-bottom:20px">
                                                <div class="col-md-12"
                                                    style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                                                    <h4>CONTRAT DE TRAVAIL</h4>
                                                    <h4>À DURÉE INDÉTERMINÉE</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5><b style="text-decoration: underline black;">Entre les sousignés
                                                            :</b></h5>
                                                    <p>La société {{ $contrat[0]->denomination }} au Capital Social de
                                                        {{ $contrat[0]->capitalSocial }} GNF
                                                        immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }},
                                                        ayant son siège
                                                        social sis à
                                                        {{ $contrat[0]->adresseEntreprise }}, représentée par son
                                                        dirigent légal,
                                                        ci-après désignée
                                                        <b>‘’Employeur’’</b>
                                                    </p>
                                                    <p style="text-align: right;"><b>D'une part</b></p>
                                                    <p style="text-align: left;"><b>Et</b></p>
                                                    <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen
                                                        de nationalité
                                                        {{ $contrat[0]->nationalite }} né le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                                                        {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins
                                                        des présentes au
                                                        siège social de
                                                        l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }}
                                                        N°{{ $contrat[0]->numPiece }} valable
                                                        jusqu’au
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }}
                                                        ci-après «
                                                        <b>Employé</b> » ;
                                                    </p>
                                                    <p>Lequel déclare être libre de tout engagement autre que celui
                                                        prévu dans le
                                                        présent contrat ;</p>
                                                    <p style="text-align: right;"><b> D’autre part </b></p>
                                                    <p>L’Employeur et l’Employé, étant désignés collectivement les «
                                                        Parties » et
                                                        individuellement la «
                                                        Partie » ;</p>
                                                    <h4
                                                        style="text-decoration: underline black;text-align:center;margin-top:50px">
                                                        Il
                                                        EST CONVENU ET ARRÊTÉ
                                                        CE QUI SUIT :</h4>
                                                    <p>Le présent contrat est régi par les dispositions de la loi
                                                        N°L/2014/072/CNT du 10
                                                        janvier 2014
                                                        portant Code du Travail de la République de Guinée (ci-après, «
                                                        Code du Travail
                                                        ») et les textes
                                                        pris en vue de son application ainsi que le règlement intérieur
                                                        de la COMPAGNIE.
                                                    </p>
                                                    <h4>ARTICLE 1 : ENGAGEMENT</h4>
                                                    <p>L’Employé est engagé par l’Employeur à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous
                                                        réserve (i)
                                                        qu’il soit déclaré apte
                                                        à l’issue d’un examen médical organisé par l’Employeur dans les
                                                        plus brefs
                                                        délais et compte tenu des
                                                        contraintes liées à la maladie du coronavirus 2019 (Covid 19) et
                                                        (ii) qu’il
                                                        fournisse dans le délai
                                                        imparti tous les documents demandés en vue de l’embauche.
                                                        Il reste entendu que l’Employé est tenu de se soumettre à
                                                        l’examen médical et
                                                        que toute
                                                        communication par lui d’un document dont le caractère faux est
                                                        découvert par
                                                        l’Employeur après
                                                        l’embauche, constitue une faute grave au sens du présent contrat
                                                        et justifie de
                                                        ce fait une
                                                        cessation immédiate du lien de travail sans indemnité ni
                                                        préavis.</p>
                                                    <p>L’Employé déclare être libre de tout engagement, et s’oblige :
                                                    </p>
                                                    <ul>
                                                        <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances,
                                                            les missions
                                                            qui lui seront
                                                            confiées par l’Employeur et/ou ses représentants ;</li>
                                                        <li>●&nbsp;&nbsp;À respecter la discipline et les directives de
                                                            ses supérieurs
                                                            hiérarchiques ;</li>
                                                        <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles
                                                            et usages en
                                                            vigueur au sein de
                                                            l’entreprise.</li>
                                                    </ul>
                                                    <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke
                                                        des données
                                                        personnelles le
                                                        concernant, y compris des données sur la santé et la sécurité au
                                                        travail, pour
                                                        satisfaire aux
                                                        exigences légales ainsi que dans le cadre de la conduite des
                                                        affaires de
                                                        l’Employeur.</p>
                                                    <p>En outre, l’Employé s’engage expressément à adhérer et respecter
                                                        le Code de
                                                        conduite et le Règlement
                                                        Intérieur mis en place par l’Employeur.</p>
                                                    <p>L’Employé est tenu de connaître l’intégralité de la teneur
                                                        desdits documents dont
                                                        une copie de chaque
                                                        sera tenue à sa disposition par l’Employeur à partir de la date
                                                        d’embauche.</p>
                                                    <h4>ARTICLE 2 : DUREE DU CONTRAT ET PERIODE D’ESSAI</h4>
                                                    <p>Le présent Contrat est conclu pour une durée indéterminée. </p>
                                                    <p>La prise de fonction du salarié débutera par une période d’essai
                                                        de
                                                        {{ $contrat[0]->dureePeriodeEssai }}. Chaque partie sera libre
                                                        de mettre un
                                                        terme au contrat durant
                                                        cette période, sans versement d’indemnités, en respectant le
                                                        délai de préavis.
                                                    </p>
                                                    <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                                                    <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                                                    <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à
                                                        ce poste de
                                                        gérant dans le cadre de
                                                        sa fonction.</p>
                                                    <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                                                    <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les
                                                        besoins de la
                                                        société, il pourrait
                                                        être affecté en tout autre lieu du territoire de la République
                                                        de Guinée.</p>
                                                    <p>L’Employé pourra en outre être amené, en cas de nécessité pour la
                                                        société, à
                                                        effectuer des
                                                        déplacements ponctuels à l’étranger ou à l’intérieur du pays ne
                                                        nécessitant pas
                                                        le changement de sa
                                                        résidence habituelle. </p>
                                                    <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                                                    <p>Le présent contrat de travail est soumis au régime de quarante
                                                        (40) heures de
                                                        travail par semaine à
                                                        raison de huit (08) heures de travail par jour.
                                                        Le Code du travail prévoie la possibilité de réaliser des heures
                                                        supplémentaires.
                                                    </p>
                                                    <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                                                    <p>En contrepartie de son activité professionnelle, l’employé
                                                        percevra un salaire
                                                        mensuel composé comme
                                                        suit :</p>
                                                    <ul>
                                                        <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                                                        <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}
                                                        </li>
                                                        <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}
                                                        </li>
                                                        <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                                                    </ul>
                                                    <p>pour un salaire net de ...... francs guinéens, versé le dernier
                                                        jour du mois.</p>
                                                    <h4>ARTICLE 7 : CONGÉS</h4>
                                                    <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours
                                                        ouvrables par mois
                                                        de travail effectif.
                                                    </p>
                                                    <p>La période de ce congé sera fixée compte tenu des nécessités du
                                                        service et devra
                                                        faire l’objet d’une
                                                        demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                                                    <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                                                    <p>L’employé bénéficiera du régime d’assurances sociales prévu par
                                                        la réglementation
                                                        en vigueur en
                                                        République de Guinée (Soins médicaux, accident de travail,
                                                        maladie
                                                        professionnelle, prestations
                                                        familiales, retraite).</p>
                                                    <p>Il sera immatriculé à la Caisse nationale de sécurité sociale
                                                        (CNSS).</p>
                                                    <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                                                    <p>L’employé s’engage à observer toutes les instructions et
                                                        consignes particulières
                                                        de travail ayant
                                                        trait à sa fonction. Il s’engage également à consacrer tout son
                                                        temps, toute son
                                                        activité et toutes
                                                        ses connaissances à l’exercice de ses fonctions et à ne
                                                        s’occuper exclusivement,
                                                        pendant la durée du
                                                        présent contrat, que des activités de l’Employeur, s’interdisant
                                                        formellement de
                                                        s’intéresser
                                                        directement ou indirectement à d’autres affaires, sauf accord
                                                        exprès et
                                                        préalable de l’employeur.
                                                    </p>
                                                    <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                                                    <p>L’employé s’engage pendant la durée de son contrat de travail, et
                                                        après sa
                                                        rupture à ne pas divulguer
                                                        des informations confidentielles sur la société, qu’elles soient
                                                        en rapport ou
                                                        non avec sa fonction.
                                                        Et ceci par quelque moyen que ce soit : oral, verbal,
                                                        informatique, écrit… et
                                                        que ce soit à
                                                        l’intérieur ou à l’extérieur de l’entreprise.</p>
                                                    <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                                                    <p>Le présent contrat peut être rompu, dans les conditions prévues
                                                        par la loi :</p>
                                                    <ul>
                                                        <li>1. D’un commun accord entre les Parties ;</li>
                                                        <li>2. En cas de faute grave de l’Employé ou de force majeure.
                                                            Est considéré
                                                            comme cas de force
                                                            majeure, tout événement imprévisible, irrésistible et
                                                            extérieur à la Partie
                                                            qui l’invoque et
                                                            dont la survenance empêche l’exécution totale de ses
                                                            obligations ; </li>
                                                        <li>3. En cas de cessation d'activité de l'Employeur.</li>
                                                    </ul>
                                                    <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                                                    <p>Les Parties s’obligent à rechercher une solution amiable à tout
                                                        différend
                                                        résultant de
                                                        l'interprétation ou de l'exécution du présent contrat de
                                                        travail, dans un délai
                                                        de trente (30) jours
                                                        à compter de la réception par l’une d’entre elles de la demande
                                                        de règlement
                                                        amiable adressée par
                                                        l’autre. </p>
                                                    <p>En cas d’échec du règlement amiable ou à l’expiration du délai
                                                        susmentionné de
                                                        trente (30) jours,
                                                        chacune des Parties pourra, sauf accord contraire, porter le
                                                        différend devant la
                                                        juridiction
                                                        territorialement compétente en matière sociale, conformément aux
                                                        articles 520.1
                                                        et suivants du Code
                                                        du Travail.</p>
                                                    <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                    </p>
                                                    <p style="text-align: right;">Fait en deux (02) exemplaires
                                                        originaux</p>
                                                    <div class="row col-md-12"
                                                        style="margin-top: 50px;text-align:center">
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYEUR</h4>
                                                            <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYE</h4>
                                                            <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}
                                                            </h5>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            @else
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:white;padding-top:20px">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION NON SIGNÉE DE
                                                    L'AVENANT</h1>
                                                <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt=""
                                                    style="height: 80px;margin-bottom:20px">
                                                <div class="col-md-12"
                                                    style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                                                    <h4>CONTRAT DE TRAVAIL</h4>
                                                    <h4>À DURÉE DÉTERMINÉE</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5><b style="text-decoration: underline black;">Entre les sousignés
                                                            :</b></h5>
                                                    <p>La société {{ $contrat[0]->denomination }} au Capital Social de
                                                        {{ $contrat[0]->capitalSocial }} GNF
                                                        immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }},
                                                        ayant son siège
                                                        social sis à
                                                        {{ $contrat[0]->adresseEntreprise }}, représentée par son
                                                        dirigent légal,
                                                        ci-après désignée
                                                        <b>‘’Employeur’’</b>
                                                    </p>
                                                    <p style="text-align: right;"><b>D'une part</b></p>
                                                    <p style="text-align: left;"><b>Et</b></p>
                                                    <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen
                                                        de nationalité
                                                        {{ $contrat[0]->nationalite }} né le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                                                        {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins
                                                        des présentes au
                                                        siège social de
                                                        l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }}
                                                        N°{{ $contrat[0]->numPiece }} valable
                                                        jusqu’au
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }}
                                                        ci-après «
                                                        <b>Employé</b> » ;
                                                    </p>
                                                    <p>Lequel déclare être libre de tout engagement autre que celui
                                                        prévu dans le
                                                        présent contrat ;</p>
                                                    <p style="text-align: right;"><b> D’autre part </b></p>
                                                    <p>L’Employeur et l’Employé, étant désignés collectivement les «
                                                        Parties » et
                                                        individuellement la «
                                                        Partie » ;</p>
                                                    <h4
                                                        style="text-decoration: underline black;text-align:center;margin-top:50px">
                                                        Il
                                                        EST CONVENU ET ARRÊTÉ
                                                        CE QUI SUIT :</h4>
                                                    <p>Le présent contrat est régi par les dispositions de la loi
                                                        N°L/2014/072/CNT du 10
                                                        janvier 2014
                                                        portant Code du Travail de la République de Guinée (ci-après, «
                                                        Code du Travail
                                                        ») et les textes
                                                        pris en vue de son application ainsi que le règlement intérieur
                                                        de la COMPAGNIE.
                                                    </p>
                                                    <h4>ARTICLE 1 : ENGAGEMENT</h4>
                                                    <p>L’Employé est engagé par l’Employeur à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous
                                                        réserve (i)
                                                        qu’il soit déclaré apte
                                                        à l’issue d’un examen médical organisé par l’Employeur dans les
                                                        plus brefs
                                                        délais et compte tenu des
                                                        contraintes liées à la maladie du coronavirus 2019 (Covid 19) et
                                                        (ii) qu’il
                                                        fournisse dans le délai
                                                        imparti tous les documents demandés en vue de l’embauche.
                                                        Il reste entendu que l’Employé est tenu de se soumettre à
                                                        l’examen médical et
                                                        que toute
                                                        communication par lui d’un document dont le caractère faux est
                                                        découvert par
                                                        l’Employeur après
                                                        l’embauche, constitue une faute grave au sens du présent contrat
                                                        et justifie de
                                                        ce fait une
                                                        cessation immédiate du lien de travail sans indemnité ni
                                                        préavis.</p>
                                                    <p>L’Employé déclare être libre de tout engagement, et s’oblige :
                                                    </p>
                                                    <ul>
                                                        <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances,
                                                            les missions
                                                            qui lui seront
                                                            confiées par l’Employeur et/ou ses représentants ;</li>
                                                        <li>●&nbsp;&nbsp;À respecter la discipline et les directives de
                                                            ses supérieurs
                                                            hiérarchiques ;</li>
                                                        <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles
                                                            et usages en
                                                            vigueur au sein de
                                                            l’entreprise.</li>
                                                    </ul>
                                                    <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke
                                                        des données
                                                        personnelles le
                                                        concernant, y compris des données sur la santé et la sécurité au
                                                        travail, pour
                                                        satisfaire aux
                                                        exigences légales ainsi que dans le cadre de la conduite des
                                                        affaires de
                                                        l’Employeur.</p>
                                                    <p>En outre, l’Employé s’engage expressément à adhérer et respecter
                                                        le Code de
                                                        conduite et le Règlement
                                                        Intérieur mis en place par l’Employeur.</p>
                                                    <p>L’Employé est tenu de connaître l’intégralité de la teneur
                                                        desdits documents dont
                                                        une copie de chaque
                                                        sera tenue à sa disposition par l’Employeur à partir de la date
                                                        d’embauche.</p>
                                                    <h4>ARTICLE 2 : DUREE DU CONTRAT</h4>
                                                    <p>Le présent Contrat est conclu pour une durée de
                                                        {{ $contrat[0]->dureeContrat }},
                                                        à compter du
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                        et prendra fin
                                                        le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateFinContrat)) }} </p>
                                                    <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                                                    <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                                                    <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à
                                                        ce poste de
                                                        gérant dans le cadre de
                                                        sa fonction.</p>
                                                    <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                                                    <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les
                                                        besoins de la
                                                        société, il pourrait
                                                        être affecté en tout autre lieu du territoire de la République
                                                        de Guinée.</p>
                                                    <p>L’Employé pourra en outre être amené, en cas de nécessité pour la
                                                        société, à
                                                        effectuer des
                                                        déplacements ponctuels à l’étranger ou à l’intérieur du pays ne
                                                        nécessitant pas
                                                        le changement de sa
                                                        résidence habituelle. </p>
                                                    <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                                                    <p>Le présent contrat de travail est soumis au régime de quarante
                                                        (40) heures de
                                                        travail par semaine à
                                                        raison de huit (08) heures de travail par jour.
                                                        Le Code du travail prévoie la possibilité de réaliser des heures
                                                        supplémentaires.
                                                    </p>
                                                    <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                                                    <p>En contrepartie de son activité professionnelle, l’employé
                                                        percevra un salaire
                                                        mensuel composé comme
                                                        suit :</p>
                                                    <ul>
                                                        <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                                                        <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}
                                                        </li>
                                                        <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}
                                                        </li>
                                                        <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                                                    </ul>
                                                    <p>pour un salaire net de ...... francs guinéens, versé le dernier
                                                        jour du mois.</p>
                                                    <h4>ARTICLE 7 : CONGÉS</h4>
                                                    <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours
                                                        ouvrables par mois
                                                        de travail effectif.
                                                    </p>
                                                    <p>La période de ce congé sera fixée compte tenu des nécessités du
                                                        service et devra
                                                        faire l’objet d’une
                                                        demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                                                    <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                                                    <p>L’employé bénéficiera du régime d’assurances sociales prévu par
                                                        la réglementation
                                                        en vigueur en
                                                        République de Guinée (Soins médicaux, accident de travail,
                                                        maladie
                                                        professionnelle, prestations
                                                        familiales, retraite).</p>
                                                    <p>Il sera immatriculé à la Caisse nationale de sécurité sociale
                                                        (CNSS).</p>
                                                    <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                                                    <p>L’employé s’engage à observer toutes les instructions et
                                                        consignes particulières
                                                        de travail ayant
                                                        trait à sa fonction. Il s’engage également à consacrer tout son
                                                        temps, toute son
                                                        activité et toutes
                                                        ses connaissances à l’exercice de ses fonctions et à ne
                                                        s’occuper exclusivement,
                                                        pendant la durée du
                                                        présent contrat, que des activités de l’Employeur, s’interdisant
                                                        formellement de
                                                        s’intéresser
                                                        directement ou indirectement à d’autres affaires, sauf accord
                                                        exprès et
                                                        préalable de l’employeur.
                                                    </p>
                                                    <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                                                    <p>L’employé s’engage pendant la durée de son contrat de travail, et
                                                        après sa
                                                        rupture à ne pas divulguer
                                                        des informations confidentielles sur la société, qu’elles soient
                                                        en rapport ou
                                                        non avec sa fonction.
                                                        Et ceci par quelque moyen que ce soit : oral, verbal,
                                                        informatique, écrit… et
                                                        que ce soit à
                                                        l’intérieur ou à l’extérieur de l’entreprise.</p>
                                                    <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                                                    <p>Le présent contrat peut être rompu, dans les conditions prévues
                                                        par la loi :</p>
                                                    <ul>
                                                        <li>1. D’un commun accord entre les Parties ;</li>
                                                        <li>2. En cas de faute grave de l’Employé ou de force majeure.
                                                            Est considéré
                                                            comme cas de force
                                                            majeure, tout événement imprévisible, irrésistible et
                                                            extérieur à la Partie
                                                            qui l’invoque et
                                                            dont la survenance empêche l’exécution totale de ses
                                                            obligations ; </li>
                                                        <li>3. En cas de cessation d'activité de l'Employeur.</li>
                                                    </ul>
                                                    <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                                                    <p>Les Parties s’obligent à rechercher une solution amiable à tout
                                                        différend
                                                        résultant de
                                                        l'interprétation ou de l'exécution du présent contrat de
                                                        travail, dans un délai
                                                        de trente (30) jours
                                                        à compter de la réception par l’une d’entre elles de la demande
                                                        de règlement
                                                        amiable adressée par
                                                        l’autre. </p>
                                                    <p>En cas d’échec du règlement amiable ou à l’expiration du délai
                                                        susmentionné de
                                                        trente (30) jours,
                                                        chacune des Parties pourra, sauf accord contraire, porter le
                                                        différend devant la
                                                        juridiction
                                                        territorialement compétente en matière sociale, conformément aux
                                                        articles 520.1
                                                        et suivants du Code
                                                        du Travail.</p>
                                                    <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                                                        {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}
                                                    </p>
                                                    <p style="text-align: right;">Fait en deux (02) exemplaires
                                                        originaux</p>
                                                    <div class="row col-md-12"
                                                        style="margin-top: 50px;text-align:center">
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYEUR</h4>
                                                            <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>L’EMPLOYE</h4>
                                                            <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}
                                                            </h5>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            @endif

                                        </div>
                                        @else
                                        <div class="card padd-10" style="">
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; background-color:white;padding-top:20px;text-align:center">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION SIGNÉE DE
                                                    L'AVENANT</h1>
                                                <p><i class="fa fa-info-circle"></i> Veuillez cliquer sur l'icone
                                                    ci-dessous pour voir l'avenant.</p>

                                                <a class="load"
                                                    href="{{route('readFile', [$fichierAvenant[0]->slug,'x'])}}">
                                                    <img src="{{URL::to('/')}}/assets/upload/avenant.png" alt=""
                                                        style="height:400px">
                                                </a> <br>
                                                <a href="{{route('deleteContraAvenantClient',$avenantSigner[0]->slug)}}"
                                                    type="button" class="btn btn-outline-danger  btn-sm"><i
                                                        class="ti-trash"></i></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="Section3">
                                        @if($fichierFinContrat=='')
                                        <div class="card padd-10" style="">
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; background-color:white;padding-top:20px;text-align:center">
                                                <h1 style="color:whitesmoke;text-align:center">AUCUN DOCUMENT DE FIN DU CONTRAT N'A ÉTÉ ENREGISTRÉ</h1>
                                            </div>
                                        </div>
                                        @else
                                        <div class="card padd-10" style="">
                                            <div class="container"
                                                style="overflow-y:auto; overflow-x:hidden; background-color:white;padding-top:20px;text-align:center">
                                                <h1 style="color:whitesmoke;text-align:center">VERSION SIGNÉE DU
                                                    FIN DE CONTRAT</h1>
                                                <p><i class="fa fa-info-circle"></i> Veuillez cliquer sur l'icone
                                                    ci-dessous pour voir le document.</p>

                                                <a class="load"
                                                    href="{{route('readFile', [$fichierFinContrat[0]->slug,'x'])}}">
                                                    <img src="{{URL::to('/')}}/assets/upload/fin.png" alt=""
                                                        style="height:400px">
                                                </a> <br>
                                                <a href="{{route('deleteFinContratClient',$finContrat[0]->slug)}}"
                                                    type="button" class="btn btn-outline-danger  btn-sm"><i
                                                        class="ti-trash"></i></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
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
function changeTab1() {

    var id1 = document.getElementById("tab1");
    var id2 = document.getElementById("tab2");
    var id3 = document.getElementById("tab3");
    var id4 = document.getElementById("tab4");

    id1.classList.add("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");

}

function changeTab2() {

    var id1 = document.getElementById("tab1");
    var id2 = document.getElementById("tab2");
    var id3 = document.getElementById("tab3");
    var id4 = document.getElementById("tab4");

    id1.classList.remove("active");
    id2.classList.add("active");
    id3.classList.remove("active");
    id4.classList.remove("active");

}

function changeTab3() {

    var id1 = document.getElementById("tab1");
    var id2 = document.getElementById("tab2");
    var id3 = document.getElementById("tab3");
    var id4 = document.getElementById("tab4");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.add("active");
    id4.classList.remove("active");

}

function changeTab4() {

    var id1 = document.getElementById("tab1");
    var id2 = document.getElementById("tab2");
    var id3 = document.getElementById("tab3");
    var id4 = document.getElementById("tab4");

    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.add("active");

}
//////////////////////////////////

function changeT1() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");


    id1.classList.add("active");
    id2.classList.remove("active");
    id3.classList.remove("active");

}

function changeT2() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");


    id1.classList.remove("active");
    id2.classList.add("active");
    id3.classList.remove("active");

}

function changeT3() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");


    id1.classList.remove("active");
    id2.classList.remove("active");
    id3.classList.add("active");

}
</script>

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