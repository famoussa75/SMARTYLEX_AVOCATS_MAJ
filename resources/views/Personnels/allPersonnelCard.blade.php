@extends('layouts.base')
@section('title','Liste du personnel')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-users"></i> RH > <span class="label bg-info"><b>Personnels ayant un compte utilisateur</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <a  href="{{ route('allPersonnel') }}" class="cl-white theme-bg btn  tooltips">
                    <i class="ti-flix ti-view-list-alt"></i>
                </a>
            </div>
          
            <div class="btn-group">
                <a  href="{{ route('formPersonnel') }}" class="cl-white theme-bg btn btn-rounded" title="Ajouter un personnel">
                    <i class="fa fa-plus"></i>
                    Ajouter un personnel
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <!-- All Contact List -->
    <div class="row">
        <!-- Single Contact List -->

        @foreach ($personnel as $personne)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="contact-grid-box">
         
                <div class="contact-thumb" >
                    <img src="/{{$personne->photo}}" class="img-circle img-responsive" alt="" style="width: auto; height: 70px; object-fit: cover;">
                </div>

                <div class="contact-detail">
                    <h4>{{ $personne->nom }}</h4>
                    <span><a class="load" href="{{ route('infosPersonne', [$personne->slug]) }}">{{ $personne->email }}</a></span>
                </div>
          
                <div class="text-center mb-3" >
                    <a href="{{ route('infosPersonne', [$personne->slug]) }}"  class="col-half cl-white theme-bg btn btn-rounded"><i class="ti-eye"></i> Voir le
                            Profile

                    </a>
                    &nbsp;&nbsp;
                    @if(Auth::user()->role=='Administrateur')
                        @if($personne->statut=='bloquer')
                        <a href="{{ route('deblockPersonnel', [$personne->email]) }}" class="col-half" >
                            <button type="button" class="btn btn-outline-success btn-rounded"><i class="ti-check-box"></i>Débloquer l'utilisateur</button>
                        </a>
                        @else
                        <a href="{{ route('blockPersonnel', [$personne->email]) }}" class="col-half" >
                            <button type="button" class="btn btn-outline-danger btn-rounded"><i class="ti-na"></i>Bloquer l'utilisateur</button>
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

<script>
    document.getElementById('rh').classList.add('active');
</script>
@endsection