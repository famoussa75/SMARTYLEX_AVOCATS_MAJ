

<!-- Parties -->
<input type="hidden" value="FormCivile" name="formulaire" />
<div class="panel panel-default" id="partieInstance">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Parties
            </a>
        </h4>
    </div>


    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <div id="dynamicAddRemove">
                <div class="form mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>PARTIE 1</h3>
                        </div>

                        <div class="col-md-6">
                            <button type="button" name="add" id="dynamic-update" onclick="addformPIC()" class="cl-white theme-bg btn btn-rounded" style="float:right"><i class="fa fa-plus"></i></button>
                        </div>

                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-0" name="formset[0][role]" onclick="var id=0; roleASKa(id)" value="Demandeur" type="radio" class="custom-control-input" required>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Demandeur</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-0" name="formset[0][role]" onclick="var id=0; roleASKb(id)" value="Defendeur" type="radio" class="custom-control-input" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Defendeur</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-0" name="formset[0][role]" type="radio" class="custom-control-input" value="Autre" onclick="var id=0; roleASKc(id)" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Autre</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-3 toReload" id="other-0" hidden>
                                <div class="form-group">
                                    <label for="" class="control-label">Autre type* :</label>
                                    <select name="formset[0][autreRole]" id="otherSelect-0" onchange="var id=0;otherSelect(id)" class="form-control select2" style="width:100%" data-placeholder="Choisissez..." >
                                        <option value="" selected disabled>-- Choisissez --</option>
                                        <option value='in'>Intervenant</option>
                                        <option value='pc'>Partie civile</option>
                                        <option value='mp'>Ministère public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 cacher" id="avc-0" hidden>
                                <div class="form-group" id="dropSelect-0">
                                    <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                    <select name="formset[0][typeAvocat]" id="typeAvocat-0" onchange="var id= 0 ;typeAvocat(id)" class="form-select select2" style="width:100%" data-placeholder="Choisissez..." required>
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

                            <div class="col-md-4 cacher" id="clientContent-0" hidden>
                                <div class="form-group">
                                    <label for="client" class="control-label">Selectionner le
                                        client*
                                        :</label>
                                    <select name="formset[0][idClient]" id="client-0" onchange="var id=0; var idclient=$(this).val();clientAud(idclient,id)" class="form-control select2" style="width:100%" data-placeholder="Selectionner le client" >
                                        <option value="" selected disabled>-- Choisissez --</option>
                                        @foreach ($clients as $client)
                                        <option value={{ $client->idClient }}>
                                            {{ $client->prenom }}
                                            {{ $client->nom }}
                                            {{ $client->denomination }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div class="col-md-5 cacher" id="affaireContent-0" hidden>
                                <input type="text" id="typeContent-0" value="audience" name="formset[0][typeContent]" hidden>

                                <div class="form-group">
                                    <label for="affaire" class="control-label">Affaire du client
                                        concerné*
                                        :</label>
                                    <select data-placeholder="Affaire du client concerné" style="width: 100%;height:28px" name="formset[0][idAffaire]" id="affaireClient-0" >

                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>

                            <div class="col-md-6 cacher" id="otherAvocats-0" hidden>
                                <div class="form-group">
                                    <label for="personne" class="control-label">Ajouter des
                                        conseils (facultatif)</label>
                                    <select multiple name="formset[0][idAvocat][]" class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER" style="width: 100%;" id="personne-0">
                                        @foreach ($avocats as $a)
                                        <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4" id="mp-0" hidden style="text-align:center; padding: 30px;background-color:yellowgreen">
                            <h1>Ministère Public</h1>
                        </div>

                        <div class="row cacher" style="margin-top: 20px;" id="personneExterne-0" hidden>
                            <div class="col-md-12">
                                <label for="">Renseignez les informations personnelles.</label>
                            </div>

                            <div class="row col-md-12 mb-4">
                                <div class="col-md-6">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio">
                                            <input id="typeAdverse1-0" name="formset[0][typeAdverse]" onclick="var id= 0 ; personneOption(id)" type="radio" class="custom-control-input typeAdverse1-0" value="Personne physique" >
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
                                            <input id="typeAdverse2-0" name="formset[0][typeAdverse]" type="radio" onclick="var id= 0 ; entrepriseOption(id)" class="custom-control-input typeAdverse2-0" value="Entreprise">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Entreprise</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mrg-0 adversePersonne" id="adversePersonne-0" hidden>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="prenom" class="control-label">Prénom
                                            :</label>
                                        <input type="text" class="form-control" id="prenom-0" data-error=" veillez saisir prénom de la personne" name="formset[0][prenom]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="nom" class="control-label">Nom :</label>
                                        <input type="text" class="form-control" id="nom-0" data-error=" veillez saisir le nom de la personne" name="formset[0][nom]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession" class="control-label">Telephone
                                            :</label>
                                        <input type="text" class="form-control" id="telephone-0" data-error=" veillez saisir un numero" name="formset[0][telephone]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession" class="control-label">Profession
                                            :</label>
                                        <input type="text" class="form-control" id="profession-0" data-error=" veillez saisir la profession" name="formset[0][profession]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nationalite" class="control-label">Nationalité
                                            :</label>
                                        <input type="text" class="form-control" id="nationalite-0" data-error=" veillez saisir la nationalité" name="formset[0][nationalite]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dateNaissance" class="control-label">Date de
                                            naissance
                                            :</label>
                                        <input type="date" class="form-control" id="dateNaissance-0" data-error=" veillez saisir la date de naissance de la personne" name="formset[0][dateNaissance]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lNaissance" class="control-label">Lieu de
                                            naissance
                                            :</label>
                                        <input type="text" class="form-control" id="lNaissance-0" data-error=" veillez indiquer le Lieu de naissance" name="formset[0][lieuNaissance]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pays" class="control-label">Pays :</label>
                                        <input type="text" class="form-control" id="pays-0" data-error=" veillez renseigner le pays de la personne" name="formset[0][pays]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="domicile" class="control-label">domicile
                                            :</label>
                                        <input type="text" class="form-control" id="domicil-0" data-error=" veillez renseigner le domicile de la personne" name="formset[0][domicile]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-0" hidden>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="denomination" class="control-label">Dénomination
                                            :</label>
                                        <input type="text" class="form-control" id="denomination-0" data-error=" veillez saisir la dénomination de l'entreprise" name="formset[0][denomination]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rccm" class="control-label">N° RCCM
                                            :</label>
                                        <input type="text" class="form-control" id="rccm-0" data-error=" veillez saisir le N° RCCM" name="formset[0][numRccm]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="siege" class="control-label">Siège Social
                                            :</label>
                                        <input type="text" class="form-control" id="siege-0" data-error=" veillez saisir le siège social de l'entreprise" name="formset[0][siegeSocial]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="formeLegal" class="control-label">Forme
                                            légale
                                            :</label>
                                        <input type="text" class="form-control" id="formeLegal-0" data-error=" veillez saisir la forme légale" name="formset[0][formeLegal]" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="representantLegal" class="control-label">Répresentant
                                            légal
                                            :</label>
                                        <input type="text" class="form-control" id="representantLegal-0" data-error=" veillez saisir le nom du répresentant légal" name="formset[0][representantLegal]">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Actes -->
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
        <h4 class="panel-title">
            <a class="collapsed" role="button" onclick="LoadSelect2Script(oSelectForm);" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Acte introductif d'instance
            </a>
        </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
        <div class="panel-body">
            <!-- <div class="col-md-12 mrg-0" id="matiere">

                <div class="form-group">
                    <h5 for="" class="" style="text-align: center;">Nature de l'action :</h5>
                    <select name="idNatureAction" id="" class="form-select select2" style="width:100%" data-placeholder="Choisissez..." required>
                        <option value="" selected disabled>-- Choisissez --</option>
                        @foreach($natureActions as $n)
                        <option value={{$n->idNatureAction}}>{{$n->natureAction}} | délais: {{$n->delaiAction}} | depart: {{$n->depart}} | {{$n->baseLegale}} </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <hr> -->
            <div class="row mb-5" style="border: 1px solid; padding:10px;border-radius: 5px;">

                <div class="col-md-3" id="assignationCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="assignation" name="typeActe" onclick="formAssignation()" type="radio" class="custom-control-input" value="Assignation" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Assignation
                            </span>
                        </label>
                    </div>
                </div>
                <br>

                <!-- <div class="col-md-3" id="requeteCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requete" name="typeActe" onclick="formRequete()" type="radio" class="custom-control-input" value="Requete" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Requete</span>
                        </label>
                    </div>
                </div> -->

                <div class="col-md-3" id="citationCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="citation" name="typeActe" onclick="formCitation()" type="radio" class="custom-control-input" value="Citation" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Citation</span>
                        </label>
                    </div>
                </div>
                
                <div class="col-md-3" id="requisitoireCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requisitoire" name="typeActe" onclick="formOpposition()" type="radio" class="custom-control-input" value="Opposition" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Opposition / Tierce Opposition</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3" id="autreCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="autre" name="typeActe" onclick="formAutre()" type="radio" class="custom-control-input" value="Autre acte" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Autre</span>
                        </label>
                    </div>
                </div>

            </div>

            <div class="row mrg-0" id="formAssignation" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Assignation</h2>
                    <hr>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputPr" class="control-label">N° RG :</label>
                        <input type="text" class="form-control" id="numRg" data-error=" veillez saisir le N° RG" name="numRg" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="client" class="control-label">Huissier
                            :</label>

                        <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="idHuissier" id="huissierAssign" >
                            <option value="" selected disabled>-- Choisissez --</option>
                            @foreach ($huissiers as $h)
                            <option value={{ $h->idHss }}>
                                {{ $h->prenomHss }}
                                {{ $h->nomHss }}
                            </option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inpuRC" class="control-label">Réçue par :</label>
                        <input type="text" class="form-control" id="recepteurAss" data-error=" veillez saisir le nom du receveur" name="recepteurAss" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputASN" class="control-label">Date assignation :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="dateAssignation" data-error=" veillez saisir la date asignation" name="dateAssignation" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
               
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputENAS" class="control-label">Date enrôlement :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="dateEnrollement" data-error=" veillez saisir la date d'enroulement" name="dateEnrollement" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputFDAT" class="control-label">Date de la 1ère comparution
                            :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="datePremiereComp" data-error=" veillez saisir la Date de la première comparution" name="datePremiereComp" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="mentionP" class="control-label">Mention particulière
                            :</label>
                        <textarea id="mentionParticuliereAssign" cols="4" rows="2" class="form-control" data-error=" veillez saisir la mention particulière" name="mentionParticuliere" ></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputRPAV" class="control-label">Copie de l'assignation :</label>
                        <input type="file" class="fichiers form-control" id="pieceAS" data-error=" veillez joindre la pièce de l'assignation" name="pieceAS" accept=".pdf" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
               
                
            </div>
            <div class="row mrg-0" id="formRequete" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Requete</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° d'Enregistrement :</label>
                            <input type="text" class="form-control" id="numRgRequete" data-error=" veillez saisir le mumero RG" name="numRgRequete" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de la requete :</label>
                            <input type="date" class="form-control" id="dateRequete" data-error=" veillez saisir la date" name="dateRequete" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date d'arrivée (Greffe) :</label>
                            <input type="date" class="form-control" id="dateArriver" data-error=" veillez saisir la date" name="dateArriver" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Juridiction presidentielle :</label>
                            <input type="text" class="form-control" id="juriductionPresidentielle" data-error=" veillez remplir ce champ" name="juriductionPresidentielle" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputRPAV" class="control-label">Copie de la requete :</label>
                        <input type="file" class="fichiers form-control" id="pieceREQ" data-error=" veillez joindre la pièce de l'assignation" name="pieceREQ" accept=".pdf" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

               

                </div>
            </div>

            <div class=" mrg-0" id="formCitation" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Signification de la citation à comparaitre</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client" class="control-label">Huissier
                                :</label>

                            <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="idHuissierCit" id="idHuissierCit" >
                                <option value="" selected disabled>-- Choisissez --</option>
                                @foreach ($huissiers as $h)
                                <option value={{ $h->idHss }}>
                                    {{ $h->prenomHss }}
                                    {{ $h->nomHss }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de la signification :</label>
                            <input type="date" class="form-control" id="dateSignification" data-error=" veillez saisir la date" name="dateSignification" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Signification faite à :</label>
                            <input type="text" class="form-control" id="personneCharger" data-error=" veillez remplir ce champ" name="personneCharger" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                   

                </div>
    
                <div class="col-md-12" style="text-align:center ;">
                    <hr>
                    <h2>Citation</h2>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° RG :</label>
                            <input type="text" class="form-control" id="numRgCitation" data-error=" veillez saisir le mumero RG" name="numRgCitation" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de la citation :</label>
                            <input type="date" class="form-control" id="dateCitation" data-error=" veillez saisir la date" name="dateCitation" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date audience :</label>
                            <input type="date" class="form-control" id="dateAudienceCitation" data-error=" veillez saisir la date" name="dateAudienceCitation" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Lieu d'audience:</label>
                            <input type="text" class="form-control" id="lieuAudience" data-error=" veillez remplir ce champ" name="lieuAudience" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    
                </div>
                <hr>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputRPAV" class="control-label">Copie de la citation :</label>
                        <input type="file" class="fichiers form-control" id="pieceCitation" data-error=" veillez joindre la pièce de l'assignation" name="pieceCitation" accept=".pdf" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0" id="formOpposition" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Opposition / Tierce Opposition</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° RG :</label>
                            <input type="text" class="form-control" id="numRgOpp" data-error=" veillez saisir le N° RG" name="numRgOpp" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="client" class="control-label">Huissier
                                :</label>

                            <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="idHuissierOpp" id="idHuissierOpp" >
                                <option value="" selected disabled>-- Choisissez --</option>
                                @foreach ($huissiers as $h)
                                <option value={{ $h->idHss }}>
                                    {{ $h->prenomHss }}
                                    {{ $h->nomHss }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inpuRC" class="control-label">Réçue par :</label>
                            <input type="text" class="form-control" id="recepteurAssOpp" data-error=" veillez saisir le nom du receveur" name="recepteurAssOpp" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de l'acte :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="dateActe" data-error=" veillez saisir la date" name="dateActe" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputENAS" class="control-label">Date enrôlement :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="dateEnrollementOpp" data-error=" veillez saisir la date d'enroulement" name="dateEnrollementOpp" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputFDAT" class="control-label">Date de la 1ère comparution
                                :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="datePremiereCompOpp" data-error=" veillez saisir la Date de la première comparution" name="datePremiereCompOpp" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date de la prochaine audience :</label>
                            <input type="date" class="form-control" id="dateProchaineAud" data-error=" veillez saisir la date" name="dateProchaineAud" readonly>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">N° Décision concernée :</label>
                            <input type="text" class="form-control" id="numDecision" data-error=" veillez saisir le N°" name="numDecisConcerner" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="mentionP" class="control-label">Mention particulière
                                :</label>
                            <textarea id="mentionParticuliereOpp" cols="4" rows="2" class="form-control" data-error=" veillez saisir la mention particulière" name="mentionParticuliereOpp" ></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRPAV" class="control-label">Copie de l'oposition :</label>
                            <input type="file" class="fichiers form-control" id="pieceOPP" data-error=" veillez joindre la pièce de l'assignation" name="pieceASOpp" accept=".pdf" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mrg-0" id="formAutre" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Autre acte</h2>
                    <label for="">Renseignez les champs en fonction de l'acte</label>

                    <div class="col-md-12" id="">
                        <div class="row mrg-0">
                            <table class="table" id="dynamicAddRemoveActe">
                                <tr>

                                    <th>Mention</th>
                                    <th>Valeur</th>
                                    <th></th>
                                </tr>
                                
                                <tr>
                                    <td><input type="text" name="formsetAutreActe[0][mention]" 
                                            placeholder="" class="form-control" id="mention" />

                                    <td><input type="text" name="formsetAutreActe[0][valeur]" 
                                            placeholder="" class="form-control" id="valeur" />
                            
                                    <td><button type="button" name="add" id="dynamic-piece" onclick="formsetAutreActe()"
                                            class="cl-white theme-bg btn btn-outline-default btn-sm"><i
                                                class="fa fa-plus"></i></button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
               
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