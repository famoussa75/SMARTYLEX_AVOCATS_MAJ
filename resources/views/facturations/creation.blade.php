@extends('layouts.base')
@section('title','Nouvelle facture')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-money"></i> Facturation > <span class="label bg-info"><b>Création</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group">
                <a type="button" href="{{route('histoFacture')}}" class="cl-white theme-bg btn btn-rounded"
                    title="Liste des factures">
                    <i class="fa fa-navicon"></i>
                    Historique des factures
                </a>
            </div>

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
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form id="myForm" class="padd-20" method="post" action="{{ route('storeFacture') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <h2>Nouvelle Facture</h2>
                        <br>
                       
                    </div>

                    <div class="row mrg-0">
                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Selectionner le client :</label>
                                @if(count($client)==1)
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="client"
                                    required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($client as $client)
                                    <option value={{ $client->idClient }}>{{ $client->prenom  }}
                                        {{ $client->nom }} {{ $client->denomination }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="form-control select2" name="idClient" style="width: 100%;" id="client"
                                    required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($client as $client)
                                    <option value={{ $client->idClient }}>{{ $client->prenom  }}
                                        {{ $client->nom }} {{ $client->denomination }}
                                    </option>
                                    @endforeach
                                </select>
                                @endif
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        @if(isset($affaire))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Affaire du client concerné :</label>
                                @if(count($affaire)==1)
                                <select class="form-control select2" style="width: 100%;" name="idAffaire"
                                    id="affaireClient" required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($affaire as $affaire)
                                    <option value={{ $affaire->idAffaire }}>{{ $affaire->nomAffaire  }} </option>
                                    @endforeach

                                </select>
                                @else
                                <select class="form-control select2" style="width: 100%;" name="idAffaire"
                                    id="affaireClient" required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($affaire as $affaire)
                                    <option value={{ $affaire->idAffaire }}>{{ $affaire->nomAffaire  }} </option>
                                    @endforeach

                                </select>
                                @endif
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-4" id="affaireContent">
                            <div class="form-group">
                                <label>Affaire du client concerné :</label>
                                <select class="form-control select2" style="width: 100%;" name="idAffaire"
                                    id="affaireClient" required>
                                    <option value="" selected disabled>-- Choisissez --</option>

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4" id="">
                            <div class="form-group">
                                <label>Monnaie :</label>
                                <select class="form-control select2" style="width: 100%;" name="monnaie"
                                    id="selectMonnaie" required>
                                    <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach($monnaies as $m)
                                    <option value="{{$m->symbole}}">{{$m->description}}</option>
                                    @endforeach


                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="type" class="control-label">Inserez des lignes</label>
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <tr>

                                    <th>Designation</th>
                                    <th>Prix (<span class="monnaieSpan"></span>)</th>
                                    <th style="width:5px">Action</th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="formset[0][designation]" placeholder=""
                                            class="form-control" required /></td>
                                    <td><input type="number"  oninput="formatNumber()" id="numberInput" min="1" name="formset[0][prix]" placeholder=""
                                            class="form-control prix" required />
                                            <span id="formattedNumber" style="margin-top: 20px; font-weight: bold;text-align:right"></span>
                                    </td>

                                    <td><button type="button" name="add" id="dynamic-ar"
                                            class="cl-white theme-bg btn btn-outline-default"><i
                                                class="fa fa-plus"></i></button></td>
                                </tr>
                            </table>

                            <div class="row mt-5">
                                <div class="col-md-8 row">
                                    <div class="form-group col-md-4">
                                        <label for="inputPName" class="control-label">Date facture :</label>
                                        <input type="date" name="dateFacture" id="" class="form-control">
                                        <div class="help-block with-errors"></div>
                                    </div> 
                                    <div class="form-group col-md-4">
                                        <label for="inputPName" class="control-label">Date d'écheance :</label>
                                        <input type="date" name="dateEcheance" id="" class="form-control" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPName" class="control-label">Valeur TVA (%) :</label>
                                        <input type="number" min="0" value="18" name="tva" id="tva" style="width:100px" class="form-control">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <p style="text-align:right"><b>Total HT (<span class="monnaieSpan"></span>) :</b>
                                        <input type="number" step=2 min="1" name="montantHT" id="montantHT" readonly required>
                                    </p>
                                    <p style="text-align:right"><b>TVA (<span class="monnaieSpan"></span>) :</b> <input
                                            type="number" step=2 min="1" name="montantTVA" id="montantTVA" readonly required></p>
                                    <p style="text-align:right"><b>Total TTC (<span class="monnaieSpan"></span>) :</b>
                                        <input type="number" step=2 min="1" name="montantTTC" id="montantTTC" readonly required>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <h3 class="text-center">Mode de Paiement</h3>
                          
                            <div class="row mt-5">
                                <div class="col-md-6" >
                                    <label for="">Choisissez le/les comptes bancaires comme mode de paiement .</label>
                                    <div style="border:1px solid; padding:10px">
                                    @foreach($compteBancaire as $cb)
                                    <div class="" >    
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="idCompteBank[]" value={{$cb->idCompteBank}} >
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">{{$cb->nomBank}} <b>IBAN :</b> {{$cb->iban}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Termes & Conditions</label>
                                    <textarea name="descMode" id="" cols="30" rows="3" class="form-control">{{ $cabinet[0]->termesFacture }}</textarea>
                                </div>
                            </div>

                        </div>


                        <div class="col-12 mt-5">
                            <div class="theme-cl form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded" style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
document.getElementById('fact').classList.add('active');
</script>

<script>
    function formatNumber() {
        const input = document.getElementById('numberInput');
        const formattedDisplay = document.getElementById('formattedNumber');
        
        // Convertir en chaîne et formater avec des espaces
        let value = input.value.replace(/\D/g, ''); // Garder seulement les chiffres
        formattedDisplay.textContent = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' '); // Ajouter espaces

        if (value === '') {
            formattedDisplay.textContent = '';
        }
    }
</script>


<!-- End Add Contact Popup -->
@endsection