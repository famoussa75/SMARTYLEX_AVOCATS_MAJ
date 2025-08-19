@extends('layouts.base')
@section('title', 'Information')
@section('content')
<div class="container-fluid @if(Auth::user()->role=='Client') bg-secondary @else @endif">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-user"></i> Modification du mot de passe</h4>
        </div>

    </div>
    <!-- Title & Breadcrumbs-->

    <!-- row -->
    <div class="container">
        <form  method="post" action="{{route('password.update')}}">
            @csrf
            <div class="row mrg-0">
                <div class="col-md-12 col-sm-12">
                    <div class="card" style="display:flex;align-items: center;">
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="current_password">Ancien Mot de passe</label><br>
                                <div class="password-container">
                                    <input type="password" class="form-control" name="current_password"  id="passwordField" style="width:50em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                    <i class="pass-view fa fa-eye" id="togglePasswordField"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password">Nouveau Mot de passe</label><br>
                                <div class="password-container">
                                    <input type="password" class="form-control" name="password"  id="passwordField2" style="width:50em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                    <i class="pass-view fa fa-eye" id="togglePasswordField2"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation">Confirmer le nouveau mot de passe</label><br>
                                <div class="password-container">
                                    <input type="password" class="form-control" name="password_confirmation"  id="passwordField3" style="width:50em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                    <i class="pass-view fa fa-eye" id="togglePasswordField3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-12">
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">
                                Valider</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<!-- /.content-wrapper-->

<script>
    document.getElementById('rh').classList.add('active');
</script>



@endsection