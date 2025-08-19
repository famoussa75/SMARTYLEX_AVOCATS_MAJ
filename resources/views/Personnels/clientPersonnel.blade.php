@extends('layouts.base')
@section('title','Nouvelle affectation')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-users"></i> RH > <span class="label bg-info"><b>Affectation</b></span></h4>
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
                                <label>Selectionner le client</label>
                                <select class="form-control select2" name="idClient" required>
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
                                <label>Selectionner un personnel</label>
                                <select class="form-control select2" name="idPersonnel" required>
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
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
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