@extends('layouts.base')
@section('title','Liste des clients')
@section('content')

<style>
/* Card principale */
.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-top: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Table */
table.filterTable {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.95rem;
}

/* En-tête */
table.filterTable thead tr {
    background-color: #009CAA; /* couleur unique */
    color: white;
    text-align: left;
    font-weight: 600;
}

/* Ligne de tableau */
table.filterTable tbody tr {
    transition: all 0.3s ease;
    cursor: pointer;
}

table.filterTable tbody tr:hover {
    background-color: rgba(0, 156, 170, 0.1);
}

/* Cellules */
table.filterTable td {
    padding: 12px 10px;
    vertical-align: middle;
}

/* Liens */
.filterTable a.load {
    color: #009CAA;
    text-decoration: none;
    transition: color 0.3s;
}

.filterTable a.load:hover {
    color: #D7AE00;
    text-decoration: underline;
}

/* Action icon */
.filterTable td i.fa-info-circle {
    color: #D7AE00;
    font-size: 1.2rem;
    transition: color 0.3s;
}

.filterTable td i.fa-info-circle:hover {
    color: #009CAA;
}

/* Filtre catégorie */
.category-filter {
    margin-bottom: 15px;
    max-width: 200px;
}

.categoryFilter {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 6px 12px;
}

/* Scrollbar si nécessaire */
.table-responsive::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #D7AE00;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
}
</style>

<div class="container-fluid">
    <!-- Title & Breadcrumbs -->
<div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

    <!-- Bloc gauche : titre + icône -->
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="icon-wrapper theme-bg">
            <i class="fa fa-users"></i>
        </div>
        <div class="ms-2">
            <h4 class="page-title mb-1">
                Clients
                <span class="page-subtitle">› Liste des clients</span>
            </h4>
            <small class="page-description text-secondary">
                Gérez vos clients, consultez leurs informations et ajoutez de nouveaux contacts.
            </small>
        </div>
    </div>

    <!-- Bloc droit : actions -->
     <div class="col">
        
     </div>
    <div class="d-flex align-items-center flex-wrap gap-2">
        <a href="{{ route('allClient') }}" class="cl-whitebtn btn-gradient-custom shadow-sm btn-rounded  tooltips">
            <i class="ti-flix ti-layout-grid2"></i>
        </a>
        &nbsp;
        <a href="{{ route('clientForme') }}" class="btn btn-gradient-custom shadow-sm btn-rounded" title="Enregistrer un client">
            <i class="fa fa-plus-circle me-1"></i> Enregistrer un client
        </a>
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
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($client as $row)
                                <a class="load" href="{{route('clientInfos', [$row->idClient,$row->slug])}}">
                                <tr onclick="window.location='{{route('clientInfos', [$row->idClient,$row->slug])}}'" style="cursor:pointer;">
                                    <td>
                                        {{ $row->idClient }}
                                    </td>
                                    <td>
                                        {{ $row->typeClient }}
                                    </td>
                                    @if($row->typeClient=='Client Physique')
                                    <td>
                                       
                                            {{ $row->prenom  }} {{ $row->nom }}
                                        </a>
                                    </td>
                                    <td>
                                        <p>{{ $row->adresse }}</p>
                                        <p>{{ $row->email }}</p>
                                        <p>{{ $row->telephone }}</p>
                                    </td>
                                    @else
                                    <td>
                                        {{ $row->denomination  }}
                                    </td>
                                    <td>
                                        <p>{{ $row->adresseEntreprise }}</p>
                                        <p>{{ $row->emailEntreprise }}</p>
                                        <p>{{ $row->telephoneEntreprise }}</p>
                                    </td>
                                    @endif
                                   

                                </tr>
                                </a>
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