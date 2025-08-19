@extends('layouts.base')
@section('title','Liste du personnel')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-6 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-users"></i> RH > <span class="label bg-info"><b>Personnels avec ou sans compte utilisateur</b></span></h4>
        </div>

        <div class="col-md-6 text-right">
            <div class="btn-group mr-lg-2">
                <a href="{{ route('personneCard') }}" class="cl-white theme-bg btn tooltips">
                    <i class="ti-flix ti-layout-grid2"></i>
                </a>
            </div>
            
            <div class="btn-group">
                <a href="{{ route('formPersonnel') }}" class="cl-white theme-bg btn btn-rounded" title="Ajouter un personnel">
                    <i class="fa fa-plus"></i>
                    Ajouter un personnel
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->


    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">
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