@extends('layouts.base')
@section('title','Liste des notaires')
@section('content')
<div class="container-fluid">
   <!-- Title & Breadcrumbs -->
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        <!-- Bloc gauche : icône + titre -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper theme-bg">
                <i class="ti i-cl-0 ti-server"></i>
            </div>
            <div class="ms-2">
                <h4 class="page-title mb-1">
                    Données externes
                    <span class="page-subtitle">
                     › Notaires
                    </span>
                </h4>
                <small class="page-description text-secondary">
                    Gérez les notaires externes et leurs informations dans le système.
                </small>
            </div>
        </div>

        <!-- Bloc droit : bouton d’action
        <div class="d-flex align-items-center">
            <a href="#" class="btn btn-gradient-custom shadow-sm" data-bs-toggle="modal" data-bs-target="#addnotaire" title="Ajouter un notaire">
                <i class="fa fa-plus me-1"></i> Ajouter un notaire
            </a>
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