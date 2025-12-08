@extends('layouts.base')
@section('title','Liste des clients')
@section('content')
<style>
/* Carte */
.client-card {
    background: #ffffff;
    border: 1px solid #e6eaf0;
    border-radius: 10px;
    padding: 1rem;
    transition: all 0.25s ease;
    position: relative;
}

.client-card:hover {
    border-color: #009CAA;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    background: linear-gradient(180deg, #ffffff, #f9fbfc);
}

/* Ligne haute */
.client-top {
    padding-bottom: 0.6rem;
    margin-bottom: 0.6rem;
    border-bottom: 1px dashed #e5e7eb;
}

/* Icône */
.client-icon {
    width: 38px;
    height: 38px;
    background: #009CAA;
    color: #fff;
    border-radius: 8px;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

/* Titre */
.client-title {
    font-size: 0.92rem;
    font-weight: 600;
    color: #111827;
}

.client-type {
    font-size: 0.7rem;
    color: #6b7280;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

/* Flèche */
.client-arrow {
    font-size: 0.8rem;
    color: #9ca3af;
    transition: transform 0.25s ease;
}

.client-card:hover .client-arrow {
    transform: translateX(3px);
}

/* Infos */
.client-info {
    font-size: 0.8rem;
    color: #4b5563;
    display: grid;
    row-gap: 5px;
}

.client-info div {
    display: flex;
    align-items: center;
    gap: 8px;
}

.client-info i {
    color: #009CAA;
    font-size: 13px;
}

/* Lien */
a.load {
    text-decoration: none;
    color: inherit;
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
                Consultez et gérez la liste complète des clients enregistrés dans le cabinet.
            </small>
        </div>
    </div>

    <!-- Bloc droit : boutons d’action -->
    <div class="d-flex align-items-center flex-wrap gap-2">
        <a href="{{ route('clientListe') }}" class="btn btn-outline-primary-custom me-2" title="Vue en liste">
            <i class="ti-flix ti-view-list-alt"></i>
        </a>
        &nbsp;
        <a href="{{ route('clientForme') }}" class="btn btn-gradient-custom shadow-sm btn-rounded" title="Ajouter un client">
            <i class="fa fa-plus-circle me-1"></i> Enregistrer un client
        </a>
    </div>

</div>

    <!-- Title & Breadcrumbs-->
   
        <div class="paginate 1">
            <div class="items row">
                        <!-- Single Service Box -->
            @foreach ($client as $value)
            <div class="col-md-4 col-sm-6 mb-3">
                <a class="load text-decoration-none" href="{{ route('clientInfos', [$value->idClient,$value->slug]) }}">
                    <div class="client-card">

                        <!-- Ligne haute : Icône + Titre -->
                        <div class="client-top d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="client-icon">
                                    @if($value->typeClient =="Client Physique")
                                        <i class="fa fa-user"></i>
                                    @else
                                        <i class="fa fa-building"></i>
                                    @endif
                                </div>

                                <div class="client-title-wrapper">
                                    @if($value->typeClient =="Client Physique")
                                        <div class="client-title">
                                            {{ $value->idClient }} – {{ $value->prenom }} {{ $value->nom }}
                                        </div>
                                    @else
                                        <div class="client-title">
                                            {{ $value->idClient }} – {{ $value->denomination }}
                                        </div>
                                    @endif
                                    <div class="client-type">
                                        {{ $value->typeClient }}
                                    </div>
                                </div>
                            </div>

                            <i class="fa fa-chevron-right client-arrow"></i>
                        </div>

                        <!-- Infos -->
                        <div class="client-info">
                            @if($value->typeClient =="Client Physique")
                                <div><i class="fa fa-map-marker-alt"></i> {{ $value->adresse }}</div>
                                <div><i class="fa fa-envelope"></i> {{ $value->email }}</div>
                                <div><i class="fa fa-phone"></i> {{ $value->telephone }}</div>
                            @else
                                <div><i class="fa fa-map-marker-alt"></i> {{ $value->adresseEntreprise }}</div>
                                <div><i class="fa fa-envelope"></i> {{ $value->emailEntreprise }}</div>
                                <div><i class="fa fa-phone"></i> {{ $value->telephoneEntreprise }}</div>
                            @endif
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
    document.getElementById('clt').classList.add('active');
</script>
@endsection