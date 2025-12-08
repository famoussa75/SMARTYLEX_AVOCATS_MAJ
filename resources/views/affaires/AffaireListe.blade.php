@extends('layouts.base')
@section('title','Liste des affaires')
@section('content')


<div class="container-fluid">

    <!-- Title & Breadcrumbs -->
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        <!-- Bloc gauche : icône + titre -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper theme-bg">
                <i class="ti-bag"></i>
            </div>
            <div class="ms-2">
                <h4 class="page-title mb-1">
                    Affaires
                    <span class="page-subtitle">
                      › Liste des affaires
                    </span>
                </h4>
                <small class="page-description text-secondary">
                    Consultez, créez et gérez l’ensemble des affaires enregistrées dans le système.
                </small>
            </div>
        </div>

        <!-- Bloc droit : boutons d’action -->
        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="javascript:history.back()" class="btn btn-outline-primary-custom me-2" title="Retour">
                <i class="ti-flix ti-layout-grid2"></i>
            </a>

            @if (sizeof($affaire) == 0 && Auth::user()->role!='Client')
            <a href="{{ route('createAffaire') }}" class="btn btn-gradient-custom shadow-sm btn-rounded" title="Créer une affaire">
                <i class="ti-wand me-1"></i> Créer une affaire
            </a>
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
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($affaire as $row)
                            <tr onclick="window.location='{{ route('showAffaire', [$row->idAffaire, $row->slug]) }}'" style="cursor:pointer;">
                                <td>
                                    {{ $row->idAffaire }}
                                </td>
                                <td>
                                    {{ $row->nomAffaire }}
                                </td>
                                <td>
                                        {{ $row->prenom }}
                                        {{ $row->nom }}
                                        {{ $row->denomination }}
                                </td>
                                <td>
                                    {{ $row->type }}
                                </td>
                                <td>
                                    {{ $row->created_at }}
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