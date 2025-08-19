@extends('layouts.base')
@section('title','Ajout des données')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-link"></i> Jointure de documents des affaires</h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a class="load" href="{{ route('allAfaires') }}" class="cl-white theme-bg btn btn-rounded" title="Aller au gestionnaire">
                    <i class="fa fa-navicon"></i>
                    Liste des affaires
                </a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form method="post" action="{{ route('addFileBusinesse') }}" enctype="multipart/form-data"   class="padd-20">
                    <div class="text-center">
                        <h2>Joindre la pièce à l'affaire</h2>
                        <br>
                        @csrf
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Nom de la pièce </label>
                                <input type="text" class="form-control" id="inputPName" placeholder="nom de la pièce jointe " data-error=" veillez saisir le nom de la pièce jointe" name="filename" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="client" class="control-label">Selectionner le client :</label>

                                <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->idClient }}">{{ $client->prenom }}
                                        {{ $client->nom }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-4" id="affaireContent" hidden>
                            <input type="text" id="typeContent" value="taches" name="typeContent" hidden>
                            <div class="form-group">
                                <label for="affaire" class="control-label">Affaire du client concerné :</label>
                                <select class="form-control select" data-placeholder="Affaire du client concerné" style="width: 100%;" name="idAffaire" id="affaireClient" required>
                                     <option value="" selected disabled>-- Choisissez --</option>

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0">Joindre la Pièce</h4>
                                </div>
                                <div class="card-body">
                                    <input type="file" class="fichiers form-control" name="pathFiles" id="files" accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a" required>
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
<script>
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