@extends('layouts.base')
@section('title','Liste des notaires')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

        <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Notaires</b></span></h4>
        </div>

        <!-- <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="" title="Créer une tâche" data-toggle="modal" data-target="#addnotaire">
                        <i class="fa fa-plus"></i>
                        Ajouter un notaire
                    </a>
                </div>
            </div>
        </div> -->

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
                        <th>Telephone 1</th>
                        <th>Telephone 2</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($notaires as $row)
                    <tr>
                        <td>{{ $row->idNtr }}</td>
                        <td>{{ $row->prenomNtr }} {{ $row->nomNtr }}</td>
                        <td>{{ $row->telNtr_1 }}</td>
                        <td>{{ $row->telNtr_2 }}</td>
                        <td>{{ $row->emailNtr }}</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="addnotaire" tabindex="-1" role="dialog" aria-labelledby="addnotaire">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title">Nouveau Notaire</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nom</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Telephone 1</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Telephone 2</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="text" class="form-control">
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

<!-- /.row -->

<script>
document.getElementById('de').classList.add('active');
</script>
@endsection