@extends('layouts.base')
@section('title','Gestion d\'utilisateur')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-users"></i> RH > <span class="label bg-info"><b>Comptes utilisateurs</b></span></h4>
        </div>

        <div class="col-md-7 text-right">

        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form method="post" action="{{route('postUser')}}">
                @csrf
                    <div class="text-center mt-4">
                        <h2><i class="fa fa-plus-circle"></i> Créer un compte utilisateur</h2>
                        <br>
                        @if($nbreCompte[0]->totalComptes=='Illimité')

                        @else
                            @if(intval($nbreCompte[0]->totalComptes) < count($users)) <p style="color:orange"><i
                                    class="fa fa-info-circle"></i> Vous avez atteint le nombre limite de compte utilisateur.
                                Veuillez contacter le centre d'aide de smartylex.</p>
                            @else
                            @endif
                        @endif
                           
                    </div>
                    <div class="row mrg-0">
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role" class="control-label">Role d'utilisateur :</label>
                                <select class="form-control select2" placeholder="selectionner le role"
                                    data-error=" veillez selectionner le role" style="width: 100%;" name="role"
                                    id="role" required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    <option value="Administrateur">Adminstrateur(trice)</option>
                                    <option value="Assistant">Assistant(e)</option>
                                    <option value="Collaborateur">Collaborateur(trice)</option>
                                   <!-- <option value="Client">Client(e)</option> -->
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="divMatricule">
                            <div class="form-group">
                                <input type="text" value="" name="slug" hidden>
                                <label for="getMatricule" class="control-label">Matricule :</label>
                                <input type="text" class="form-control" id="getMatricule"
                                    placeholder="Entrer le matricule du personnel"
                                    data-error=" veillez saisir le prénom de la personne" name="matricules" required
                                    autocomplete="false">
                                <div class="help-block with-errors"></div>
                                <span id="matriculeInfo">Vérification encours...
                                    <i class="ace-icon fa fa-spinner fa-spin them-red"></i>
                                </span>
                                <span id="trueUser" style="color:green">Vérification terminés, personnel trouvée...
                                    <i class="ace-icon fa fa-check them-success"></i>
                                </span>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row mrg-0" id="identifiantClient" hidden>
                       
                        <div class="col-sm-4" id="divClient">
                            <div class="form-group">
                                <label>Selectionner le client</label>
                                 @if($plan=='standard')
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="idClient" required>
                                     <option value="" selected disabled>Module Premium</option>
                                   
                                </select>
                                <div class="help-block with-errors" style="color:red"><i class="fa fa-info-circle"></i> Indisponible dans le plan <b>standard</b>.</div>
                                @else
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="idClient" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($client as $data )
                                    <option value={{ $data->idClient }}>
                                           {{$data->prenom}} {{$data->nom}} {{$data->denomination}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                             @endif
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="control-label">Nom d'utilisateur :</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    data-error=" veillez saisir le mot de passe" placeholder="Nom d'utilisateur" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="control-label">Initial :</label>
                                <input type="text" class="form-control" id="initial" name="initial"
                                    data-error=" veillez saisir le mot de passe" placeholder="EX: AC" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="control-label">Email :</label>
                                <input type="email" class="form-control" id="email"
                                    name="email"
                                    data-error=""
                                    placeholder="Email de connexion" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                       
                    </div>
                   
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Mot de passe par defaut :</label><br>
                            
                                    <div class="password-container">
                                        <input type="password" class="form-control" name="password"  id="passwordField" style="width:40em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                        <i class="pass-view fa fa-eye" id="togglePasswordField"></i>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="passwordConf" class="control-label">Confirmation du mot de passe :</label><br>
                               
                                    <div class="password-container">
                                        <input type="password" class="form-control" name="confirmation_password"  id="passwordField2" style="width:40em" data-error="veillez saisir la confirmation du mot de passe" placeholder="" required>
                                        <i class="pass-view fa fa-eye" id="togglePasswordField2"></i>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <br />
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    @if($nbreCompte[0]->totalComptes=='Illimité')
                                    <input type="submit" class="cl-white theme-bg btn btn-rounded" style="width:20%;"
                                        value="Enregistrer" />

                                    @else
                                    @if(intval($nbreCompte[0]->totalComptes) < count($users)) 
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" style="width:20%;">Enregistrer</button>
                                        @else
                                        <input type="submit" class="cl-white theme-bg btn btn-rounded"
                                            style="width:20%;" value="Enregistrer" />
                                        @endif
                                        @endif
                                       

                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <div class="text-center mt-4">
                    <h2><i class="fa fa-lock"></i> Comptes utilisateurs du personnel</h2>
                    <br>
                    @csrf
                </div>

                <div class="card-body">

                    <div class=" table-responsive">
                        <div class="category-filter">
                            <select id="categoryFilter" class="categoryFilter form-control">
                                <option value="">Tous</option>
                                <option value="Collaborateur">Collaborateur</option>
                                <option value="Assistant">Assistant</option>
                                <option value="Client">Client</option>
                            </select>
                        </div>
                        <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Prenoms & Noms</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Date de creation</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>@if($row->role=='Collaborateur') Collaborateur(trice) @elseif($row->role=='Assistant') Assistant(e) @elseif($row->role=='Administrateur') Administrateur(trice) @else @endif</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ $row->statut }}</td>
                                    <td>
                                   
                                        @if($row->statut=='bloquer')
                                        <a href="{{ route('deblockPersonnel', [$row->email]) }}" class="">
                                            <button type="button"
                                                class="btn btn-outline-success btn-rounded">Débloquer</button>
                                        </a>
                                        @else
                                        <a href="{{ route('blockPersonnel', [$row->email]) }}" class="">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-rounded">Bloquer</button>
                                        </a>
                                        @endif
                                    
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <div class="text-center mt-4">
                    <h2><i class="fa fa-lock"></i> Comptes administrateurs</h2>
                    <br>
                    @csrf
                </div>

                <div class="card-body">

                    <div class=" table-responsive">
                        <div class="category-filter">
                            <select id="categoryFilter" class="categoryFilter form-control">
                                <option value="">Tous</option>
                                <option value="Collaborateur">Collaborateur</option>
                                <option value="Assistant">Assistant</option>
                                <option value="Client">Client</option>
                            </select>
                        </div>
                        <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Prenoms & Noms</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Date de creation</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($adminUsers as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>@if($row->role=='Collaborateur') Collaborateur(trice) @elseif($row->role=='Assistant') Assistant(e) @elseif($row->role=='Administrateur') Administrateur(trice) @else @endif</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ $row->statut }}</td>
                                    <td>
                                      @if(Auth::user()->email==$firstAdmin[0]->email)
                                            @if($row->statut=='bloquer')
                                            <a href="{{ route('deblockPersonnel', [$row->email]) }}" class="">
                                                <button type="button"
                                                    class="btn btn-outline-success btn-rounded">Débloquer</button>
                                            </a>
                                            @else
                                            <a href="{{ route('blockPersonnel', [$row->email]) }}" class="">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-rounded">Bloquer</button>
                                            </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    document.getElementById('ges').classList.add('active');
    </script>
    @endsection