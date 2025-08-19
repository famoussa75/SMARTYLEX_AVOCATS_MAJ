<!-- Parties -->
<input type="hidden" value="FormAppel" name="formulaire"/>
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
                @foreach($partiesCabinet as $c)
                <div class="form mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>PARTIE {{ $loop->iteration }}</h3>
                        </div>
                    </div>

                    <div style="border: 1px solid; padding:10px;border-radius: 5px;">

                        <div class="row col-md-12" id="choixPartie-0">
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKa-0" name="formsetCabinet[{{ $loop->iteration }}][role]" onclick="" value="Appelant" type="radio" class="custom-control-input" required @if($c->role=='Appelant') checked @else  @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Appelant(e)</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-0" name="formsetCabinet[{{ $loop->iteration }}][role]" onclick="" value="Intimé(e)" type="radio" class="custom-control-input" @if($c->role=='Intimé(e)') checked @else  @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Intimé(e)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKc-0" name="formsetCabinet[{{ $loop->iteration }}][role]" type="radio" class="custom-control-input" value="Autre" onclick="var id=0; roleASKc(id)" @if($c->role=='Autre') checked @else disabled @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Autre</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-3 toReload" id="other-0"  @if($c->role=='Autre') @else
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
                            <div class="col-md-3 cacher" id="avc-0" >
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

                            <div class="col-md-4 cacher" id="clientContent-0"  @if($c->typeAvocat==1)
                                @else hidden @endif>
                                <div class="form-group">
                                    <label for="client" class="control-label">Selectionner le
                                        client*
                                        :</label>
                                    <select name="formset[0][idClient]" id="client-0" onchange="var id=0; var idclient=$(this).val();clientAud(idclient,id)" class="form-control select2" style="width:100%" data-placeholder="Selectionner le client" >
                                    <option value={{$c->idClient}} selected>
                                            {{ $c->prenom }}
                                            {{ $c->nom }}
                                            {{ $c->denomination }}
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
                            <div class="col-md-5 cacher" id="affaireContent-0"  @if($c->typeAvocat==1)
                                @else hidden @endif>
                                <input type="text" id="typeContent-0" value="audience" name="formset[0][typeContent]" hidden>

                                <div class="form-group">
                                    <label for="affaire" class="control-label">Affaire du client
                                        concerné*
                                        :</label>
                                    <select data-placeholder="Affaire du client concerné" style="width: 100%;height:28px" name="formset[0][idAffaire]" id="affaireClient-0" >
                                        <option value="{{$c->idAffaire}}">
                                                {{$c->nomAffaire}}</option>
                                  
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>

                            <div class="col-md-6 cacher" id="otherAvocats-0" @if($c->role!='Autre')
                                @else hidden @endif>
                                <div class="form-group">
                                    <label for="personne" class="control-label">Ajouter/Retirer des
                                        conseils (facultatif)</label>
                                    <select multiple name="formset[0][idAvocat][]" class="form-control select2" data-placeholder="Recherchez un ou plusieurs avocats puis appuyez sur la touche ENTRER" style="width: 100%;" id="personne-0">
                                    @foreach ($avocatsParties as $a)
                                        @if($a->idPartie==$c->idPartie)
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
                @endforeach
                @foreach($partiesAdverse as $p)
                <div class="form mt-4">
                    <div class="mt-4 row">
                        <div class="col-md-6">
                            <h3>PARTIE <span class="iterationPartie">{{ $loop->iteration+count($partiesCabinet) }}</span></h3>
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
                                            value="Appelant" type="radio" class="custom-control-input" required
                                            @if($p->role=='Appelant') checked @else  @endif >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKa-0">Appelant</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input id="roleASKb-1" name="formset[{{ $loop->iteration }}][role]"
                                            value="Intimé(e)" type="radio" class="custom-control-input"
                                            @if($p->role=='Intimé(e)') checked @else  @endif>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" id="labelroleASKb-0">Intimé(e)</span>
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
                                        >
                                        <option value='2'>
                                            Autre
                                        </option>
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
            <div class="col-md-6">
                <button type="button" name="add" id="dynamic-a" onclick="addformAppel()" class="cl-white theme-bg btn btn-rounded" style="float:right"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Actes -->
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour" >
        <h4 class="panel-title">
            <a class="collapse" role="button"  onclick="LoadSelect2Script(oSelectForm);" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Acte introductif d'instance
            </a>
        </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingFour">
        
    @foreach($actes as $a)
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
            <div class="row mb-5" style="border: 1px solid; padding:10px;border-radius: 5px;" hidden>

                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="requisitoire" name="formsetActe[{{ $loop->iteration }}][typeActe]" onclick="" type="radio" class="custom-control-input" value="Assignation" required  @if($a->typeActe=='Assignation') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Assignation</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="" name="formsetActe[{{ $loop->iteration }}][typeActe]" onclick="" type="radio" class="custom-control-input" value="Requete"  @if($a->typeActe=='Requete') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Requete</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="assignation" name="formsetActe[{{ $loop->iteration }}][typeActe]" onclick="" type="radio" class="custom-control-input" value="Declaration d'appel" @if($a->typeActe=="Declaration d'appel") checked @else disabled @endif >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Declaration d'appel
                            </span>
                        </label>
                    </div>
                </div>
                <br>

                <div class="col-md-3" id="">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio">
                            <input id="" name="formsetActe[{{ $loop->iteration }}][typeActe]" onclick="" type="radio" class="custom-control-input" value="Contredit"  @if($a->typeActe=='Contredit') checked @else disabled @endif>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Contredit</span>
                        </label>
                    </div>
                </div>
            </div>

             @if($a->typeActe=="Declaration d'appel")
            <div class="row mrg-0" id="formDeclarationAppel"  @if($a->typeActe=="Declaration d'appel") @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Declaration d'appel#{{$loop->iteration}}</h2>
                    <hr>
                </div>
                 @foreach($acteDetail as $ad)
                    @if($ad->idActe==$a->idActe)
                    <div class="row col-md-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inpuRC" class="control-label">N° RG :</label>
                                <input type="text" class="form-control" id="numRG"  data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][numRgDeclaration]" value="{{$ad->numRg}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inpuRC" class="control-label">N° du jugement d'instance :</label>
                                <input type="text" class="form-control" id="numJugement"  data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][numJugement]" value="{{$ad->numJugement}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputASN" class="control-label">Date de l'appel :</label>
                                <input type="date" class="form-control" id="dateAppel"  data-error=" veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][dateAppel]" value="{{$ad->dateAppel}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>


                    </div>
                     @endif
                @endforeach
            </div>
            @endif

             @if($a->typeActe=="Contredit")
            <div class="row mrg-0" id="formContredit" @if($a->typeActe=="Contredit") @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Contredit#{{$loop->iteration}}</h2>
                    <hr>
                </div>
                 @foreach($acteDetail as $ad)
                    @if($ad->idActe==$a->idActe)
                    <div class="row col-md-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inpuRC" class="control-label">N° concernée :</label>
                                <input type="text" class="form-control" id="numConcerner"  data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][numConcerner]" value="{{$ad->numConcerner}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inpuRC" class="control-label">N° decision :</label>
                                <input type="text" class="form-control" id="numDecision"  data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][numDecisConcerner]" value="{{$ad->numDecisConcerner}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputASN" class="control-label">Date du contredit :</label>
                                <input type="date" class="form-control" id="dateContredit" data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][dateContredit]" value="{{$ad->dateContredit}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputASN" class="control-label">Date de la decision :</label>
                                <input type="date" class="form-control" id="dateDecision" data-error="veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][dateDecision]" value="{{$ad->dateDecision}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif

             @if($a->typeActe=="Assignation")
            <div class="row mrg-0" id="formAssignationAppel" @if($a->typeActe=="Assignation") @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Assignation#{{$loop->iteration}}</h2>
                    <hr>
                </div>
                @foreach($acteDetail as $ad)
                    @if($ad->idActe==$a->idActe)
                    <div class="row col-md-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">N° RG :</label>
                                <input type="text" class="form-control" id="numRgAss" data-error=" veillez saisir le N° RG" name="formsetActe[{{ $loop->iteration }}][numRg]" value="{{$ad->dateDecision}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="client" class="control-label">Huissier
                                    :</label>

                                <select class="form-control select2" data-placeholder="Rechercher..." style="width: 100%;" name="formsetActe[{{ $loop->iteration }}][idHuissier]" id="huissier" >
                                    <option value={{$ad->idHuissier}} selected disabled>{{ $ad->prenomHss }} {{ $ad->nomHss }}</option>
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
                                data-error=" veillez saisir le nom du receveur" name="formsetActe[{{ $loop->iteration }}][recepteurAss]" value="{{$ad->recepteurAss}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputASN" class="control-label">Date assignation :</label>
                                <input type="date" onchange="validateDatesAss()" class="form-control" id="dateAssignation"  data-error=" veillez saisir la date asignation" name="formsetActe[{{ $loop->iteration }}][dateAssignation]" value="{{$ad->dateAssignation}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputENAS" class="control-label">Date enrôlement :</label>
                                <input type="date" onchange="validateDatesAss()" class="form-control" id="dateEnrollement" data-error=" veillez saisir la date d'enroulement" name="formsetActe[{{ $loop->iteration }}][dateEnrollement]" value="{{$ad->dateEnrollement}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputFDAT" class="control-label">Date de la 1ère comparution
                                    :</label>
                                <input type="date" onchange="validateDatesAss()" class="form-control" id="datePremiereComp"  data-error=" veillez saisir la Date de la première comparution" name="formsetActe[{{ $loop->iteration }}][datePremiereComp]" value="{{$ad->datePremiereComp}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="mentionP" class="control-label">Mention particulière
                                    :</label>
                                <textarea id="mentionParticuliere" cols="4" rows="2" class="form-control" data-error=" veillez saisir la mention particulière" name="formsetActe[{{ $loop->iteration }}][mentionParticuliere]" >{{$ad->mentionParticuliere}}</textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    
                    </div>
                    @endif
                @endforeach
            </div>
            @endif

             @if($a->typeActe=="Requete")
            <div class="row mrg-0" id="formRequeteAppel" @if($a->typeActe=="Requete") @else hidden @endif>
                <div class="col-md-12" style="text-align:center ;">
                    <h2>Requete#{{$loop->iteration}}</h2>
                    <hr>
                </div>
                @foreach($acteDetail as $ad)
                    @if($ad->idActe==$a->idActe)
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">N° d'Enregistrement :</label>
                                <input type="text" class="form-control" id="numRgRequete"  data-error=" veillez saisir la date" name="formsetActe[{{ $loop->iteration }}][numRgRequete]" value="{{$ad->numRg}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">Date de la requete :</label>
                                <input type="date" class="form-control" id="dateRequete"  data-error=" veillez saisir la date" name="formsetActe[{{ $loop->iteration }}][dateRequete]" value="{{$ad->dateRequete}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPr" class="control-label">Date d'arrivée (Greffe) :</label>
                                <input type="date" class="form-control" id="dateArriver"  data-error=" veillez saisir la date" name="formsetActe[{{ $loop->iteration }}][dateArriver]" value="{{$ad->dateArriver}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label">Juridiction presidentielle :</label>
                                <input type="text" class="form-control" id="juriductionPresidentielle"  data-error=" veillez remplir ce champ" name="formsetActe[{{ $loop->iteration }}][juriductionPresidentielle]" value="{{$ad->juriductionPresidentielle}}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    

                    </div>
                  @endif
                @endforeach
            </div>
            @endif

        </div>
    @endforeach
    </div>
</div>

<div class="form-group">
    <div class="text-center">
        <button type="submit" class="cl-white theme-bg btn btn-rounded btn-block btn-default" style="width:50%;">
            Enregistrer</button>
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