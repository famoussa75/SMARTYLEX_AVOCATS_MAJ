@extends('layouts.base')
@section('title','Facture')
@section('content')

<style>
    table {
        width: 100%;
        border-collapse: collapse; /* Supprime les espaces entre les cellules */
    }
    tr {
        height: 17px; /* Hauteur de la ligne */
    }
    td, th {
        height: 17px; /* Hauteur maximale des cellules */
        padding: 0px; /* Diminue le padding */
        line-height: 1; /* Ajuste la hauteur de ligne du texte */
    }
</style>


<div class="container-fluid  @if (Auth::user()->role=='Client') bg-secondary @else  @endif">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            @empty($factureBreadcrumbs)
            @else

            <h5 class="theme-cl">
                <b> {{ $factureBreadcrumbs[0]->idClient }}</b>
                >
                <a class="load theme-cl"
                    href="{{route('clientInfos', [$factureBreadcrumbs[0]->idClient, $factureBreadcrumbs[0]->slugClient])}}">
                    {{ $factureBreadcrumbs[0]->prenom }} {{ $factureBreadcrumbs[0]->nom }}
                    {{ $factureBreadcrumbs[0]->denomination }}
                </a>
                >
                <a class="load theme-cl"
                    href="{{ route('showAffaire', [$factureBreadcrumbs[0]->idAffaire,$factureBreadcrumbs[0]->slugAffaire]) }}">
                    {{ $factureBreadcrumbs[0]->idAffaire }} {{ $factureBreadcrumbs[0]->nomAffaire }}
                </a>
                >
                <span class="label bg-info"><b>Facture</b></span>

            </h5>
            @endif
        </div>

        @if (Auth::user()->role=='Client')

        @else

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a type="button" href="{{route('histoFacture')}}" class="cl-white theme-bg btn btn-rounded"
                    title="Liste des factures">
                    <i class="fa fa-navicon"></i>
                    Historique des factures
                </a>
            </div>
          
        </div>
        @endif


    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding:50px">
                @if($facture[0]->statut=='Créée')
                <div class="col-md-12 mb-5 bg-primary-light padd-5">
                    <h5 style="text-align:right; padding-top:10px;"><i class="fa fa-magic cl-primary"></i>
                        <span style="color:gray">&nbsp;{{$facture[0]->statut}}</span>&nbsp;&nbsp;
                    </h5>
                </div>
                @elseif($facture[0]->statut=='En cours de paiement')
                <div class="col-md-12 mb-5 bg-warning-light padd-5">
                    <h5 style="text-align:right; padding-top:10px;"><i class="fa fa-hourglass-half cl-warning"></i>
                        <span style="color:gray">&nbsp;{{$facture[0]->statut}}</span>&nbsp;&nbsp;
                    </h5>
                </div>
                @elseif($facture[0]->statut=='Payée')
                <div class="col-md-12 mb-5 bg-success-light padd-5">
                    <h5 style="text-align:right; padding-top:10px;"><i class="fa fa-check-circle cl-success"></i>
                        <span style="color:gray">&nbsp;{{$facture[0]->statut}}</span>&nbsp;&nbsp;
                    </h5>
                </div>
                @elseif($facture[0]->statut=='En retard')
                <div class="col-md-12 mb-5 bg-danger-light padd-5">
                    <h5 style="text-align:right; padding-top:10px;"><i class="fa fa-times-circle cl-danger"></i>
                        <span style="color:gray">&nbsp;{{$facture[0]->statut}}</span>&nbsp;&nbsp;
                    </h5>
                </div>
                @elseif($facture[0]->statut=='Annulée')
                <div class="col-md-12 mb-5 bg-purple-light padd-5">
                    <h5 style="text-align:right; padding-top:10px;"><i class="fa fa-times-circle cl-danger"></i>
                        <span style="color:gray">&nbsp;{{$facture[0]->statut}}</span>&nbsp;&nbsp;
                    </h5>
                </div>
                @else

                @endif

                @foreach($paiement as $p)

                    @if($facture[0]->statut=='Annulée')

                    @else
                        @if($p->statut=='Non validé' && Auth::user()->role=='Administrateur')
                        <div class="card padd-5 text-center bg-default">
                            <p><i class="fa fa-info-circle"></i> Voulez vous confirmer le paiement de
                                <b>{{number_format($p->montantPayer, 0, ' ', ' ')}} {{$facture[0]->monnaie}}</b> ?
                            </p>
                            <P>Paiement par : {{$p->methodePaiement}}</P>
                            <P>Reste à payer : {{number_format($p->montantRestant, 0, ' ', ' ')}} {{$facture[0]->monnaie}}</P>
                            <P> Date de paiement : {{date('d-m-Y', strtotime($p->datePaiement))}}</P>
                            <div class="row mrg-0">
                                <div class="col-md-12 col-sm-12">
                                    <a href="{{route('deletePaiement',[$p->idPaiementFacture,$p->idFacture])}}" class="btn btn-default"
                                        data-dismiss="modal" aria-label="Close">
                                        NON
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="{{route('validePaiement',[$p->idFacture,$p->montantPayer,$p->montantRestant,$p->idPaiementFacture])}}"
                                        class="btn btn-success">OUI</a>

                                </div>
                            </div>
                            </div>
                        @else
                        @endif
                    
                    @endif

                @endforeach
                <div class="row col-md-12">
                    <div class="col-md-4">
                        <h5><i class="fa fa-language"></i> Traduire</h5>
                        
                        <div class=" onoffswitchLang">
                            <input type="checkbox" name="onoffswitchLang" class="onoffswitchLang-checkbox" id="infowitchLangInvoice"
                                checked="" style="width:5px">
                            <label class="onoffswitchLang-label label-default" for="infowitchLangInvoice">
                                <span class="onoffswitchLang-inner" id="onoffswitchLang-inner"></span>
                                <span class="onoffswitchLang-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-8" style="padding-top:30px">
                        <div class="dropdown" style="float: right ;">
                            <button class="btn btn-rounded theme-bg dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info-circle"></i>
                                Options
                            </button>

                            @if($facture[0]->statut=='Annulée')
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                                
                                    <a class=" dropdown-item " href="#" onclick="telechargerFacture()" title="telecharger la facture"><i
                                        class="fa fa-download mr-2"></i>Telecharger</a>

                                </div>
                            @else
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                                    style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    @if($facture[0]->statut=='Payée')
                                    @else
                                    <a class="dropdown-item " href="#" title="Payer la facture" data-toggle="modal"
                                        data-target="#paiement"><i class="ti-wallet mr-2"></i>Paiement</a>
                                    @endif
                                    @if($facture[0]->statut=='envoyer' )
                                    @else
                                    <a class=" dropdown-item " href="#" data-toggle="modal" data-target="#envoiFacture"
                                        title="Envoyer la facture au client"><i class="fa fa-send mr-2"></i>Envoyer au client</a>
                                    @endif

                                    <a class=" dropdown-item " href="#" onclick="telechargerFacture()" title="telecharger la facture"><i
                                        class="fa fa-download mr-2"></i>Telecharger</a>
                                
                                    <a class=" dropdown-item " href="#" data-toggle="modal" data-target="#deleteFacture"
                                        title="Annuler la facture"><i class="ti-close mr-2"></i>Annuler</a>

                                </div>

                            @endif
                        </div>

                    </div>

                </div>
               
                <div class="detail-wrapper padd-50 factureDiv " style="background-color:#f5f5f5;display: flex;justify-content: center;align-items: center; " >
                    <div
                        class="ruban left @if ($facture[0]->notification=='envoyer') rubanEnvoyer @else rubanNonEnvoyer @endif ">
                        <span><b>@if ($facture[0]->notification=='envoyer') <i class="fa fa-envelope"></i> Envoyée @else
                                <i class="fa fa-envelope"></i> Non envoyée @endif</b></span>
                    </div>
                    <div id="factureDiv" class="contact-grid-box">
                        <div class="row mrg-0">
                            <div class="col-md-6">
                                <img src="{{URL::to('/')}}/{{$cabinets[0]->logo}}" alt="" class="factureImage" />
                            </div>

                            <div class="col-md-6">
                                <h2
                                    style="font-size: 21px; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                    <span id="labelFacture">FACTURE</span>
                                </h2>
                                <p id="invoice-info">
                                    <span><strong>No:</strong> {{$facture[0]->idFacture}}-{{ date('m/Y', strtotime($facture[0]->dateFacture))}}</span> <br>
                                    <span><strong id="labelDateInvoice">Fait le :</strong>
                                    @if(empty($facture[0]->dateFacture))
                                        <small>N/A</small>
                                    @else
                                        {{ date('d-m-Y', strtotime($facture[0]->dateFacture))}}
                                    @endif
                                       </span> <br>
                                    <span><strong id="labelDateEcheance">Date d'écheance :</strong>
                                        @if(empty($facture[0]->dateEcheance))
                                            <small>N/A</small>
                                        @else
                                             {{ date('d-m-Y', strtotime($facture[0]->dateEcheance))}}
                                        @endif
                                    </span> <br>

                                </p>
                            </div>

                        </div>

                        <div class="row  mrg-0 detail-invoice">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7 col-sm-7">
                                        <h5> <span>{{$cabinets[0]->nomCabinet}}</span></h5>
                                        <p>
                                            <a href="#" class="__cf_email__" data-cfemail="640d0a020b242500090d0a220d01164a070b09"><span>{{$cabinets[0]->emailFinance}}</span></a><br />
                                            <span>NIF: {{$cabinets[0]->nif}}</span><br />
                                            <span>N° TVA: {{$cabinets[0]->numTva}}</span><br />
                                            <span>{{$cabinets[0]->tel1}} / {{$cabinets[0]->tel2}}</span> <br />
                                            <span>{{$cabinets[0]->adresseCabinet}}</span> 
  
                                        </p>

                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <h5><span id="labelClient">CLIENT : </span> <span>{{$client[0]->prenom}}
                                                {{$client[0]->nom}}{{$client[0]->denomination}}</span></h5>
                                        <p>
                                            <a href="" class="__cf_email__"
                                                data-cfemail="493a283c3b283f24282025717e092e24282025672a2624">
                                                <span>{{$client[0]->email}}{{$client[0]->emailEntreprise}}</span></a><br />

                                            <span>{{$client[0]->telephone}}{{$client[0]->telephoneEntreprise}}</span><br />

                                            <span>{{$client[0]->adresse}}{{$client[0]->adresseEntreprise}}</span>

                                        </p>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 ">
                                <div class="invoice-table">
                                    <div class="table-responsive">
                                    <h5> <span id="labelDescription">DESCRIPTIONS & DETAILS :</span></h5>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <span id="labelDesignation">Designation</span>
                                                    </th>
                                                    <th>
                                                        <span id="labelPrix">Prix</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($factureDetails as $fd)
                                                <tr>
                                                    <td>
                                                        <span>{{ $fd->designation }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ number_format($fd->prix, 0, ' ', ' ') }}
                                                                {{$fd->monnaie}}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <h5> <span><span id="labelTotalHt">Total HT</span> : {{number_format($facture[0]->montantHT, 0, ' ', ' ')}}
                                                {{$facture[0]->monnaie}}</span> </h5>
                                    </div>
                                    <hr>
                                    <div>
                                        <h5> <span><span id="labelTotalTva">TVA ({{ number_format(($facture[0]->montantTVA / $facture[0]->montantHT) * 100) }}%)</span> : {{number_format($facture[0]->montantTVA, 0, ' ', ' ')}}
                                                {{$facture[0]->monnaie}} </span></h5>
                                    </div>
                                    <hr>
                                    <div>

                                        @if(!empty($paiement))
                                        <h4><span><b><span id="labelTotalApayer">Total à payer (TTC)</span>  :
                                                    {{number_format($facture[0]->montantTTC, 0, ' ', ' ')}}
                                                    {{$facture[0]->monnaie}}</b> </span></h4>
                                            <h5 class=""> <span><i class="fa fa-rotate-left"></i><span id="labelHistory"> Historique de paiement</span></h5>
                                            <table class="table table-lg table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><span id="labelDatePaiement">Date de paiement</span></th>
                                                        <th><span id="labelMontantPayer">Montant payé</span></th>
                                                        <th><span id="labelMontantRestant">Montant restant</span></th>
                                                        <th><span id="labelMethode">Methode de paiement</span></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($paiement as $row)
                                                    <tr>
                                                        <td><span>{{ date('d-m-Y', strtotime($row->datePaiement))}}</span>
                                                        </td>
                                                        <td><span>{{number_format($row->montantPayer, 0, ' ', ' ')}}
                                                                {{$facture[0]->monnaie}}</span></td>
                                                        <td><span>{{number_format($row->montantRestant, 0, ' ', ' ')}}
                                                                {{$facture[0]->monnaie}}</span></td>
                                                        <td>
                                                            <span class="methodePaiemet">
                                                                @if($row->methodePaiement=='Chèque')
                                                                {{$row->methodePaiement}} / {{$row->banqueCheque}} / {{$row->numeroCheque}}
                                                                @elseif($row->methodePaiement=='Virement bancaire')
                                                                {{$row->methodePaiement}} / viré le: {{date('d-m-Y', strtotime($row->dateVirement))}}
                                                                @else
                                                                {{$row->methodePaiement}}
                                                                @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <h5> <span><b><span id="labelSolde">Solde restant à payer</span> :
                                                        {{number_format($paiement[0]->montantRestant, 0, ' ', ' ')}}
                                                        {{$facture[0]->monnaie}}</b></span> </h5>
                                            <input type="hidden" value="{{$paiement[0]->montantRestant}}" id="montantTTCjs">

                                            @else
                                            <h4><span><b><span id="labelTTC">Total à payer (TTC)</span> :
                                                        {{number_format($facture[0]->montantTTC, 0, ' ', ' ')}}
                                                        {{$facture[0]->monnaie}}</b> </span></h4>
                                                <input type="hidden" value="{{$facture[0]->montantTTC}}" id="montantTTCjs">

                                            @endif
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for=""><span><i class="fa fa-bank"></i><span id="labelReferenceB"> References bancaires</span></span></label>
                                            <hr style="margin-top:-5px">
                                            @foreach($modePaieBank as $cb)
                                            <p> <span>{{$cb->nomBank}} <b>IBAN :</b> {{$cb->iban}}</span></p>
                                            @endforeach

                                        </div>
                                        @if(!empty($autreMode))
                                        <div class="col-md-6">
                                            <label for=""> <span><i class="fa fa-info-circle"></i> <span id="labelTerme"> Termes &
                                                    Conditions</span></span></label>
                                            <hr style="margin-top:-5px">
                                            <p> <span>{{$autreMode[0]->descMode}}</span></p>
                                        </div>
                                        @endif
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

