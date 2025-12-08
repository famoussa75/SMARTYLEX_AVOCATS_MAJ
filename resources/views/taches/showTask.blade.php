@extends('layouts.base')
@section('title','Liste des tâches')
@section('content')

<style>
/* Card principale */
.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-top: 30px;
    display: grid;
    min-height: 70vh;
    transition: all 0.3s ease;
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
    border-radius: 10px;
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

/* Statut */
.label {
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.85rem;
    color: white;
    display: inline-block;
    text-align: center;
}

/* Couleurs statuts */
.label.validée {
    background-color: #28a745; /* vert */
}
.label.en-cours {
    background-color: #17a2b8; /* bleu clair */
}
.label.suspendu {
    background-color: #6c757d; /* gris */
}
.label.hors-delais {
    background-color: #dc3545; /* rouge */
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

<div class="container-fluid" >

   
<!-- Title & Breadcrumbs -->
<div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

    <!-- Bloc gauche : icône + titre -->
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="icon-wrapper theme-bg">
            <i class="ti i-cl-0 ti-layers"></i>
        </div>
        <div class="ms-2">
            <h4 class="page-title mb-1">
                Tâches
                <span class="page-subtitle">
                › Liste des tâches
                </span>
            </h4>
            <small class="page-description text-secondary">
                Visualisez et gérez toutes les tâches créées dans le système.
            </small>
        </div>
    </div>

    <!-- Bloc droit : bouton d’action -->
    @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant")
        <div class="d-flex align-items-center">
            <a href="{{ route('taskForm', [$idAffaire='x','all']) }}" 
               class="btn btn-gradient-custom shadow-sm" 
               title="Créer une tâche">
               <i class="fa fa-plus me-1"></i> Créer une Tâche
            </a>
        </div>
    @endif

</div>


    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">

        <div class="table-responsive">
            <div class="category-filter">
                <select id="categoryFilter" class="categoryFilter form-control">
                    <option value="">Tous</option>
                    <option value="validée">Validée</option>
                    <option value="En cours">En cours</option>
                    <option value="suspendu">Suspendu</option>
                    <option value="Hors Délais">Hors Délais</option>
                </select>
            </div>
            <table id="filterTable" class=" filterTable dataTableExport table table-bordered table-hover"
                style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Tâche</th>
                        <th scope="col">Affaire</th>
                        <th scope="col">Date début</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Statut</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($taches as $row)
                    <tr onclick="window.location='{{ route('infosTask', [$row->slug]) }}'" style="cursor:pointer;">
                        <td scope="col">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col">{{ $row->titre }}</td>
                        @if(is_null($row->idAffaire))
                        <td scope="col">Cabinet</td>
                        @else
                        <td scope="col">{{ $row->idClient }} - {{ $row->prenom }} {{ $row->nom }} {{ $row->denomination }} - {{ $row->nomAffaire }}</td>

                        @endif
                        
                        <td scope="col">{{ $row->dateDebut ? date('d-m-Y', strtotime($row->dateDebut)) : 'N/A' }}</td>
                        <td scope="col">{{ $row->dateFin ? date('d-m-Y', strtotime($row->dateFin)) : 'N/A' }}</td>

                        <td scope="col">
                        @if($row->statut =='validée')
                            <div class="label validée">{{ $row->statut }}</div>
                        @elseif($row->statut =='En cours')
                            <div class="label en-cours">{{ $row->statut }}</div>
                        @elseif($row->statut =='suspendu')
                            <div class="label suspendu">{{ $row->statut }}</div>
                        @else
                            <div class="label hors-delais">{{ $row->statut }}</div>
                        @endif

                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

<script>
    document.getElementById('tch').classList.add('active');
</script>

<!-- /.row -->
@endsection