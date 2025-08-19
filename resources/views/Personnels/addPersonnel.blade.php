@extends('layouts.base')
@section('title','Nouveau personnel')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-user-plus"></i> RH > <span class="label bg-info"><b>Nouveau</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a href="{{ route('allPersonnel') }}" class="cl-white theme-bg btn btn-rounded"
                    title="Liste des personnels">
                    <i class="fa fa-navicon"></i>
                    Liste du personnels
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form method="post" action="{{ route('addPersonnel') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <h2 class="mt-5"><i class="fa fa-user-plus"></i> Nouveau personnel</h2>
                        <br>

                    </div>

                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="initP" class="control-label">Intial de la personne :</label>
                                <input type="text" class="form-control" id="initP"
                                    placeholder="Initial de la personne exemple (AD) pour Amadou Diaby"
                                    data-error=" veillez saisir l'initial de la personne exemple (AD)"
                                    name="initialPersonnel" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="initP" class="control-label">SSN :</label>
                                <input type="text" class="form-control" id="initP"
                                    placeholder="Numero de securite sociale" data-error=" veillez saisir le SSN"
                                    name="ssn" >
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
                                <input type="text" class="form-control" id="inputP" placeholder="prénom de la personne"
                                    data-error=" veillez saisir le prénom de la personne" name="prenom" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputN" class="control-label">Nom :</label>
                                <input type="text" class="form-control" id="inputN" placeholder="nom de la personne"
                                    name="nom" data-error=" veillez saisir le nom de la personne" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sexe" class="control-label">Sexe :</label>
                                <select class="form-control select2" placeholder="selectionner le sexe"
                                    style="width: 100%;" name="sexe" id="sexe" required>
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
                                    data-error=" veillez saisir la date de naissance" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row mrg-0">
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label for="inputFAV" class="control-label">Téléphone </label><br>

                                <input type="text" class="form-control phone" style="width: 228%;" value="+224"
                                    data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="phoneP"
                                    name="telephone" data-error=" veillez saisir le téléphone" required>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label for="inputFAV" class="control-label">Numero d'urgence : </label><br>

                                <input type="text" class="form-control phone1" style="width: 228%;" value="+224"
                                    data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="phoneUP"
                                    name="numeroUrgence" data-error=" veillez saisir le téléphone" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>



                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputA" class="control-label">Adresse :</label>
                                <input type="text" class="form-control" id="inputA" placeholder="adresse de la personne"
                                    data-error=" veillez saisir l'adresse" name="adresse" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputF" class="control-label">Fonction : </label>
                                <input type="text" class="form-control" id="inputF"
                                    placeholder="fonction de la personne" name="fonction"
                                    data-error=" veillez saisir la fonction" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputSa" class="control-label">Salaire brut :</label>
                                <input type="text" class="form-control" id="inputSa"
                                    placeholder="salaire de la personne "
                                    data-error=" veillez saisir le salaire de la personne" name="salaire" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEM" class="control-label">E-mail :</label>
                                <input type="mail" class="form-control" id="inputEM" placeholder="e-mail de la personne"
                                    name="email" data-error="Cet adresse n'est pas valide" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="control-label">Joindre une photo</label>
                                <input type="file" name="photo" class="fichiers form-control" id="files" accept="image/*">
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
                                <input type="text" class="form-control" id="" placeholder="Saisir le prenom et nom"
                                    data-error="" name="nomPersonneUrgence" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEM" class="control-label">Telephone :</label>
                                <input type="text" class="form-control" id=""
                                    placeholder="Telephone de la personne à contacter" name="telPersonneUrgence" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                    </div>



                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <input type="submit" class="cl-white theme-bg btn btn-rounded btn-block"
                                        style="width:50%;" value="Enregistrer" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Contact Popup -->

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