<!-- Paiement facture -->
<div class="add-popup modal fade" id="paiement" tabindex="-1" role="dialog" aria-labelledby="update">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-money"></i> Paiement de la facture</h4>
            </div>
            <div class="modal-body">
                <div class="card">
                    <form id="myForm" class="padd-20" method="post" action="{{ route('storePaiement') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Date de paiement :</label>
                                    <input type="date" class="form-control" id="inputPName" placeholder=""
                                        data-error=" veillez saisir le nom expéditeur" name="datePaiement" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEmail" class="control-label">Montant payé
                                        ({{$facture[0]->monnaie}}) :</label>
                                    <input type="number" class="form-control" min="1" id="montantPayer"
                                        name="montantPayer" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Methode de paiement :</label>
                                    <select name="methodePaiement" id="methodePaiement" class="form-select select2" style="width:100%"
                                        required onchange="chequeEtVirement()">
                                        <option value="" selected disabled>-- Choisissez --</option>
                                        <option value="Espèce">Espèce</option>
                                        <option value="Chèque">Chèque</option>
                                        <option value="Virement bancaire">Virement bancaire</option>
                                        <option value="E-Money">E-Money</option>

                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divBanqueCheque" hidden>
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Banque :</label>
                                    <input type="text" class="form-control" id="banqueCheque" placeholder=""
                                        data-error=" veillez saisir le nom expéditeur" name="banqueCheque">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divNumeroCheque" hidden>
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Numéro de chèque :</label>
                                    <input type="text" class="form-control" id="numeroCheque" placeholder=""
                                        data-error=" veillez saisir le nom expéditeur" name="numeroCheque" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divDateVirement" hidden>
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Date de virement :</label>
                                    <input type="date" class="form-control" id="dateVirement" placeholder=""
                                        data-error=" veillez saisir le nom expéditeur" name="dateVirement" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPName" class="control-label">Reste à payer
                                        ({{$facture[0]->monnaie}}) :</label>
                                    <input type="number" class="form-control" id="montantRestant" placeholder=""
                                        data-error=" veillez saisir le nom expéditeur" name="montantRestant" readonly
                                        required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="idFacture" value={{$facture[0]->idFacture}}>
                        <input type="hidden" name="slugFacture" value="{{$facture[0]->slug}}">
                        <div class="row mrg-0" style="margin-top: 10px;">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                            style="width:30%;">Payer</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <span>&nbsp;&nbsp;</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal-mail -->
