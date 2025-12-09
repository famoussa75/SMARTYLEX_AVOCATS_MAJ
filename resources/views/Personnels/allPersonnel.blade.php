@extends('layouts.base')
@section('title','Liste du personnel')
@section('content')
<div class="container-fluid">
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        <!-- Bloc gauche : icône + titre -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper theme-bg">
                <i class="fa fa-users"></i>
            </div>
            <div class="ms-2">
                <h4 class="page-title mb-1">
                    RH
                    <span class="page-subtitle text-muted">› Personnels avec ou sans compte utilisateur</span>
                </h4>
                <small class="page-description text-secondary">
                    Gérez tous les personnels, qu'ils disposent ou non d’un compte utilisateur.
                </small>
            </div>
        </div>

        <!-- Bloc droit : boutons d’action -->
        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('personneCard') }}" 
            class="btn btn-outline-primary-custom shadow-sm"
            title="Vue grille des personnels">
                <i class="ti-flix ti-layout-grid2"></i>
            </a>
            &nbsp;
            <a href="{{ route('formPersonnel') }}" 
            class="btn btn-gradient-custom shadow-sm"
            title="Ajouter un personnel">
                <i class="fa fa-plus me-1"></i> Ajouter un personnel
            </a>
        </div>

    </div>

    <!-- Title & Breadcrumbs-->


    <div class="card col-md-12">
                <div class="flex-box padd-10 bb-1">
                    <h4 class="mb-0">Liste du personnel</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="category-filter">
                            <select id="categoryFilter" class="categoryFilter form-control">
                                <option value="">Tous</option>

                            </select>
                        </div>
                        <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Photo</th>
                                    <th>Prénom et nom</th>
                                    <th>Fonction</th>
                                    <th>email</th>
                                    <th>score</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($personnel as $row)
                                <tr>
                                    <td>
                                        {{ $row->matricules }}
                                    </td>
                                    <td><a class="load" href="{{ route('infosPersonne', [$row->slug]) }}"><img src="/{{$row->photo}}" class="avatar" alt="Avatar"> </a></td>
                                    <td>
                                        <a class="load" href="{{ route('infosPersonne', [$row->slug]) }}" class="settings" title="Plus d'infos" data-toggle="tooltip">{{ $row->prenom }}
                                            {{ $row->nom }}</a>
                                    </td>
                                    <td>{{ $row->fonction }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>
                                        <div class="label cl-success bg-success-light">{{ $row->score }}</div>
                                    </td>
                                    <td>
                                        <a class="load" href="{{ route('infosPersonne', [$row->slug]) }}" class="settings" title="Information" data-toggle="tooltip"><i class="fa fa-info-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
     
</div>
<!-- /.row -->

<script>
    document.getElementById('rh').classList.add('active');
</script>
@endsection