@extends('layouts.base')
@section('title','Liste des avocats')
@section('content')
<div class="container-fluid">


    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

            <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Avocats</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="" title="Créer une tâche" class="cl-white theme-bg btn btn-rounded" data-toggle="modal"
                        data-target="#addavocats">
                        <i class=" fa fa-plus"></i>
                        Ajouter un avocat
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
                        <th>année d'entrée</th>
                        <th>Action</th>


                    </tr>
                </thead>

                <tbody>
                    @foreach($avocats as $row)
                    <tr>
                        <td>{{ $row->idAvc }}</td>
                        <td>{{ $row->prenomAvc }} {{ $row->nomAvc }}</td>
                        <td>{{ $row->telAvc_1 }}</td>
                        <td>{{ $row->telAvc_2 }}</td>
                        <td>{{ $row->emailAvc_1 }}</td>
                        <td>{{ $row->adresseAvc }}</td>
                        <td>{{ $row->annee_entrer }}</td>
                        <td><a href="" data-toggle="modal" id="{{ $row->idAvc }}" data-target="#updateAvocat"
                                onclick="var id= this.id ; updateAvocat(id)"><i class="fa fa-pencil"
                                    style="color:dodgerblue ;"></i></a>
                            <a href="" data-toggle="modal" id="{{ $row->idAvc }}" data-target="#deleteAvocat"
                                onclick="var id= this.id ; deleteAvocat(id)"><i class="fa fa-trash"
                                    style="color:brown ;"></i></a>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="add-popup modal fade" id="addavocats" tabindex="-1" role="dialog" aria-labelledby="addavocats">
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
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nouveau avocat</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('avocats.create')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Prénom</label>
                                        <input type="text" class="form-control" name="prenomAvc" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nom</label>
                                        <input type="text" class="form-control" name="nomAvc" required>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 1</label>
                                            <input type="tel" class="form-control phone " value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask minlength="6"
                                                name="telAvc_1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 2</label>
                                            <input type="tel" class="form-control phone3" value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask minlength="4"
                                                name="telAvc_2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="text" class="form-control" name="emailAvc_1">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Adresse</label>
                                        <input type="text" class="form-control" name="adresseAvc">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Année d'entrée</label>
                                        <input type="text" class="form-control" name="annee_entrer">
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

<div class="add-popup modal fade" id="updateAvocat" tabindex="-1" role="dialog" aria-labelledby="updateAvocat">
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
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification de l'avocat</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('avocats.update')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Prénom</label>
                                        <input type="text" class="form-control" id="prenomAvc" name="prenomAvc"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nom</label>
                                        <input type="text" class="form-control" id="nomAvc" name="nomAvc" required>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 1</label>
                                            <input type="text" class="form-control phone1" value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="telAvc_1"
                                                name="telAvc_1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description">Telephone 2</label>
                                            <input type="text" class="form-control phone2" value="+224"
                                                data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="telAvc_2"
                                                name="telAvc_2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="text" class="form-control" id="emailAvc" name="emailAvc">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Adresse</label>
                                        <input type="text" class="form-control" id="adresseAvc" name="adresseAvc">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Année d'entrée</label>
                                        <input type="text" class="form-control" id="annee_entrer" name="annee_entrer">

                                        <input type="hidden" class="form-control" id="idAvc" name="idAvc">

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

<div class="add-popup modal fade" id="deleteAvocat" tabindex="-1" role="dialog" aria-labelledby="deleteAvocat">
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
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez la suppression</h4>
            </div>
            <form method="post" action="{{route('avocats.delete')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment supprimer cet avocat du systeme ?</p>
                    <input type="hidden" id="idAvocat" name="avocat">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal"
                                aria-label="Close">
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