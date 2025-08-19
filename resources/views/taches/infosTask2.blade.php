@extends('layouts.base')
@section('title','Tache en attente')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-9 align-self-center">
            <h5 class="theme-cl">
                <b>

                    @foreach ($clients as $c)
                    <span class="pdf-title1">{{ $c->idClient }}</span>

                    @endforeach
                    >
                    @foreach ($clients as $client)
                    <a class="load" href="{{route('clientInfos', [$client->idClient, $client->slug])}}" class="theme-cl pdf-title2">
                        {{ $client->prenom }} {{ $client->nom }} {{ $client->denomination }}</a>
                    @endforeach
                    >
                    @foreach ($affaires as $affaire)
                    <a class="load" href="{{route('showAffaire', [$affaire->idAffaire, $affaire->slug])}}" class="theme-cl pdf-title3">
                        {{ $affaire->nomAffaire }}</a>
                    @endforeach
                    >
                    <span class="label bg-info-light"><b>Tâche en attente</b></span>
                </b>
            </h5>
        </div>
        <div class="col-md-3">
            @if(Auth::user()->role=="Administrateur")
            <div class="dropdown" style="float: right ;">
                <button class="btn btn-rounded theme-bg dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">

                    <a class="dropdown-item " href="#" data-toggle="modal" data-target="#editTask"><i class="ti-pencil-alt mr-2"></i>Editer</a>
                    <a class="dropdown-item " href="#" onclick="getPDF()"><i class="ti-file mr-2"></i>Page en PDF</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteTask" href="{{route('deleteTask2',[$slug])}}" style="color:red"><i class="ti-close mr-2"></i>Supprimer</a>

                </div>


            </div>
            @else
            @endif

        </div>

    </div>
    <!-- Title & Breadcrumbs-->



    <script>
        function suggestion() {
            $('#typeTraitement').val('suggestion');
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
                                    @foreach ($tache as $taches)

                                    <h4 class="pdf-title4" style="color:gray">
                                        <b>
                                            @if($taches->titre=='Rédaction du PV et les Statuts')
                                                N° 1 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Enregistrement des PV et Statuts à l’impôt")
                                                N° 2 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Ouverture de compte bancaire pour la société en formation")
                                                N° 3 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Libération du capital social")
                                                N° 4 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Délivrance de l’attestation du dépôt de capital social")
                                                N° 5 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Création de la société sur la plateforme de l’APIP (SYNERGUI)")
                                                N° 6 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Rédaction de la lettre de transmission des pièces suivantes")
                                                N° 7 : {{ $taches->titre }}
                                            @elseif($taches->titre=="Récupération des documents suivants contre reçu de paiement")
                                                N° 8 : {{ $taches->titre }}
                                            @else
                                            {{ $taches->titre }}
                                            @endif
                                        </b>
                                   </h4>
                                    <p style="color:gray"> {{ $taches->description }}</p>
                                    <p style="color:gray">
                                        <b>Date début</b> : date de validation de la tache parente | <b>Date
                                            de
                                            fin</b> :
                                        <span style="color:red">Date de validation +{{$taches->dateFin}}
                                            jour(s)</span>
                                        | <b>Point</b> : {{ $taches->point }} &nbsp;&nbsp; <br>


                                        @if($taches->statut =='validée')
                                    <div class="label" style="background-color:green ;">{{ $taches->statut }}</div>
                                    @elseif($taches->statut =='En cours')
                                    <div class="label" style="background-color:aqua ;color:green">{{ $taches->statut }}
                                    </div>
                                    @elseif($taches->statut =='suspendu')
                                    <div class="label" style="background-color:grey ;">{{ $taches->statut }}</div>
                                    @else
                                    <div class="label" style="background-color:red ;">{{ $taches->statut }}</div>
                                    @endif
                                    <div class="label" style="background-color:orange ;"><b>Categorie :</b>
                                        {{ $taches->categorie }}
                                    </div>

                                    </p>
                                    <hr>



                                    @endforeach
                                </div>



                            </div>
                            <div class="row">
                                @if(empty($tacheParente))
                                @else
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <h4 class="pdf-title4"><b>Tâche Principale :</b>

                                        @foreach($tacheParente as $t)
                                        <a class="load" href="{{ route('infosTask', [$t->slug]) }}">{{$t->titre}}</a>
                                        @endforeach
                                    </h4>

                                </div>
                                @endif

                            </div>
                            @if(empty($tacheFille))
                            @else
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h3 class="box-title m-t-40 bg-warning">Tâche(s) en attente(s)</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            @foreach ($tacheFille as $row)
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
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h3 class="box-title m-t-40" style="background-color:gray">Personne(s) assignée(s)
                                        &nbsp;&nbsp;&nbsp;
                                        @if(Auth::user()->role=='Administrateur')
                                        <a href="#" data-toggle="modal" data-target="#jointureMultiple" type="btn btn-success"><i class="fa fa-plus-circle" style="font-size:x-large;color:white"></i></a>
                                        @else
                                        @endif
                                    </h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($personnels as $row)
                                                <tr>
                                                    <td>{{ $row->prenom }} {{ $row->nom }}</td>
                                                    <td>{{ $row->fonction }}</td>
                                                    <!-- <td> <a href="#" style="color:red" class="toggle"
                                                            title="Cliquer pour dissocié cette personne à la tâche">Dissocié</a>
                                                    </td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-6">

                                    <h3 class="box-title m-t-40" style="background-color:gray">Ressources de la tâche
                                        &nbsp;&nbsp;&nbsp;
                                        @if(Auth::user()->role=='Administrateur')
                                        <a href="#" type="btn btn-success" data-toggle="modal" data-target="#addcontact"><i class="fa fa-plus-circle" style="font-size:x-large;color:white"></i></a>
                                        @else
                                        @endif
                                    </h3>
                                    <div class="table-responsive">
                                        @if(empty($fichiers))
                                        <h4 style="text-align:center ;color:red; margin-bottom:30px">Aucun fichier n'est
                                            lié à
                                            cette tâche . . .
                                        </h4>
                                        @else

                                        <table class="table">
                                            <tbody>
                                                @foreach ($fichiers as $t)
                                                <tr>
                                                    <td style="width:10px ;">
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td><span class="heading-name-meta">
                                                            <a class="load" href="{{route('readFile', [$t->slug, 'x'])}}" class="toggle" title="Cliquer pour afficher le contenu du fichier"><i class="fa  fa-file-pdf-o" style="color:red; font-size:1.5em;"></i>
                                                            </a>
                                                        </span>
                                                    </td>
                                                    <td> {{$t->nomOriginal}}</td>

                                                    <td>
                                                        <span class="label cl-info bg-primary-ligth">{{ date('H:m', strtotime($t->created_at))}}</span>
                                                        <span class="label cl-info bg-primary-ligth">{{ date('d-m-Y', strtotime($t->created_at))}}</span>
                                                    </td>


                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        @endif
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
                <form   method="post" action="{{ route('joinFile') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0">Joindre un fichier à la tâche</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" name="slugTache" hidden="true" value="{{ $tache[0]->slug }}">
                                        <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]" multiple>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
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
                <form   method="post" action="{{ route('assigneTaskPersonne2', [$tache[0]->idTacheFille, $slug]) }}" accept-charset="utf-8" enctype="multipart/form-data">
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
                                                <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="selectionner ..." style="width: 100%;" id="personne" data-error="" required>
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
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
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
<div class="modal modal-box-1 fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="editTask" aria-hidden="true">
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
                <h4 class="modal-title text-center"><i class="fa fa-pencil"></i> Modification de la tâche</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title m-t-0 text-center">
                                     <!--$taches->idTypeTache ==0-->
                                    @if ($taches->idAffaire == null )
                                    Tache du cabinet
                                    @else
                                    &nbsp;
                                    @endif
                                </h4>
                            </div>
                            <!-- form start -->
                            <form   method="post" action="{{ route('updateTaskSelected2', [$slug]) }}" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf

                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="iputP" class="control-label">Nom de la tâche :</label>
                                            <input type="text" class="form-control" id="iputP" data-error=" veillez saisir le nom de la tâche" name="titre" required placeholder="" style="color:blue;" value="{{ $taches->titre }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                     <!--$taches->idTypeTache ==0-->
                                     <!-- 
                                    @if ($taches->idAffaire == null )

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Type de tâche :</label>
                                            <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idTypeTache" id="" required style="color:blue;">
                                                <option>Cabinet</option>

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Type de tâche :</label>
                                            <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idTypeTache" id="" required>
                                                <option>{{ $taches->idTypeTache }}</option>
                                                <option>Creation de courrier</option>
                                                <option>Creation d'entreprise</option>
                                                <option>Contrats</option>
                                                <option>Autres</option>

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    @endif-->
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="dateDebutTa" class="control-label">Date début de la tâche
                                                :</label>
                                            <p style="color:orange;font-weight:bold">La date de début correspond à la
                                                date de validation de la tâche principale. </p>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="dateFinTa" class="control-label">Date fin de la tâche
                                                :</label>
                                            <input type="number" class="form-control" id="dateFinCond2" placeholder="Nombre de jour après validation" data-placeholder="Choisissez un délais" data-error=" veillez saisir le nom de la tâche" name="dateFin" required>
                                            </br>
                                            <span id="m2" class="m2" style=" color:red"></span>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <!--$taches->idTypeTache ==0-->
                                    @if ($taches->idAffaire == null )
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="client" class="control-label">Client :</label>
                                            <select class="form-control" data-placeholder="" style="width: 100%; color:blue" name="idClient">
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
                                            <select class="form-control" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client" required style="color:blue">
                                                @foreach ($clients as $client)
                                                <option value="{{ $client->idClient }}" selected>{{ $client->prenom }}
                                                    {{ $client->nom }}
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
                                            <input type="number" name="point" min="1" class="form-control" style="height:30px" required placeholder="" style="color:blue;" value="{{ $taches->point }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--$taches->idTypeTache ==0-->
                                @if ($taches->idAffaire == null )
                                &nbsp;
                                @else
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="aff" class="control-label">Affaire :</label>
                                            <select class="form-control select2" data-placeholder="selectionner une affaire" style="width: 100%;" name="idAffaire" id="aff" required style="color:blue;">
                                                <!-- Mise a jour  -->
                                                @foreach ($affaires as $affaire)
                                                    <option value="{{ $affaire->idAffaire }}" selected>{{ $affaire->nomAffaire }}</option>
                                                @endforeach
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
                                            <textarea class="form-control" id="desc" rows="3" name="description" placeholder="" data-error=" veillez saisir une description de la tâche" required style="color:blue;">
                                            {{ $taches->description }}
                                            </textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
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
                        <a type="button" href="{{ route('deleteTask2', [$slug]) }}" class="load btn btn-danger">OUI</a>
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