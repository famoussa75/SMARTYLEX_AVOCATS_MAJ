@extends('layouts.base')
@section('title','Ajout des données')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl">Transmission du courrier</h4>
        </div>
    </div>
   
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
                                            <a href="#step-1" class="btn circle-button"><i
                                                    class="fa fa-pencil-square-o"></i></a>
                                            <p>Enregistrement</p>
                                        </div>
                                        <div class="form-wizard-setup last">
                                            <a href="#step-2" class="btn  circle-button active-wizard"><i
                                                    class="fa  fa-file-text"></i></a>
                                            <p>Soumission</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 1 -->
                                <div class="row form-step" id="step-1">
                                    <div class="row">
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
                                                            <h2 style="text-decoration: underline;"> Courriers - Arrivée</h2>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    <h4>{{ $courierArriver->expediteur }}</h4>
                                                                    <p>
                                                                        Date du courrier :
                                                                        {{ date('d-m-Y', strtotime($courierArriver->dateCourier))}}<br>
                                                                        Date d'arrivée : <span
                                                                            style="color:red">{{ date('d-m-Y', strtotime($courierArriver->dateArrive))}}</span><br>
                                                                        Status actuel : <span
                                                                            class="label cl-success bg-success-light">
                                                                            {{ $courierArriver->statut }}</span>
                                                                    </p>

                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <h3 class="m-t-40">Pièces </h3>
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>{{ $courierFile->nomFiles}}
                                                                                        </td>
                                                                                        <td> <a class="load" href="{{route('readFile', [$courierFile->nomFiles, $courierFile->slug])}}"
                                                                                                style="color:red"
                                                                                                class="toggle"
                                                                                                title="Cliquer pour afficher le contenu du fichier">Voir
                                                                                                le contenu</a> </td>
                                                                                    </tr>
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
                                </div>

                                <!-- Step 2 -->
                                <div class="row form-step" id="step-2">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="col-12">
                                                <div class="box card-inverse bg-img">
                                                    <div class="flex-box align-items-center padd-l-10 padd-r-10"
                                                        data-overlay="3">
                                                        <div class="flex-box align-items-center mr-auto">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row page-breadcrumbs">
                                                    <div class="col-md-5 align-self-center">
                                                        <div class="panel-group accordion-stylist" id="accordion"
                                                            role="tablist" aria-multiselectable="false">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="headingOne">
                                                                    <h4>
                                                                        <a class="load btn btn-rounded btn-outline-info"
                                                                            data-toggle="collapse"
                                                                            data-parent="#accordion" href="#collapseOne"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseOne">
                                                                            Action
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseOne"
                                                                    class="panel-collapse collapse show" role="tabpanel"
                                                                    aria-labelledby="headingOne">
                                                                    <div class="panel-body">
                                                                        <span class="btn label label-danger"> <a
                                                                                href="#"
                                                                                style="color:white">Classé</a></span>
                                                                        <span class="btn label label-warning"> <a
                                                                                href="#" style="color:white"> Créer une
                                                                                tâche</a></span>
                                                                        <span class="btn label label-primary"> <a
                                                                                href="#" style="color:white"> Envoyer à
                                                                                la correction</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <<<<<<< HEAD <div class="col-md-7 text-right">
                                                        <div class="btn-group">
                                                            <a href="#" class="btn " name="transmis"
                                                                value="{{ $courierFile->slug }}">approuver</a>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    =======
                                </div>
                            </div>
                            >>>>>>> fd3e914b0bfa84e450a8d8cb1f36f32a214c81c4
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
<<<<<<< HEAD </div>
    </div>
    </div>
    @endsection
    =======
    </div>
    @endsection
    >>>>>>> fd3e914b0bfa84e450a8d8cb1f36f32a214c81c4
