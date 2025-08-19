@extends('layouts.base')
@section('title','Liste Courriers - Départ')
@section('content')
<div class="container-fluid">
    @php
    setlocale(LC_TIME, 'fr_FR');
    @endphp
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers - Départ > <span class="label bg-info"><b>Liste</b></span></h4>
        </div>
        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('createCourierDepart') }}" title="Créer un courier depart"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="ti-wand"></i>&nbsp;&nbsp;Créer un Courriers - Départ
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
                        <option value="Transmis">Transmis</option>
                        <option value="Approuvé">Approuvé</option>
                        <option value="Terminé">Terminé</option>
                        <option value="Désapprouvé">Désapprouvé</option>
                        <option value="Annulé">Annulé</option>


                    </select>
                </div>
                <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 10px;">N°</th>
                            <th style="width: 100px;">Date du courrier</th>
                            <th>Destinataire</th>
                            <th>Objet</th>
                            <th>Statut</th>
                            <th style="text-align: center;">Voir / Suppr</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($couriers as $row)
                            @if($row->statut=='Annulé')
                            <tr class="bg-danger-light">
                                <td>
                                    {{ $row->numCourier }}
                                </td>

                                <td>
                                    @if(empty($row->dateCourier))
                                        <small>N/A</small>
                                    @else
                                         {{ date('d-m-Y', strtotime($row->dateCourier)) }}
                                    @endif
                                   
                                </td>
                                <td style="text-align:center ;">

                                    <span class="pull-right-container">
                                        <small class="label" style="color:black">{{ $row->destinataire }}</small>
                                    </span>

                                </td>
                                <td><a href="#">{{ $row->objet }}</td>
                                <td>
                                    @if ($row->statut == 'Envoyé')
                                    <div class="label cl-info bg-info-light">{{ $row->statut }}
                                        <div>
                                            @elseif($row->statut == 'Transmis')
                                            <div class="label cl-warning bg-warning-light">{{ $row->statut }}
                                                <div>
                                                    @elseif($row->statut == 'Approuvé')
                                                    <div class="label cl-primary bg-primary-light">
                                                        {{ $row->statut }}
                                                        <div>
                                                            @elseif($row->statut == 'Terminé')
                                                            <div class="label bg-success">{{ $row->statut }}
                                                                <div>
                                                                    @elseif($row->statut == 'Désapprouvé')
                                                                    <div class="label bg-danger">{{ $row->statut }}
                                                                        <div>
                                                                            @else
                                                                            <div class="label bg-default">
                                                                                {{ $row->statut }}
                                                                                <div>
                                                                                    @endif
                                <td style="text-align: center;width:100px">
                                    <a class="" href="{{ route('infoCourierDepart', [$row->slug]) }}" title="Information"
                                        data-toggle="tooltip"><i class="fa fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @elseif($row->confidentialite=='on' && Auth::user()->role!='Administrateur')
                            <tr class="bg-warning-light">
                                <td style="font-style:italic">{{ $row->numCourier }}</td>

                                <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                <td style="text-align:center ;font-style:italic"><span>Confidentiel</span></td>
                                <td></td>
                            </tr>
                            @else
                            <tr>
                                <td>
                                @if($row->confidentialite=='on')<i class="fa fa-lock" style="font-size:11px"></i>@endif {{ $row->numCourier }}
                                </td>

                                <td>
                                     @if(empty($row->dateCourier))
                                        <small>N/A</small>
                                    @else
                                         {{ date('d-m-Y', strtotime($row->dateCourier)) }}
                                    @endif
                                </td>
                                <td style="text-align:center ;">

                                    <span class="">
                                        <small class="label" style="color:black">{{ $row->destinataire }}</small>
                                    </span>


                                </td>
                                <td><a href="{{ route('infoCourierDepart', [$row->slug]) }}">{{ $row->objet }}</a></td>
                                <td>
                            
                                    @if ($row->statut == 'Envoyé')
                                        <div class="label cl-info bg-info-light">{{ $row->statut }}</div>
                                    @elseif($row->statut == 'Transmis')
                                        <div class="label cl-warning bg-warning-light">{{ $row->statut }}</div>
                                    @elseif($row->statut == 'Approuvé')
                                        <div class="label cl-primary bg-primary-light">{{ $row->statut }}</div>
                                    @elseif($row->statut == 'Terminé')
                                        <div class="label bg-success">{{ $row->statut }}</div>
                                    @elseif($row->statut == 'Désapprouvé')
                                        <div class="label bg-danger">{{ $row->statut }}</div>
                                    @else
                                        <div class="label bg-default">{{ $row->statut }}</div>
                                    @endif
                                </td>
                                <td style="text-align: center;width:100px">
                                    <a class="" href="{{ route('infoCourierDepart', [$row->slug]) }}" title="Information"><i class="fa fa-arrow-right"></i></a>
                                    <a class="" href="" data-toggle="modal" id="{{ $row->slug }}"
                                        data-target="#deleteCourierDepart"
                                        onclick="var slug= this.id ; deleteCourierDepart(slug)" title="Supprimer"
                                        style="color:red"><i class="ti-trash"></i></a>
                                </td>
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

<div class="add-popup modal fade" id="deleteCourierDepart" tabindex="-1" role="dialog"
    aria-labelledby="deleteCourierDepart">
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
            <form method="post" action="{{route('deleteCourierDepart')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment annuler ce courrier ?</p>
                    <input type="hidden" id="slugCourier2" name="slug">

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