<!-- Parties -->
<input type="hidden" value="FormPenale" name="formulaire"/>
<div class="panel panel-default" id="partieInstance">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapse" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                            <button type="button" name="add" id="dynamic-a" onclick="addformPIP()" class="cl-white theme-bg btn btn-rounded" style="float:right"><i class="fa fa-plus"></i></button>
                        </div>

                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-0" name="formset[0][role]" onclick="var id=0; roleASKa(id)" value="Prevenu / Accusé" type="radio" class="custom-control-input" required   @if($partiesCabinet[0]->role=='Prevenu / Accusé') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Prevenu / Accusé</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-0" name="formset[0][role]" onclick="var id=0; roleASKb(id)" value="Partie civile" type="radio" class="custom-control-input"  @if($partiesCabinet[0]->role=='Partie civile')
                                        checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Partie civile</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-0" name="formset[0][role]" type="radio" class="custom-control-input" value="Autre" onclick="var id=0; roleASKc(id)"  @if($partiesCabinet[0]->role=='Autre') checked @else disabled @endif>
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
                                    <select name="formset[0][autreRole]" id="otherSelect-0" onchange="var id=0;otherSelect(id)" class="form-control select2" style="width:100%" data-placeholder="Choisissez..." >
                                        <option value="" selected disabled>-- Choisissez --</option>
                                        <option value='in'>Intervenant</option>
                                        <option value='pc'>Partie civile</option>
                                        <option value='mp'>Ministère public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 cacher" id="avc-0">
                                <div class="form-group" id="dropSelect-0">
                                    <label for="" class="control-label">Avocat<span style="color:red">*</span> :</label>
                                    <select name="formset[0][typeAvocat]" id="typeAvocat-0" onchange="var id= 0 ;typeAvocat(id)" class="form-select select2" style="width:100%" data-placeholder="Choisissez..." >
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
                                    <select name="formset[0][idClient]" id="client-0" onchange="var id=0; var idclient=$(this).val();clientAud(idclient,id)" class="form-control select2" style="width:100%" data-placeholder="Selectionner le client" >
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
                            <div class="col-md-5 cacher" id="affaireContent-0"  @if($partiesCabinet[0]->typeAvocat==1)
                                @else hidden @endif>
                                <input type="text" id="typeContent-0" value="audience" name="formset[0][typeContent]" hidden>

                                <div class="form-group">
                                    <label for="affaire" class="control-label">Affaire du client
                                        concerné*
                                        :</label>
                                    <select data-placeholder="Affaire du client concerné" style="width: 100%;height:28px" name="formset[0][idAffaire]" id="affaireClient-0" >
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
                                    <select multiple name="formset[0][idAvocat][]" class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER" style="width: 100%;" id="personne-0">
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

                        <div class="col-md-12 mt-4" id="mp-0" hidden style="text-align:center; padding: 30px;background-color:yellowgreen">
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
                                            value="Prevenu / Accusé" type="radio" class="custom-control-input" required
                                            @if($p->role=='Prevenu / Accusé') checked @else disabled @endif >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Prevenu / Accusé</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-1" name="formset[{{ $loop->iteration }}][role]"
                                            value="Partie civile" type="radio" class="custom-control-input"
                                            @if($p->role=='Partie civile') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Partie civile</span>
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

                            <div class="col-md-6 cacher" id="otherAvocats-0" @if($p->role!='Autre')
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
                                                onclick="var id= 0 ; personneOption(id)" type="radio"
                                                class="custom-control-input typeAdverse1-0" value="Personne physique"
                                                @if(is_null($p->denomination)&&($p->role!='Autre')) checked @else
                                            disabled @endif >
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
                                                onclick="var id= 0 ; entrepriseOption(id)"
                                                class="custom-control-input typeAdverse2-0" value="Entreprise"
                                                @if(!(is_null($p->denomination))&&($p->role!='Autre')) checked @else
                                            disabled @endif>
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
    <div class="panel-heading" role="tab" id="headingFour" >
        <h4 class="panel-title">
            <a class="collapse" role="button" onclick="LoadSelect2Script(oSelectForm);" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
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

                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="assignation" name="typeActe" onclick="" type="radio" class="custom-control-input" value="PV introgatoire"  @if($actes[0]->typeActe=='PV introgatoire') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">PV introgatoire
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requete" name="typeActe" onclick="" type="radio" class="custom-control-input" value="Requisitoire"  @if($actes[0]->typeActe=='Requisitoire') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Requisitoire</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requisitoire" name="typeActe" onclick="" type="radio" class="custom-control-input" value="Ordonnance Renvoi" @if($actes[0]->typeActe=='Ordonnance Renvoi') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Ordonnance Renvoi</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="ordonnance" name="typeActe" onclick="" type="radio" class="custom-control-input" value="Citation directe" @if($actes[0]->typeActe=='Citation directe') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Citation directe</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="ordonnance" name="typeActe" onclick="" type="radio" class="custom-control-input" value="PCPC"  @if($actes[0]->typeActe=='PCPC') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">PCPC</span>
                        </label>
                    </div>
                </div>
            </div>

            @if($actes[0]->typeActe=='PV introgatoire')
            <div class="row mrg-0" id="formPvInterogatoire" @if($actes[0]->typeActe=='PV introgatoire') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Pv introgatoire</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date d'audition :</label>
                            <input type="date" class="form-control" id="dateAudition"  data-error=" veillez remplir ce champ" name="dateAudition" value="{{$acteDetail[0]->dateAudition}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Identité de l'OPJ :</label>
                            <input type="text" class="form-control" id=""  data-error="veillez remplir ce champ" name="identiteOPJ" value="{{$acteDetail[0]->identiteOPJ}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Infractions :</label>
                            <input type="text" class="form-control" id="infractions"  data-error="veillez remplir ce champ" name="infractions" value="{{$acteDetail[0]->infractions}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date d'audience :</label>
                            <input type="date" class="form-control" id="dateAudience"  data-error=" veillez remplir ce champ" name="dateAudience" value="{{$acteDetail[0]->dateAudience}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($actes[0]->typeActe=='Requisitoire')
            <div class="row mrg-0" id="formRequisitoire" @if($actes[0]->typeActe=='Requisitoire') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Requisitoire</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° d'instruction / No RP :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir le N°" name="numInstruction" value="{{$acteDetail[0]->numInstruction}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Procureur :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir la date" name="procureur" value="{{$acteDetail[0]->procureur}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusationReq" class="form-control" id="chefAccusationReq" cols="30" rows="10" >{{$acteDetail[0]->chefAccusation}}</textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            @if($actes[0]->typeActe=='Ordonnance Renvoi')
            <div class="row mrg-0" id="formOrdonnanceRenvoi" @if($actes[0]->typeActe=='Ordonnance Renvoi') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Ordonnance Renvoi</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">N° de l'ordonnance :</label>
                            <input type="text" class="form-control" id="numOrd"  data-error=" veillez saisir le N°" name="numOrd" value="{{$acteDetail[0]->numOrd}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Cabinet d'instruction :</label>
                            <input type="text" class="form-control" id="cabinetIns"  data-error=" veillez saisir la date" name="cabinetIns" value="{{$acteDetail[0]->cabinetIns}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Procédure :</label>
                            <select name="typeProcedure" id="typeProcedure" class="form-select select2" style="width:100%" >
                                 <option value="{{$acteDetail[0]->typeProcedure}}" selected>{{$acteDetail[0]->typeProcedure}}</option>
                                <option value="Correctionnelle">Correctionnelle</option>
                                <option value="Criminelle ">Criminelle </option>

                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusationOrd" class="form-control" id="" cols="30" rows="10">{{$acteDetail[0]->chefAccusation}}</textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            @if($actes[0]->typeActe=='Citation directe')
            <div class="row mrg-0" id="formCitationDirect" @if($actes[0]->typeActe=='Citation directe') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Citation directe</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Saisi par:</label>
                            <select name="saisi" id="idSaisiPar" class="form-select select2" style="width:100%" onchange="saisiPar()"  >
                                 <option value="{{$acteDetail[0]->saisi}}" selected >{{$acteDetail[0]->saisi}}</option>
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
                            <option value={{$acteDetail[0]->idHuissier}} selected >{{ $acteDetail[0]->prenomHss }} {{ $acteDetail[0]->nomHss }}</option>
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
                            <input type="text" class="form-control" id="recepteurCitation"  data-error=" veillez saisir la date" name="recepteurCitation" value="{{$acteDetail[0]->recepteurCitation}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6" id="dateSignification">
                        <div class="form-group">
                            <label for="" class="control-label">Date de signification :</label>
                            <input type="date" class="form-control" id=""  data-error=" veillez remplir ce champ" name="dateSignification" value="{{$acteDetail[0]->dateSignification}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date & Heure de l'audience :</label>
                            <input type="text" class="form-control" id=""  data-error=" veillez saisir la date" name="dateHeureAud" value="{{$acteDetail[0]->dateHeureAud}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Mention particulière :</label>
                            <input type="text" class="form-control" id="mentionParticuliere"  data-error=" veillez saisir la date" name="mentionParticuliere" value="{{$acteDetail[0]->mentionParticuliere}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Chef d'accusation :</label>
                            <textarea name="chefAccusation" class="form-control" id="chefAccusation" cols="30" rows="10" >{{$acteDetail[0]->chefAccusation}}</textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            @if($actes[0]->typeActe=='PCPC')
            <div class="row mrg-0" id="formPcpc" @if($actes[0]->typeActe=='PCPC') @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Plainte avec Constitution de Partie Civile</h2>
                    <hr>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date :</label>
                            <input type="date" class="form-control" id="datePcpc"  data-error=" veillez remplir ce champ" name="datePcpc" value="{{$acteDetail[0]->datePcpc}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Référence :</label>
                            <input type="text" class="form-control" id="reference"  data-error="veillez remplir ce champ" name="reference" value="{{$acteDetail[0]->reference}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPr" class="control-label">Date de prochaine audience :</label>
                            <input type="date" class="form-control" id="dateProchaineAud"  data-error=" veillez remplir ce champ" name="dateProchaineAud" value="{{$acteDetail[0]->dateProchaineAud}}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>


                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="text-center">
        <button type="submit" class="cl-white theme-bg btn btn-rounded btn-block btn-default" style="width:50%;">
            Enregistrer les modifications</button>
    </div>
</div>