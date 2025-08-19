@extends('layouts.base')
@section('title', 'Courriers - Départ')
@section('content')

<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers - Départ > <span class="label bg-info"><b>Création</b></span></h4>
        </div>
        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a href="{{ route('listCourierDepart') }}" title="Liste des couriers"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-navicon"></i>
                    Liste Courriers - Départ
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-12 container-fluid">
        <!-- form start -->
        <form class="" method="post" action=" {{ route('storeCourierDepart') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 col-sm-12">
                <div class="card padd-20">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Type de courrier</label>
                            <div class="row" style="background-color: white;padding-top:5px;">
                                <div class="col-md-4">
                                    <label class="custom-control custom-radio">
                                        <input id="radioStacked1" val="Cabinet" name="categorie" type="radio"
                                            class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"> Courrier Cabinet </span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-control custom-radio">
                                        <input id="radioStacked2" name="categorie" type="radio"
                                            class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"> Courrier Client</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Choisir un modèle</label>
                            <select class="form-control select2 " id="typeModel" name="typeModel" style="width: 100%;">
                                <option value="aucun" selected="selected">Aucun</option>
                                <option value="LT">Lettre de transmission APIP</option>
                                <option value="LCP">Lettre de constitution ( personne physique )</option>
                                <option value="LCS">Lettre de constitution ( société )</option>
                                <option value="DAP">Déclaration d'appel ( Personne physique )</option>
                                <option value="DAS">Déclaration d'appel ( société )</option>
                                <option value="LDC">Lettre de demande d'ouverture de compte bancaire</option>

                            </select>
                        </div>
                    </div>
                    @if(Auth::user()->role=='Administrateur')
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                        <label for="">Confidentialité</label>
                            <div class="row" style="background-color: white;padding-top:15px;padding-left:15px;">
                                <div class="form-group has-warning">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="confidentialite">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Activer/Désactiver la confidentialité</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="">Lié à un ou plusieurs courriers arrivé/départ</label>
                            <select class="form-control select2" style="width: 100%;" name="idCourierLier[]" id="preparant" multiple required>
                            
                                    <option value=0>-- Ne pas lier --</option>
                                    @foreach ($courierArrivers as $row)
                                    <option value="{{ $row->slug }}">Courrier-Arrivé N° {{ $row->numero }} - {{$row->objet}}</option>
                                    @endforeach
                                    @foreach ($courierDeparts as $row2)
                                    <option value="{{ $row2->slug }}">Courrier-Départ N° {{ $row2->numCourier }} - {{$row2->objet}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card padd-20">

                    <div class="row mrg-0">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">N° du courrier: </label>
                                <input type="number" name="idCourier" class="form-control" value="{{$idCourier}}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Destinataire :</label>
                                <input type="text" class="form-control" id="destinataire" placeholder=" "
                                    data-error=" veillez saisir le nom du destinataire" name="destinataire" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Date du courrier :</label>
                                <input type="date" class="form-control" id="dateCourier" name="dateCourier"
                                    data-error=" veillez saisir la date du courrier" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Projet préparé par :</label>
                                <select class="form-control select2" style="width: 100%;" name="idPersonnel"
                                    id="preparant" required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($personnels as $row)
                                    <option value={{ $row->idPersonnel }}>{{ $row->prenom }} {{ $row->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Signataire (Administrateurs) :</label>
                                <select class="form-control select2" style="width: 100%;" name="idAmin" id="admin"
                                    required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($admins as $row)
                                    <option value={{ $row->id }}>{{ $row->name }}
                                    <option>
                                        @endforeach
                                </select>
                                <input type="hidden" name="signataire" id="signataire">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Objet : </label>
                                <input type="text" id="desc" name="objet" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Est-ce une lettre d'appel ? :</label>
                                <select class="form-control select2" style="width: 100%;" name="slugSuivitAudience"
                                    id="preparant" required>
                                    <option value="" selected disabled>-- Selectionner la décision --</option>
                                    <option value="">-- NON --</option>
                                    @foreach ($suiviAudiences as $row)
                                    <option value={{ $row->slug }}>{{ $row->decision }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mrg-0 mb-4">
                        <div class="col-md-6">
                            <div class="form-group" id="clientSelect">
                                <label>Selectionner le client :</label>
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="client">
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($clients as $client)
                                    <option value={{ $client->idClient }}>{{ $client->prenom  }}
                                        {{ $client->nom }} {{ $client->denomination }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <input type="text" id="typeContent" value="courierDepart" name="typeContent" hidden>
                        <div class="col-md-6" id="affaireContent" hidden>
                            <div class="form-group">
                                <label>Affaire du client concerné :</label>
                                <select class="form-control select2" style="width: 100%;" name="idAffaire"
                                    id="affaireClient">

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-6" id="piece">
                            <div class="form-group">
                                <label for="">Joindre un fichier</label>
                                <input type="file" class="fichiers form-control" name="fichiers[]" id="file" multiple
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0 mb-4" id="partieAdverseDiv">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Assigner par :</label>
                                <input type="text" id="partieAdverse" name="partieAdverse" class="form-control"
                                    required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Motif :</label>
                                <input type="text" id="motif" name="motif" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0 mb-4" id="appelDiv">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>jugement :</label>
                                <input type="text" id="jugement" name="jugement" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cour d'appel de :</label>
                                <input type="text" id="courAppel" name="courAppel" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0 mb-4" id="dateProcesDiv">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Date du procès-verbal :</label>
                                <input type="date" class="form-control" id="dateProcesVerbal" name="dateProcesVerbal"
                                    required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="models">
                    <div class="card" style="padding: 100px;" id="lettreTransmissionForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-4 mt-4">
                            <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                        class="initialPersonnel">.....</span>/<span
                                        class="initialAdmin">.....</span></b></p>
                        </div>
                        <div class="col-md-12 text-center mt-5">
                            <h4 style="text-decoration:underline;">Lettre de transmission</h4>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>J’ai l’honneur de vous transmettre par la présente, en vue de la création de la SOCIETE
                                <span class="clientSpan">............</span>, les documents ci-dessous énumérés :</p>
                            <p>
                            <ul>
                                <li>1. Deux copies des Statuts</li>
                                <li>2. Deux copies du PV de constitution</li>
                                <li>3. Une copie de l’attestation du compte bancaire portant</li>
                                <li>4. La décharge de la lettre d’ouverture de compte</li>
                                <li>5. Une copie de la pièce d'identité du/des gérant(s)</li>
                                <li>6. Deux (2) photos d'identité du/des gérant(s)</li>
                            </ul>
                            </p>
                            <p>Je reste à votre disposition pour tout complément de dossier à fournir.</p>
                            <p>Dans l’attente, veuillez recevoir, Madame/Monsieur, l’expression de mes salutations
                                distinguées.</p>
                            <p style="margin-top:10px;text-align:right;text-decoration:underline;">Conakry, le <span
                                    class="dateCourierSpan">........</span></p>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3>Maître <span class="nomAdmin">...........</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                    <div class="card" style="padding: 100px;" id="lettreConstitutionPersForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-4 mt-4">
                            <p>Affaire : <b style="text-decoration:underline;"><span
                                        class="affaireSpan">..............</span></b></p>
                        </div>
                        <div class="row col-md-12 mt-4">
                            <div class="col-md-6">
                                <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                            class="initialPersonnel">.....</span>/<span
                                            class="initialAdmin">.....</span></b></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p><b>À</b></p>
                                <p><b><span class="destinataireSpan">...............</span></b></p>
                                <p style="margin-top:10px;text-decoration:underline;"><b>Conakry, le <span
                                            class="dateCourierSpan">........</span></b></p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <p><b style="text-decoration:underline;">Objet:</b> Lettre de constitution</p>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>Nous avons l’honneur de vous informer de ce que notre cabinet a été constitué pour
                                défendre les intérêts de madame/monsieur <span class="clientSpan">..........</span>,
                                résident à <span class="adresseClientSpan">.............</span> assignée par <span
                                    class="partieAdverseSpan">..........</span> par devant votre juridiction pour <span
                                    class="motifSpan"></span>.</p>
                            <p>Pour toutes fins utiles que de droit.</p>
                            <p>Nous vous souhaitons bonne réception de la présente et vous prions de recevoir, Monsieur
                                le président, nos salutations toujours respectueuses.</p>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3>Maître <span class="nomAdmin">..................</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                    <div class="card" style="padding: 100px;" id="lettreConstitutionSocieteForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-4 mt-4">
                            <p>Affaire : <b style="text-decoration:underline;"><span
                                        class="affaireSpan">..............</span></b></p>
                        </div>
                        <div class="row col-md-12 mt-4">
                            <div class="col-md-6">
                                <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                            class="initialPersonnel">.....</span>/<span
                                            class="initialAdmin">.....</span></b></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p><b>À</b></p>
                                <p><b><span class="destinataireSpan">...............</span></b></p>
                                <p style="margin-top:10px;text-decoration:underline;"><b>Conakry, le <span
                                            class="dateCourierSpan">........</span></b></p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <p><b style="text-decoration:underline;">Objet:</b> Lettre de constitution</p>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>Nous avons l’honneur de vous informer de ce que notre cabinet a été constitué pour
                                défendre les intérêts de la SOCIETE <span class="clientSpan">..........</span>, ayant
                                son siège à <span class="adresseClientSpan">.............</span>, immatriculée au
                                Registre de Commerce et du Crédit Mobilier sous le numéro <span
                                    class="rccm">.........</span> assignée par <span
                                    class="partieAdverseSpan">..........</span> par devant votre juridiction pour <span
                                    class="motifSpan"></span>.</p>
                            <p>Pour toutes fins utiles que de droit.</p>
                            <p>Nous vous souhaitons bonne réception de la présente et vous prions de recevoir, Monsieur
                                le président, nos salutations toujours respectueuses.</p>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3>Maître <span class="nomAdmin">..................</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                    <div class="card" style="padding: 100px;" id="declarationPersForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-4 mt-4">
                            <p>Affaire : <b style="text-decoration:underline;"><span
                                        class="affaireSpan">..............</span></b></p>
                        </div>
                        <div class="row col-md-12 mt-4">
                            <div class="col-md-6">
                                <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                            class="initialPersonnel">.....</span>/<span
                                            class="initialAdmin">.....</span></b></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p><b>À</b></p>
                                <p><b><span class="destinataireSpan">...............</span></b></p>
                                <p style="margin-top:10px;text-decoration:underline;"><b>Conakry, le <span
                                            class="dateCourierSpan">........</span></b></p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <p><b style="text-decoration:underline;">Objet:</b> Déclaration d'appel</p>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>Par la présente, monsieur/madame<span class="clientSpan">..........</span>, résident à
                                <span class="adresseClientSpan">.............</span>,ayant pour avocat Maître <span
                                    class="nomAdmin">..................</span> , avocat à la Cour, déclare, avoir
                                formellement relevé appel contre <b>le jugement <span
                                        class="jugementSpan">..............</span>, rendu dans l’affaire suscitée.</b>
                            </p>
                            <p>L’appelant(e) entend, en effet, développer les motifs de son appel par devant la Cour
                                d’appel de <span class="courAppelSpan"></span>.</p>
                            <p>Vous en souhaitant bonne réception, nous vous prions d’agréer, monsieur le chef de
                                greffe, nos salutations distinguées.</p>
                        </div>
                        <div class="col-md-12 text-center">
                            <p style="text-decoration:underline;">Pour l'appelante</p>
                            <h3>Maître <span class="nomAdmin">..................</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                    <div class="card" style="padding: 100px;" id="declarationSocieteForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-4 mt-4">
                            <p>Affaire : <b style="text-decoration:underline;"><span
                                        class="affaireSpan">..............</span></b></p>
                        </div>
                        <div class="row col-md-12 mt-4">
                            <div class="col-md-6">
                                <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                            class="initialPersonnel">.....</span>/<span
                                            class="initialAdmin">.....</span></b></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p><b>À</b></p>
                                <p><b><span class="destinataireSpan">...............</span></b></p>
                                <p style="margin-top:10px;text-decoration:underline;"><b>Conakry, le <span
                                            class="dateCourierSpan">........</span></b></p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <p><b style="text-decoration:underline;">Objet:</b> Déclaration d'appel</p>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>Par la présente, la société <span class="clientSpan">..........</span>, sise à <span
                                    class="adresseClientSpan">.............</span>, représentée par son dirigeant légal,
                                ayant pour avocat Maître <span class="nomAdmin">..................</span> , avocat à la
                                Cour, déclare, avoir formellement relevé appel contre <b>le jugement <span
                                        class="jugementSpan">..............</span>, rendu dans l’affaire suscitée.</b>
                            </p>
                            <p>L’appelant(e) entend, en effet, développer les motifs de son appel par devant la Cour
                                d’appel de <span class="courAppelSpan"></span>.</p>
                            <p>Vous en souhaitant bonne réception, nous vous prions d’agréer, monsieur le chef de
                                greffe, nos salutations distinguées.</p>
                        </div>
                        <div class="col-md-12 text-center">
                            <p style="text-decoration:underline;">Pour l'appelante</p>
                            <h3>Maître <span class="nomAdmin">..................</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                    <div class="card" style="padding: 100px;" id="ouvertureCompteForm" hidden>
                        <div class="col-md-4">
                            @if(Session::has('cabinetLogo'))
                            @foreach (Session::get('cabinetLogo') as $logo)
                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon" style="height:70px" />
                            @endforeach
                            @endif
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <p>Réf. : <b style="text-decoration:underline;">N° {{$idCourier}}/<span
                                            class="initialPersonnel">.....</span>/<span
                                            class="initialAdmin">.....</span></b></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p><b>À</b></p>
                                <p><b><span class="destinataireSpan">...............</span></b></p>
                                <p style="margin-top:10px;text-decoration:underline;"><b>Conakry, le <span
                                            class="dateCourierSpan">........</span></b></p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <p><b style="text-decoration:underline;">Objet:</b>Demande d’ouverture d’un compte bancaire
                                au nom de la Société <span class="clientSpan">..........</span> en formation </p>
                        </div>
                        <div class="col-md-12">
                            <p>Madame / Monsieur,</p>
                            <p>En vertu du procès-verbal de l’assemblée générale constitutive en date du <span
                                    class="dateProcesVerbalSpan">..........</span>, et pour nous permettre de procéder à
                                la libération du capital social, nous venons par la présente, solliciter l’ouverture
                                d’un compte bancaire au nom de la société <span class="clientSpan">..........</span> en
                                formation</p>
                            <p>Outre la libération du capital social, le compte bancaire dont l’ouverture est sollicitée
                                recevra tous les revenus escomptés par l’entreprise.</p>
                            <p>À l’appui de la présente, nous vous communiquons les pièces suivantes :</p>
                            <p>
                            <ul>
                                <li>1. une copie des Statuts ;</li>
                                <li>2. une copie du procès-verbal de constitution ;</li>
                                <li>3. une copie des pièces d’identité des associés ;</li>
                                <li>4. un certificat de résidence du/des gérant(s) ;</li>
                                <li>5. deux photos d’identité du/des gérant(s).</li>
                            </ul>
                            </p>
                            <p>Nous nous tenons à votre disposition pour tout complément de dossier à fournir.</p>
                            <p>Dans l’attente d’une suite favorable, nous vous prions de recevoir, monsieur le Directeur
                                général, l’expression de nos salutations distinguées.</p>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3>Maître <span class="nomAdmin">..................</span></h3>
                            <p>Avocat à la Cour</p>
                        </div>


                    </div>
                </div>

                <div class="row mrg-0" style="margin-top: 10px;">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                    style="width:50%;">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

</div>

<script>
document.getElementById('cr').classList.add('active');

// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function(e) {

            var fichiersInput = this.querySelectorAll(
            ".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

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