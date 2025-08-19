@extends('layouts.base')
@section('title','Courriers - Arrivée')
@section('content')

<style>
    .radio-sm {
        margin:10px;
        width: 16px;
        height: 16px;
        vertical-align: middle;
        margin-right: 10px;
    }
</style>

<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers - Arrivée > <span class="label bg-info"><b>Création</b></span></h4>
        </div>
        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a  href="{{ route('listCourierArriver') }}" class="cl-white theme-bg btn  btn-rounded" title="Liste des couriers">
                    <i class="fa fa-navicon"></i>
                    Liste Courriers - Arrivée
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->
   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form   class="padd-20" method="post" action=" {{ route('storeCourierArriver')}}" enctype="multipart/form-data">

                    @csrf

                    <div class="row mrg-0">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">N° ordre :</label>
                                <input type="text" class="form-control" id="inputPName" value="{{ $numero }}" name="numero" readOnly>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        @if(Auth::user()->role=='Administrateur')
                            <div class="col-md-5">
                                <div class="form-group" style="margin-left:50px">
                                <label for="">Confidentialité</label>
                                    <div class="row" >
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
                            <div class="col-md-5 mb-4">
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
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Expéditeur :</label>
                                <input type="text" class="form-control" id="inputPName" placeholder="nom expéditeur " data-error=" veillez saisir le nom expéditeur" name="expediteur" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Date du courrier :</label>
                                <input type="date" class="form-control" id="inputEmail" name="dateCourier" data-error=" veillez saisir la date du courrier" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Date d'arrivée :</label>
                                <input type="date" class="form-control" id="inputEmail" name="dateArriver" data-error=" veillez saisir la date arriver du courrier" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Objet : </label>
                                <textarea class="form-control" id="desc" rows="1" name="objet" data-error=" veillez saisir objet du courrier" required></textarea>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="row ">
                                <div class="col-md-4">
                                    <label class="custom-control custom-radio">
                                        <input id="radioStacked1" val="Cabinet" name="categorie" type="radio" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"> Courrier Cabinet </span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-control custom-radio">
                                        <input id="radioStacked2" name="categorie" type="radio" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"> Courrier Client</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mrg-0">

                        <div class="col-md-6">
                            <div class="form-group" id="clientSelect">
                                <label class="control-label">Selectionner le client :</label>
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="client">
                                    <option value="" selected disabled>-- Choisissez --</option>
                                        @foreach ($client as $data )
                                            <option value={{ $data->idClient }}>{{ $data->prenom }} {{ $data->nom }} {{ $data->denomination }}
                                            </option>
                                        @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6" id="affaireContent" hidden>
                            <input type="text" id="typeContent" value="courier arriver" name="typeContent" hidden>

                            <div class="form-group">
                                <label for="affaire" class="control-label">Affaire du client concerné :</label>
                                <select class="" style="width: 100%; height:28px" name="idAffaire" id="affaireClient">

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" id="signifie" name="notification" value="signifie" class="radio-sm">
                            Courier Signifié
                        </label>

                        <label>
                            <input type="radio" id="autre" name="notification" value="autre" class="radio-sm">
                            Autre Courrier
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="" id="huissierField" style="display: none;">
                                <label for="huissier">Nom de l'huissier :</label><br>
                                <select name="huissier" id="huissier" class="form-control select2" multiple required>
                                    @foreach ($huissier as $huissiers)
                                        <option value="{{ $huissiers->idHss }}">
                                            {{ $huissiers->prenomHss }} - {{ $huissiers->nomHss }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Importer un fichier</label>
                            <input type="file" class="fichiers form-control" name="fichiers[]" id="files" multiple required>
                        </div>
                    </div>


                    <div class="row mrg-0" style="margin-top: 10px;">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">Enregistrer</button>
                                </div>
                            </div>
                        </div>
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
    document.getElementById('cr').classList.add('active');

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#signifie').on('change', function () {
            if ($(this).is(':checked')) {
                $('#huissierField').show();
                $('#huissier').attr('required', true); // Facultatif
            } else {
                $('#huissierField').hide();
                $('#huissier').removeAttr('required'); // Facultatif
            }
        });
        $('#autre').on('change', function () {
            $('#huissierField').hide();
            $('#huissier').removeAttr('required'); 
        });
    });
</script>


</script>

@endsection