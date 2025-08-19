@extends('layouts.base')
@section('title','Liste des audiences')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Gestion des audiences</h4>
        </div>
        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('addAudience') }}" title="Créer une audience" class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une nouvelle procédure
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

   
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="flex-box padd-10 bb-1">
                    <h4 class="mb-0">Liste des audiences</h4>
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
                                    <th>N°</th>
                                    <th>Objet</th>
                                    <th>Role ASK</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audience as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->objet }}</td>
                                    <td>
                                        <span>
                                            <small class="label bg-green"> {{ $row->roleASK }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="label cl-success bg-success-light">{{ $row->statut }}</div>
                                    </td>
                                    <td>

                                        <a  type="button" class="load btn btn-outline-primary" href="{{ route('detailAudience', ['id' => $row->id, 'slug' => $row->slug]) }}" data-toggle="tooltip" title="Voir plus de cette audience"><i class="ti-arrow-right"></i></a>
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
</div>
<script>
    document.getElementById('aud').classList.add('active');
</script>
<!-- /.row -->
@endsection