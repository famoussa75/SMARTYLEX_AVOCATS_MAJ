@extends('layouts.base')
@section('title','Fichiers')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-file"></i> Gestion des fichiers clients</h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a class="load" href="{{ route('formeFiles') }}" class="cl-white theme-bg btn btn-rounded" title="Nouvelle jointure">
                    <i class="fa fa-plus"></i>
                    Nouvelle jointure
                </a>
            </div>
        </div>
    </div>
   
    <!-- Title & Breadcrumbs-->
    <div class="row">
        @foreach ($files as $data )
        <div class="col-md-3 col-sm-6">
            <div class="widget simple-widget">
                <div class="rwidget-caption info">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($affaire as $af )

                            <a class="load" href="{{ route('showAffaire', [$af->id,$af->slug]) }}" data-toggle="tooltip" data-placement="top" title="cliquer pour ouverture"><i style="font-size: 4em; font-weight: bold" class="cl-warning icon ti-folder"></i></a>
                            <br>
                            @endforeach
                            <div class="widget-detail">
                                <H6><span>{{ $data->filename }}</span></H6>
                                <span>Ajouter le, {{ date('d-m-Y', strtotime($data->created_at)) }}</span> <br>
                                <span style="font-size: 14px; font-weight: bold"> Client : {{ $data->prenom }}
                                    {{ $data->nom }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection