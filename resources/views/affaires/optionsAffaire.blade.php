
    @extends('layouts.base')
    @section('title','Information de l\'affaire')
    @section('content')
        <div class="container-fluid">
            <!-- Title & Breadcrumbs-->
            <div class="row page-breadcrumbs">
                <div class="col-md-5 align-self-center">
                    <h4 class="theme-cl">N° Affaire et nom client</h4>
                </div>
                <div class="col-md-7 text-right">
                    <div class="btn-group mr-lg-2">
                         <a href="#" class="cl-white theme-bg btn  tooltips">
                             <i class="ti-flix ti-view-list-alt"></i>
                         </a>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="btn gredient-btn" data-toggle="modal" data-target="#addcontact" title="Create project">
                        Ajouter ou Liste
                        </a>
                    </div>
                </div>
            </div>
            <!-- Title & Breadcrumbs-->
            <div class="col-md-12 col-sm-12">
                <div class="card padd-15">
                    <div class="tab" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"> <i class="ti i-cl-5 ti-layers-alt"></i> Tâche</a></li>
                            <li role="presentation"><a href="#Section2" role="tab" data-toggle="tab"> <i class="ti i-cl-3  fa fa-tasks"></i> courrier</a></li>
                            <li role="presentation"><a href="#Section3" role="tab" data-toggle="tab"> <i class="ti i-cl-8  ti-announcement"></i> Audiences</a></li>
                            <li role="presentation"><a href="#Section4" role="tab" data-toggle="tab"> <i class="ti i-cl-4 fa fa-money"></i> Factures</a></li>
                            <li role="presentation"><a href="#Section5" role="tab" data-toggle="tab"> <i class="ti i-cl-7  ti-alarm-clock"></i> Temps</a></li>
                            <li role="presentation"><a href="#Section6" role="tab" data-toggle="tab"> <i class="ti i-cl-3 ti-bookmark-alt"></i> Pièces</a></li>
                            <li role="presentation"><a href="#Section7" role="tab" data-toggle="tab"> <i class="ti i-cl-6  ti-clipboard"></i> Modèles</a></li>
                            <li role="presentation"><a href="#Section8" role="tab" data-toggle="tab"> <i class="ti i-cl-2 ti-notepad"></i> Requête</a></li>
                        </ul>
                        <div class="tab-content tabs" id="home">
                            <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                                <div class="text-center">
                                    <h3>Les Tâches de cette affaire</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section2">
                                <div class="text-center">
                                    <h3>Les courier de l'affaire</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section3">
                                <div class="text-center">
                                    <h3>Les Audiences de cette affaire</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section4">
                                <div class="text-center">
                                    <h3>Facture de l'affaire</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section5">
                                <div class="text-center">
                                    <h3>Les temps de l'affaire</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section6">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="invoice-table">
                                        <div class="text-center">

                                        <div class="row page-breadcrumbs">
                                            <div class="col-md-5 align-self-center">
                                                <h4 class="theme-cl">Les Pièces de cette affaire</h4>
                                            </div>
                                            <div class="col-md-7 text-right">
                                                <div class="btn-group">
                                                    <a style="color: red;" href="#" class="btn gredient-btn" data-toggle="modal" data-target="#addcontact" title="Cliquer pour joindre une pièce à cette affaire">
                                                    Joindre une pièce
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>N° de pièce</th>
                                                        <th>Nom client</th>
                                                        <th> Nom de la pièce</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <a href="#"><span style="font-size: 14px; font-weight: bold" data-toggle="tooltip" data-placement="top" title="cliquer pour voir les informations de ce client">Abou DABO</span></a>
                                                        </td>
                                                        <td>
                                                            <a href="#"><span style="font-size: 14px; font-weight: bold" data-toggle="tooltip" data-placement="top" title="cliquer pour ouverture le fichier">RCCM</span></a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="settings" title="Ouvrir le fichier" data-toggle="tooltip"><i class="fa fa-info-circle"></i></a>
                                                            <a href="#" class="delete" title="Supprimer ce fichier" data-toggle="tooltip"><i class="ti-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section7">
                                <div class="text-center">
                                    <h3>Les models</h3>
                                </div>
                                <hr>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section8">
                                <div class="text-center">
                                    <h3>Les requêtes</h3>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
                 document.getElementById('aff').classList.add('active');
        </script>
    @endsection
