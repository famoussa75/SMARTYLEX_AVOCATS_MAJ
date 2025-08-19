@extends('layouts.base')
@section('title','Ajout des données')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers - Départ</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-sm-12">

                                <div class="stepwizard">
                                    <div class="stepwizard-row setup-panel">
                                        <div class="form-wizard-setup first">
                                            <a href="#step-1" class="btn circle-button active-wizard"><i
                                                    class="fa fa-pencil-square-o"></i></a>
                                            <p>Enregistrement</p>
                                        </div>
                                        <div class="form-wizard-setup">
                                            <a href="#step-2"
                                                class="btn @if($courierSent[0]->statut=='Annulé') disabled @else @endif circle-button">
                                                <i class="fa  fa-file-text"></i></a>
                                            <p>Approbation</p>
                                        </div>
                                        <div class="form-wizard-setup">
                                            @if($courierSent[0]->statut=='Approuvé' ||
                                            $courierSent[0]->statut=='Envoyé')
                                            <a href="#step-3" class="btn  circle-button "><i
                                                    class="fa fa-paper-plane-o"></i></a>
                                            <p>Procédure envoi</p>
                                            @else
                                            <a href="#step-3" class="btn  circle-button disabled "><i
                                                    class="fa fa-paper-plane-o"></i></a>
                                            <p>Procédure envoi</p>
                                            @endif
                                        </div>
                                        <div class="form-wizard-setup last">
                                            @if($courierSent[0]->statut=='Envoyé')
                                            <a href="#step-4" class="btn  circle-button "><i
                                                    class="fa fa-check-square-o"></i></a>
                                            <p>Accusé réception</p>
                                            @else
                                            <a href="#step-4" class="btn  circle-button disabled"><i
                                                    class="fa fa-check-square-o"></i></a>
                                            <p>Accusé réception</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 1 -->
                                <div class="row form-step" id="step-1">

                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="detail-wrapper padd-top-30">
                                                <div class="row text-center">
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp
                                                    </div>
                                                </div>
                                                <div class="row  mrg-0 detail-invoice">
                                                    <div class="col-md-12">
                                                        <h2 style="text-decoration: underline;"> Courriers - Départ</h2>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            <div class="col-lg-6 col-md-6 col-sm-6">

                                                                <h4>Destinataire : {{ $courierSent[0]->destinataire }}
                                                                </h4>
                                                                <p>
                                                                    N° du courrier : {{ $courierSent[0]->numCourier }}
                                                                    <br>
                                                                    Objet du courrier : {{ $courierSent[0]->objet }}
                                                                    <br>

                                                                    Date du courrier :
                                                                    {{ date('d-m-Y', strtotime($courierSent[0]->dateCourier)) }}<br>
                                                                    Statut actuel : <span
                                                                        class="label cl-success bg-success-light">
                                                                        {{ $courierSent[0]->statut }}</span> <br>
                                                                    Niveau dans le processus : <span
                                                                        class="label bg-danger bg-warning">
                                                                        {{ $courierSent[0]->niveau }}</span>
                                                                </p>
                                                                @if(empty($clientAffaire))
                                                                <p>
                                                                    Courrier Cabinet
                                                                </p>
                                                                @else
                                                                <p>
                                                                    Client : {{ $clientAffaire[0]->prenom }}
                                                                    {{ $clientAffaire[0]->nom }}{{ $clientAffaire[0]->denomination }}
                                                                    <br>
                                                                    Affaire : {{ $clientAffaire[0]->nomAffaire }}
                                                                </p>
                                                                @endif

                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <h3 class="m-t-40">Pièces du courrier</h3>
                                                                    @if(empty($courierFile))
                                                                    <p> Courrier crée à travers un model.</p>
                                                                    @else
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <a class="load"
                                                                                            href="{{route('readFile', [$courierFile[0]->slug])}}">
                                                                                            <i class="fa fa-file-pdf-o"
                                                                                                style="font-size:1.5em; color:red;"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td> <a class="load"
                                                                                            href="{{route('readFile', [$courierFile[0]->slug])}}"
                                                                                            style="color:red"
                                                                                            class="toggle"
                                                                                            title="Cliquer pour afficher le contenu du fichier">Voir
                                                                                            le contenu</a> </td>
                                                                                </tr>
                                                                                @if(Auth::user()->role=='Administrateur')
                                                                                    <tr>
                                                                                        <td>Confidentialité</td>
                                                                                        <td>
                                                                                            @if($courierSent[0]->confidentialite=='on')
                                                                                            <div class="btn-group">
                                                                                                <a href="{{ route('offConfDepart',$courierSent[0]->slug) }}"
                                                                                                    class="cl-white bg-danger btn  btn-rounded"
                                                                                                    title="Classer le courier">
                                                                                                    <i class="fa fa-lock"></i>
                                                                                                    Désactiver la Confidentialité
                                                                                                </a>
                                                                                            </div>
                                                                                            @else
                                                                                            <div class="btn-group">
                                                                                                <a href="{{ route('onConfDepart',$courierSent[0]->slug) }}"
                                                                                                    class="cl-white bg-primary btn  btn-rounded"
                                                                                                    title="Classer le courier">
                                                                                                    <i class="fa fa-unlock"></i>
                                                                                                    Activer la Confidentialité
                                                                                                </a>
                                                                                            </div>
                                                                                            @endif

                                                                                        </td>
                                                                                    </tr>
                                                                                    @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    @endif
                                                                   

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                        @if($courierSent[0]->statut=='Annulé')
                                        <button class="btn  btn-default pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @else
                                        <button class="btn  nextBtn  pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="row form-step" id="step-2">
                                    <div class="col-md-12">
                                        <div class="card" style="background-color: whitesmoke;">
                                            <div class="col-12">
                                                @if(empty($courierFile))

                                                    @if(!empty($courierModel) && $courierModel[0]->typeModel=='LT')
                                                    <div class="card card-model mt-4" style="padding: 100px;"
                                                        id="lettreTransmissionForm">
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                    {{$courierModel[0]->numCourier}}/<span
                                                                        class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                        class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/<span>{{$annee}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='col-md-12 text-center mt-5'>
                                                            <h4 style="text-decoration:underline; text-align:center">Lettre
                                                                de transmission</h4>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <p>Madame / Monsieur,</p>
                                                            <p>J’ai l’honneur de vous transmettre par la présente, en vue de
                                                                la création de la SOCIETE <span
                                                                    class='clientSpan'>{{$courierModel[0]->prenom}}
                                                                    {{$courierModel[0]->nom}}
                                                                    {{$courierModel[0]->denomination}}</span>, les documents
                                                                ci-dessous énumérés :</p>
                                                            <p>
                                                            <ul>
                                                                <li>1. Deux copies des Statuts</li>
                                                                <li>2. Deux copies du PV de constitution</li>
                                                                <li>3. Une copie de l’attestation du compte bancaire portant
                                                                </li>
                                                                <li>4. La décharge de la lettre d’ouverture de compte</li>
                                                                <li>5. Une copie de la pièce d'identité du/des gérant(s)
                                                                </li>
                                                                <li>6. Deux (2) photos d'identité du/des gérant(s)</li>
                                                            </ul>
                                                            </p>
                                                            <p>Je reste à votre disposition pour tout complément de dossier
                                                                à fournir.</p>
                                                            <p>Dans l’attente, veuillez recevoir, Madame/Monsieur,
                                                                l’expression de mes salutations distinguées.</p>
                                                            <p
                                                                style='margin-top:100px;margin-bottom:100px;text-align:right;margin-right:200px;text-decoration:underline;'>
                                                                Conakry, le <span
                                                                    class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span>
                                                            </p>
                                                        </div>
                                                        <div class='col-md-12 text-center'>
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>

                                                    </div>

                                                    <div class="row  mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/LT/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>

                                                    @elseif(!empty($courierModel) && $courierModel[0]->typeModel=='LCP')
                                                    <div class="card card-model mt-4" style="padding: 50px;"
                                                        id="lettreConstitutionPersForm">
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <p>Affaire : <b style='text-decoration:underline;'><span
                                                                        class='affaireSpan'>{{$courierModel[0]->nomAffaire}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                    {{$courierModel[0]->numCourier}}/<span
                                                                        class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                        class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/<span>{{$annee}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='row col-md-12 mt-5'>
                                                            <div class="col-md-6">
                                                                <p><b style='text-decoration:underline;'>Objet:</b> Lettre
                                                                    de constitution</p>
                                                            </div>

                                                            <div class='col-md-6' style="text-align: center;">
                                                                <div style="float: right;">
                                                                    <p><b>À</b></p>
                                                                    <p><b><span
                                                                                class='destinataireSpan'>{{$courierModel[0]->destinataire}}</span></b>
                                                                    </p>
                                                                    <p style='margin-top:10px;text-decoration:underline;'>
                                                                        <b>Conakry, le <span
                                                                                class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span></b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12' style="margin-top: 120px;">
                                                            <p>Madame / Monsieur,</p>
                                                            <p>Nous avons l’honneur de vous informer de ce que notre cabinet
                                                                a été constitué pour défendre les intérêts de
                                                                madame/monsieur <span
                                                                    class='clientSpan'>{{$courierModel[0]->prenom}}
                                                                    {{$courierModel[0]->nom}}</span>, résident à <span
                                                                    class='adresseClientSpan'>{{$courierModel[0]->adresse}}</span>
                                                                assignée par <span
                                                                    class='partieAdverseSpan'>{{$courierModel[0]->partieAdverse}}</span>
                                                                par devant votre juridiction pour <span
                                                                    class='motifSpan'>{{$courierModel[0]->motif}}</span>.
                                                            </p>
                                                            <p>Pour toutes fins utiles que de droit.</p>
                                                            <p>Nous vous souhaitons bonne réception de la présente et vous
                                                                prions de recevoir, Monsieur le président, nos salutations
                                                                toujours respectueuses.</p>
                                                        </div>
                                                        <div class='col-md-12 mt-5' style="text-align: center;">
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>


                                                    </div>
                                                    <div class="row mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/LCP/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>

                                                    @elseif(!empty($courierModel) && $courierModel[0]->typeModel=='LCS')
                                                    <div class="card card-model mt-4" style="padding: 50px;"
                                                        id="lettreConstitutionSocieteForm">
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <p>Affaire : <b style='text-decoration:underline;'><span
                                                                        class='affaireSpan'>{{$courierModel[0]->nomAffaire}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='row col-md-12 mt-4'>
                                                            <div class='col-md-6'>
                                                                <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                        {{$courierModel[0]->numCourier}}/<span
                                                                            class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                            class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/{{$annee}}</b>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6 text-center'>
                                                                <p><b>À</b></p>
                                                                <p><b><span
                                                                            class='destinataireSpan'>{{$courierModel[0]->destinataire}}</span></b>
                                                                </p>
                                                                <p style='margin-top:10px;text-decoration:underline;'>
                                                                    <b>Conakry, le <span
                                                                            class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span></b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12 mt-5'>
                                                            <p><b style='text-decoration:underline;'>Objet:</b> Lettre de
                                                                constitution</p>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <p>Madame / Monsieur,</p>
                                                            <p>Nous avons l’honneur de vous informer de ce que notre cabinet
                                                                a été constitué pour défendre les intérêts de la SOCIETE
                                                                <span
                                                                    class='clientSpan'>{{$courierModel[0]->denomination}}</span>,
                                                                ayant son siège à <span
                                                                    class='adresseClientSpan'>{{$courierModel[0]->adresseEntreprise}}</span>,
                                                                immatriculée au Registre de Commerce et du Crédit Mobilier
                                                                sous le numéro <span
                                                                    class='rccm'>{{$courierModel[0]->rccm}}</span> assignée
                                                                par <span
                                                                    class='partieAdverseSpan'>{{$courierModel[0]->partieAdverse}}</span>
                                                                par devant votre juridiction pour <span
                                                                    class='motifSpan'>{{$courierModel[0]->motif}}</span>.
                                                            </p>
                                                            <p>Pour toutes fins utiles que de droit.</p>
                                                            <p>Nous vous souhaitons bonne réception de la présente et vous
                                                                prions de recevoir, Monsieur le président, nos salutations
                                                                toujours respectueuses.</p>
                                                        </div>
                                                        <div class='col-md-12 text-center'>
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>


                                                    </div>
                                                    <div class="row mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/LCS/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>

                                                    @elseif(!empty($courierModel) && $courierModel[0]->typeModel=='DAP')
                                                    <div class="card card-model mt-4" style="padding: 50px;"
                                                        id="declarationPersForm">
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <p>Affaire : <b style='text-decoration:underline;'><span
                                                                        class='affaireSpan'>{{$courierModel[0]->nomAffaire}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='row col-md-12 mt-4'>
                                                            <div class='col-md-6'>
                                                                <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                        {{$courierModel[0]->numCourier}}/<span
                                                                            class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                            class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/{{$annee}}</b>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6 text-center'>
                                                                <p><b>À</b></p>
                                                                <p><b><span
                                                                            class='destinataireSpan'>{{$courierModel[0]->destinataire}}</span></b>
                                                                </p>
                                                                <p style='margin-top:10px;text-decoration:underline;'>
                                                                    <b>Conakry, le <span
                                                                            class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span></b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12 mt-5'>
                                                            <p><b style="text-decoration:underline;">Objet:</b> Déclaration
                                                                d'appel</p>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <p>Madame / Monsieur,</p>
                                                            <p>Par la présente, monsieur/madame <span
                                                                    class='clientSpan'>{{$courierModel[0]->prenom}}
                                                                    {{$courierModel[0]->nom}}</span>, résident à <span
                                                                    class='adresseClientSpan'>{{$courierModel[0]->adresse}}</span>,ayant
                                                                pour avocat Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span> , avocat à la Cour, déclare, avoir
                                                                formellement relevé appel contre <b>le jugement <span
                                                                        class='jugementSpan'>{{$courierModel[0]->jugement}}</span>,
                                                                    rendu dans l’affaire suscitée.</b></p>
                                                            <p>L’appelant(e) entend, en effet, développer les motifs de son
                                                                appel par devant la Cour d’appel de <span
                                                                    class="courAppelSpan">{{$courierModel[0]->courAppel}}</span>.
                                                            </p>
                                                            <p>Vous en souhaitant bonne réception, nous vous prions
                                                                d’agréer, monsieur le chef de greffe, nos salutations
                                                                distinguées.</p>
                                                        </div>
                                                        <div class='col-md-12 text-center'>
                                                            <p style='text-decoration:underline;'>Pour l'appelante</p>
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>


                                                    </div>
                                                    <div class="row mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/DAP/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>

                                                    @elseif(!empty($courierModel) && $courierModel[0]->typeModel=='DAS')
                                                    <div class='card card-model mt-4' style='padding: 100px;'
                                                        id='declarationSocieteForm'>
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <p>Affaire : <b style='text-decoration:underline;'><span
                                                                        class='affaireSpan'>{{$courierModel[0]->nomAffaire}}</span></b>
                                                            </p>
                                                        </div>
                                                        <div class='row col-md-12 mt-4'>
                                                            <div class='col-md-6'>
                                                                <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                        {{$courierModel[0]->numCourier}}/<span
                                                                            class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                            class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/{{$annee}}</b>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6 text-center'>
                                                                <p><b>À</b></p>
                                                                <p><b><span
                                                                            class='destinataireSpan'>{{$courierModel[0]->destinataire}}</span></b>
                                                                </p>
                                                                <p style='margin-top:10px;text-decoration:underline;'>
                                                                    <b>Conakry, le <span
                                                                            class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span></b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12 mt-5'>
                                                            <p><b style='text-decoration:underline;'>Objet : </b>
                                                                Déclaration d'appel</p>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <p>Madame / Monsieur,</p>
                                                            <p>Par la présente, la société <span
                                                                    class='clientSpan'>{{$courierModel[0]->denomination}}</span>,
                                                                sise à <span
                                                                    class='adresseClientSpan'>{{$courierModel[0]->adresseEntreprise}}</span>,
                                                                représentée par son dirigeant légal, ayant pour avocat
                                                                Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span> , avocat à la Cour,
                                                                déclare, avoir formellement relevé appel contre <b>le
                                                                    jugement <span
                                                                        class='jugementSpan'>{{$courierModel[0]->jugement}}</span>,
                                                                    rendu dans l’affaire suscitée.</b></p>
                                                            <p>L’appelant(e) entend, en effet, développer les motifs de son
                                                                appel par devant la Cour d’appel de <span
                                                                    class='courAppelSpan'></span>.</p>
                                                            <p>Vous en souhaitant bonne réception, nous vous prions
                                                                d’agréer, monsieur le chef de greffe, nos salutations
                                                                distinguées.</p>
                                                        </div>
                                                        <div class='col-md-12 text-center mt-4'>
                                                            <p style='text-decoration:underline;'>Pour l'appelante</p>
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>


                                                    </div>
                                                    <div class="row mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/DAS/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>

                                                    @elseif(!empty($courierModel) && $courierModel[0]->typeModel=='LDC')
                                                    <div class='card card-model mt-4' style='padding: 100px;'
                                                        id='ouvertureCompteForm'>
                                                        <div class='col-md-4' style="margin-bottom: 100px;">
                                                            @if(Session::has('cabinetLogo'))
                                                            @foreach (Session::get('cabinetLogo') as $logo)
                                                            <img src="{{URL::to('/')}}/{{$logo->logo}}" alt="Logo Icon"
                                                                style="height:70px">
                                                            @endforeach
                                                            @endif
                                                        </div>

                                                        <div class='row col-md-12'>
                                                            <div class='col-md-6'>
                                                                <p>Réf. : <b style='text-decoration:underline;'>N°
                                                                        {{$courierModel[0]->numCourier}}/<span
                                                                            class='initialPersonnel'>{{$courierModel[0]->initialPersonnel}}</span>/<span
                                                                            class='initialAdmin'>{{$courierModel[0]->signataire}}</span>/{{$annee}}</b>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6 text-center'>
                                                                <p><b>À</b></p>
                                                                <p><b><span
                                                                            class='destinataireSpan'>{{$courierModel[0]->destinataire}}</span></b>
                                                                </p>
                                                                <p style='margin-top:10px;text-decoration:underline;'>
                                                                    <b>Conakry, le <span
                                                                            class='dateCourierSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateCourier)) }}</span></b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12 mt-5'>
                                                            <p><b style='text-decoration:underline;'>Objet : </b>Demande
                                                                d’ouverture d’un compte bancaire au nom de la Société <span
                                                                    class='clientSpan'>{{$courierModel[0]->denomination}}</span>
                                                                en formation </p>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <p>Madame / Monsieur,</p>
                                                            <p>En vertu du procès-verbal de l’assemblée générale
                                                                constitutive en date du <span
                                                                    class='dateProcesVerbalSpan'>{{ date('d-m-Y', strtotime($courierModel[0]->dateProcesVerbal)) }}</span>,
                                                                et pour nous permettre de procéder à la libération du
                                                                capital social, nous venons par la présente, solliciter
                                                                l’ouverture d’un compte bancaire au nom de la société <span
                                                                    class='clientSpan'>{{$courierModel[0]->denomination}}</span>
                                                                en formation</p>
                                                            <p>Outre la libération du capital social, le compte bancaire
                                                                dont l’ouverture est sollicitée recevra tous les revenus
                                                                escomptés par l’entreprise.</p>
                                                            <p>À l’appui de la présente, nous vous communiquons les pièces
                                                                suivantes :</p>
                                                            <p>
                                                            <ul>
                                                                <li>1. une copie des Statuts ;</li>
                                                                <li>2. une copie du procès-verbal de constitution ;</li>
                                                                <li>3. une copie des pièces d’identité des associés ;</li>
                                                                <li>4. un certificat de résidence du/des gérant(s) ;</li>
                                                                <li>5. deux photos d’identité du/des gérant(s).</li>
                                                            </ul>
                                                            </p>
                                                            <p>Nous nous tenons à votre disposition pour tout complément de
                                                                dossier à fournir.</p>
                                                            <p>Dans l’attente d’une suite favorable, nous vous prions de
                                                                recevoir, monsieur le Directeur général, l’expression de nos
                                                                salutations distinguées.</p>
                                                        </div>
                                                        <div class='col-md-12 text-center mt-5'>
                                                            <h3>Maître <span class='nomAdmin'>@foreach($signataire as $s){{$s->name}} @endforeach</span></h3>
                                                            <p>Avocat à la Cour</p>
                                                        </div>


                                                    </div>
                                                    <div class="row mb-5 col-md-12 text-center" style="padding-left: 40%;">
                                                        <form action="/courier_depart/LDC/word" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Autres champs du formulaire -->
                                                            <input type="hidden" name="idCourier"
                                                                value="{{$courierModel[0]->idCourierDep}}">
                                                            <button type="submit" class="btn btn-info" id="btnDownload"><i
                                                                    class="fa fa-download"></i> Télécharger en document
                                                                word</button>
                                                        </form>
                                                    </div>
                                                    @endif
                              

                                                @else
                                                <a class="load" href="{{route('readFile', [$courierFile[0]->slug])}}"
                                                    style="color:red" class="toggle"
                                                    title="Cliquer pour afficher le contenu du fichier">

                                                    <div class="flex-box align-items-center"
                                                        style="height: 275px; background-color:grey;display:block;padding:20px; margin-bottom:30px">

                                                        <h2 style="color:white;text-align:center"> Cliquez ici pour
                                                            voir
                                                            le contenu . . . <br><br>
                                                            <i class="fa fa-envelope-o"
                                                                style="font-size:4.5em; color:info;"></i>

                                                        </h2>
                                                    </div>
                                                </a>
                                                @endif
                                                <div class="row text-center">


                                                    <div class="form-group">
                                                        @if($courierSent[0]->statut=='Approuvé')
                                                        <h5 style="color:green">Ce courrier a été approuvé,
                                                            veuillez
                                                            cliquer
                                                            sur <b>suivant</b> pour continuer</h5>
                                                        <p><b>
                                                                <h5>Consigne :</h5>
                                                            </b> {{ $courierSent[0]->consignes }}</p>
                                                        @elseif($courierSent[0]->statut=='Envoyé')
                                                        <h5 style="color:green">Ce courrier a été envoyé,
                                                            veuillez
                                                            cliquer
                                                            sur <b>suivant</b> pour continuer</h5>
                                                        @elseif($courierSent[0]->statut=='Désapprouvé')
                                                        <h5 style="color:red">Ce courrier a été desapprouvé,
                                                            cliquez sur <b>reprendre</b>.</h5> <br>
                                                        <a class="load"
                                                            href="{{ route('reprendreCourier', [$courierSent[0]->slug ]) }}"
                                                            class="btn btn-warning" name="transmis"
                                                            value="{{ $courierSent[0]->slug }}"><i
                                                                class="fa fa-pencil"></i> Reprendre</a>
                                                        <p><b>
                                                                <h5>Consigne :</h5>
                                                            </b> {{ $courierSent[0]->consignes }}</p>
                                                        @else

                                                        @if(Auth::user()->role === 'Administrateur')
                                                        <h5>Ce courrier est déja transmis, veuillez vérifier pour une
                                                            approbation</h5>
                                                        <a href="#" class="btn btn-success" name="transmis"
                                                            value="{{ $courierSent[0]->slug }}" data-toggle="modal"
                                                            data-target="#addconsigne"><i
                                                                class="fa fa-check-circle"></i>
                                                            Approuver</a>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a href="#" class="btn btn-danger" name="transmis"
                                                            value="{{ $courierSent[0]->slug }}" data-toggle="modal"
                                                            data-target="#addconsigne2"><i
                                                                class="fa fa-times-circle"></i> Désapprouver</a>



                                                        @else
                                                        <h5 style="color:red">Ce courrier n'est pas encore approuvé ,
                                                            revenez plutard . . .</h5>

                                                        @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($courierSent[0]->statut=='Approuvé' || $courierSent[0]->statut=='Envoyé')
                                        <button class="btn  nextBtn  pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @else
                                        <button class="btn btn-default  pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="row form-step" id="step-3">
                                    <div class="col-md-12">
                                        <div class="">

                                            @if($courierSent[0]->statut=='Envoyé')
                                            <div class="text-center">
                                                <br>
                                                <h3 style="color:green">Ce courrier a déjà été envoyé . . .</h3><br>
                                                <h5><b>Date d'envoi :</b>
                                                    {{ date('d-m-Y', strtotime($courierSent[0]->dateEnvoi)) }}</h5>
                                                <h5><b>Personne en charge :</b> {{$courierSent[0]->nomPersonne}} </h5>

                                            </div>

                                            @else

                                            <div class="text-center mb-4 mt-4">
                                                <h3>Procédure d'envoi du courrier</h3>                                                   
                                                </div>
                                                <div class="col-md-12 col-sm-12" id="">
                                                    <div class="form-group">
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio">
                                                                <input id="radioStackedPro1" name="sendMode" onclick="sendbyphysique()" type="radio" class="custom-control-input" checked>
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description">Envoyer par voie physique</span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input id="radioStackedPro2" name="sendMode" onclick="sendbymail()" type="radio" class="custom-control-input">
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description">Envoyer par voie électronique</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <hr>
                                            <!-- form start -->
                                            <form class="padd-50" method="post" action="{{ route('completeCourier') }}" id="formEnvoiPhysique" >
                                                 @csrf
                                                
                                                <div class="row mrg-0">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="inputEmail" class="control-label">Date d'envoi
                                                                :</label>
                                                            <input type="date" class="form-control" id="inputEmail"
                                                                name="dateEnvoi"
                                                                data-error=" veillez saisir la date d'envoi du courrier"
                                                                required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="text" name="courierSlug" hidden="true"
                                                            value="{{ $slug }}">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label">Personne en
                                                                charge :</label>
                                                            <input type="text" class="form-control" id="inputPName"
                                                                placeholder=""
                                                                data-error=" veillez saisir le nom complet de la personne en charge de l'envoi du courrier"
                                                                name="nomPersonne" required />
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="inputEmail" class="control-label">Téléphone
                                                                :</label><br>
                                                            <input type="text" class="form-control" id="inputEmail"
                                                                name="telephonePersonne"
                                                                data-error=" veillez saisir le N° de téléphone"
                                                                required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-rounded btn-block theme-bg"
                                                                    style="width:10%;"> <i class="fa fa-send"></i>
                                                                    Envoyer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- form start -->
                                            <form class="padd-50" method="post" action="{{ route('sendCourrierMail') }}" accept-charset="utf-8" enctype="multipart/form-data" id="formEnvoiMail" hidden>
                                                @csrf
                                               
                                                <div class="row mrg-0">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label">À :</label>
                                                            <input type="email" class="form-control" id="phone" data-error="" name="email" required >
                                                          
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label">Cc :</label>
                                                            <select multiple="" name="emails[]" class="form-control select2"
                                                                data-placeholder="Recherchez..." style="width: 100%;" id="personne"
                                                                data-error="erre">
                                                                <option value="{{$paramCabinet[0]->emailContact}}" selected>
                                                                    {{$paramCabinet[0]->emailContact}}</option>
                                                                @foreach ($annuaires as $a)
                                                                <option value="{{ $a->email }}">{{ $a->email }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label">Objet :</label>
                                                                @if(empty($clientAffaire))
                                                                <input type="text" class="form-control" name="objet" value="{{ $courierSent[0]->objet }}" required>

                                                                @else
                                                                <input type="text" class="form-control" name="objet" value="{{ $courierSent[0]->objet }} - {{ $clientAffaire[0]->prenom }} {{ $clientAffaire[0]->nom }} - {{ $clientAffaire[0]->nomAffaire }}" required>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0 mb-4">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="description">Message :</label>
                                                            <div id="message-box"
                                                                style="overflow-y:auto; overflow-x:hidden;height:289px;">
                                                                
                                                               <textarea name="body" id="" cols="30" rows="5" class="form-control" required>
Madame/Monsieur,

Veuillez trouver en pièce jointe le courrier N°{{$courierSent[0]->numCourier}} pour le compte de @if(empty($clientAffaire)) {{ $paramCabinet[0]->nomCabinet }} @else {{ $clientAffaire[0]->prenom }} {{ $clientAffaire[0]->nom }}{{ $clientAffaire[0]->denomination }} @endif.

Salutation cordiale
</textarea>
                                                                <div class="mt-4">
                                                                    <?php echo $paramCabinet[0]->signature; ?>
                                                                </div>
                                                                

                                                            </div>

                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="text" name="slugCourier" value="{{$courierSent[0]->slug}}" hidden>
                                                <div class="row mrg-0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label">Joindre le courrier :</label>
                                                            <input type="file" class="fichiers form-control" id="phone"
                                                                name="attachment[]" multiple="multiple" required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idSuivit" name="idSuivit">
                                                <input type="hidden" id="idSuivitAppel" name="idSuivitAppel">
                                                <div class="row mrg-0">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-rounded btn-block theme-bg"
                                                                    style="width:10%;"><i class="fa fa-send"></i> Envoyer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        @endif
                                        </div>
                                        @if($courierSent[0]->statut=='Envoyé')
                                        <button class="btn  nextBtn  pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @else
                                        <button class="btn btn-default  pull-right" type="button">Suivant <i
                                                class="fa fa-arrow-right"></i></button>
                                        @endif

                                    </div>
                                </div>


                                <!-- Step 4 -->
                                <div class="row form-step" id="step-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <!-- form start -->
                                            <form class="padd-20" method="post" action="{{ route('accuserReception') }}"
                                                enctype="multipart/form-data">
                                                <div class="text-center">
                                                    <h3>Accusé réception du courrier</h3>
                                                    <br>
                                                    @csrf
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="inputEmail" class="control-label">Date de
                                                                reception:</label>
                                                            <input type="date" class="form-control" id="inputEmail"
                                                                name="dateReception"
                                                                data-error=" veillez saisir la date de reception du courrier"
                                                                required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">

                                                            <input type="text" name="slugCourier"
                                                                value="{{$courierSent[0]->slug}}" hidden>

                                                            <label for="inputPName" class="control-label"> N° du réçu
                                                                :</label>
                                                            <input type="text" class="form-control" id="inputPName"
                                                                placeholder=""
                                                                data-error=" veillez saisir le N° du réçu du courrier"
                                                                name="numeroRecu" required />
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="inputPName" class="control-label"> Joindre le
                                                                fichier
                                                                :</label>
                                                            <input type="file" name="fichiers[]" id="files"
                                                                class="fichiers form-control" accept="image/*,.pdf,"
                                                                multiple required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="text-center">
                                                                <button type="submit"
                                                                    class="theme-bg btn btn-rounded btn-block "
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
            </div>
        </div>
        <div class="add-popup modal fade" id="addconsigne" tabindex="-1" role="dialog" aria-labelledby="addcontact">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <ul class="card-actions icons right-top">
                            <li>
                                <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                                    <i class="ti-close"></i>
                                </a>
                            </li>
                        </ul>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Laisser une consigne</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('onApprouve')}}" accept-charset="utf-8"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mrg-0">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">

                                        <div class="card-body">
                                            <input type="hidden" name="slug" value="{{$courierSent[0]->slug}}">
                                            <textarea name="consignes" id="" cols="30" rows="10" class="form-control"
                                                placeholder="Inserez la consigne ici . . ." required></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mrg-0">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-rounded btn-block "
                                                style="width:50%;">Continuer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-popup modal fade" id="addconsigne2" tabindex="-1" role="dialog" aria-labelledby="addcontact">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <ul class="card-actions icons right-top">
                            <li>
                                <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                                    <i class="ti-close"></i>
                                </a>
                            </li>
                        </ul>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Laisser une consigne</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('desapprouver') }}" accept-charset="utf-8"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mrg-0">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">

                                        <div class="card-body">
                                            <input type="hidden" name="slug" value="{{$courierSent[0]->slug}}">
                                            <textarea name="consignes" id="" cols="30" rows="10" class="form-control"
                                                placeholder="Inserez la consigne ici . . ." required></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mrg-0">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-rounded btn-block "
                                                style="width:50%;">Continuer</button>
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

<script>
document.getElementById('cr').classList.add('active');

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