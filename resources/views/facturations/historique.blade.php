@extends('layouts.base')
@section('title','Historique des factures')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-7 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-money"></i> Facturation > <span class="label bg-info"><b>Historique</b></span></h4>
        </div>



        <div class="col-md-5 text-right">
            @if(Auth::user()->role=='Administrateur' || Auth::user()->role=='Assistant')
            <div class="btn-group">
                <a href="{{ route('factureForm') }}" class="cl-white theme-bg btn  btn-rounded"
                    title="Creer une facture">
                    <i class="ti-wand"></i>
                    Creer une facture
                </a>
            </div>
            @else
            @endif
        </div>

    </div>
    @if($plan=='standard')
    <div class="card text-center" style="padding:30px">
        <h2 class="bg-warning"><i class="fa fa-exclamation-triangle"></i> Module Premium</h2>
        <p style="font-size:18px">Chèr(e) utilisateur ce module ne figure pas sur le plan <b>standard</b> auquel vous avez souscri. Veuillez contacter notre équipe pour passer au <b>premium</b> si vous voulez obtenir ce module. <br>
        visitez notre site web pour voir les différents plans  <a href="https://www.smartylex.com#prix" target="_blank" style="color:blue"><i class="fa fa-arrow-right"></i> www.smartylex.com</a>
        </p>
       
    </div>
    @else
    <div class="col-md-12 align-self-center mb-4">
        <form method="post" action="{{route('factureFilter')}}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="btn-group mr-lg-2">
                <h4 class="theme-cl"><i class="fa fa-filter"></i> Filtre</h4>
            </div>

            <div class="btn-group mr-lg-2">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">Du</span>
                    <input type="date" name="dateDebut" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3" required>
                </div>
            </div>

            <div class="btn-group mr-lg-2">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">Au</span>
                    <input type="date" name="dateFin" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3" required>
                </div>
            </div>
            <div class="btn-group mr-lg-2">
                <button type="submit" title="Filtrer" class="btn btn-default">
                    <i class="fa fa-filter"></i>
                </button>
            </div>


            <div class="btn-group mr-lg-2">
                <a href="{{ route('histoFacture') }}" title="Tous afficher" class="btn btn-default tooltips">
                    <i class="ti-flix ti-layout-grid2"></i>
                </a>
            </div>
        </form>

    </div>

    <!-- Title & Breadcrumbs-->
    @if(isset($dateDebut))
    <h5><b>Resultat filtre :</b> Du {{date('d-m-Y', strtotime($dateDebut))}} Au {{date('d-m-Y', strtotime($dateFin))}}</h5>
    @endif

    <div class="row mb-4">

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-money blue-cl font-30"></i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1 infoPrive">{{number_format($TFactures[0]->TFactures, 0, ' ', ' ')}}
                            {{$monnaieParDefaut[0]->monnaieParDefaut}}</h4>
                        <span>Total facturé</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-check-circle green-cl font-30"></i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1 infoPrive">{{number_format($TFacturesPaye[0]->TFacturesPaye, 0, ' ', ' ')}}
                            {{$monnaieParDefaut[0]->monnaieParDefaut}}</h4>
                        <span>Total payé</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-hourglass-half yellow-cl font-30"></i>
                    </div>
                    <div class="widget-detail ">
                        <h4 class="mb-1 infoPrive">{{number_format($TFacturesEncours[0]->TFacturesEncours, 0, ' ', ' ')}}
                            {{$monnaieParDefaut[0]->monnaieParDefaut}}</h4>
                        <span>Total en cours de paiement</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-times-circle red-cl font-30"></i>
                    </div>
                    <div class="widget-detail ">
                        <h4 class="mb-1 infoPrive">{{number_format($TFacturesDue, 0, ' ', ' ')}}
                            {{$monnaieParDefaut[0]->monnaieParDefaut}}</h4>
                        <span>Total Dû</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <div class="card col-md-12" style="padding:10px;display:grid;min-height:70vh">
        <div class="card-body">

            <div class="table-responsive">
                <div class="category-filter">
                    <select id="categoryFilter" class="categoryFilter form-control">
                        <option value="">Tous</option>
                        <option value="Créée">Créée(s)</option>
                        <!--<option value="Envoyée">Envoyée(s)</option>-->
                        <option value="Payée">Payée(s)</option>
                        <option value="En cours de paiement">En cours de paiement</option>
                        <option value="En retard">En retard</option>
                        <option value="Annulée">Annulée(s)</option>

                    </select>
                </div>
                <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 50px">N°</th>
                            <th>Date facture</th>
                            <th>Client</th>
                            <th>Affaire</th>
                            <th>Montant Total</th>
                            <th>À payer</th>
                            <th>Statut</th>
                            <th style="width: 50px">Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($factures as $f)
                        <tr>
                            <td>{{$f->idFacture}}</td>
                            <td>
                                @if(empty($f->dateFacture))
                                    <small>N/A</small>
                                @else
                                    {{date('d-m-Y', strtotime($f->dateFacture))}}
                                @endif
                               
                            </td>
                            <td>{{$f->prenom}} {{$f->nom}} {{$f->denomination}}</td>
                            <td>{{$f->nomAffaire}}</td>
                            <td> <span class="infoPrive" >  {{$f->montantTTC}}</span></td>
                            <td>
                            @php
                                $facturesPaiements = DB::select("select * from paiement_factures,factures where
                                paiement_factures.idFacture = factures.idFacture and
                                paiement_factures.idFacture=$f->idFacture 
                                order by idPaiementFacture  desc limit 1");
                            @endphp
                               

                            @if (empty($facturesPaiements))
                            <span class="infoPrive">{{number_format($f->montantTTC, 0, ' ', ' ')}} {{$f->monnaie}}</span>
                            @else
                            <span class="infoPrive">{{number_format($facturesPaiements[0]->montantRestant, 0, ' ', ' ')}} {{$f->monnaie}}</span>
                            @endif
                                
                                             
                            </td>
                            @if($f->statut=='Créée')
                            <td class="bg-primary-light" style="text-align:center">
                                <span>{{$f->statut}}</span>
                            </td>
                            @elseif($f->statut=='Payée')
                            <td class="bg-success-light" style="text-align:center">
                                <span>{{$f->statut}}</span>
                            </td>
                            @elseif($f->statut=='En retard')
                            <td class="bg-danger-light" style="text-align:center">
                                <span>{{$f->statut}}</span>
                            </td>
                            @elseif($f->statut=='Annulée')
                            <td class="bg-purple-light" style="text-align:center">
                                <span>{{$f->statut}}</span>
                            </td>
                            @else
                            <td class="bg-warning-light" style="text-align:center">
                                <span>{{$f->statut}}</span>
                            </td>
                            @endif
                            <td style="text-align:center;">
                                <a class="" href="{{route('facture',$f->slug)}}" title="Voir la facture"
                                    data-toggle="tooltip"><i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
</div>
<!-- /.row -->

<div class="add-popup modal fade" id="deleteAffaire" tabindex="-1" role="dialog" aria-labelledby="deleteAffaire">
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

            <div class="modal-body">
                <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                <p>Cette action est irreversible , vous perdrez toutes les données liées à cette affaire.</p>
                <p>Voulez-vous vraiment supprimer cette affaire ?</p>
                <input type="hidden" id="slugCourier" name="slug">

                <div class="row mrg-0">
                    <div class="col-md-12 col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                            NON
                        </a>

                        <a href="" class="btn btn-danger">OUI</a>

                    </div>
                </div>


            </div>

        </div>
    </div>
</div>


<script>
document.getElementById('fact').classList.add('active');
</script>

@endsection