@extends('layouts.base')
@section('title','Liste Courriers - Arrivée')
@section('content')
<div class="container-fluid">
@php
setlocale(LC_TIME, 'fr_FR');
@endphp
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers - Arrivée > <span class="label bg-info"><b>Liste</b></span></h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a  href="{{ route('createCourierArriver') }}" class="cl-white theme-bg btn  btn-rounded" title="Ajouter un personnel">
                    <i class="ti-wand"></i> Créer un Courrier - Arrivée
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="category-filter">
                            <select id="categoryFilter" class="categoryFilter form-control">
                                <option value="">Tous</option>
                                <option value="Reçu">Reçu</option>
                                <option value="Lu">Lu</option>
                                <option value="En Traitement">En traitement</option>
                                <option value="Traité">Traité</option>
                                <option value="Classé">Classé</option>
                                <option value="Annulé">Annulé</option>

                            </select>
                        </div>
                        <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">N°</th>
                                    <th>Expéditeur</th>
                                    <th style="width: 100px;">Date du courrier</th>
                                    <th>Objet</th>
                                    <th>Statut</th>
                                    <th style="width: 100px;text-align:center">Voir / Suppr</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($couriers as $row)

                                @if($row->confidentialite=='on' && Auth::user()->role!='Administrateur')
                                <tr class="bg-warning-light">
                                    <td style="font-style:italic">{{ $row->numero }}</td>

                                    <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                    <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                    <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                    <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                    <td></td>
                                </tr>
                                @else
                                
                                <tr class="@if($row->statut=='Annulé') bg-danger-light @else @endif">
                                    <td>
                                    @if($row->confidentialite=='on')<i class="fa fa-lock" style="font-size:11px"></i>@endif {{ $row->numero }}
                                    </td>
                                    <td>
                                            {{ $row->expediteur }}
                                    </td>
                                    <td>
                                        @if(empty($row->dateCourier))
                                            <small>N/A</small>
                                        @else
                                            {{ date('d-m-Y', strtotime($row->dateCourier))}}
                                        @endif
                                        <!-- {{ date('d-m-Y', strtotime($row->dateCourier))}} -->
                                    </td>

                                    <td><a  href="{{ route('detailCourierArriver', [$row->slug]) }}">{{ $row->objet }}</a></td>
                                    <td style="text-align:center ;">
                                        @if($row->statut=='Lu')
                                        <div class="label  bg-warning">{{ $row->statut }}</div>
                                        @elseif($row->statut=='Reçu')
                                        <div class="label bg-primary">{{ $row->statut }}</div>
                                        @elseif($row->statut=='En Traitement')
                                        <div class="label bg-info">{{ $row->statut }}</div>
                                        @elseif($row->statut=='Annulé')
                                        <div class="label bg-default">{{ $row->statut }}</div>
                                        @elseif($row->statut=='Traitement annulé')
                                        <div class="label bg-danger">{{ $row->statut }}</div>
                                        @else
                                        <div class="label bg-success">{{ $row->statut }}</div>
                                        @endif
                                    </td>
                                    @if($row->statut=='Annulé')
                                        <td style="text-align: center;">
                                            <a   href="{{ route('detailCourierArriver', [$row->slug]) }}"  title="Information" data-toggle="tooltip"><i class="fa fa-arrow-right"></i></a>  
                                        </td>
                                    @else 
                                        <td style="text-align: center;">
                                            <a   href="{{ route('detailCourierArriver', [$row->slug]) }}"  title="Information" data-toggle="tooltip"><i class="fa fa-arrow-right"></i></a>  
                                            <a  href=""  data-toggle="modal" id="{{ $row->slug }}" data-target="#deleteCourierArriver" onclick="var slug= this.id ; deleteCourierArriver(slug)"  title="Annulé"  style="color:red"><i class="ti-trash"></i></a>
                                        </td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
</div>
<!-- /.row -->

<div class="add-popup modal fade" id="deleteCourierArriver" tabindex="-1" role="dialog" aria-labelledby="deleteCourierArriver">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gray;">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez l'annulation</h4>
            </div>
            <form  method="post" action="{{route('deleteCourierArriver')}}" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment annuler ce courrier ?</p>
                    <input type="hidden" id="slugCourier" name="slug">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn " data-dismiss="modal" aria-label="Close">
                                NON
                            </a>

                            <button type="submit" class="btn btn-danger">OUI</button>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('cr').classList.add('active');
</script>
@endsection