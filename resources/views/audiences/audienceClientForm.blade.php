@extends('layouts.base')
@section('title','Ouverture de l\'audience')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl">A propos </h4>
            @foreach ($infoClient as $row)
            @if($row->typeClient =="Client Physique")
            <p>
            <h4>Client : {{ $row->prenom }} {{ $row->nom }}<br></h4>
            <span>Téléphone : {{ $row->telephone }}<br></span>
            <span>E-mail : {{ $row->email }}<br></span>
            <span>Adresse : {{ $row->adresse }}<br></span>
            </p>
            @else
            <p>
            <h4> Sociéte (Client) : {{ $row->nom }}<br></h4>
            <span> Téléphone : {{ $row->telephone }}<br></span>
            <span> E-mail : {{ $row->email }}<br></span>
            <span> Adresse : {{ $row->adresse }}<br></span>
            <span> RCCM : {{ $row->rccm }}<br></span>
            </p>
            @endif
            @endforeach
        </div>
        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <a href="{{ route('allClient') }}" class="cl-white theme-bg btn btn-default btn-rounded">
                    <i class="fa fa-navicon"></i> Liste des clients
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form   class="padd-20" method="post" action=" {{ route('storeAudience')}}" enctype="multipart/form-data">
                <div class="card">
                    <div class="panel-group accordion-stylist" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="text-center">
                            <br>
                            @csrf
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Audience
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Objet audience :</label>
                                                <input type="text" class="form-control" id="inputPName" placeholder="Objet de l'audience " data-error=" veillez saisir l'objet de l'audience" name="objet" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Démandeur / Défendeur
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <h3>ASK Avocats</h3>
                                    <hr>
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="roleASKa1" name="roleASK" type="radio" class="custom-control-input" value="Demandeur" required>
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Demandeur </span>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-sm-6">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="roleASKb1" name="roleASK" type="radio" class="custom-control-input" value="Defendeur" required>
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Defendeur</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="client" class="control-label">Selectionner le client
                                                    :</label>
                                                <select name="idClient" id="client" class="form-control select2" data-placeholder="Selectionner le client" required>
                                                     <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach ($infoClient as $client)
                                                    <option value={{ $client->idClient }}>{{ $client->prenom }}
                                                        {{ $client->nom }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="affaireContent" hidden>
                                        <input type="text" id="typeContent" value="audience client" name="typeContent" hidden>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="affaireClient" class="control-label">Affaire du client
                                                    concernés :</label>
                                                <select class="form-control" data-placeholder="Affaire du client concerné" style="width: 100%;" name="idAffaire" id="affaireClient" required>

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h3>Partie adverse</h3>
                                    <div class="row mrg-0">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="" class="control-label">
                                                    <span class="custom-control-description" id="roleAD1">
                                                        &nbsp;Demandeur&nbsp; </span><br>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="" class="control-label">
                                                    <span class="custom-control-description" id="roleAD2">&nbsp;Defendeur&nbsp;</span>
                                                </label>
                                                <input type="text" id="roleAdverse" name="roleAdverse" hidden="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="typeAdverse1" name="typeAdverse" type="radio" class="custom-control-input" value="Personne physique">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Personne physique </span>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-sm-3">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="typeAdverse2" name="typeAdverse" type="radio" class="custom-control-input" value="Entreprise">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Entreprise</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mrg-0" id="adversePersonne">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="prenom" class="control-label">Prénom :</label>
                                                <input type="text" class="form-control" id="prenom" placeholder="prénom de la personne " data-error=" veillez saisir prénom de la personne" name="prenomPersonne" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="nom" class="control-label">Nom :</label>
                                                <input type="text" class="form-control" id="nom" placeholder="nom de la personne" data-error=" veillez saisir le nom de la personne" name="nomPersonne" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="profession" class="control-label">Profession :</label>
                                                <input type="text" class="form-control" id="profession" placeholder="profession de la personne" data-error=" veillez saisir la profession" name="professionPersonne" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="nationalite" class="control-label">Nationalité :</label>
                                                <input type="text" class="form-control" id="nationalite" placeholder="nationalité " data-error=" veillez saisir la nationalité" name="nationalite" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="dateNaissance" class="control-label">Date de naissance
                                                    :</label>
                                                <input type="date" class="form-control" id="dateNaissance" placeholder="date de naissance" data-error=" veillez saisir la date de naissance de la personne" name="dateNaissancePersonne" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="lNaissance" class="control-label">Lieu de naissance
                                                    :</label>
                                                <input type="text" class="form-control" id="lNaissance" placeholder="Lieu de naissance " data-error=" veillez indiquer le Lieu de naissance" name="lieuNaissance" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="pays" class="control-label">Pays :</label>
                                                <input type="text" class="form-control" id="pays" placeholder="pays de la personne " data-error=" veillez renseigner le pays de la personne" name="paysPersonne" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="domicile" class="control-label">Domicile :</label>
                                                <input type="text" class="form-control" id="domicil" placeholder="domicile " data-error=" veillez renseigner le domicile de la personne" name="domicil" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="adverseEntreprise">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="denomination" class="control-label">Dénomination :</label>
                                                <input type="text" class="form-control" id="denomination" placeholder="dénomination de l'entreprise " data-error=" veillez saisir la dénomination de l'entreprise" name="denomination" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="rccm" class="control-label">N° RCCM :</label>
                                                <input type="text" class="form-control" id="rccm" placeholder="RCCM de l'entreprise" data-error=" veillez saisir le N° RCCM" name="Nrccm" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="siege" class="control-label">Siège Social :</label>
                                                <input type="text" class="form-control" id="siege" placeholder="siège social de l'entreprise" data-error=" veillez saisir le siège social de l'entreprise" name="siegeSocial" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="formeLegal" class="control-label">Forme légale :</label>
                                                <input type="text" class="form-control" id="formeLegal" placeholder="forme légale " data-error=" veillez saisir la forme légale" name="formeLegal" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="representantLegal" class="control-label">Répresentant légale
                                                    :</label>
                                                <input type="text" class="form-control" id="representantLegal" placeholder="répresentant légal" data-error=" veillez saisir le nom du répresentant légal" name="representantLegal" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <hr>
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Avocat adverse
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputPr" class="control-label">Prénom :</label>
                                                <input type="text" class="form-control" id="inputDAV" placeholder="prénom de l'avocat adverse" data-error=" veillez saisir le prénom de l'avocat adverse" name="prenomAV" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputNR" class="control-label">Nom :</label>
                                                <input type="text" class="form-control" id="inputNAV" placeholder="nom de l'avocat" data-error=" veillez saisir le nom de l'avocat" name="nomAV" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputPS" class="control-label">Adresse :</label>
                                                <input type="text" class="form-control" id="inputPAV" placeholder="adresse de l'avocat" data-error=" veillez saisir l'adresse" name="adresseAV" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputFAV" class="control-label">Téléphone :</label>
                                                <input type="text" class="form-control" id="inputFAV" placeholder="téléphone de l'avocat " data-error=" veillez saisir le téléphone" name="telephoneAV" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputRPAV" class="control-label">E-mail :</label>
                                                <input type="text" class="form-control" id="inputRPAV" placeholder="e-mail" data-error=" veillez saisir l'adresse mail de l'avocat" name="emailAV" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Assignation
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputPr" class="control-label">N° RG :</label>
                                                <input type="text" class="form-control" id="inputRG" placeholder="N° de du registre général" data-error=" veillez saisir le N° RG" name="numRg">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputJNS" class="control-label">Juridiction :</label>
                                                <input type="text" class="form-control" id="inputJNS" placeholder="juridiction " data-error=" veillez saisir la juridiction" name="juridictionAS" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputPS" class="control-label">Huissier :</label>
                                                <input type="text" class="form-control" id="inputH" placeholder="nom huissier" data-error=" veillez saisir le huissier" name="idHuissier" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inpuRC" class="control-label">Réçue par :</label>
                                                <input type="text" class="form-control" id="inpuRC" placeholder="assignation réçu par :" data-error=" veillez saisir le nom du receveur" name="recepteurAss" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="mentionP" class="control-label">Mention particulière
                                                    :</label>
                                                <textarea id="mentionP" cols="4" rows="2" class="form-control" data-error=" veillez saisir la mention particulière" name="mentionParticuliere" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputASN" class="control-label">Date assignation :</label>
                                                <input type="date" class="form-control" id="inputASN" placeholder="date d'assignation" data-error=" veillez saisir la date asignation" name="dateAssignation" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputFDAT" class="control-label">Date de la 1ère comparition
                                                    :</label>
                                                <input type="date" class="form-control" id="inputFDAT" placeholder="Date de la première comparition " data-error=" veillez saisir la date de la première comparition" name="datePremiereComp" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputENAS" class="control-label">Date enroulement :</label>
                                                <input type="date" class="form-control" id="inputENAS" placeholder="date d'enroulement" data-error=" veillez saisir la date d'enroulement" name="dateEnrollement">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputRPAV" class="control-label">Pièce :</label>
                                                <input type="file" class="fichiers form-control" id="inputASF" placeholder="pièce jointe" data-error=" veillez joindre la pièce de l'assignation" name="pieceAS" accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-rounded btn-block " style="width:50%;">
                                Enregistrer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('aud').classList.add('active');

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