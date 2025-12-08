@extends('layouts.base')
@section('title','Liste du personnel')
@section('content')
<div class="container-fluid">

<div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

    <!-- Bloc gauche : icône + titre -->
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="icon-wrapper theme-bg">
            <i class="fa fa-users"></i>
        </div>
        <div class="ms-2">
            <h4 class="page-title mb-1">
                RH
                <span class="page-subtitle text-muted">› Personnels ayant un compte utilisateur</span>
            </h4>
            <small class="page-description text-secondary">
                Consultez et gérez les personnels disposant d’un compte utilisateur.
            </small>
        </div>
    </div>

    <!-- Bloc droit : boutons d’action -->
    <div class="d-flex align-items-center flex-wrap gap-2">
        <a href="{{ route('allPersonnel') }}" 
        class="btn btn-outline-primary-custom shadow-sm" 
        title="Liste des personnels">
            <i class="ti-flix ti-view-list-alt"></i>
        </a>
        &nbsp;
        <a href="{{ route('formPersonnel') }}" 
        class="btn btn-gradient-custom shadow-sm" 
        title="Ajouter un personnel">
            <i class="fa fa-plus me-1"></i> Ajouter un personnel
        </a>
    </div>

</div>

    <!-- Title & Breadcrumbs-->

    <!-- All Contact List -->
    <div class="row">
        <!-- Single Contact List -->

        @foreach ($personnel as $personne)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="user-status-card {{ $personne->statut == 'bloquer' ? 'is-blocked' : 'is-active' }}">

                <!-- Header -->
                <div class="card-header d-flex align-items-center">
                    <img src="/{{ $personne->photo }}"
                        alt="{{ $personne->nom }}"
                        class="status-avatar">

                    <div class="ml-3">
                        <h6 class="mb-0 font-weight-bold">
                            {{ $personne->prenom }} {{ $personne->nom }}
                        </h6>
                        <small class="text-muted">
                            {{ $personne->email }}
                        </small>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card-footer bg-transparent border-0 pt-2">

                    <a href="{{ route('infosPersonne', [$personne->slug]) }}"
                    class="btn btn-sm btn-info btn-rounded mr-1">
                        <i class="ti-eye"></i> Profil
                    </a>

                    @if(Auth::user()->role == 'Administrateur')
                        @if($personne->statut == 'bloquer')
                            <a href="{{ route('deblockPersonnel', [$personne->email]) }}"
                            class="btn btn-sm btn-outline-success btn-rounded">
                                <i class="ti-check-box"></i> Débloquer
                            </a>
                        @else
                            <a href="{{ route('blockPersonnel', [$personne->email]) }}"
                            class="btn btn-sm btn-danger btn-rounded">
                                <i class="ti-na"></i> Bloquer
                            </a>
                        @endif
                    @endif

                </div>

            </div>
        </div>

        @endforeach
    </div>
    <!-- End All Contact List -->

</div>

<style>
    .user-status-card {
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
    border-left: 6px solid transparent;
    transition: transform .2s ease, box-shadow .2s ease;
}

.user-status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0,0,0,.12);
}

/* Statuts */
.user-status-card.is-active {
    border-left-color: #28a745;
}

.user-status-card.is-blocked {
    border-left-color: #dc3545;
}

/* Header */
.user-status-card .card-header {
    background: transparent;
    border: none;
    padding: 16px;
}

.status-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e5e7eb;
}

/* Footer */
.user-status-card .card-footer .btn {
    font-size: 0.8rem;
    padding: 6px 14px;
}

</style>

<script>
    document.getElementById('rh').classList.add('active');
</script>
@endsection