@extends('layouts.base')
@section('title','Nouvelle Affaire')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti-bag"></i> Affaires > <span class="label bg-info"><b>Création</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a type="button" href="{{ route('allAfaires') }}" class="cl-white theme-bg btn btn-rounded" title="Liste des Affaires">
                    <i class="fa fa-navicon"></i>
                    Liste des Affaires
                </a>
            </div>

        </div>
    </div>
    <!-- Title & Breadcrumbs-->
    @if (sizeof($client) == 0)
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div class="text-center">
            <span>Aucune affaire ne peux être créer car aucun client n'est disponible, cliquer <a class="load" href="{{ route('clientForme') }}" style="color:blue">ici pour en ajouter une !</a> </span>
        </div>
    </div><br />
    @endif

   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form   id="myForm" class="padd-20" method="post" action="{{ route('storeAffaire') }}" enctype="multipart/form-data">
                    <div class="text-center">
                        <h2>Nouvelle Affaire</h2>
                        <br>
                        @csrf
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Nom de l'affaire </label>
                                <input type="text" class="form-control" id="inputPName"  data-error=" veillez saisir le nom de l'affaire" name="nom" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Date d'Ouverture</label>
                                <input type="date" class="form-control" id="inputEmail" name="dateOuverture" data-error=" veillez saisir la date d'ouverture" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Selectionner le client</label>
                                <select class="form-control select2" name="idClient" style="width: 100%;" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($client as $data )
                                    <option value={{ $data->idClient }}>
                                           {{$data->prenom}} {{$data->nom}} {{$data->denomination}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type" class="control-label">Type affaire</label>
                                <select class="form-control select2" id="type" name="type" style="width: 100%;" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    <option value="Contentieux">Contentieux</option>
                                    <option value="Conseil">Conseil</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type" class="control-label">Piece(s) jointe(s) ( Facultatif )</label>
                                <input type="file" class="fichiers form-control" name="fichiers[]" multiple>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        @if (sizeof($client) > 0)
                        <div class="col-12 mt-5">
                            <div class="theme-cl form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded" style="width:50%;"> Enregistrer</button>
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
<script>
    document.getElementById('aff').classList.add('active');

    // Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    console.warn = () => {};
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
<!-- End Add Contact Popup -->
@endsection