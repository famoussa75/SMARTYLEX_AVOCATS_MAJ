@extends('layouts.base')
@section('title','Les affaires')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti-bag"></i> Mes affaires</h4>
        </div>
        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <a class="load" href="{{ route('affaireListeCollab') }}" class="btn  tooltips">
                    <i class="ti-flix ti-view-list-alt"></i>
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('createAffaire') }}" class="cl-white theme-bg btn  btn-rounded" title="Creer une Affaire">
                    <i class="ti-wand"></i>
                    Creer une affaire
                </a>
            </div>
       
        </div>

    </div>
    <!-- Title & Breadcrumbs-->
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
            <div class="col-md-4 col-sm-6">
                <div class="card outline-primary mb-3 text-center" style="height: 10em;">
                    <a class="theme-cl" href="{{ route('showAffaire', [$affaires->idAffaire,$affaires->slug]) }}">
                        <div class="card-detail-block">
                            <i class="ti ti-bag theme-cl" style="font-size: 20px;"></i>
                            <blockquote class="card-detail-blockquote">
                                <h6 style="text-transform: uppercase;">
                                    <b style="font-family: Gill Sans, sans-serif; ">
                                        {{ $affaires->idClient }} - {{ $affaires->prenom }}
                                        {{ $affaires->nom }} {{ $affaires->denomination }}
                                        - {{ $affaires->nomAffaire }}
                                    </b>
                                </h6>

                            </blockquote>
                        </div>
                    </a>
                </div>
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