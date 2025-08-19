@extends('layouts.base')
@section('title', 'administration')
@section('content')
<div class="container-fluid">
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-cog"></i> Administration</h4>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="card padd-15">
            <div class="tab" role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"> <i class="ti i-cl-0 fa fa-group"></i> Personnel</a></li>
                    <li role="presentation"><a href="#Section2" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-money"></i> Caisse</a></li>
                    <li role="presentation"><a href="#Section3" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-book"></i> courrier</a></li>
                    <li role="presentation"><a href="#Section4" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-file"></i> Tâche</a></li>
                    <li role="presentation"><a href="#Section5" role="tab" data-toggle="tab"> <i class="ti i-cl-0 "></i>
                            Transport</a></li>
                    <li role="presentation"><a href="#Section6" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-trello"></i> Stock</a></li>
                    <li role="presentation"><a href="#Section7" role="tab" data-toggle="tab"> <i class="ti i-cl-0 ti-file"></i> Archive</a></li>
                </ul>
                <div class="tab-content tabs" id="home">

                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <!-- Title & Breadcrumbs-->
                        <div class="row page-breadcrumbs">
                            <div class="col-md-5 align-self-center">
                                <h4 class="theme-cl">Personnels</h4>
                            </div>

                            <div class="col-md-7 text-right">
                                <div class="btn-group mr-lg-2">
                                    <a  href="{{ route('personneCard') }}" class="cl-white theme-bg btn  tooltips">
                                        <i class="ti-flix ti-layout-grid2"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a  href="{{ route('formPersonnel') }}" class="cl-white theme-bg btn btn-rounded" title="Ajouter un personnel"><i class="fa fa-user" ></i>
                                        Ajouter un personnel
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Title & Breadcrumbs-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="flex-box padd-10 bb-1">
                                        <h4 class="mb-0">Liste du personnel</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="category-filter">
                                                <select id="categoryFilter" class="categoryFilter form-control">
                                                    <option value="">Tous</option>

                                                </select>
                                            </div>
                                            <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Matricule</th>
                                                        <th>Photo</th>
                                                        <th>Prénom et nom</th>
                                                        <th>Fonction</th>
                                                        <th>Email</th>
                                                        <th>Telephone</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($personnel as $row)
                                                    <tr>
                                                        <td>
                                                            {{ $row->matricules }}
                                                        </td>
                                                        <td><a class="load" href="{{ route('infosPersonne', [$row->slug]) }}"><img src="{{$row->photo}}" class="avatar" alt="Avatar"> </a></td>
                                                        <td>
                                                            <a class="load" href="{{ route('infosPersonne', [$row->slug]) }}" class="settings" title="Plus d'infos" data-toggle="tooltip">{{ $row->prenom }}
                                                                {{ $row->nom }}</a>
                                                        </td>
                                                        <td>{{ $row->fonction }}</td>
                                                        <td>{{ $row->email }}</td>
                                                        <td>
                                                            <div class="label cl-success bg-success-light">{{ $row->telephone }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="load" href="{{ route('infosPersonne', [$row->slug]) }}" class="settings" title="Information" data-toggle="tooltip"><i class="fa fa-info-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section3">3</div>
                    <div role="tabpanel" class="tab-pane fade" id="Section4">4</div>
                    <div role="tabpanel" class="tab-pane fade" id="Section5">5</div>
                    <div role="tabpanel" class="tab-pane fade" id="Section6">6</div>
                    <div role="tabpanel" class="tab-pane fade" id="Section7">7</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="reader" tabindex="-1" role="dialog" aria-labelledby="reader">
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
                <h4 class="modal-title">Lecture du document</h4>
            </div>
            <div class="modal-body">
                <form   method="post" action="{{ route('joinFile') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title m-t-0">Lecteur du document</h4>
                                </div>
                                <div class="card-body">
                                </div>
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
<script>
    console.warn = () => {};
    document.getElementById('ges').classList.add('active');
</script>
@endsection