<div class="add-popup modal fade" id="envoiFacture" tabindex="-1" role="dialog" aria-labelledby="envoiFacture">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-envelope"></i> Envoi de facture</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form class="padd-20" method="post" action="{{ route('envoiFacture') }}"
                                enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>

                                <input type="hidden" name="slug" value="{{$facture[0]->slug}}">
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="label-control">Email de facturation du client</label>
                                            <input type="text" class="form-control" name="emailFacture"
                                                value="{{$facture[0]->emailFacture}}" required>
                                            @if($facture[0]->emailFacture=='')
                                            <small style="color:red"><i class="fa fa-info-circle"></i> Ce client ne
                                                possède pas un email de facture, veuillez saisir un email ou editez les
                                                informations client.</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">

                                            <label for="" class="label-control"> Inserer la facture ici</label>
                                            <input type="file" accept=".pdf" class="fichiers form-control" name="attachment[]"
                                                multiple="multiple" required>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-rounded btn-block "
                                                    style="width:50%;"><i class="fa fa-send"></i> Envoyer</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteFacture" tabindex="-1" role="dialog" aria-labelledby="deleteFacture">
    <div class="modal-dialog" role="document">
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
                <p>Cette action est irreversible , Cette facture sera annulée dans le système.</p>
                <p>Voulez-vous vraiment annuler cette facture ?</p>

                <div class="row mrg-0">
                    <div class="col-md-12 col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                            NON
                        </a>

                        <a href="{{route('deleteFacture',$facture[0]->idFacture)}}" class="btn btn-danger">OUI</a>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>


