@extends('layouts.base')
@section('title','Liste des huissiers')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

        <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Huissiers</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="" title="Créer une tâche" class="cl-white theme-bg btn btn-rounded" data-toggle="modal"
                        data-target="#addhuissiers">
                        <i class="fa fa-plus"></i>
                        Ajouter un huissier
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Title & Breadcrumbs-->

    <div class="card  col-md-12" style="margin-top:30px;padding:10px">

        <div class=" table-responsive">
            <div class="category-filter">
                <select id="categoryFilter" class="categoryFilter form-control">
                    <option value="">Tous</option>

                </select>
            </div>
            <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Prenoms & Noms</th>
                        <th>Telephone1</th>
                        <th>Telephone2</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Rattachement</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($huissiers as $row)
                    <tr>
                        <td>{{ $row->idHss }}</td>
                        <td>{{ $row->prenomHss }} {{ $row->nomHss }}</td>
                        <td>{{ $row->telHss_1 }}</td>
                        <td>{{ $row->telHss_2 }}</td>
                        <td>{{ $row->emailHss }}</td>
                        <td>{{ $row->adresseHss }}</td>
                        <td>{{ $row->rattachement }}</td>
                        <td><a href="" data-toggle="modal" id="{{ $row->idHss }}" data-target="#updateHuissier"
                                onclick="var id= this.id ; updateHuissier(id)"><i class="fa fa-pencil"
                                    style="color:dodgerblue ;"></i></a>
                            <a href="" data-toggle="modal" id="{{ $row->idHss }}" data-target="#deleteHuissier"
                                onclick="var id= this.id ; deleteHuissier(id)"><i class="fa fa-trash"
                                    style="color:brown ;"></i></a>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="addhuissiers" tabindex="-1" role="dialog" aria-labelledby="addhuissiers">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nouveau Huissier</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('huissiers.create')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0" style="text-align:center ;">Formulaire
                                        d'enregistrement
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Prénom</label>
                                        <input type="text" class="form-control" name="prenomHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nom</label>
                                        <input type="text" class="form-control" name="nomHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Telephone 1</label><br>
                                        <input type="text" class="form-control phone" name="telHss_1" value="+224"
                                            data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask minlength="6"
                                            style="width:200% ;">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Telephone 2</label><br>
                                        <input type="text" class="form-control phone1" name="telHss_2" value="+224"
                                            data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask minlength="4"
                                            style="width:200% ;">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="text" class="form-control" name="emailHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Adresse</label>
                                        <input type="text" class="form-control" name="adresseHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Rattachement</label>
                                        <input type="text" class="form-control" name="rattachement">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                        style="width:50%;"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="updateHuissier" tabindex="-1" role="dialog" aria-labelledby="updateHuissier">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification de l'Huissier</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('huissier.update')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Prénom</label>
                                        <input type="text" class="form-control" id="prenomHss" name="prenomHss"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nom</label>
                                        <input type="text" class="form-control" id="nomHss" name="nomHss" required>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 1</label>
                                            <input type="text" class="form-control phone2" value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="telHss_1"
                                                name="telHss_1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 2</label>
                                            <input type="text" class="form-control phone3" value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="telHss_2"
                                                name="telHss_2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="text" class="form-control" id="emailHss" name="emailHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Adresse</label>
                                        <input type="text" class="form-control" id="adresseHss" name="adresseHss">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Rattachement</label>
                                        <input type="text" class="form-control" id="rattachement" name="rattachement">

                                        <input type="hidden" class="form-control" id="idHss" name="idHss">

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                        style="width:50%;"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteHuissier" tabindex="-1" role="dialog" aria-labelledby="deleteHuissier">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gray;">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez l'annulation</h4>
            </div>
            <form method="post" action="{{route('huissier.delete')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment supprimer cet Huissier du systeme ?</p>
                    <input type="hidden" id="idHuissier" name="huissier">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn " data-dismiss="modal" aria-label="Close">
                                NON
                            </a>

                            <button type="submit" class="btn btn-danger">OUI</button>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('de').classList.add('active');
</script>

<!-- /.row -->
@endsection