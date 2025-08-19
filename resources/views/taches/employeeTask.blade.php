@extends('layouts.base')
@section('title','Liste des tâches')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

            <h4 class="theme-cl"><i class="fa fa-navicon"></i> Mes Tâches</h4>
        </div>
        @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant")
        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a  href="{{ route('taskForm') }}" class="cl-white theme-bg btn btn-rounded" title="Créer une tâche">
                        <i class="ti-wand"></i>
                        Créer Une Tâche
                    </a>
                </div>
            </div>
        </div>
        @else
        @endif
        <!-- Title & Breadcrumbs-->

    </div>

    <div class="card  col-md-12" style="margin-top:30px;padding:10px">

<div class=" table-responsive">
    <div class="category-filter">
        <select id="categoryFilter" class="categoryFilter form-control">
            <option value="">Tous</option>
            <option value="validée">Validée</option>
            <option value="En cours">En cours</option>
            <option value="suspendu">Suspendu</option>
            <option value="Hors Délais">Hors Délais</option>

        </select>
    </div>
    <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th style="width:10px;">N°</th>
                <th>Tâche</th>
                <th>Affaire</th>
                <th>Deadline</th>
                <th>Fonction</th>
                <th>Statut</th>
                <th style="width:10px;">Action</th>

            </tr>
        </thead>

        <tbody>
            @foreach($taches as $row)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td><a class="load" href="{{ route('infosTask', [$row->slug]) }}"> {{ $row->titre }}</a></td>
                @if(is_null($row->idAffaire))
                <td>Cabinet</td>
                @else
                <td>{{ $row->idClient }} - {{ $row->prenom }} - {{ $row->nom }} {{ $row->denomination }}
                </td>
                @endif
                <td>{{ date('d-m-Y', strtotime($row->dateFin)) }}</td>
                <td>
                    <span class="btn btn-small font-midium font-13 btn-rounded @if($row->fonction=='Responsable')bg-primary-light @else bg-default-light @endif"> 
                        {{ $row->fonction }}
                    </span>
                </td>
                <td>
                    @if($row->statut =='validée')
                    <div class="label" style="background-color:green ;">{{ $row->statut }}</div>
                    @elseif($row->statut =='En cours')
                    <div class="label" style="background-color:aqua ;color:green">{{ $row->statut }}</div>
                    @elseif($row->statut =='suspendu')
                    <div class="label" style="background-color:grey ;">{{ $row->statut }}</div>
                    @else
                    <div class="label" style="background-color:red ;">{{ $row->statut }}</div>
                    @endif
                </td>
                <td>
                    <a class="load" href="{{ route('infosTask', [$row->slug]) }}"><i class="fa fa-info-circle"></i></a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
<script>
    document.getElementById('tch').classList.add('active');
</script>

<!-- /.row -->
@endsection