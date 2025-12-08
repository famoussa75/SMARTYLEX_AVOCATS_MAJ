@extends('layouts.base')
@section('title','Les affaires')
@section('content')

<style>
.erp-card {
    background: #ffffff;
    border: 1px solid #e6eaef;
    border-radius: 10px;
    padding: 0.9rem;
    height: 100%;
    transition: all 0.25s ease;
}

.erp-card:hover {
    border-color: #009CAA;
    background: #fbfefe;
}

/* Header */
.erp-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 0.8rem;
}

/* Icône */
.erp-icon {
    min-width: 42px;
    height: 42px;
    border-radius: 8px;
    background: rgba(0, 156, 170, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #009CAA;
    font-size: 18px;
}

/* Titres */
.erp-client {
    font-size: 0.87rem;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.3;
}

.erp-subtitle {
    font-size: 0.78rem;
    color: #6b7280;
}

/* Footer */
.erp-footer {
    padding-top: 0.5rem;
    border-top: 1px dashed #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #009CAA;
}

.erp-footer i {
    font-size: 0.8rem;
}
</style>


<div class="container-fluid @if(Auth::user()->role=='Client') bg-secondary @else @endif">
    <!-- Title & Breadcrumbs-->
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper">
                <i class="ti ti-briefcase"></i>
            </div>
            <div>
                <h4 class="page-title">
                    Affaires <span class="page-subtitle">› Liste des affaires</span>
                </h4>
                <small class="page-description">Gérez toutes les affaires juridiques enregistrées.</small>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <a href="{{ route('affaireListe') }}" class="btn btn-outline-primary-custom me-2" title="Vue liste">
                <i class="ti ti-view-list-alt"></i>
            </a>&nbsp;
            <a href="{{ route('createAffaire') }}" class="btn btn-gradient-custom" title="Créer une affaire">
                <i class="ti ti-plus me-1"></i> Nouvelle affaire
            </a>
        </div>
    </div>

   
    @if (sizeof($affaire) == 0 && Auth::user()->role=='Client')
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div class="text-center">
            <span>Aucune affaire disponible... </span>
        </div>
    </div><br />
    @endif

    @if (sizeof($affaire) == 0 && Auth::user()->role!='Client')

    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div class="text-center">
            <span>Vous avez aucune affaire, cliquer <a class="load" href="{{ route('createAffaire') }}" style="color:blue">ici pour en ajouter
                    un !</a> </span>
        </div>
    </div><br />

    @endif

   
    <div class="paginate 1">
        <div class="items row">
        @foreach ($affaire as $affaires)
        <div class="col-md-4 col-sm-6 mb-3">
            <a href="{{ route('showAffaire', [$affaires->idAffaire, $affaires->slug]) }}" class="text-decoration-none">
                <div class="erp-card">

                    <!-- En-tête -->
                    <div class="erp-header">
                        <div class="erp-icon">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div class="erp-title">
                            <div class="erp-client">
                                {{ $affaires->idClient }} – {{ $affaires->prenom }} {{ $affaires->nom }} {{ $affaires->denomination }}
                            </div>
                            <div class="erp-subtitle">
                                {{ $affaires->nomAffaire }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="erp-footer">
                        <span class="erp-link">
                            Ouvrir l’affaire
                        </span>
                        <i class="ti ti-chevron-right"></i>
                    </div>

                </div>
            </a>
        </div>

        @endforeach

        </div>
        <div class="pager">
            <div class="firstPage">&laquo;</div>
            <div class="previousPage">&lsaquo;</div>
            <div class="pageNumbers"></div>
            <div class="nextPage">&rsaquo;</div>
            <div class="lastPage">&raquo;</div>
        </div>
    </div>



</div>
<script>
    document.getElementById('aff').classList.add('active');
</script>


@endsection