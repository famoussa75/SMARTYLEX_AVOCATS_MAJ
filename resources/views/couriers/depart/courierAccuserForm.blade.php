@extends('layouts.base')
@section('title', 'Courier depart')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl">Finalisation</h4>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-sm-12">
                                <div class="stepwizard">
                                    <div class="stepwizard-row setup-panel">
                                        <div class="form-wizard-setup first">
                                            <a href="#step-1" class="btn circle-button"><i class="fa fa-pencil-square-o"></i></a>
                                            <p>Enregistrement</p>
                                        </div>
                                        <div class="form-wizard-setup">
                                            <a href="#step-2" class="btn  circle-button"><i class="fa  fa-file-text"></i></a>
                                            <p>Soumission</p>
                                        </div>
                                        <div class="form-wizard-setup">
                                            <a href="#step-3" class="btn  circle-button  "><i class="fa fa-paper-plane-o"></i></a>
                                            <p>Procédure envoi</p>
                                        </div>
                                        <div class="form-wizard-setup last">
                                            <a href="#step-4" class="btn  circle-button active-wizard"><i class="fa fa-check-square-o"></i></a>
                                            <p>Accusé réception</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 1 -->
                                <div class="row form-step" id="step-1">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="detail-wrapper padd-top-30">
                                                <div class="row text-center">
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp
                                                    </div>
                                                </div>
                                                <div class="row  mrg-0 detail-invoice">
                                                    <div class="col-md-12">
                                                        <h2 style="text-decoration: underline;"> Courriers - Départ</h2>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                @foreach ($courierSent as $courier)
                                                                <h4>Destinataire : {{ $courier->destinataire }}</h4>
                                                                <p>
                                                                    Objet du courrier : {{ $courier->objet }} <br>
                                                                    Date du courrier :
                                                                    {{ date('d-m-Y', strtotime($courier->dateCourier))}}<br>
                                                                    Status actuel : <span class="label cl-success bg-success-light">
                                                                        {{ $courier->statut }}</span>
                                                                </p>

                                                                @endforeach

                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <h3 class="m-t-40">Pièces du courrier</h3>
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                @foreach ($courierFile as $courierFiles)
                                                                                <tr>
                                                                                    <td>{{ $courierFiles->nomFiles}}
                                                                                    </td>
                                                                                    <td> <a class="load" href="{{route('readFile', [$courierFiles->nomFiles, $courierFiles->slug])}}" style="color:red" class="toggle" title="Cliquer pour afficher le contenu du fichier">Voir
                                                                                            le contenu</a> </td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="row form-step" id="step-2">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="col-12">
                                                @if(empty($courierFile))
                                                <p> Courrier crée à travers un model.</p>
                                                @else
                                                <a class="load" href="{{route('readFile', [$courierFile[0]->nomFiles, 'x'])}}" style="color:red" class="toggle" title="Cliquer pour afficher le contenu du fichier">

                                                    <div class="flex-box align-items-center" style="height: 275px; background-color:grey;display:block;padding:20px; margin-bottom:30px">

                                                        <h2 style="color:white;text-align:center"> Cliquez ici pour voir
                                                            le contenu ... <br><br>
                                                            <i class="fa fa-file-pdf-o" style="font-size:4.5em; color:info;"></i>

                                                        </h2>


                                                    </div>

                                                </a>
                                                @endif
                                                <div class="row text-center">


                                                    <div class="form-group">
                                                        @if(Auth::user()->role === 'Administrateur')
                                                        <h5>Ce courrier est déja transmis, veuillez vérifier pour une
                                                            approbation</h5>
                                                        <a class="load" href="{{ route('dutySent', [$courierSent[0]->slug ]) }}" class="btn btn-warning" name="transmis" value="{{ $courierSent[0]->slug }}">Approuvé</a>

                                                        @else
                                                        <h5>Ce courrier est déja approver par le maitre, veuillez cliquer
                                                            sur suivant pour continuer</h5>
                                                        <a href="#" class="btn btn-success" name="transmis">Suivant</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="row form-step" id="step-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="detail-wrapper padd-top-30">
                                                <div class="row text-center">
                                                    <div class="col-md-12">
                                                        &nbsp;&nbsp
                                                    </div>
                                                </div>
                                                <div class="row  mrg-0 detail-invoice">
                                                    <div class="col-md-12">
                                                        <h2 style="text-decoration: underline;">Procédure envoi</h2>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                @foreach ($courierSent as $courier)
                                                                <h4>Personne en charge : {{ $courier->nomPersonne }}
                                                                </h4>
                                                                <p>
                                                                    Téléphone : {{ $courier->telephonePersonne }} <br>
                                                                    Date d'Envoi :
                                                                    {{ date('d-m-Y', strtotime($courier->dateEnvoi))}}<br>
                                                                    Status actuel : <span class="label cl-success bg-success-light">
                                                                        {{ $courier->statut }}</span>
                                                                </p>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4 -->
                                <div class="row form-step" id="step-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <!-- form start -->
                                            <form   class="padd-20" method="post" action="{{ route('accuserReception') }}">
                                                <div class="text-center">
                                                    <h3>Accusé réception du courrier</h3>
                                                    <br>
                                                    @csrf
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="inputEmail" class="control-label">Date de
                                                                reception:</label>
                                                            <input type="date" class="form-control" id="inputEmail" name="dateReception" data-error=" veillez saisir la date de reception du courrier" required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            @foreach ($courierSent as $courier)
                                                            <input type="text" name="slugAccuser" value="{{$courier->slug}}" hidden>
                                                            @endforeach
                                                            <label for="inputPName" class="control-label"> N° de reception
                                                                :</label>
                                                            <input type="text" class="form-control" id="inputPName" placeholder="" data-error=" veillez saisir le N° du réçu du courrier" name="numeroRecu" required />
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mrg-0">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="text-center">
                                                                <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
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
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('cr').classList.add('active');
</script>
@endsection