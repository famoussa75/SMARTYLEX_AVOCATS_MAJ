@extends('layouts.base')
@section('title','Ouverture de l\'audience')
@section('content')

<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-plus"></i> Changement du niveau d'audience</h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('listAudience', 'generale') }}" class="cl-white theme-bg btn btn-default btn-rounded"
                    title="Voir la liste des audiences">
                    <i class="fa fa-navicon"></i> Liste des audiences
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form method="post" action=" {{ route('storeNewLevel')}}" enctype="multipart/form-data">
                @csrf
                <div class="card padd-10">
                    <div class="panel-group accordion-stylist" id="accordion" role="tablist"
                        aria-multiselectable="true">


                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Juridiction compétente
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Juridiction :</label>
                                                <select name="juridiction" id="" class="form-select select2"
                                                    style="width:100%" required>
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    @foreach($juriductions as $j)
                                                    <option value="{{$j->id}}">{{$j->nom}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="inputPName" class="control-label">Objet :</label>
                                                <input type="text" name="objet" class="form-control"
                                                    value="{{$audiencePrecedent[0]->objet}}" required>
                                                <input type="hidden" name="slugAudience"
                                                    value="{{$audiencePrecedent[0]->slug}}">
                                                <input type="hidden" name="idAudience"
                                                    value="{{$audiencePrecedent[0]->idAudience}}">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default" id="partieInstance">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Parties
                                    </a>
                                </h4>
                            </div>


                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="">

                                        <div class="table-responsive">
                                            @if($audiencePrecedent[0]->niveauProcedural=='1ère instance')
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th>Parties</th>
                                                        <th>Ancien Role</th>
                                                        <th style="text-align:left">Nouveau Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($cabinet as $c )
                                                    <tr style="text-align: center;">
                                                        <td>
                                                            {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($c->role=='Autre')
                                                            @if($c->autreRole=='in')
                                                            <small class="label bg-success">Intervenant(e)</small>
                                                            @elseif($c->autreRole=='pc')
                                                            <small class="label bg-success">Partie civile</small>
                                                            @elseif($c->autreRole=='mp')
                                                            <small class="label bg-success">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-success">{{ $c->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="formset1[{{ $c->idPartie }}][idPartie1]" value="{{ $c->idPartie }}">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}"
                                                                        name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Appelant(e)" required>
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Appelant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}"
                                                                        name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intimé(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intimé(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}"
                                                                        name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intervenant(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}"
                                                                        name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="N/A">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>

                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($personne_adverses as $p )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $p->prenom }} {{ $p->nom }}
                                                        </td>
                                                        <td>
                                                            @if($p->role=='Autre')
                                                            @if($p->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant(e)</small>
                                                            @elseif($p->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($p->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $p->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                           <input type="hidden" name="formset2[{{ $p->idPartie }}][idPartie2]" value="{{ $p->idPartie }}">

                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}"
                                                                        name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Appelant(e)" required>
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Appelant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}"
                                                                        name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intimé(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intimé(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}"
                                                                        name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intervenant(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}"
                                                                        name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="N/A">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($entreprise_adverses as $e )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $e->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($e->role=='Autre')
                                                            @if($e->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant(e)</small>
                                                            @elseif($e->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($e->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $e->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <input type="hidden" name="formset3[{{ $e->idPartie }}][idPartie3]" value="{{ $e->idPartie }}">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}"
                                                                        name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Appelant(e)" required>
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Appelant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}"
                                                                        name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intimé(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intimé(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}"
                                                                        name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="Intervenant(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}"
                                                                        name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input"
                                                                        value="N/A">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @elseif($audiencePrecedent[0]->niveauProcedural=='Appel')
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th>Parties</th>
                                                        <th>Ancien Role</th>
                                                        <th style="text-align:left">Nouveau Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($cabinet as $c )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($c->role=='Autre')
                                                            @if($c->autreRole=='in')
                                                            <small class="label bg-success">Intervenant(e)</small>
                                                            @elseif($c->autreRole=='pc')
                                                            <small class="label bg-success">Partie civile</small>
                                                            @elseif($c->autreRole=='mp')
                                                            <small class="label bg-success">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-success">{{ $c->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <input type="hidden" name="formset1[{{ $c->idPartie }}][idPartie1]" value="{{ $c->idPartie }}">

                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}" name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input" value="Demandeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Demandeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}" name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input" value="Defendeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Defendeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}" name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input" value="Intervenant(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $c->idPartie }}" name="formset1[{{ $c->idPartie }}][role1]"
                                                                        type="radio" class="custom-control-input" value="N/A">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($personne_adverses as $p )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $p->prenom }} {{ $p->nom }}
                                                        </td>
                                                        <td>
                                                            @if($p->role=='Autre')
                                                            @if($p->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant(e)</small>
                                                            @elseif($p->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($p->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $p->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <input type="hidden" name="formset2[{{ $p->idPartie }}][idPartie2]" value="{{ $p->idPartie }}">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}" name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input" value="Demandeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Demandeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}" name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input" value="Defendeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Defendeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}" name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input" value="Intervenant(e)">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $p->idPartie }}" name="formset2[{{ $p->idPartie }}][role2]"
                                                                        type="radio" class="custom-control-input" value="N/A">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($entreprise_adverses as $e )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $e->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($e->role=='Autre')
                                                            @if($e->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant(e)</small>
                                                            @elseif($e->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($e->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $e->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <input type="hidden" name="formset3[{{ $e->idPartie }}][idPartie3]" value="{{ $e->idPartie }}">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}" name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input" value="Demandeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Demandeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}" name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input" value="Defendeur au pourvoi">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Defendeur
                                                                        au pourvoi</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}" name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span
                                                                        class="custom-control-description">Intervenant(e)</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="{{ $e->idPartie }}" name="formset3[{{ $e->idPartie }}][role3]"
                                                                        type="radio" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description"> N/A</span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseFive" aria-expanded="false" aria-controls="headingFive">
                                        Niveau procédural / Nature
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFive">
                                <div class="panel-body">
                                    <div class="row mrg-0">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="control-label">Niveau procédural :</label>
                                                @if($audiencePrecedent[0]->niveauProcedural=='1ère instance')
                                                <select name="niveauProcedural" id="niveauProcedural"
                                                    class="form-select select2" style="width:100%" required>
                                                    <option value="Appel">Appel</option>
                                                </select>
                                                @elseif($audiencePrecedent[0]->niveauProcedural=='Appel')
                                                <select name="niveauProcedural" id="niveauProcedural"
                                                    class="form-select select2" style="width:100%" required>
                                                    <option value="Cassation">Cassation</option>

                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="control-label">Nature :</label>
                                                <select name="nature" id="nature" class="form-select select2"
                                                    style="width:100%" onchange="natureLevel();" required>
                                                    <option value="" selected disabled>-- Choisissez --</option>
                                                    <option value="Civile">Civile, Commerciale, Administrative, Sociale
                                                    </option>
                                                    <option value="Pénale">Pénale</option>

                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="formInstruction" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Instruction ( Facultatif )</h2>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputPr" class="control-label">importer un fichier :</label>
                                                <input type="file" class="fichiers form-control" id="" placeholder="pièce jointe"
                                                    data-error=" veillez joindre la pièce de l'assignation"
                                                    name="pieceInstruction"
                                                    accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Actes -->

                        @if($audiencePrecedent[0]->niveauProcedural=='1ère instance')
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour"
                                style="background-color:whitesmoke; ">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" onclick="LoadSelect2Script(oSelectForm);"
                                        data-toggle="collapse" data-parent="#accordion" href="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Acte introductif d'instance
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <!-- <div class="col-md-12 mrg-0" id="matiere">

                                        <div class="form-group">
                                            <h5 for="" class="" style="text-align: center;">Nature de l'action :</h5>
                                            <select name="idNatureAction" id="" class="form-select select2"
                                                style="width:100%" data-placeholder="Choisissez..." required>
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                @foreach($natureActions as $n)
                                                <option value={{$n->idNatureAction}}>{{$n->natureAction}} | délais:
                                                    {{$n->delaiAction}} | depart: {{$n->depart}} | {{$n->baseLegale}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div> 
                                    <hr> -->
                                    <div class="row mb-5" style="border: 1px solid; padding:10px;border-radius: 5px;">

                                        <div class="col-md-3" id="">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="requisitoire" name="typeActe"
                                                        onclick="formAssignationAppel()" type="radio"
                                                        class="custom-control-input" value="Assignation" required>
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Assignation</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="" name="typeActe" onclick="formRequeteAppel()"
                                                        type="radio" class="custom-control-input" value="Requete">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Requete</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input id="assignation" name="typeActe"
                                                        onclick="formDeclarationAppel()" type="radio"
                                                        class="custom-control-input" value="Declaration d'appel">
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
                                                    <input id="" name="typeActe" onclick="formContredit()" type="radio"
                                                        class="custom-control-input" value="Contredit">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Contredit</span>
                                                </label>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row mrg-0" id="formDeclarationAppel" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Declaration d'appel</h2>
                                            <hr>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° RG :</label>
                                                    <input type="text" class="form-control" id="numRG"
                                                        data-error="veillez remplir ce champ" name="numRgDeclaration">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° du jugement d'instance
                                                        :</label>
                                                    <input type="text" class="form-control" id="numJugement"
                                                        data-error="veillez remplir ce champ" name="numJugement">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date de l'appel
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateAppel"
                                                        data-error=" veillez remplir ce champ" name="dateAppel">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="row mrg-0" id="formContredit" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Contredit</h2>
                                            <hr>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° concernée :</label>
                                                    <input type="text" class="form-control" id="numConcerner"
                                                        data-error="veillez remplir ce champ" name="numConcerner">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° decision :</label>
                                                    <input type="text" class="form-control" id="numDecision"
                                                        data-error="veillez remplir ce champ" name="numDecisConcerner">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date du contredit
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateContredit"
                                                        data-error="veillez remplir ce champ" name="dateContredit">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date de la decision
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateDecision"
                                                        data-error="veillez remplir ce champ" name="dateDecision">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="formAssignationAppel" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Assignation</h2>
                                            <hr>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° RG :</label>
                                                    <input type="text" class="form-control" id="numRgAss"
                                                        data-error=" veillez saisir le N° RG" name="numRg">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="client" class="control-label">Huissier
                                                        :</label>

                                                    <select class="form-control select2"
                                                        data-placeholder="Rechercher..." style="width: 100%;"
                                                        name="idHuissier" id="huissier">
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
                                                    <input type="text" class="form-control" id="recepteurAss"
                                                        data-error=" veillez saisir le nom du receveur"
                                                        name="recepteurAss">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date assignation
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateAssignation"
                                                        data-error=" veillez saisir la date asignation"
                                                        name="dateAssignation">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputFDAT" class="control-label">Date de la 1ère
                                                        comparution
                                                        :</label>
                                                    <input type="date" class="form-control" id="datePremiereComp"
                                                        data-error=" veillez saisir la Date de la première comparution"
                                                        name="datePremiereComp">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputENAS" class="control-label">Date enrôlement
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateEnrollement"
                                                        data-error=" veillez saisir la date d'enroulement"
                                                        name="dateEnrollement">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="mentionP" class="control-label">Mention particulière
                                                        :</label>
                                                    <textarea id="mentionParticuliere" cols="4" rows="2"
                                                        class="form-control"
                                                        data-error=" veillez saisir la mention particulière"
                                                        name="mentionParticuliere"></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièce :</label>
                                                    <input type="file" class="fichiers form-control" id="pieceAS"
                                                        data-error=" veillez joindre la pièce de l'assignation"
                                                        name="pieceAS"
                                                        accept="image/*,.pdf, .mp3, mp4, .doc, docx,  .aac, .m4a">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mrg-0" id="formRequeteAppel" hidden>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Requete</h2>
                                            <hr>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° d'Enregistrement
                                                        :</label>
                                                    <input type="text" class="form-control" id="numRgRequete"
                                                        data-error=" veillez saisir la date" name="numRgRequete">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de la requete
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateRequete"
                                                        data-error=" veillez saisir la date" name="dateRequete">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date d'arrivée (Greffe)
                                                        :</label>
                                                    <input type="date" class="form-control" id="dateArriver"
                                                        data-error=" veillez saisir la date" name="dateArriver">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Juridiction presidentielle
                                                        :</label>
                                                    <input type="text" class="form-control"
                                                        id="juriductionPresidentielle"
                                                        data-error=" veillez remplir ce champ"
                                                        name="juriductionPresidentielle">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièce :</label>
                                                    <input type="file" class="fichiers form-control" id="pieceREQ"
                                                        data-error=" veillez joindre la pièce de l'assignation"
                                                        name="pieceREQ" accept="image/*,.pdf, .doc, docx">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @elseif($audiencePrecedent[0]->niveauProcedural=='Appel')
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        onclick="LoadSelect2Script(oSelectForm);" data-parent="#accordion"
                                        href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Acte introductif d'instance
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFour">
                                <div class="panel-body">

                                    <div class="col-md-12 mrg-0" id="matiere">

                                        <div class="form-group">
                                            <h5 for="" class="" style="text-align: center;">Nature de l'action :</h5>
                                            <select name="idNatureAction" id="" class="form-select select2"
                                                style="width:100%" data-placeholder="Choisissez..." required>
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                @foreach($natureActions as $n)
                                                <option value={{$n->idNatureAction}}>{{$n->natureAction}} | délais:
                                                    {{$n->delaiAction}} |
                                                    depart: {{$n->depart}} | {{$n->baseLegale}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <hr>

                                    <input id="" name="typeActe" type="hidden" class="custom-control-input"
                                        value="Pourvoi">
                                    <div class="row mrg-0" id="formDeclarationAppel">
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Pourvoi</h2>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">N° de pourvoi :</label>
                                                <input type="text" class="form-control" id=""
                                                    data-error=" veillez remplir ce champ" name="numPourvoi">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">N° décision:</label>
                                                <input type="text" class="form-control" id=""
                                                    data-error=" veillez remplir ce champ" name="numDecisConcerner" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">Date pourvoi :</label>
                                                <input type="date" class="form-control" id=""
                                                    data-error="veillez remplir ce champ" name="datePourvoi" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">Date de la décision :</label>
                                                <input type="date" class="form-control" id=""
                                                    data-error="veillez remplir ce champ" name="dateDecision" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                style="width:50%;">Enregistrer</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
var i = 0;

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
</script>

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