@extends('layouts.base')
@section('title','Liste des clients')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

            <h4 class="theme-cl"> <i class="fa fa-users"></i>&nbsp;&nbsp;Clients > <span class="label bg-info"><b>Liste des clients</b></span></h4>
        </div>
        <div class="col-md-7 text-right">
             <div class="btn-group mr-lg-2 ">
                <a  href="{{ route('clientListe') }}" class="cl-white theme-bg btn tooltips">
                    <i class="ti-flix ti-view-list-alt"></i>
                </a>
            </div>
            <div class="btn-group">
                <a  href="{{ route('clientForme') }}" class="cl-white theme-bg btn  btn-rounded" title="Ajouter clients">
                    <i class="fa fa-plus-circle"></i> Enregistrer un client
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->
   
    <div class="paginate 1">
        <div class="items row">
            <!-- Single Service Box -->
            @foreach ($client as $value)
            <div class=" col-md-4 col-sm-6">
                <a class="load" href="{{ route('clientInfos', [$value->idClient,$value->slug]) }}">
                    <div class=" service-box box-icon" style="height: 20em;">
                        <div class="round-icon-box theme-bg">
                            @if($value->typeClient =="Client Physique")
                            <i class="fa fa-user"></i>
                            @else
                            <i class="fa fa-home"></i>
                            @endif
                        </div>
                       
                        @if($value->typeClient =="Client Physique")
                        <div class="service-box-heading">
                            <h4>{{$value->idClient}} - {{ $value->prenom  }} {{ $value->nom}}</h4>
                        </div>
                        <div class="service-box-content">
                            <p>adresse : {{ $value->adresse }}</p>
                            <p>E-mail : {{ $value->email }}</p>
                            <p>Contact : {{ $value->telephone}}</p>
                        </div>
                        @else
                        <div class="service-box-heading">
                            <h4>{{$value->idClient}} - {{ $value->denomination  }}</h4>
                        </div>
                        <div class="service-box-content">
                            <p>adresse : {{ $value->adresseEntreprise }}</p>
                            <p>E-mail : {{ $value->emailEntreprise }}</p>
                            <p>Contact : {{ $value->telephoneEntreprise}}</p>
                        </div>
                        @endif
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