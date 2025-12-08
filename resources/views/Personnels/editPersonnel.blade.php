@extends('layouts.base')
@section('title', 'Information')
@section('content')
<div class="container-fluid @if(Auth::user()->role=='Client') bg-secondary @else @endif">

<div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

    {{-- Bloc gauche : Icône + Titre --}}
    <div class="d-flex align-items-center">
        <div class="icon-wrapper me-3">
            <i class="fa fa-key"></i>
        </div>

        <div>
            <h4 class="page-title mb-0">
                Modification du mot de passe
            </h4>
            <small class="page-subtitle text-muted">
                Sécurité du compte
            </small>
        </div>
    </div>

</div>

    <!-- Title & Breadcrumbs-->

    <div class="container">
    <form method="post" action="{{ route('password.update') }}">
        @csrf

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <h5 class="fw-semibold mb-4 text-center">
                            <i class="fa fa-shield-alt me-2 text-success"></i>
                            Sécurisation du compte
                        </h5>

                        <!-- Ancien mot de passe -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">
                                Ancien mot de passe
                            </label>
                            <div class="password-wrapper">
                                <input type="password"
                                       class="form-control form-control-lg"
                                       name="current_password"
                                       id="passwordField"
                                       required>
                                <i class="toggle-password fa fa-eye" data-target="passwordField"></i>
                            </div>
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">
                                Nouveau mot de passe
                            </label>
                            <div class="password-wrapper">
                                <input type="password"
                                       class="form-control form-control-lg"
                                       name="password"
                                       id="passwordField2"
                                       required>
                                <i class="toggle-password fa fa-eye" data-target="passwordField2"></i>
                            </div>
                        </div>

                        <!-- Confirmation -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">
                                Confirmer le mot de passe
                            </label>
                            <div class="password-wrapper">
                                <input type="password"
                                       class="form-control form-control-lg"
                                       name="password_confirmation"
                                       id="passwordField3"
                                       required>
                                <i class="toggle-password fa fa-eye" data-target="passwordField3"></i>
                            </div>
                        </div>

                        <!-- Bouton -->
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="btn btn-primary btn-rounded"
                                    aria-label="Mettre à jour le mot de passe">
                                <i class="fa fa-check me-2" aria-hidden="true"></i>
                                Mettre à jour le mot de passe
                            </button>
                        </div>


                    </div>
                </div>

            </div>
        </div>

    </form>
</div>


</div>
<!-- /.content-wrapper-->

<style>
    .password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 48px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.password-wrapper .form-control:focus {
    border-color: #009CAA;
    box-shadow: 0 0 0 3px rgba(0, 156, 170, 0.15);
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 16px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #9ca3af;
    font-size: 16px;
    transition: color 0.2s ease;
}

.toggle-password:hover {
    color: #009CAA;
}

</style>

<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const input = document.getElementById(icon.dataset.target);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });
</script>


<script>
    document.getElementById('rh').classList.add('active');
</script>



@endsection