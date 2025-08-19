<!-- Parties -->
<input type="hidden" value="FormPenale" name="formulaire"/>
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
                            <button type="button" name="add" id="dynamic-ar" onclick="addformPIP()" class="cl-white theme-bg btn btn-rounded" style="float:right"><i class="fa fa-plus"></i></button>
                        </div>

                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-0" name="formset[0][role]" onclick="var id=0; roleASKa(id)" value="Prevenu / Accusé" type="radio" class="custom-control-input" required>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Prévenu(e)/Accusé(e)</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-0" name="formset[0][role]" onclick="var id=0; roleASKb(id)" value="Partie civile" type="radio" class="custom-control-input" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Partie civile</span>
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
                                      <!--  <option value='pc'>Partie civile</option> -->
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
    <div class="panel-heading" role="tab" id="headingFour" >
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

                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="assignation" name="typeActe" onclick="formPvInterogatoire()" type="radio" class="custom-control-input" value="PV introgatoire" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">PV introgatoire
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requete" name="typeActe" onclick="formRequisitoire()" type="radio" class="custom-control-input" value="Requisitoire" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Requisitoire</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requisitoire" name="typeActe" onclick="formOrdonnanceRenvoi()" type="radio" class="custom-control-input" value="Ordonnance Renvoi" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Ordonnance Renvoi</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="ordonnance" name="typeActe" onclick="formCitationDirect()" type="radio" class="custom-control-input" value="Citation directe" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Citation directe</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="ordonnance" name="typeActe" onclick="formPcpc()" type="radio" class="custom-control-input" value="PCPC" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">PCPC</span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="row mrg-0" id="formPvInterogatoire" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Pv interrogatoire</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date d'audition :</label>
                            <input type="date" class="form-control" id="dateAudition"  data-error=" veillez remplir ce champ" name="dateAudition" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Identité de l'OPJ :</label>
                            <input type="text" class="form-control" id=""  data-error="veillez remplir ce champ" name="identiteOPJ" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Infractions :</label>
                            <input type="text" class="form-control" id="infractions"  data-error="veillez remplir ce champ" name="infractions" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date d'audience :</label>
                            <input type="date" class="form-control" id="dateAudience"  data-error=" veillez remplir ce champ" name="dateAudience" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0" id="formRequisitoire" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Requisitoire</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° d'instruction / No RP :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir le N°" name="numInstruction" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Procureur :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir la date" name="procureur" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusationReq" class="form-control" id="chefAccusationReq" cols="30" rows="10" ></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mrg-0" id="formOrdonnanceRenvoi" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Ordonnance Renvoi</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° de l'ordonnance :</label>
                            <input type="text" class="form-control" id="numOrd"  data-error=" veillez saisir le N°" name="numOrd" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Cabinet d'instruction :</label>
                            <input type="text" class="form-control" id="cabinetIns"  data-error=" veillez saisir la date" name="cabinetIns" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Procédure :</label>
                            <select name="typeProcedure" id="typeProcedure" class="form-select select2" style="width:100%" >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                <option value="Correctionnelle">Correctionnelle</option>
                                <option value="Criminelle ">Criminelle </option>

                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusationOrd" class="form-control" id="" cols="30" rows="10"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mrg-0" id="formCitationDirect" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Citation directe</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Saisi par:</label>
                            <select name="saisi" id="idSaisiPar" class="form-select select2" style="width:100%" onchange="saisiPar()"  >
                                 <option value="" selected disabled>-- Choisissez --</option>
                                <option value="Procureur">Procureur</option>
                                <option value="Victime">Victime</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                   
                    <div class="col-md-6" id="huissier">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Huissier :</label>
                            <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="idHuissier" >
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
                            <label for="" class="control-label">Reçue par :</label>
                            <input type="text" class="form-control" id="recepteurCitation"  data-error=" veillez saisir la date" name="recepteurCitation" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6" id="dateSignification">
                        <div class="form-group">
                            <label for="" class="control-label">Date de signification :</label>
                            <input type="date" class="form-control" id=""  data-error=" veillez remplir ce champ" name="dateSignification" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date & Heure de l'audience :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir la date" name="dateHeureAud" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Mention particulière :</label>
                            <input type="text" class="form-control" id="mentionParticuliere"  data-error=" veillez saisir la date" name="mentionParticuliere" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusation" class="form-control" id="chefAccusation" cols="30" rows="10" ></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mrg-0" id="formPcpc" hidden>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Plainte avec Constitution de Partie Civile</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date :</label>
                            <input type="date" class="form-control" id="datePcpc"  data-error=" veillez remplir ce champ" name="datePcpc" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Référence :</label>
                            <input type="text" class="form-control" id="reference"  data-error="veillez remplir ce champ" name="reference" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de prochaine audience :</label>
                            <input type="date" class="form-control" id="dateProchaineAud"  data-error=" veillez remplir ce champ" name="dateProchaineAud" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

