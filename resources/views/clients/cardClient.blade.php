@extends('layouts.base')
@section('title','Liste des clients')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
        <h4 class="theme-cl"> <i class="fa fa-users"></i>&nbsp;&nbsp;Clients > <span class="label bg-info"><b>Liste des clients</b></span></h4>
        </div>
        <div class="col-md-7 text-right">
                 <a href="{{ route('allClient') }}" class="cl-white theme-bg btn  tooltips">
                    <i class="ti-flix ti-layout-grid2"></i>
                </a>
            <div class="btn-group">
                <a  href="{{ route('clientForme') }}" class="cl-white theme-bg btn  btn-rounded" title="Enregistrer un client">
                    <i class="fa fa-plus-circle"></i> Enregistrer un client
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
                                    <th>Type de client</th>
                                    <th>Prenom & Nom / Denomination</th>
                                    <th>Coordoonées</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($client as $row)
                                <tr>
                                    <td>
                                        {{ $row->idClient }}
                                    </td>
                                    <td>
                                        {{ $row->typeClient }}
                                    </td>
                                    @if($row->typeClient=='Client Physique')
                                    <td>
                                        <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}">
                                            {{ $row->prenom  }} {{ $row->nom }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}">
                                            <p>{{ $row->adresse }}</p>
                                            <p>{{ $row->email }}</p>
                                            <p>{{ $row->telephone }}</p>
                                        </a>
                                    </td>
                                    @else
                                    <td>
                                        <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}">
                                            {{ $row->denomination  }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}">
                                            <p>{{ $row->adresseEntreprise }}</p>
                                            <p>{{ $row->emailEntreprise }}</p>
                                            <p>{{ $row->telephoneEntreprise }}</p>
                                        </a>
                                    </td>
                                    @endif
                                    <td style="text-align:center;">
                                        <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}" class="settings" title="Information" data-toggle="tooltip"><i class="fa fa-info-circle"></i></a>

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
    document.getElementById('clt').classList.add('active');
</script>

@endsection