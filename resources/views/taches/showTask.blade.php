@extends('layouts.base')
@section('title','Liste des tâches')
@section('content')
<div class="container-fluid" >

   
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs" style="height:100%;display:flex">
        <div class="col-md-5 align-self-center" >

            <h4 class="theme-cl"><i class="ti i-cl-0 ti-layers"></i> Tâches > <span class="label bg-info"><b>Liste des tâches</b></span></h4>
        </div>
        @if(Auth::user()->role=="Administrateur" || Auth::user()->role=="Assistant")
        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a  href="{{ route('taskForm',[$idAffaire='x','all']) }}" class="cl-white theme-bg btn btn-rounded"
                        title="Créer une tâche">
                        <i class="ti-wand"></i>
                        Créer une Tâche
                    </a>
                </div>
            </div>
        </div>
        @else
        @endif
        <!-- Title & Breadcrumbs-->

    </div>

    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">

        <div class="table-responsive">
            <div class="category-filter">
                <select id="categoryFilter" class="categoryFilter form-control">
                    <option value="">Tous</option>
                    <option value="validée">Validée</option>
                    <option value="En cours">En cours</option>
                    <option value="suspendu">Suspendu</option>
                    <option value="Hors Délais">Hors Délais</option>
                </select>
            </div>
            <table id="filterTable" class=" filterTable dataTableExport table table-bordered table-hover"
                style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" >N°</th>
                        <th scope="col" >Tâche</th>
                        <th scope="col">Affaire</th>
                        <th scope="col">Date début</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Statut</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($taches as $row)
                    <tr>
                        <td scope="col">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col"><a class="load" href="{{ route('infosTask', [$row->slug]) }}"> {{ $row->titre }}</a>
                        </td>
                        @if(is_null($row->idAffaire))
                        <td scope="col">Cabinet</td>
                        @else
                        <td scope="col">{{ $row->idClient }} - {{ $row->prenom }} {{ $row->nom }} {{ $row->denomination }} - {{ $row->nomAffaire }}
                            
                        </td>

                        @endif
                        <td scope="col">
                            @if(empty($row->dateDebut))
                                <small>N/A</small>
                            @else
                                 {{ date('d-m-Y', strtotime($row->dateDebut)) }}
                            @endif
                            </td>
                        <td scope="col">
                            @if(empty($row->dateFin))
                                <small>N/A</small>
                            @else
                                {{ date('d-m-Y', strtotime($row->dateFin)) }}
                            @endif
                           </td>
                        <td scope="col">
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