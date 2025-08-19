@extends('layouts.base')
@section('title','Liste des clients')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti-bag"></i> Affaires</h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group mr-lg-2">
                <a href="javascript:history.back()" class="btn  tooltips">
                    <i class="ti-flix ti-layout-grid2"></i>
                </a>
            </div>
          
            <div class="btn-group">
                <a  href="{{ route('createAffaire') }}" class="cl-white theme-bg btn  btn-rounded" title="Creer une Affaire">
                    <i class="fa fa-plus"></i>
                    Creer une affaire
                </a>
            </div>
            
        </div>

    </div>
    <!-- Title & Breadcrumbs-->

   
    <div class="row">
        <div class="col-md-12">
            <div class="card">

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
                                    <th>Affaires</th>
                                    <th style="width: 80px">Date de creation</th>
                                    <th style="width: 80px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($affaire as $row)
                                <tr>
                                    <td>
                                        {{ $row->idAffaire }}
                                    </td>
                                    <td>
                                        <a class="load" href="{{ route('showAffaire', [$row->idAffaire,$row->slug]) }}">
                                            {{ $row->clientid }} - {{ $row->prenom }} {{ $row->nom }}{{ $row->denomination }} - {{ $row->nomAffaire }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $row->created_at }}
                                    </td>

                                    <td>
                                        <a href="" class="settings" title="Information" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="delete" title="Supprimer" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
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
<!-- /.row -->

<script>
    document.getElementById('aff').classList.add('active');
</script>

@endsection