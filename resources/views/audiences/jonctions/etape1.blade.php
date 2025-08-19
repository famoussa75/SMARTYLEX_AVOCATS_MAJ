@extends('layouts.base')
@section('title','Etape 1')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Gestion des audiences</h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('addAudience') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une nouvelle procédure
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('createJonctionEtape1') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une jonction
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form class="padd-20" method="post" action="{{ route('createJonctionEtape2') }}" id="formEtape1"
                accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="text-center">
                        @csrf
                    </div>
                    <h2 style="text-align:center">Étape 1</h2><br>
                    <div class="row page-breadcrumbs">
                        <div class="col-4">
                            <div class="form-group">
                                <div class="text-center">
                                    <h3><label for="typeEntreprise" class="active">Juridiction</label></h3>
                                        <select name="juridiction" id="idJuridiction" class="form-select select2" style="width:100%" onchange="audJonction();">
                                        <option value="" selected disabled>-- Choisissez --</option>
                                            @foreach($juriductions as $j)
                                            <option value={{$j->id}}>{{$j->nom}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-8">
                            <div class="form-group">
                                <div class="text-center">
                                    <h3><label for="typeEntreprise" class="active">Sélectionner les audiences à joindre</label></h3>
                                    <select multiple="" name="idAudienceSource[]" class="form-control select2" data-placeholder=" . . ." style="width: 100%;" id="selectJonction" data-error="erre" required>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn  nextBtn  pull-right" type="submit">Suivant <i class="fa fa-arrow-right"></i></button>
                    </div>
            </form>
        </div>
    </div>




</div>
<!-- /.row -->

<script>
document.getElementById('aud').classList.add('active');

</script>
@endsection