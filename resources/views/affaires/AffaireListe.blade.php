@extends('layouts.base')
@section('title','Liste des clients')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti-bag"></i> Affaires > <span class="label bg-info"><b>Liste des affaires</b></span></h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group mr-lg-2">
                <a href="javascript:history.back()" class="cl-white theme-bg btn  tooltips">
                    <i class="ti-flix ti-layout-grid2"></i>
                </a>
            </div>
             @if (sizeof($affaire) == 0 && Auth::user()->role!='Client')
            <div class="btn-group">
                <a  href="{{ route('createAffaire') }}" class="cl-white theme-bg btn  btn-rounded" title="Creer une Affaire">
                    <i class="ti-wand"></i>
                    Creer une affaire
                </a>
            </div>
            @endif
        </div>

    </div>
    <!-- Title & Breadcrumbs-->

    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">

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
                                <th style="width: 50px">N°</th>
                                <th>Affaires</th>
                                <th>Client</th>
                                <th>Type d'affaire</th>
                                <th >Date de creation</th>
                                <th style="width: 100px">Action</th>
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
                                        {{ $row->nomAffaire }}
                                    </a>
                                </td>
                                <td>
                                    <a class="load" href="{{ route('showAffaire', [$row->idAffaire,$row->slug]) }}">
                                        {{ $row->prenom }}
                                        {{ $row->nom }}
                                        {{ $row->denomination }}
                                    </a>
                                </td>
                                <td>
                                    {{ $row->type }}
                                </td>
                                <td>
                                    {{ $row->created_at }}
                                </td>
                               

                                <td>
                                    <a href="{{ route('showAffaire', [$row->idAffaire,$row->slug]) }}" class="settings" title="Information" ><i class="fa fa-arrow-right"></i></a>
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
<!-- /.row -->
 

<script>
    document.getElementById('aff').classList.add('active');
</script>

@endsection