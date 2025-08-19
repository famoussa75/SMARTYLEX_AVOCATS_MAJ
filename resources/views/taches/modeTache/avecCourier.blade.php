<div role="tabpanel" class="tab-pane fade in active" id="Section1">
    <div class="card" style="padding: 10px;">
        <!-- form start -->
        <form   method="post" action="{{ route('addTask') }}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputP" class="control-label">Nom de la tâche :</label>
                        <input type="text" class="form-control" id="inputP" placeholder="saisir le nom de la tâche" data-error=" veillez saisir le nom de la tâche" name="titre" required>
                        <div class="help-block with-errors"></div>
                        <input type="hidden" name="courrier" value="{{$idCourrier}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="R" class="control-label">Type de tâche :</label>

                        <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idTypeTache" id="R" required>
                            <option>Creation de courrier</option>
                            <option>Creation d'entreprise</option>
                            <option>Contrats</option>
                            <option>Autres</option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

            </div>
            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="dateDebutTa" class="control-label">Date début de la tâche
                            :</label>
                        <input type="date" class="form-control dateDebutTa" id="dateDebutTa" name="dateDebut" data-error=" veillez saisir la date début de la tâche" required><br>
                        <span id="m1" class="m1" style=" color:red"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="dateFinTa" class="control-label">Date fin de la tâche
                            :</label>
                        <input type="date" class="form-control dateFinTa" id="dateFinTa" name="dateFin" data-error=" veillez saisir la date de fin de la tâche" required><br>
                        <span id="m2" class="m2" style=" color:red"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>

            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="client" class="control-label">Selectionner le client
                            :</label>

                        <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client" required>
                            <option value="{{ $clientCourrier[0]->id }}">
                                {{ $clientCourrier[0]->prenom }}
                                {{ $clientCourrier[0]->nom }}
                            </option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-6" id="affaireContent">
                    <input type="text" id="typeContent" value="taches" name="typeContent" hidden>
                    <div class="form-group">
                        <label for="affaire" class="control-label">Affaire du client concerné
                            :</label>
                        <select class="form-control select" data-placeholder="Affaire du client concerné" style="width: 100%;" name="idAffaire" id="affaireClient" required>
                            <option value="{{ $clientAffaire[0]->id }}">
                                {{ $clientAffaire[0]->nom }}

                            </option>

                        </select>
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
                        <label for="personne" class="control-label">Assignation de la
                            tâche:</label>
                        <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" required>
                            @foreach ($personnels as $personne)
                            <option value="{{ $personne->id }}">{{ $personne->prenom }}
                                {{ $personne->nom }}
                            </option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="personnePoint" class="control-label">Point :</label>
                        <input type="number" min="1" class="form-control" name="point" required id="personnePoint">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title m-t-0">Joindre un fichier ( Optionnel )</h4>
                        </div>
                        <div class="card-body">
                            <input type="file" class="fichiers form-control" name="filename" id="files" accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-12">
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div role="tabpanel" class="tab-pane fade" id="Section2">
    <div class="card" style="padding: 10px;">
        <!-- form start -->
        <form   method="post" action="{{ route('addTask') }}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputP" class="control-label">Nom de la tâche :</label>
                        <input type="text" class="form-control" id="inputP" placeholder="saisir le nom de la tâche" data-error=" veillez saisir le nom de la tâche" name="titre" required>
                        <div class="help-block with-errors"></div>
                        <input type="hidden" name="courrier" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="R" class="control-label">Type de tâche :</label>

                        <select class="form-control select2" data-placeholder="selectionner le client" style="width: 100%;" name="idTypeTache" id="R" required>
                            <option>Cabinet</option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="idClient" value="Cabinet">
            <input type="hidden" name="idAffaire" value="Cabinet">
            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="dateDebutTa" class="control-label">Date début de la tâche
                            :</label>
                        <input type="date" class="form-control dateDebutTa" id="dateDebutTa" name="dateDebut" data-error=" veillez saisir la date début de la tâche" required><br>
                        <span id="m1" class="m1" style=" color:red"""></span>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="dateFinTa" class="control-label">Date fin de la tâche
                            :</label>
                        <input type="date" class="form-control dateFinTa" id="dateFinTa" name="dateFin" data-error=" veillez saisir la date de fin de la tâche" required><br>
                        <span id="m2" class="m2" style=" color:red"""></span>
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
                        <label for="personne" class="control-label">Assignation de la
                            tâche:</label>
                        <select multiple="" name="idPersonnel[]" class="form-control select2" data-placeholder="Selectionner les personnes concernées pour la tâche" style="width: 100%;" id="personne" data-error="erre" required>
                            @foreach ($personnels as $personne)
                            <option value="{{ $personne->id }}">{{ $personne->prenom }}
                                {{ $personne->nom }}
                            </option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="personnePoint" class="control-label">Point :</label>
                        <input type="number" min="1" class="form-control" name="point" required id="personnePoint">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title m-t-0">Joindre un fichier ( Optionnel )</h4>
                        </div>
                        <div class="card-body">
                            <input type="file" class="fichiers form-control" name="filename" id="files" accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-12">
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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