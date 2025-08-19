@extends('layouts.base')
@section('title','Modification de l\'audience')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-pencil"></i> Modification de l'audience</h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('listAudience', 'generale') }}" class="cl-white theme-bg btn btn-default btn-rounded" title="Voir la liste des audiences">
                    <i class="fa fa-navicon"></i> Liste des audiences
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form  method="post" action="{{route('updateAudience',[$juriductionsAud[0]->slug,$juriductionsAud[0]->idAudience])}}" enctype="multipart/form-data">
            @csrf
                <div class="card padd-10">
                    <div class="panel-group accordion-stylist" id="accordion" role="tablist" aria-multiselectable="true">
                   
                   
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Juridiction compétente
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Juridiction<span style="color:red">*</span> :</label>
                                                <select name="juridiction" id="" class="form-select select2" style="width:100%" >
                                                    <option value={{$juriductionsAud[0]->id}} selected >{{$juriductionsAud[0]->nom}}</option>
                                                    @foreach($juriductions as $j)
                                                    <option value={{$j->id}}>{{$j->nom}}</option>
                                                    @endforeach
                                                </select>
                                                @error('juridiction')
                                                     <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Objet<span style="color:red">*</span> :</label>
                                                <input type="text" value="{{$juriductionsAud[0]->objet}}" name="objet" class="form-control" >
                                                @error('objet')
                                                     <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapse" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="headingFive">
                                        Niveau procedural / Nature
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="control-label">Selectionnez un niveau :</label>
                                                <select name="niveauProcedural" id="niveauProcedural" class="form-select select2" onchange="natureAud();" style="width:100%" >
                                                    <option value="{{$juriductionsAud[0]->niveauProcedural}}" selected >{{$juriductionsAud[0]->niveauProcedural}}</option>
                                                </select>
                                                @error('niveauProcedural')
                                                     <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="control-label">Nature :</label>
                                                <select name="nature" id="nature" class="form-select select2" style="width:100%" onchange="natureAud();" >
                                                    <option value="{{$juriductionsAud[0]->nature}}" selected >{{$juriductionsAud[0]->nature}}</option>
                                                </select>
                                                @error('nature')
                                                     <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row mrg-0" id="formInstruction" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Instruction ( Facultatif )</h2>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputPr" class="control-label">importer un fichier :</label>
                                                <input type="file" class="fichiers form-control" id="" placeholder="pièce jointe" data-error=" veillez joindre la pièce de l'assignation" name="pieceInstruction" accept="image/*,.pdf, .doc, docx">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <div id="audienceFormContent" onchange="LoadSelect2Script(oSelectForm);">
                            <!--- elements de formulaire avec le changement de selection du niveau --->
                            @if($juriductionsAud[0]->niveauProcedural=='1ère instance' && $juriductionsAud[0]->nature=='Civile')
                                @include('audiences.updateForm.premiereInstanceCivile')
                            @endif
                            @if($juriductionsAud[0]->niveauProcedural=='1ère instance' && $juriductionsAud[0]->nature=='Pénale')
                                @include('audiences.updateForm.premiereInstancePenale')
                            @endif
                            @if($juriductionsAud[0]->niveauProcedural=='Appel')
                                @include('audiences.updateForm.appel')
                            @endif
                            @if($juriductionsAud[0]->niveauProcedural=='Cassation')
                                @include('audiences.updateForm.cassation')
                            @endif
                            
                        </div>

                    </div>
                   
                </div>
            </form>
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

    var totalIteration = parseInt("{{count($partiesAdverse)}}");

   

    /** Mise en forme des SELECT **/
    LoadSelect2Script(oSelectForm);

    // Si le plugin n'est pas inclus dans la source, on l'intègre et on exécute la fonction passée en callback
    function LoadSelect2Script(callback) {
        if (!$.fn.select2) {
            $.getScript('/public/assets/plugins/select2/select2.full.min.js', callback);
        } else {
            if (callback && typeof(callback) === "function") {
                callback();
            }

        }
    }

    /**
     * @fonction : oSelectForm
     * @void (void) : void
     * @descr : Applique le plugin select2 sur les DOM élément SELECT
     **/
    function oSelectForm() {
        try {
            $(".select2").select2();
        } catch (error) {
            console.log(error);
        }


    }

    // Formset pour premiere instance civile
    function addformPIC() {
        
        ++totalIteration;
        j = totalIteration + 1
        var i = j;
        
        $("#dynamicAddRemove").append(`
            <div  class="form mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <h3>PARTIE ` + j + `</h3>
                    </div>

                    <div class="col-md-6">
                            <button type="button" class="btn btn-outline-danger btn-rounded remove-input-field"
                                        onclick="$(this).parents('.form').remove(); i=1" style="float:right"><i
                                            class="fa fa-trash"></i></button>

                    </div>
            </div>

            <div style="border: 1px solid; padding:10px;border-radius: 5px;">
                <div class="row mrg-0">
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKa-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKa(id)"
                                    value="Demandeur" required>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Demandeur </span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKb-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKb(id)"
                                    value="Defendeur" >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Defendeur</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKc-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" value="Autre" onclick="var id=` + i + `; roleASKc(id)"
                                    value="Autre" >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Autre</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-3 toReload" id="other-` + i + `" hidden>
                        <div class="form-group">
                            <label for="" class="control-label">Autre type* :</label>
                            <select name="formset[` + i + `][autreRole]" id="otherSelect-` + i + `" onchange="var id=` +
            i + `;otherSelect(id)"
                                class="form-control select2" style="width:100%"
                                data-placeholder="Choisissez..." >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                <option value='in'>Intervenant</option>
                                <option value='pc'>Partie civile</option>
                                <option value='mp'>Ministère public</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 cacher" id="avc-` + i + `" hidden>
                        <div class="form-group" id="dropSelect-` + i + `">
                            <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                            <select name="formset[` + i + `][typeAvocat]" id="typeAvocat-` + i + `" onchange="var id= ` +
            i + ` ;typeAvocat(id)"
                                class="form-select select2" style="width:100%"
                                data-placeholder="Choisissez..."  required>
                                 <option value="" selected disabled>-- Choisissez --</option>
                                 <option value='1'> 
                                            @if(Session::has('cabinetSession'))
                                                @foreach (Session::get('cabinetSession') as $cabinet)
                                                    {{$cabinet->nomCourt}}
                                                @endforeach
                                            @else
                                                Nous
                                            @endif
                                        </option>
                                <option value='2'>Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 cacher" id="clientContent-` + i + `" hidden>
                        <div class="form-group">
                            <label for="client" class="control-label">Selectionner le
                                client*
                                :</label>
                            <select name="formset[` + i + `][idClient]" id="client-` + i + `"
                                class="form-control select2" style="width:100%" onchange="var id=` + i + `; var idclient=$(this).val();clientAud(idclient,id)"
                                data-placeholder="Selectionner le client" >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                @foreach ($clients as $client)
                                <option value={{ $client->idClient }}>{{ $client->prenom }}
                                    {{ $client->nom }} {{ $client->denomination }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div class="col-md-5 cacher" id="affaireContent-` + i + `" hidden>
                        <input type="text" id="typeContent-` + i + `" value="audience"
                            name="formset[` + i + `][typeContent]" hidden>

                        <div class="form-group">
                            <label for="affaire" class="control-label">Affaire du client
                                concerné*
                                :</label>
                            <select class="" data-placeholder="Affaire du client concerné"
                                style="width: 100%;height:28px" name="formset[` + i + `][idAffaire]"
                                id="affaireClient-` + i + `" >

                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                   
                    <div class="col-md-6 cacher" id="otherAvocats-` + i + `" hidden>
                        <div class="form-group">
                            <label for="personne" class="control-label">Ajouter des
                                conseils (facultatif)</label>
                            <select multiple="" name="formset[` + i + `][idAvocat][]"
                                class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                style="width: 100%;" id="personne-` + i + `" >
                                @foreach ($avocats as $a)
                                <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                    {{ $a->nomAvc }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4" id="mp-` + i + `" hidden
                    style="text-align:center; padding: 30px;background-color:yellowgreen">
                    <h1>Ministère Public</h1>
                </div>

                <div class="row cacher" style="margin-top: 20px;" id="personneExterne-` + i + `"
                    hidden>
                    <div class="col-md-12">
                        <label for="">Renseignez les informations personnelles.</label>
                    </div>
                    <div class="row col-md-12 mb-4">
                        <div class="col-md-6">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="typeAdverse1-` + i + `"
                                        name="formset[` + i + `][typeAdverse]"
                                        onclick="var id= ` + i + ` ; personneOption(id)"
                                        type="radio"
                                        class="custom-control-input typeAdverse1-` + i + `"
                                        value="Personne physique" >
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Personne
                                        physique
                                    </span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="typeAdverse2-` + i + `"
                                        name="formset[` + i + `][typeAdverse]" type="radio"
                                        onclick="var id= ` + i + ` ; entrepriseOption(id)"
                                        class="custom-control-input typeAdverse2-` + i + `"
                                        value="Entreprise">
                                    <span class="custom-control-indicator"></span>
                                    <span
                                        class="custom-control-description">Entreprise</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mrg-0 adversePersonne" id="adversePersonne-` + i + `" hidden>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="prenom" class="control-label">Prénom :</label>
                                <input type="text" class="form-control" id="prenom-` + i + `"
                                    placeholder="prénom de la personne "
                                    data-error=" veillez saisir prénom de la personne"
                                    name="formset[` + i + `][prenom]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nom" class="control-label">Nom :</label>
                                <input type="text" class="form-control" id="nom-0"
                                    placeholder="nom de la personne"
                                    data-error=" veillez saisir le nom de la personne"
                                    name="formset[` + i + `][nom]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="nom" class="control-label">Telephone :</label>
                                <input type="text" class="form-control" id="nom-0"
                                    placeholder="Numero de telephone"
                                    data-error=" veillez saisir un numero"
                                    name="formset[` + i + `][telephone]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="profession" class="control-label">Profession
                                    :</label>
                                <input type="text" class="form-control" id="profession-` + i + `"
                                    placeholder="profession de la personne"
                                    data-error=" veillez saisir la profession"
                                    name="formset[` + i + `][profession]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nationalite" class="control-label">Nationalité
                                    :</label>
                                <input type="text" class="form-control" id="nationalite-` + i + `"
                                    placeholder="nationalité "
                                    data-error=" veillez saisir la nationalité"
                                    name="formset[` + i + `][nationalite]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="dateNaissance" class="control-label">Date de
                                    naissance
                                    :</label>
                                <input type="date" class="form-control" id="dateNaissance-` + i + `"
                                    placeholder="date de naissance"
                                    data-error=" veillez saisir la date de naissance de la personne"
                                    name="formset[` + i + `][dateNaissance]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="lNaissance" class="control-label">Lieu de
                                    naissance
                                    :</label>
                                <input type="text" class="form-control" id="lNaissance-` + i + `"
                                    placeholder="Lieu de naissance "
                                    data-error=" veillez indiquer le Lieu de naissance"
                                    name="formset[` + i + `][lieuNaissance]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pays" class="control-label">Pays :</label>
                                <input type="text" class="form-control" id="pays-` + i + `"
                                    placeholder="pays de la personne "
                                    data-error=" veillez renseigner le pays de la personne"
                                    name="formset[` + i + `][pays]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="domicile" class="control-label">domicile
                                    :</label>
                                <input type="text" class="form-control" id="domicil-` + i + `"
                                    placeholder="domicile"
                                    data-error=" veillez renseigner le domicile de la personne"
                                    name="formset[` + i + `][domicile]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-` + i + `" hidden>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="denomination" class="control-label">Dénomination
                                    :</label>
                                <input type="text" class="form-control" id="denomination-` + i + `"
                                    placeholder="dénomination de l'entreprise "
                                    data-error=" veillez saisir la dénomination de l'entreprise"
                                    name="formset[` + i + `][denomination]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rccm" class="control-label">N° RCCM :</label>
                                <input type="text" class="form-control" id="rccm-` + i + `"
                                    placeholder="RCCM de l'entreprise"
                                    data-error=" veillez saisir le N° RCCM"
                                    name="formset[` + i + `][numRccm]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="siege" class="control-label">Siège Social
                                    :</label>
                                <input type="text" class="form-control" id="siege-` + i + `"
                                    placeholder="siège social de l'entreprise"
                                    data-error=" veillez saisir le siège social de l'entreprise"
                                    name="formset[` + i + `][siegeSocial]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="formeLegal" class="control-label">Forme légale
                                    :</label>
                                <input type="text" class="form-control" id="formeLegal-` + i + `"
                                    placeholder="forme légale "
                                    data-error=" veillez saisir la forme légale"
                                    name="formset[` + i + `][formeLegal]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="representantLegal"
                                    class="control-label">Répresentant
                                    légale
                                    :</label>
                                <input type="text" class="form-control"
                                    id="representantLegal-` + i + `"
                                    placeholder="répresentant légal"
                                    data-error=" veillez saisir le nom du répresentant légal"
                                    name="formset[` + i + `][representantLegal]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>`
        );

        LoadSelect2Script(oSelectForm);
    };


    // Formset pour premiere instance Penale
    function addformPIP() {

        ++totalIteration;
        j = totalIteration + 1
        var i = j;
        $("#dynamicAddRemove").append(`
                <div  class="form mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>PARTIE ` + j + `</h3>
                        </div>

                        <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger btn-rounded remove-input-field"
                                            onclick="$(this).parents('.form').remove(); i=1" style="float:right"><i
                                                class="fa fa-trash"></i></button>

                        </div>
                </div>

                <div style="border: 1px solid; padding:10px;border-radius: 5px;">
                    <div class="row mrg-0">
                        <div class="col-md-4">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="roleASKa-` + i + `" name="formset[` + i + `][role]"
                                        type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKa(id)"
                                        value="Prevenu / Accusé" required>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Prevenu / Accusé</span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-4">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="roleASKb-` + i + `" name="formset[` + i + `][role]"
                                        type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKb(id)"
                                        value="Partie civile" >
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Partie civile</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="roleASKc-` + i + `" name="formset[` + i + `][role]"
                                        type="radio" class="custom-control-input" value="Autre" onclick="var id=` + i + `; roleASKc(id)"
                                         >
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Autre</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-3 toReload" id="other-` + i + `" hidden>
                            <div class="form-group">
                                <label for="" class="control-label">Autre type* :</label>
                                <select name="formset[` + i + `][autreRole]" id="otherSelect-` + i + `" onchange="var id=` +
            i + `;otherSelect(id)"
                                    class="form-control select2" style="width:100%"
                                    data-placeholder="Choisissez..." >
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    <option value='in'>Intervenant</option>
                                    <option value='pc'>Partie civile</option>
                                    <option value='mp'>Ministère public</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 cacher" id="avc-` + i + `" hidden>
                            <div class="form-group" id="dropSelect-` + i + `">
                                <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                <select name="formset[` + i + `][typeAvocat]" id="typeAvocat-` + i + `" onchange="var id= ` +
            i + ` ;typeAvocat(id)"
                                    class="form-select select2" style="width:100%"
                                    data-placeholder="Choisissez..."  required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                     <option value='1'> 
                                            @if(Session::has('cabinetSession'))
                                                @foreach (Session::get('cabinetSession') as $cabinet)
                                                    {{$cabinet->nomCourt}}
                                                @endforeach
                                            @else
                                                Nous
                                            @endif
                                        </option>
                                    <option value='2'>Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 cacher" id="clientContent-` + i + `" hidden>
                            <div class="form-group">
                                <label for="client" class="control-label">Selectionner le
                                    client*
                                    :</label>
                                <select name="formset[` + i + `][idClient]" id="client-` + i + `"
                                    class="form-control select2" style="width:100%" onchange="var id=` + i + `; var idclient=$(this).val();clientAud(idclient,id)"
                                    data-placeholder="Selectionner le client" >
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($clients as $client)
                                    <option value={{ $client->idClient }}>{{ $client->prenom }}
                                        {{ $client->nom }} {{ $client->denomination }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="col-md-5 cacher" id="affaireContent-` + i + `" hidden>
                            <input type="text" id="typeContent-` + i + `" value="audience"
                                name="formset[` + i + `][typeContent]" hidden>

                            <div class="form-group">
                                <label for="affaire" class="control-label">Affaire du client
                                    concerné*
                                    :</label>
                                <select class="" data-placeholder="Affaire du client concerné"
                                    style="width: 100%;height:28px" name="formset[` + i + `][idAffaire]"
                                    id="affaireClient-` + i + `" >

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <div class="col-md-6 cacher" id="otherAvocats-` + i + `" hidden>
                            <div class="form-group">
                                <label for="personne" class="control-label">Ajouter des
                                    conseils (facultatif)</label>
                                <select multiple="" name="formset[` + i + `][idAvocat][]"
                                    class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                    style="width: 100%;" id="personne-` + i + `" >
                                    @foreach ($avocats as $a)
                                    <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                        {{ $a->nomAvc }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4" id="mp-` + i + `" hidden
                        style="text-align:center; padding: 30px;background-color:yellowgreen">
                        <h1>Ministère Public</h1>
                    </div>

                    <div class="row cacher" style="margin-top: 20px;" id="personneExterne-` + i + `"
                        hidden>
                        <div class="col-md-12">
                            <label for="">Renseignez les informations personnelles.</label>
                        </div>
                        <div class="row col-md-12 mb-4">
                            <div class="col-md-6">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="typeAdverse1-` + i + `"
                                            name="formset[` + i + `][typeAdverse]"
                                            onclick="var id= ` + i + ` ; personneOption(id)"
                                            type="radio"
                                            class="custom-control-input typeAdverse1-` + i + `"
                                            value="Personne physique" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Personne
                                            physique
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="typeAdverse2-` + i + `"
                                            name="formset[` + i + `][typeAdverse]" type="radio"
                                            onclick="var id= ` + i + ` ; entrepriseOption(id)"
                                            class="custom-control-input typeAdverse2-` + i + `"
                                            value="Entreprise">
                                        <span class="custom-control-indicator"></span>
                                        <span
                                            class="custom-control-description">Entreprise</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mrg-0 adversePersonne" id="adversePersonne-` + i + `" hidden>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="prenom" class="control-label">Prénom :</label>
                                    <input type="text" class="form-control" id="prenom-` + i + `"
                                        placeholder="prénom de la personne "
                                        data-error=" veillez saisir prénom de la personne"
                                        name="formset[` + i + `][prenom]"  >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nom" class="control-label">Nom :</label>
                                    <input type="text" class="form-control" id="nom-0"
                                        placeholder="nom de la personne"
                                        data-error=" veillez saisir le nom de la personne"
                                        name="formset[` + i + `][nom]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="nom" class="control-label">Telephone :</label>
                                    <input type="text" class="form-control" id="nom-0"
                                        placeholder="Numero de telephone"
                                        data-error=" veillez saisir un numero"
                                        name="formset[` + i + `][telephone]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="profession" class="control-label">Profession
                                        :</label>
                                    <input type="text" class="form-control" id="profession-` + i + `"
                                        placeholder="profession de la personne"
                                        data-error=" veillez saisir la profession"
                                        name="formset[` + i + `][profession]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nationalite" class="control-label">Nationalité
                                        :</label>
                                    <input type="text" class="form-control" id="nationalite-` + i + `"
                                        placeholder="nationalité "
                                        data-error=" veillez saisir la nationalité"
                                        name="formset[` + i + `][nationalite]"  >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dateNaissance" class="control-label">Date de
                                        naissance
                                        :</label>
                                    <input type="date" class="form-control" id="dateNaissance-` + i + `"
                                        placeholder="date de naissance"
                                        data-error=" veillez saisir la date de naissance de la personne"
                                        name="formset[` + i + `][dateNaissance]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="lNaissance" class="control-label">Lieu de
                                        naissance
                                        :</label>
                                    <input type="text" class="form-control" id="lNaissance-` + i + `"
                                        placeholder="Lieu de naissance "
                                        data-error=" veillez indiquer le Lieu de naissance"
                                        name="formset[` + i + `][lieuNaissance]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pays" class="control-label">Pays :</label>
                                    <input type="text" class="form-control" id="pays-` + i + `"
                                        placeholder="pays de la personne "
                                        data-error=" veillez renseigner le pays de la personne"
                                        name="formset[` + i + `][pays]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="domicile" class="control-label">domicile
                                        :</label>
                                    <input type="text" class="form-control" id="domicil-` + i + `"
                                        placeholder="domicile"
                                        data-error=" veillez renseigner le domicile de la personne"
                                        name="formset[` + i + `][domicile]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-` + i + `" hidden>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="denomination" class="control-label">Dénomination
                                        :</label>
                                    <input type="text" class="form-control" id="denomination-` + i + `"
                                        placeholder="dénomination de l'entreprise "
                                        data-error=" veillez saisir la dénomination de l'entreprise"
                                        name="formset[` + i + `][denomination]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="rccm" class="control-label">N° RCCM :</label>
                                    <input type="text" class="form-control" id="rccm-` + i + `"
                                        placeholder="RCCM de l'entreprise"
                                        data-error=" veillez saisir le N° RCCM"
                                        name="formset[` + i + `][numRccm]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="siege" class="control-label">Siège Social
                                        :</label>
                                    <input type="text" class="form-control" id="siege-` + i + `"
                                        placeholder="siège social de l'entreprise"
                                        data-error=" veillez saisir le siège social de l'entreprise"
                                        name="formset[` + i + `][siegeSocial]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="formeLegal" class="control-label">Forme légale
                                        :</label>
                                    <input type="text" class="form-control" id="formeLegal-` + i + `"
                                        placeholder="forme légale "
                                        data-error=" veillez saisir la forme légale"
                                        name="formset[` + i + `][formeLegal]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="representantLegal"
                                        class="control-label">Répresentant
                                        légale
                                        :</label>
                                    <input type="text" class="form-control"
                                        id="representantLegal-` + i + `"
                                        placeholder="répresentant légal"
                                        data-error=" veillez saisir le nom du répresentant légal"
                                        name="formset[` + i + `][representantLegal]" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>`
        );

        LoadSelect2Script(oSelectForm);
    };

    // Formset pour appel Civile/Penale
    function addformAppel() {

        ++i;
        j = i + 1
        $("#dynamicAddRemove").append(`
                    <div  class="form mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>PARTIE ` + j + `</h3>
                            </div>

                            <div class="col-md-6">
                                    <button type="button" class="btn btn-outline-danger btn-rounded remove-input-field"
                                                onclick="$(this).parents('.form').remove(); i=1" style="float:right"><i
                                                    class="fa fa-trash"></i></button>

                            </div>
                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">
                        <div class="row mrg-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-` + i + `" name="formset[` + i + `][role]"
                                            type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKa(id)"
                                            value="Appelant" required>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Appelant(e)</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-` + i + `" name="formset[` + i + `][role]"
                                            type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKb(id)"
                                            value="Intimé(e)" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Intimé(e)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-` + i + `" name="formset[` + i + `][role]"
                                            type="radio" class="custom-control-input" value="Autre" onclick="var id=` + i + `; roleASKc(id)"
                                            value="Defendeur" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Autre</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-3 toReload" id="other-` + i + `" hidden>
                                <div class="form-group">
                                    <label for="" class="control-label">Autre type* :</label>
                                    <select name="formset[` + i + `][autreRole]" id="otherSelect-` + i + `" onchange="var id=` +
            i + `;otherSelect(id)"
                                        class="form-control select2" style="width:100%"
                                        data-placeholder="Choisissez..." >
                                         <option value="" selected disabled>-- Choisissez --</option>
                                        <option value='in'>Intervenant</option>
                                        <option value='pc'>Partie civile</option>
                                        <option value='mp'>Ministère public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 cacher" id="avc-` + i + `" hidden>
                                <div class="form-group" id="dropSelect-` + i + `">
                                    <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                    <select name="formset[` + i + `][typeAvocat]" id="typeAvocat-` + i + `" onchange="var id= ` +
            i + ` ;typeAvocat(id)"
                                        class="form-select select2" style="width:100%"
                                        data-placeholder="Choisissez..." required>
                                         <option value="" selected disabled>-- Choisissez --</option>
                                         <option value='1'> 
                                            @if(Session::has('cabinetSession'))
                                                @foreach (Session::get('cabinetSession') as $cabinet)
                                                    {{$cabinet->nomCourt}}
                                                @endforeach
                                            @else
                                                Nous
                                            @endif
                                        </option>
                                        <option value='2'>Autre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 cacher" id="clientContent-` + i + `" hidden>
                                <div class="form-group">
                                    <label for="client" class="control-label">Selectionner le
                                        client*
                                        :</label>
                                    <select name="formset[` + i + `][idClient]" id="client-` + i + `"
                                        class="form-control select2" style="width:100%" onchange="var id=` + i + `; var idclient=$(this).val();clientAud(idclient,id)"
                                        data-placeholder="Selectionner le client" >
                                         <option value="" selected disabled>-- Choisissez --</option>
                                        @foreach ($clients as $client)
                                        <option value={{ $client->idClient }}>{{ $client->prenom }}
                                            {{ $client->nom }} {{ $client->denomination }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div class="col-md-5 cacher" id="affaireContent-` + i + `" hidden>
                                <input type="text" id="typeContent-` + i + `" value="audience"
                                    name="formset[` + i + `][typeContent]" hidden>

                                <div class="form-group">
                                    <label for="affaire" class="control-label">Affaire du client
                                        concerné*
                                        :</label>
                                    <select class="" data-placeholder="Affaire du client concerné"
                                        style="width: 100%;height:28px" name="formset[` + i + `][idAffaire]"
                                        id="affaireClient-` + i + `" >

                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>

                            <div class="col-md-6 cacher" id="otherAvocats-` + i + `" hidden>
                                <div class="form-group">
                                    <label for="personne" class="control-label">Ajouter des
                                        conseils (facultatif)</label>
                                    <select multiple="" name="formset[` + i + `][idAvocat][]"
                                        class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                        style="width: 100%;" id="personne-` + i + `" >
                                        @foreach ($avocats as $a)
                                        <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4" id="mp-` + i + `" hidden
                            style="text-align:center; padding: 30px;background-color:yellowgreen">
                            <h1>Ministère Public</h1>
                        </div>

                        <div class="row cacher" style="margin-top: 20px;" id="personneExterne-` + i + `"
                            hidden>
                            <div class="col-md-12">
                                <label for="">Renseignez les informations personnelles.</label>
                            </div>
                            <div class="row col-md-12 mb-4">
                                <div class="col-md-6">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio">
                                            <input id="typeAdverse1-` + i + `"
                                                name="formset[` + i + `][typeAdverse]"
                                                onclick="var id= ` + i + ` ; personneOption(id)"
                                                type="radio"
                                                class="custom-control-input typeAdverse1-` + i + `"
                                                value="Personne physique">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Personne
                                                physique
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-6">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio">
                                            <input id="typeAdverse2-` + i + `"
                                                name="formset[` + i + `][typeAdverse]" type="radio"
                                                onclick="var id= ` + i + ` ; entrepriseOption(id)"
                                                class="custom-control-input typeAdverse2-` + i + `"
                                                value="Entreprise">
                                            <span class="custom-control-indicator"></span>
                                            <span
                                                class="custom-control-description">Entreprise</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mrg-0 adversePersonne" id="adversePersonne-` + i + `" hidden>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="prenom" class="control-label">Prénom :</label>
                                        <input type="text" class="form-control" id="prenom-` + i + `"
                                            placeholder="prénom de la personne "
                                            data-error=" veillez saisir prénom de la personne"
                                            name="formset[` + i + `][prenom]"  >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nom" class="control-label">Nom :</label>
                                        <input type="text" class="form-control" id="nom-0"
                                            placeholder="nom de la personne"
                                            data-error=" veillez saisir le nom de la personne"
                                            name="formset[` + i + `][nom]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="nom" class="control-label">Telephone :</label>
                                        <input type="text" class="form-control" id="nom-0"
                                            placeholder="Numero de telephone"
                                            data-error=" veillez saisir un numero"
                                            name="formset[` + i + `][telephone]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession" class="control-label">Profession
                                            :</label>
                                        <input type="text" class="form-control" id="profession-` + i + `"
                                            placeholder="profession de la personne"
                                            data-error=" veillez saisir la profession"
                                            name="formset[` + i + `][profession]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nationalite" class="control-label">Nationalité
                                            :</label>
                                        <input type="text" class="form-control" id="nationalite-` + i + `"
                                            placeholder="nationalité "
                                            data-error=" veillez saisir la nationalité"
                                            name="formset[` + i + `][nationalite]"  >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dateNaissance" class="control-label">Date de
                                            naissance
                                            :</label>
                                        <input type="date" class="form-control" id="dateNaissance-` + i + `"
                                            placeholder="date de naissance"
                                            data-error=" veillez saisir la date de naissance de la personne"
                                            name="formset[` + i + `][dateNaissance]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lNaissance" class="control-label">Lieu de
                                            naissance
                                            :</label>
                                        <input type="text" class="form-control" id="lNaissance-` + i + `"
                                            placeholder="Lieu de naissance "
                                            data-error=" veillez indiquer le Lieu de naissance"
                                            name="formset[` + i + `][lieuNaissance]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pays" class="control-label">Pays :</label>
                                        <input type="text" class="form-control" id="pays-` + i + `"
                                            placeholder="pays de la personne "
                                            data-error=" veillez renseigner le pays de la personne"
                                            name="formset[` + i + `][pays]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="domicile" class="control-label">domicile
                                            :</label>
                                        <input type="text" class="form-control" id="domicil-` + i + `"
                                            placeholder="domicile"
                                            data-error=" veillez renseigner le domicile de la personne"
                                            name="formset[` + i + `][domicile]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-` + i + `" hidden>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="denomination" class="control-label">Dénomination
                                            :</label>
                                        <input type="text" class="form-control" id="denomination-` + i + `"
                                            placeholder="dénomination de l'entreprise "
                                            data-error=" veillez saisir la dénomination de l'entreprise"
                                            name="formset[` + i + `][denomination]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rccm" class="control-label">N° RCCM :</label>
                                        <input type="text" class="form-control" id="rccm-` + i + `"
                                            placeholder="RCCM de l'entreprise"
                                            data-error=" veillez saisir le N° RCCM"
                                            name="formset[` + i + `][numRccm]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="siege" class="control-label">Siège Social
                                            :</label>
                                        <input type="text" class="form-control" id="siege-` + i + `"
                                            placeholder="siège social de l'entreprise"
                                            data-error=" veillez saisir le siège social de l'entreprise"
                                            name="formset[` + i + `][siegeSocial]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="formeLegal" class="control-label">Forme légale
                                            :</label>
                                        <input type="text" class="form-control" id="formeLegal-` + i + `"
                                            placeholder="forme légale "
                                            data-error=" veillez saisir la forme légale"
                                            name="formset[` + i + `][formeLegal]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="representantLegal"
                                            class="control-label">Répresentant
                                            légale
                                            :</label>
                                        <input type="text" class="form-control"
                                            id="representantLegal-` + i + `"
                                            placeholder="répresentant légal"
                                            data-error=" veillez saisir le nom du répresentant légal"
                                            name="formset[` + i + `][representantLegal]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>`
        );

        LoadSelect2Script(oSelectForm);
    };


    // Formset pour cassation Civile/Penale
    function addformCassation() {

        ++i;
        j = i + 1
        $("#dynamicAddRemove").append(`
            <div  class="form mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <h3>PARTIE ` + j + `</h3>
                    </div>

                    <div class="col-md-6">
                            <button type="button" class="btn btn-outline-danger btn-rounded remove-input-field"
                                        onclick="$(this).parents('.form').remove(); i=1" style="float:right"><i
                                            class="fa fa-trash"></i></button>

                    </div>
            </div>

            <div style="border: 1px solid; padding:10px;border-radius: 5px;">
                <div class="row mrg-0">
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKa-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKa(id)"
                                    value="Demandeur au pourvoi" required>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Demandeur au pourvoi</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKb-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" onclick="var id=` + i + `; roleASKb(id)"
                                    value="Defendeur au pourvoi" >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Defendeur au pourvoi</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio">
                                <input id="roleASKc-` + i + `" name="formset[` + i + `][role]"
                                    type="radio" class="custom-control-input" value="Autre" onclick="var id=` + i + `; roleASKc(id)"
                                     >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Autre</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-3 toReload" id="other-` + i + `" hidden>
                        <div class="form-group">
                            <label for="" class="control-label">Autre type* :</label>
                            <select name="formset[` + i + `][autreRole]" id="otherSelect-` + i + `" onchange="var id=` +
            i + `;otherSelect(id)"
                                class="form-control select2" style="width:100%"
                                data-placeholder="Choisissez..." >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                <option value='in'>Intervenant</option>
                                <option value='pc'>Partie civile</option>
                                <option value='mp'>Ministère public</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 cacher" id="avc-` + i + `" hidden>
                        <div class="form-group" id="dropSelect-` + i + `">
                            <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                            <select name="formset[` + i + `][typeAvocat]" id="typeAvocat-` + i + `" onchange="var id= ` +
            i + ` ;typeAvocat(id)"
                                class="form-select select2" style="width:100%"
                                data-placeholder="Choisissez..."  required>
                                 <option value="" selected disabled>-- Choisissez --</option>
                                 <option value='1'> 
                                            @if(Session::has('cabinetSession'))
                                                @foreach (Session::get('cabinetSession') as $cabinet)
                                                    {{$cabinet->nomCourt}}
                                                @endforeach
                                            @else
                                                Nous
                                            @endif
                                        </option>
                                <option value='2'>Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 cacher" id="clientContent-` + i + `" hidden>
                        <div class="form-group">
                            <label for="client" class="control-label">Selectionner le
                                client*
                                :</label>
                            <select name="formset[` + i + `][idClient]" id="client-` + i + `"
                                class="form-control select2" style="width:100%" onchange="var id=` + i + `; var idclient=$(this).val();clientAud(idclient,id)"
                                data-placeholder="Selectionner le client" >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                @foreach ($clients as $client)
                                <option value={{ $client->idClient }}>{{ $client->prenom }}
                                    {{ $client->nom }} {{ $client->denomination }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div class="col-md-5 cacher" id="affaireContent-` + i + `" hidden>
                        <input type="text" id="typeContent-` + i + `" value="audience"
                            name="formset[` + i + `][typeContent]" hidden>

                        <div class="form-group">
                            <label for="affaire" class="control-label">Affaire du client
                                concerné*
                                :</label>
                            <select class="" data-placeholder="Affaire du client concerné"
                                style="width: 100%;height:28px" name="formset[` + i + `][idAffaire]"
                                id="affaireClient-` + i + `" >

                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>

                    <div class="col-md-6 cacher" id="otherAvocats-` + i + `" hidden>
                        <div class="form-group">
                            <label for="personne" class="control-label">Ajouter des
                                conseils (facultatif)</label>
                            <select multiple="" name="formset[` + i + `][idAvocat][]"
                                class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                style="width: 100%;" id="personne-` + i + `" >
                                @foreach ($avocats as $a)
                                <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                    {{ $a->nomAvc }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4" id="mp-` + i + `" hidden
                    style="text-align:center; padding: 30px;background-color:yellowgreen">
                    <h1>Ministère Public</h1>
                </div>

                <div class="row cacher" style="margin-top: 20px;" id="personneExterne-` + i + `"
                    hidden>
                    <div class="col-md-12">
                        <label for="">Renseignez les informations personnelles.</label>
                    </div>
                    <div class="row col-md-12 mb-4">
                        <div class="col-md-6">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="typeAdverse1-` + i + `"
                                        name="formset[` + i + `][typeAdverse]"
                                        onclick="var id= ` + i + ` ; personneOption(id)"
                                        type="radio"
                                        class="custom-control-input typeAdverse1-` + i + `"
                                        value="Personne physique">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Personne
                                        physique
                                    </span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input id="typeAdverse2-` + i + `"
                                        name="formset[` + i + `][typeAdverse]" type="radio"
                                        onclick="var id= ` + i + ` ; entrepriseOption(id)"
                                        class="custom-control-input typeAdverse2-` + i + `"
                                        value="Entreprise">
                                    <span class="custom-control-indicator"></span>
                                    <span
                                        class="custom-control-description">Entreprise</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mrg-0 adversePersonne" id="adversePersonne-` + i + `" hidden>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="prenom" class="control-label">Prénom :</label>
                                <input type="text" class="form-control" id="prenom-` + i + `"
                                    placeholder="prénom de la personne "
                                    data-error=" veillez saisir prénom de la personne"
                                    name="formset[` + i + `][prenom]"  >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nom" class="control-label">Nom :</label>
                                <input type="text" class="form-control" id="nom-0"
                                    placeholder="nom de la personne"
                                    data-error=" veillez saisir le nom de la personne"
                                    name="formset[` + i + `][nom]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="nom" class="control-label">Telephone :</label>
                                <input type="text" class="form-control" id="nom-0"
                                    placeholder="Numero de telephone"
                                    data-error=" veillez saisir un numero"
                                    name="formset[` + i + `][telephone]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="profession" class="control-label">Profession
                                    :</label>
                                <input type="text" class="form-control" id="profession-` + i + `"
                                    placeholder="profession de la personne"
                                    data-error=" veillez saisir la profession"
                                    name="formset[` + i + `][profession]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nationalite" class="control-label">Nationalité
                                    :</label>
                                <input type="text" class="form-control" id="nationalite-` + i + `"
                                    placeholder="nationalité "
                                    data-error=" veillez saisir la nationalité"
                                    name="formset[` + i + `][nationalite]"  >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="dateNaissance" class="control-label">Date de
                                    naissance
                                    :</label>
                                <input type="date" class="form-control" id="dateNaissance-` + i + `"
                                    placeholder="date de naissance"
                                    data-error=" veillez saisir la date de naissance de la personne"
                                    name="formset[` + i + `][dateNaissance]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="lNaissance" class="control-label">Lieu de
                                    naissance
                                    :</label>
                                <input type="text" class="form-control" id="lNaissance-` + i + `"
                                    placeholder="Lieu de naissance "
                                    data-error=" veillez indiquer le Lieu de naissance"
                                    name="formset[` + i + `][lieuNaissance]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pays" class="control-label">Pays :</label>
                                <input type="text" class="form-control" id="pays-` + i + `"
                                    placeholder="pays de la personne "
                                    data-error=" veillez renseigner le pays de la personne"
                                    name="formset[` + i + `][pays]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="domicile" class="control-label">domicile
                                    :</label>
                                <input type="text" class="form-control" id="domicil-` + i + `"
                                    placeholder="domicile"
                                    data-error=" veillez renseigner le domicile de la personne"
                                    name="formset[` + i + `][domicile]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-` + i + `" hidden>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="denomination" class="control-label">Dénomination
                                    :</label>
                                <input type="text" class="form-control" id="denomination-` + i + `"
                                    placeholder="dénomination de l'entreprise "
                                    data-error=" veillez saisir la dénomination de l'entreprise"
                                    name="formset[` + i + `][denomination]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rccm" class="control-label">N° RCCM :</label>
                                <input type="text" class="form-control" id="rccm-` + i + `"
                                    placeholder="RCCM de l'entreprise"
                                    data-error=" veillez saisir le N° RCCM"
                                    name="formset[` + i + `][numRccm]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="siege" class="control-label">Siège Social
                                    :</label>
                                <input type="text" class="form-control" id="siege-` + i + `"
                                    placeholder="siège social de l'entreprise"
                                    data-error=" veillez saisir le siège social de l'entreprise"
                                    name="formset[` + i + `][siegeSocial]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="formeLegal" class="control-label">Forme légale
                                    :</label>
                                <input type="text" class="form-control" id="formeLegal-` + i + `"
                                    placeholder="forme légale "
                                    data-error=" veillez saisir la forme légale"
                                    name="formset[` + i + `][formeLegal]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="representantLegal"
                                    class="control-label">Répresentant
                                    légale
                                    :</label>
                                <input type="text" class="form-control"
                                    id="representantLegal-` + i + `"
                                    placeholder="répresentant légal"
                                    data-error=" veillez saisir le nom du répresentant légal"
                                    name="formset[` + i + `][representantLegal]" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>`
        );

        LoadSelect2Script(oSelectForm);
    };

    // Si le choix du type est personne physique
    function personneOption(id) {
        console.log(id);
        const adversePersonne = "#adversePersonne-" + id;
        $(adversePersonne).removeAttr('hidden');

        const adverseEntreprise = "#adverseEntreprise-" + id;
        $(adverseEntreprise).attr('hidden', true);

        const representantLegal = "#representantLegal-" + id;
        const formeLegal = "#formeLegal-" + id;
        const siege = "#siege-" + id;
        const rccm = "#rccm" + id;
        const denomination = "#denomination-" + id;
        const prenom = "#prenom-" + id;
        const nom = "#nom-" + id;
        const profession = "#profession-" + id;
        const nationalite = "#nationalite-" + id;
        const dateNaissance = "#dateNaissance-" + id;
        const lNaissance = "#lNaissance-" + id;
        const pays = "#pays-" + id;
        const domicil = "#domicil-" + id;
        const personneOption = "#domicil-" + id;

       

        $(representantLegal).removeAttr('required');
        $(formeLegal).removeAttr('required');
        $(siege).removeAttr('required');
        $(rccm).removeAttr('required');
        $(denomination).removeAttr('required');

        $(representantLegal).val('');
        $(formeLegal).val('');
        $(siege).val('');
        $(rccm).val('');
        $(denomination).val('');


        $(prenom).attr('required', true);
        $(nom).attr('required', true);
        $(profession).attr('required', true);
        $(nationalite).attr('required', true);
        $(dateNaissance).attr('required', true);
        $(lNaissance).attr('required', true);
        $(pays).attr('required', true);
        $(domicil).attr('required', true);
    }

    // Si le choix du type est personne morale
    function entrepriseOption(id) {

        const adversePersonne = "#adversePersonne-" + id;
        $(adversePersonne).attr('hidden', true);

        const adverseEntreprise = "#adverseEntreprise-" + id;
        $(adverseEntreprise).removeAttr('hidden');

        const representantLegal = "#representantLegal-" + id;
        const formeLegal = "#formeLegal-" + id;
        const siege = "#siege-" + id;
        const rccm = "#rccm" + id;
        const denomination = "#denomination-" + id;
        const prenom = "#prenom-" + id;
        const nom = "#nom-" + id;
        const profession = "#profession-" + id;
        const nationalite = "#nationalite-" + id;
        const dateNaissance = "#dateNaissance-" + id;
        const lNaissance = "#lNaissance-" + id;
        const pays = "#pays-" + id;
        const domicil = "#domicil-" + id;

        $(prenom).removeAttr('required');
        $(nom).removeAttr('required');
        $(profession).removeAttr('required');
        $(nationalite).removeAttr('required');
        $(dateNaissance).removeAttr('required');
        $(lNaissance).removeAttr('required');
        $(pays).removeAttr('required');
        $(domicil).removeAttr('required');

        $(representantLegal).attr('required', true);
        $(formeLegal).attr('required', true);
        $(siege).attr('required', true);
        $(rccm).attr('required', true);
        $(denomination).attr('required', true);


        $(prenom).val('');
        $(nom).val('');
        $(profession).val('');
        $(nationalite).val('');
        $(dateNaissance).val('');
        $(lNaissance).val('');
        $(pays).val('');
        $(domicil).val('');
    }

    
    // Function to validate dates on change
    function validateDatesAss() {
                const dateAssignation = new Date(document.getElementById('dateAssignation').value);
                const dateEnrollement = new Date(document.getElementById('dateEnrollement').value);
                const datePremiereComp = new Date(document.getElementById('datePremiereComp').value);

            if (datePremiereComp <= dateEnrollement || dateEnrollement < dateAssignation) {
                alert('Veuillez entrer des dates valides, telles que la date de 1ère comparution soit postérieure à la date d\'enrôlement et la date d\'assignation soit antérieur ou égale à la date d\'enrôlement');
                $('#submitButton').prop('disabled', true);
                $('#submitButton').removeClass('theme-bg');
                $('#submitButton').addClass('btn-default');
            }else{
                $('#submitButton').prop('disabled', false);
                $('#submitButton').removeClass('btn-default');
                $('#submitButton').addClass('theme-bg');
            }
            
    }

    // Function to validate dates on change
    function validateDatesOpp() {
                const dateActe = new Date(document.getElementById('dateActe').value);
                const dateEnrollementOpp = new Date(document.getElementById('dateEnrollementOpp').value);
                const datePremiereCompOpp = new Date(document.getElementById('datePremiereCompOpp').value);

            if (datePremiereCompOpp <= dateEnrollementOpp || dateEnrollementOpp < dateActe) {
                alert('Veuillez entrer des dates valides, telles que la date de 1ère comparution soit postérieure à la date d\'enrôlement et la date de l\'acte soit antérieur ou égale à la date d\'enrôlement');
                $('#submitButton').prop('disabled', true);
                $('#submitButton').removeClass('theme-bg');
                $('#submitButton').addClass('btn-default');
            }else{
                $('#submitButton').prop('disabled', false);
                $('#submitButton').removeClass('btn-default');
                $('#submitButton').addClass('theme-bg');
            }
    }

           
</script>

<script>
    document.getElementById('aud').classList.add('active');
</script>
@endsection