<script>



var monSwitchButtonLang = document.getElementById("infowitchLangInvoice");
     
     


    // Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");
   
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function (e) {
           
            var fichiersInput = this.querySelectorAll(".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name + " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});

function telechargerFacture() {
    var element = document.getElementById('factureDiv');
    var idFacture = "{{$facture[0]->idFacture}}";
    // Configuration pour html2pdf.js
    var opt = {
        margin: 0.5,
        filename: "Facture N°"+idFacture+".pdf",
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 4 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Convertir et télécharger le PDF
    html2pdf().from(element).set(opt).save();
}



function chequeEtVirement(){
    var methodePaiement = $('#methodePaiement').val();

    if (methodePaiement=='Chèque') {

        $('#banqueCheque').attr('required', true);
        $('#numeroCheque').attr('required', true);
        $('#divBanqueCheque').removeAttr('hidden');
        $('#divNumeroCheque').removeAttr('hidden');

        $('#dateVirement').removeAttr('required');
        $('#divDateVirement').attr('hidden', true);


    }else if(methodePaiement=='Virement bancaire'){

        $('#dateVirement').attr('required', true);
        $('#divDateVirement').removeAttr('hidden');

        $('#banqueCheque').removeAttr('required');
        $('#numeroCheque').removeAttr('required');
        $('#divBanqueCheque').attr('hidden', true);
        $('#divNumeroCheque').attr('hidden', true);

    }else{

        $('#dateVirement').removeAttr('required');
        $('#divDateVirement').attr('hidden', true);

        $('#banqueCheque').removeAttr('required');
        $('#numeroCheque').removeAttr('required');
        $('#divBanqueCheque').attr('hidden', true);
        $('#divNumeroCheque').attr('hidden', true);
    }
   
}
</script>

<script>
document.getElementById('fact').classList.add('active');
</script>
<!-- End Add Contact Popup -->
@endsection