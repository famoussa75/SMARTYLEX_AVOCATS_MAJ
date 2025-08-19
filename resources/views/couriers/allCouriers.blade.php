@extends('layouts.base')
@section('title','Tous les courriers')
@section('content')
<div class="container-fluid">
   

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="row card-header">
                    <div class="col-md-5 align-self-center">
                        <h4 class="theme-cl"><i class="fa fa-envelope"></i> Courriers > <span class="label bg-info"><b>Tous les courriers</b></span></h4>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card padd-10">
                        <div class="panel-group accordion-stylist" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h4 class="theme-cl"> Courriers Arrivé</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                                <th style="5px">N°</th>
                                                                <th>Expéditeur</th>
                                                                <th>Date du courrier</th>
                                                                <th>Objet</th>
                                                                <th>Statut</th>
                                                                <th style="width:50px">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($couriersArriver as $row)
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
                                                                      <!-- Mise a jour  -->
                                                                      <td style="text-align: center;">
                                                                        <a   href="{{ route('detailCourierArriver', [$row->slug]) }}"  title="Information" data-toggle="tooltip"><i class="fa fa-arrow-right"></i></a>  
                                                                        @if($row->statut=='Annulé')
                                                                        @else
                                                                        <a  href=""  data-toggle="modal" id="{{ $row->slug }}" data-target="#deleteCourierArriver" onclick="var slug= this.id ; deleteCourierArriver(slug)"  title="Annulé"  style="color:red"><i class="ti-trash"></i></a>
                                                                        @endif
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
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="theme-cl"> Courriers - Départ</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                                <div class="category-filter">
                                                                    <select id="categoryFilter3" class="categoryFilter3 form-control">
                                                                        <option value="">Tous</option>
                                                                        <option value="Transmis">Transmis</option>
                                                                        <option value="Approuvé">Approuvé</option>
                                                                        <option value="Désapprouvé">Désapprouvé</option>
                                                                        <option value="Terminé">Terminé</option>
                                                                        <option value="Annulé">Annulé</option>

                                                                    </select>
                                                                </div>
                                                                <table id="filterTable3" class="filterTable3 dataTableExport table table-bordered table-hover" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:5px">N°</th>
                                                                        <th>Date du courrier</th>
                                                                        <th>Destinataire</th>
                                                                        <th>Objet</th>
                                                                        <th>Statut</th>
                                                                        <th style="width:50px">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($couriersDepart as $row)
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
                                                                                    {{ date('d-m-Y', strtotime($row->dateCourier))}}
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->

  <!-- Mise a jour  -->

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