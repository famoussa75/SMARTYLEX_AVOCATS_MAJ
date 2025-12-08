<!-- Parties -->
<input type="hidden" value="FormCivile" name="formulaire" />
<div class="panel panel-default" id="partieInstance">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapse" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                aria-expanded="false" aria-controls="collapseTwo">
                Parties
            </a>
        </h4>
    </div>


    <div id="collapseTwo" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <div id="dynamicAddRemove">
                @if(!empty($partiesCabinet))
                <div class="form mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>PARTIE 1</h3>
                        </div>

                        <div class="col-md-6">
                            <button type="button" name="add" id="dynamic-update" onclick="addformPIC()"
                                class="cl-white theme-bg btn btn-rounded" style="float:right"><i
                                    class="fa fa-plus"></i></button>
                        </div>

                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-0" name="formset[0][role]" value="Demandeur" type="radio"
                                            class="custom-control-input" required
                                            @if($partiesCabinet[0]->role=='Demandeur') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Demandeur</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-0" name="formset[0][role]" value="Defendeur" type="radio"
                                            class="custom-control-input" @if($partiesCabinet[0]->role=='Defendeur')
                                        checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Defendeur</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-0" name="formset[0][role]" type="radio"
                                            class="custom-control-input" value="Autre"
                                            @if($partiesCabinet[0]->role=='Autre') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Autre</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-3 toReload" id="other-0" @if($partiesCabinet[0]->role=='Autre') @else
                                hidden @endif>
                                <div class="form-group">
                                    <label for="" class="control-label">Autre type* :</label>
                                    <select name="formset[0][autreRole]" id="otherSelect-0"
                                        onchange="var id=0;otherSelect(id)" class="form-control select2"
                                        style="width:100%" data-placeholder="Choisissez...">
                                        <option value="" selected>-- Choisissez --</option>
                                        <option value='in'>Intervenant</option>
                                        <option value='pc'>Partie civile</option>
                                        <option value='mp'>Ministère public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 cacher" id="avc-0" >
                                <div class="form-group" id="dropSelect-0">
                                    <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                    <select name="formset[0][typeAvocat]" id="typeAvocat-0"
                                        onchange="var id= 0 ;typeAvocat(id)" class="form-select select2"
                                        style="width:100%" data-placeholder="Choisissez..." required>
                                        <option value='1'>
                                            @if(Session::has('cabinetSession'))
                                            @foreach (Session::get('cabinetSession') as $cabinet)
                                            {{$cabinet->nomCourt}}
                                            @endforeach
                                            @else
                                            Nous
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 cacher" id="clientContent-0" @if($partiesCabinet[0]->typeAvocat==1)
                                @else hidden @endif>
                                <div class="form-group">
                                    <label for="client" class="control-label">Selectionner le
                                        client*
                                        :</label>
                                    <select name="formset[0][idClient]" id="client-0"
                                        onchange="var id=0; var idclient=$(this).val();clientAud(idclient,id)"
                                        class="form-control select2" style="width:100%"
                                        data-placeholder="Selectionner le client">
                                        <option value={{$partiesCabinet[0]->idClient}} selected>
                                            {{ $partiesCabinet[0]->prenom }}
                                            {{ $partiesCabinet[0]->nom }}
                                            {{ $partiesCabinet[0]->denomination }}
                                        </option>
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
                            <div class="col-md-5 cacher" id="affaireContent-0" @if($partiesCabinet[0]->typeAvocat==1)
                                @else hidden @endif>
                                <input type="text" id="typeContent-0" value="audience" name="formset[0][typeContent]"
                                    hidden>

                                <div class="form-group">
                                    <label for="affaire" class="control-label">Affaire du client
                                        concerné*
                                        :</label>
                                    <select data-placeholder="Affaire du client concerné"
                                        style="width: 100%;height:28px" name="formset[0][idAffaire]"
                                        id="affaireClient-0" class="form-select select2">
                                        <option value="{{$partiesCabinet[0]->idAffaire}}">
                                            {{$partiesCabinet[0]->nomAffaire}}</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>

                            <div class="col-md-6 cacher" id="otherAvocats-0" @if($partiesCabinet[0]->role!='Autre')
                                @else hidden @endif>
                                <div class="form-group">
                                    <label for="personne" class="control-label">Ajouter/Retirer des
                                        conseils (facultatif)</label>
                                    <select multiple name="formset[0][idAvocat][]" class="form-control select2"
                                        data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                        style="width: 100%;" id="personne-0">
                                        @foreach ($avocatsParties as $a)
                                        @if($a->idPartie==$partiesCabinet[0]->idPartie)
                                        <option value="{{ $a->idAvc }}" selected>{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @foreach ($avocats as $a)
                                        <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4" id="mp-0" hidden
                            style="text-align:center; padding: 30px;background-color:yellowgreen">
                            <h1>Ministère Public</h1>
                        </div>

                    </div>
                </div>
                @endif

                @foreach($partiesAdverse as $p)
                <div class="form mt-4">
                    <div class="mt-4 row">
                        <div class="col-md-6">
                            <h3>PARTIE <span class="iterationPartie">{{ $loop->iteration+1 }}</span></h3>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-danger btn-rounded remove-input-field"
                                onclick="$(this).parents('.form').remove(); i={{ $loop->iteration }}; "
                                style="float:right"><i class="fa fa-trash"></i></button>

                        </div>
                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-1" name="formset[{{ $loop->iteration }}][role]"
                                            value="Demandeur" type="radio" class="custom-control-input" required
                                            @if($p->role=='Demandeur') checked @else disabled @endif >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Demandeur</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-1" name="formset[{{ $loop->iteration }}][role]"
                                            value="Defendeur" type="radio" class="custom-control-input"
                                            @if($p->role=='Defendeur') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Defendeur</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-1" name="formset[{{ $loop->iteration }}][role]" type="radio"
                                            class="custom-control-input" value="Autre" @if($p->role=='Autre') checked
                                        @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Autre</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-top: 20px;">

                            <div class="col-md-3 cacher" id="avc-0" @if($p->role=='Autre') @else hidden @endif>
                                <div class="form-group" id="dropSelect-0">
                                    <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                    <select name="formset[formset[{{ $loop->iteration }}]][typeAvocat]"
                                        id="typeAvocat-0" onchange="var id= 0 ;typeAvocat(id)"
                                        class="form-select select2" style="width:100%" data-placeholder="Choisissez..."
                                        required>
                                        <option value='2'>
                                            Autre
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 cacher" id="otherAvocatsAdverse-0" @if($p->role!='Autre')
                                @else hidden @endif>
                                <div class="form-group">
                                    <label for="personne" class="control-label">Ajouter/Retirer des
                                        conseils (facultatif)</label>
                                    <select multiple name="formset[{{ $loop->iteration }}][idAvocat][]" class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER" style="width: 100%;" id="personne-0">
                                        @foreach ($avocatsParties as $a)
                                            @if($a->idPartie==$p->idPartie)
                                            <option value="{{ $a->idAvc }}" selected>{{ $a->prenomAvc }}
                                                {{ $a->nomAvc }}
                                            </option>
                                            @endif
                                        @endforeach
                                        @foreach ($avocats as $a)
                                        <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6 cacher" id="otherAvocats-0" @if($p->role=='Autre') @else hidden @endif>
                                <div class="form-group">
                                    <label for="" class="control-label">Autre type* :</label>
                                    <select name="formset[{{ $loop->iteration }}][autreRole]" id="otherSelect-0"
                                        onchange="var id=0;otherSelect(id)" class="form-control select2"
                                        style="width:100%" data-placeholder="Choisissez...">
                                        <option value="{{$p->autreRole}}" selected>@if ($p->autreRole=='in')Intervenant
                                            @elseif($p->autreRole=='pc')Partie civile
                                            @elseif($p->autreRole=='mp')Ministère public @endif</option>

                                    </select>
                                </div>
                                <div class="form-group" @if($p->autreRole=='mp') hidden @else @endif>
                                    <label for="personne" class="control-label">Ajouter/Retirer des
                                        conseils (facultatif)</label>
                                    <select multiple name="formset[formset[{{ $loop->iteration }}]][idAvocat][]"
                                        class="form-control select2"
                                        data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER"
                                        style="width: 100%;" id="personne-0">
                                        @foreach ($avocatsParties as $a)
                                        @if($a->idPartie==$p->idPartie)
                                        <option value="{{ $a->idAvc }}" selected>{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }} {{ $p->idPartie }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @foreach ($avocats as $a)
                                        <option value="{{ $a->idAvc }}">{{ $a->prenomAvc }}
                                            {{ $a->nomAvc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4" id="mp-{{ $loop->iteration }}" @if($p->autreRole=='mp') @else hidden
                            @endif style="text-align:center; padding: 30px;background-color:yellowgreen">
                            <h1>Ministère Public</h1>
                        </div>

                        <div class="row cacher" style="margin-top: 20px;" id="personneExterne-0" @if($p->
                            autreRole=='mp') hidden @else @endif>
                            <div class="col-md-12">
                                <label for="">Renseignez les informations personnelles.</label>

                            </div>

                            <div class="row col-md-12 mb-4">
                                <div class="col-md-6">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio">
                                            <input id="typeAdverse1-1"
                                                name="formset[{{ $loop->iteration }}][typeAdverse]"
                                               onclick="personneOption({{ $loop->iteration }})" type="radio"
                                                class="custom-control-input typeAdverse1-0" value="Personne physique"
                                                @if(is_null($p->denomination)&&($p->role!='Autre')) checked @else
                                             @endif >
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
                                            <input id="typeAdverse2-1"
                                                name="formset[{{ $loop->iteration }}][typeAdverse]" type="radio"
                                                onclick="entrepriseOption({{ $loop->iteration }})"
                                                class="custom-control-input typeAdverse2-0" value="Entreprise"
                                                @if(!(is_null($p->denomination))&&($p->role!='Autre')) checked @else
                                             @endif>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Entreprise</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mrg-0 adversePersonne" id="adversePersonne-1" @if(is_null($p->denomination))
                                @else hidden @endif>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="prenom" class="control-label">Prénom
                                            :</label>
                                        <input type="text" class="form-control" id="prenom-1"
                                            data-error=" veillez saisir prénom de la personne"
                                            name="formset[{{ $loop->iteration }}][prenom]" value="{{$p->prenom}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="nom" class="control-label">Nom :</label>
                                        <input type="text" class="form-control" id="nom-1"
                                            data-error=" veillez saisir le nom de la personne"
                                            name="formset[{{ $loop->iteration }}][nom]" value="{{$p->nom}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession" class="control-label">Telephone
                                            :</label>
                                        <input type="text" class="form-control" id="telephone-1"
                                            data-error=" veillez saisir un numero"
                                            name="formset[{{ $loop->iteration }}][telephone]" value="{{$p->telephone}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession" class="control-label">Profession
                                            :</label>
                                        <input type="text" class="form-control" id="profession-1"
                                            data-error=" veillez saisir la profession"
                                            name="formset[{{ $loop->iteration }}][profession]"
                                            value="{{$p->profession}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nationalite" class="control-label">Nationalité
                                            :</label>
                                        <input type="text" class="form-control" id="nationalite-1"
                                            data-error=" veillez saisir la nationalité"
                                            name="formset[{{ $loop->iteration }}][nationalite]"
                                            value="{{$p->nationalite}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dateNaissance" class="control-label">Date de
                                            naissance
                                            :</label>
                                        <input type="date" class="form-control" id="dateNaissance-1"
                                            data-error=" veillez saisir la date de naissance de la personne"
                                            name="formset[{{ $loop->iteration }}][dateNaissance]"
                                            value="{{$p->dateNaissance}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lNaissance" class="control-label">Lieu de
                                            naissance
                                            :</label>
                                        <input type="text" class="form-control" id="lNaissance-1"
                                            data-error=" veillez indiquer le Lieu de naissance"
                                            name="formset[{{ $loop->iteration }}][lieuNaissance]"
                                            value="{{$p->lieuNaissance}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pays" class="control-label">Pays :</label>
                                        <input type="text" class="form-control" id="pays-1"
                                            data-error=" veillez renseigner le pays de la personne"
                                            name="formset[{{ $loop->iteration }}][pays]" value="{{$p->pays}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="domicile" class="control-label">domicile
                                            :</label>
                                        <input type="text" class="form-control" id="domicil-1"
                                            data-error=" veillez renseigner le domicile de la personne"
                                            name="formset[{{ $loop->iteration }}][domicile]" value="{{$p->domicile}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0 adverseEntreprise" id="adverseEntreprise-1" @if(!(is_null($p->
                                denomination))) @else hidden @endif>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="denomination" class="control-label">Dénomination
                                            :</label>
                                        <input type="text" class="form-control" id="denomination-1"
                                            data-error=" veillez saisir la dénomination de l'entreprise"
                                            name="formset[{{ $loop->iteration }}][denomination]"
                                            value="{{$p->denomination}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rccm" class="control-label">N° RCCM
                                            :</label>
                                        <input type="text" class="form-control" id="rccm-1"
                                            data-error=" veillez saisir le N° RCCM"
                                            name="formset[{{ $loop->iteration }}][numRccm]" value="{{$p->numRccm}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="siege" class="control-label">Siège Social
                                            :</label>
                                        <input type="text" class="form-control" id="siege-1"
                                            data-error=" veillez saisir le siège social de l'entreprise"
                                            name="formset[{{ $loop->iteration }}][siegeSocial]"
                                            value="{{$p->siegeSocial}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="formeLegal" class="control-label">Forme
                                            légale
                                            :</label>
                                        <input type="text" class="form-control" id="formeLegal-1"
                                            data-error=" veillez saisir la forme légale"
                                            name="formset[{{ $loop->iteration }}][formeLegal]"
                                            value="{{$p->formeLegal}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="representantLegal" class="control-label">Répresentant
                                            légal
                                            :</label>
                                        <input type="text" class="form-control" id="representantLegal-1"
                                            data-error=" veillez saisir le nom du répresentant légal"
                                            name="formset[{{ $loop->iteration }}][representantLegal]"
                                            value="{{$p->representantLegal}}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>


<!-- Actes -->
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
        <h4 class="panel-title">
            <a class="collapse" role="button" onclick="LoadSelect2Script(oSelectForm);" data-toggle="collapse"
                data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Acte introductif d'instance
            </a>
        </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingFour">
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
                            <input id="assignation" name="typeActe"
                                onclick="formAssignation()"
                                type="radio" class="custom-control-input" value="Assignation"
                                @if($actes[0]->typeActe=='Assignation') checked @endif>

                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Assignation</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-3" id="requeteCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="Citation" name="typeActe"
                                onclick="formCitation()"
                                type="radio" class="custom-control-input" value="Citation"
                                @if($actes[0]->typeActe=='Citation') checked @endif >

                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Citation</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-6" id="requisitoireCheckbox">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requisitoire" name="typeActe"
                                onclick="formOpposition()"
                                type="radio" class="custom-control-input" value="Opposition"
                                @if($actes[0]->typeActe=='Opposition') checked @endif >

                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Opposition / Tierce Opposition</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mrg-0" id="formAssignation" @if($actes[0]->typeActe!='Assignation') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Assignation</h2>
                    <hr>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputPr" class="control-label">N° RG :</label>
                        <input type="text" class="form-control" id="numRg" data-error=" veillez saisir le N° RG"
                            name="numRgAss" value="{{$acteDetail[0]->numRg ?? ''}}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="client" class="control-label">Huissier
                            :</label>

                        <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;"
                            name="idHuissierAss" id="huissierAssign">
                            <option value={{$acteDetail[0]->idHuissier ?? ''}} selected>{{$acteDetail[0]->prenomHss ?? ''}}
                                {{$acteDetail[0]->nomHss ?? ''}}</option>
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
                        <input type="text" class="form-control" id="recepteurAss"
                            data-error=" veillez saisir le nom du receveur" name="recepteurAss"
                            value="{{$acteDetail[0]->recepteurAss ?? '' }}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputASN" class="control-label">Date assignation :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="dateAssignation"
                            data-error=" veillez saisir la date asignation" name="dateAssignation"
                            value="{{$acteDetail[0]->dateAssignation ?? ''}}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputENAS" class="control-label">Date enrôlement :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="dateEnrollement"
                            data-error=" veillez saisir la date d'enroulement" name="dateEnrollement"
                            value="{{$acteDetail[0]->dateEnrollement ?? ''}}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputFDAT" class="control-label">Date de la 1ère comparution
                            :</label>
                        <input type="date" onchange="validateDatesAss()" class="form-control" id="datePremiereComp"
                            data-error=" veillez saisir la Date de la première comparution" name="datePremiereComp"
                            value="{{$acteDetail[0]->datePremiereComp ?? ''}}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="mentionP" class="control-label">Mention particulière
                            :</label>
                        <textarea id="mentionParticuliereAssign" cols="4" rows="2" class="form-control"
                            data-error=" veillez saisir la mention particulière"
                            name="mentionParticuliereAssign">{{$acteDetail[0]->mentionParticuliere ?? ''}}</textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputRPAV" class="control-label">Remplacer la pièce (Facultatif) :</label>
                        <input type="file" class="fichiers form-control" id="pieceAS" data-error=" veillez joindre la pièce de l'assignation" name="pieceAS" accept="image/*,.pdf, .doc, docx" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div> -->
            </div>
           
           
            <div class="row mrg-0" id="formCitation" @if($actes[0]->typeActe!='Citation') @else hidden @endif>
               
                    <div class="col-md-12" style="text-align:center ;">
                        <h2>Signification de la citation à comparaitre</h2>
                        <hr>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client" class="control-label">Huissier
                                    :</label>

                                <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;"
                                    name="idHuissier" id="huissierCita">
                                    <option value="{{ $acteDetail[0]->idHuissier ?? '' }}">
                                            {{ $acteDetail[0]->prenomHss ?? '' }} {{ $acteDetail[0]->nomHss ?? '' }}
                                    </option>
                                    @foreach ($huissiers as $h)
                                    <option value="{{ $h->idHss }}">
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
                                <input type="date" class="form-control" id="dateSignification" data-error=" veillez saisir la date" name="dateSignification"  value="{{ $acteDetail[0]->dateSignification ?? '' }}" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label">Signification faite à :</label>
                                <input type="text" class="form-control" id="personneCharger" data-error=" veillez remplir ce champ" name="personneCharger"  value="{{ $acteDetail[0]->personneCharger ?? '' }}" >
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
                                <input type="text" class="form-control" id="numRg" data-error=" veillez saisir le mumero RG" name="numRg" value="{{ $acteDetail[0]->numRg ?? '' }}" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">Date de la citation :</label>
                                <input type="date" class="form-control" id="dateCitation" data-error=" veillez saisir la date" name="dateCitation" value="{{ $acteDetail[0]->dateCitation ?? '' }}" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">Date audience :</label>
                                <input type="date" class="form-control" id="dateAudienceCitation" data-error=" veillez saisir la date" name="dateAudience"  value="{{ $acteDetail[0]->dateAudience ?? '' }}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label">Lieu d'audience:</label>
                                <input type="text" class="form-control" id="lieuAudience" data-error=" veillez remplir ce champ" name="lieuAudience" value="{{ $acteDetail[0]->lieuAudience ?? '' }}" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRPAV" class="control-label">Copie de la citation :</label>
                            <input type="file" class="fichiers form-control" id="pieceCitation" data-error=" veillez joindre la pièce de l'assignation" name="pieceCitation" accept=".pdf"  value="{{ $acteDetail[0]->pieceCitation ?? '' }}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
               
            </div>
            
            
            <div class="row mrg-0" id="formOpposition" @if($actes[0]->typeActe!='Opposition') @else hidden @endif>
                <div class="row col-md-12">
                   <div class="row mrg-0" id="formOpposition" >
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Opposition / Tierce Opposition</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° RG :</label>
                            <input type="text" class="form-control" id="numRg" data-error=" veillez saisir le N° RG" name="numRg"  value="{{$acteDetail[0]->numRg ?? ''}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="client" class="control-label">Huissier
                                :</label>

                            <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="idHuissierOpp" id="idHuissierOpp" value="{{$acteDetail[0]->idHuissierOpp ?? ''}}">
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
                            <input type="text" class="form-control" id="recepteurOpp" data-error=" veillez saisir le nom du receveur" name="recepteurOpp" value="{{$acteDetail[0]->recepteurAss ?? ''}}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de l'acte :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="dateActe" data-error=" veillez saisir la date" name="dateActe"   value="{{$acteDetail[0]->dateActe ?? ''}}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputENAS" class="control-label">Date enrôlement :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="dateEnrollementOpp" data-error=" veillez saisir la date d'enroulement" name="dateEnrollementOpp" value="{{$acteDetail[0]->dateEnrollement ?? ''}}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputFDAT" class="control-label">Date de la 1ère comparution
                                :</label>
                            <input type="date" class="form-control" onchange="validateDatesOpp()" id="datePremiereCompOpp" data-error=" veillez saisir la Date de la première comparution" name="datePremiereCompOpp" value="{{$acteDetail[0]->datePremiereComp ?? ''}}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date de la prochaine audience :</label>
                            <input type="date" class="form-control" id="dateProchaineAud" data-error=" veillez saisir la date" name="dateProchaineAud" value="{{$acteDetail[0]->dateProchaineAud ?? ''}}" readonly>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">N° Décision concernée :</label>
                            <input type="text" class="form-control" id="numDecision" data-error=" veillez saisir le N°" name="numDecision" value="{{$acteDetail[0]->numDecision ?? ''}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="mentionP" class="control-label">Mention particulière
                                :</label>
                            <textarea id="mentionParticuliere" cols="4" rows="2" class="form-control" data-error=" veillez saisir la mention particulière" name="mentionParticuliere"  value="{{$acteDetail[0]->mentionParticuliere ?? ''}}"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRPAV" class="control-label">Copie de l'oposition :</label>
                            <input type="file" class="fichiers form-control" id="pieceOPP" data-error=" veillez joindre la pièce de l'assignation" name="pieceASOpp" accept=".pdf" value="{{$acteDetail[0]->pieceASOpp ?? ''}}" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>

                    <!-- <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRPAV" class="control-label">Remplacer la pièce (Facultatif) :</label>
                            <input type="file" class="fichiers form-control" id="inputASF" data-error=" veillez joindre la pièce de l'assignation" name="pieceASOpp" accept="image/*,.pdf, .doc, docx" >
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> -->

                </div>
            </div>
           

        </div>
    </div>
</div>

<div class="form-group">
    <div class="text-center">
        <button type="submit" id="submitButton" class="theme-bg btn btn-rounded btn-block"><i class="fa fa-save"></i> Enregistrer les modifications</button>
    </div>
</div>



<script>
// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function(e) {

            var fichiersInput = this.querySelectorAll(
            ".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name +
                            " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});
</script>

<script>
    function personneOption(id) {
        document.getElementById("adversePersonne-" + id).hidden = false;
        document.getElementById("adverseEntreprise-" + id).hidden = true;
    }

    function entrepriseOption(id) {
        document.getElementById("adversePersonne-" + id).hidden = true;
        document.getElementById("adverseEntreprise-" + id).hidden = false;
    }
</script>

<script>
// Fonctions pour afficher les formulaires
function formAssignation() {
    // Activer tous les boutons radio
    enableAllRadioButtons();
    
    // Afficher le formulaire Assignation
    document.getElementById("formAssignation").hidden = false;
    
    // Masquer les autres formulaires
    document.getElementById("formCitation").hidden = true;
    document.getElementById("formOpposition").hidden = true;
    
    // Réinitialiser les autres formulaires
    resetOtherForms('formAssignation');
}

function formCitation() {
    // Activer tous les boutons radio
    enableAllRadioButtons();
    
    // Afficher le formulaire Requête
    document.getElementById("formCitation").hidden = false;
    
    // Masquer les autres formulaires
    document.getElementById("formAssignation").hidden = true;
    document.getElementById("formOpposition").hidden = true;
    
    // Réinitialiser les autres formulaires
    resetOtherForms('formCitation');
}

function formOpposition() {
    // Activer tous les boutons radio
    enableAllRadioButtons();
    
    // Afficher le formulaire Opposition
    document.getElementById("formOpposition").hidden = false;
    
    // Masquer les autres formulaires
    document.getElementById("formAssignation").hidden = true;
    document.getElementById("formCitation").hidden = true;
    
    // Réinitialiser les autres formulaires
    resetOtherForms('formOpposition');
}

// Activer tous les boutons radio
function enableAllRadioButtons() {
    document.getElementById("assignation").disabled = false;
    document.getElementById("Citation").disabled = false;
    document.getElementById("requisitoire").disabled = false;
}

// Réinitialise complètement les formulaires non affichés (vide tous les champs)
function resetOtherForms(showFormId) {
    const forms = ['formAssignation', 'formCitation', 'formOpposition'];
    forms.forEach(formId => {
        if (formId !== showFormId) {
            const form = document.getElementById(formId);
            if (form) {
                form.querySelectorAll('input, textarea, select').forEach(el => {
                    if(el.type === 'checkbox' || el.type === 'radio') return;
                    
                    if(el.type === 'text' || el.type === 'date' || el.tagName.toLowerCase() === 'textarea') {
                        el.value = '';
                    }
                    else if(el.tagName.toLowerCase() === 'select') {
                        el.selectedIndex = 0;
                    }
                });
            }
        }
    });
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Activer tous les boutons radio au chargement
    enableAllRadioButtons();
    
    // S'assurer que seul le formulaire correspondant au type d'acte est affiché
    const typeActe = "{{$actes[0]->typeActe}}";
    
    if(typeActe === 'Assignation') {
        document.getElementById("formAssignation").hidden = false;
        document.getElementById("formCitation").hidden = true;
        document.getElementById("formOpposition").hidden = true;
    } else if(typeActe === 'Citation') {
        document.getElementById("formAssignation").hidden = true;
        document.getElementById("formCitation").hidden = false;
        document.getElementById("formOpposition").hidden = true;
    } else if(typeActe === 'Opposition') {
        document.getElementById("formAssignation").hidden = true;
        document.getElementById("formCitation").hidden = true;
        document.getElementById("formOpposition").hidden = false;
    }
});
</script>