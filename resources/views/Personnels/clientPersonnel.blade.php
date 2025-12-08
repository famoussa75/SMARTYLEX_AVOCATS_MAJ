@extends('layouts.base')
@section('title','Nouvelle affectation')
@section('content')
<div class="container-fluid">
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        <!-- Bloc gauche : icône + titre -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper theme-bg">
                <i class="fa fa-users text-white"></i>
            </div>
            <div class="ms-3">
                <h4 class="page-title mb-1 fw-bold">
                    RH
                    <span class="page-subtitle">› Affectation</span>
                    
                </h4>
                <small class="page-description text-secondary">
                    Gerez les affectations de vos clients à vos collaborateurs.
                </small>
            </div>
        </div>

    </div>



   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <!-- form start -->
                <form   class="padd-20" method="post" action="{{ route('addAffectation') }}">
                    <div class="text-center">
                        <h2>Nouvelle Affectation</h2>
                        <br>
                        @csrf
                    </div>

                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Selectionner le client</label><br>
                                <select class="form-control select2" name="idClient" style="width:100%;" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($client as $data )
                                    <option value={{ $data->idClient }}>{{ $data->prenom }} {{ $data->nom }}{{ $data->denomination }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Selectionner un personnel</label><br>
                                <select class="form-control select2" name="idPersonnel" style="width:100%;" required>
                                     <option value="" selected disabled>-- Choisissez --</option>
                                    @foreach ($personnel as $p )
                                    <option value={{ $p->idPersonnel }}>{{ $p->prenom }} {{ $p->nom }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        @if (sizeof($client) > 0)
                        <div class="col-12" style="margin-top:20px">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "><i class="fa fa-save"></i> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="flex-box padd-10 bb-1">
                    <h4 class="mb-0">Toutes les affectations</h4>
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
                                    <th>Client</th>
                                    <th>Employés</th>
                                    <th style="width:15px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($personnelAffec as $row)
                                <tr>
                                    <td>{{$row->prenomClient}} {{$row->nomClient}} {{$row->denomination}}</td>
                                    <td>{{$row->prenom}} {{$row->nom}}</td>
                                    <td>
                                        <a class="load btn btn-small font-midium font-13 btn-outline-danger btn-rounded w-100" href="{{ route('deleteGranted', [$row->slug]) }}">
                                            Annulé
                                        </a>
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

<!-- End Add Contact Popup -->

<script>
    document.getElementById('rh').classList.add('active');
</script>
@endsection