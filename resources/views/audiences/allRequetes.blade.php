@extends('layouts.base')
@section('title','Liste des audiences')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
           
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Procédures > <span class="label bg-info"><b>Non contradictoires</b></span> </label></h4>
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('addAudience') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une nouvelle procédure
                </a>
            </div>
           
            <!-- <div class="btn-group">
                <a href="{{ route('createJonctionEtape1') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une jonction
                </a>
            </div> -->
        </div>
    </div>



    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">
        @if (empty($requetes))
        <div class="alert alert-warning alert-dismissable" style="height: 100px;">
            <div class="card-body">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">×</button>
                <div class="text-center">
                    <span>Aucune requête trouvée,
                    </span>
                    <a class="load" href="{{ route('addAudience') }}">
                        <i class="fa fa-plus"></i> cliquer pour créer une nouvelle procédure
                    </a>
                </div>
            </div>
        </div>
        @else

        <div class="table-responsive">

            <!-- <div class="col-md-12 align-self-center mb-4">
                <form method="post" action="{{route('filtreAudience')}}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="btn-group mr-lg-2">
                        <h4 class="theme-cl"><i class="fa fa-filter"></i> Filtre</h4>
                    </div>

                    <div class="btn-group mr-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Du</span>
                            <input type="date" name="dateDebut" class="form-control" id="basic-url" value="{{ $dateDebut ?? $requetes[0]->prochaineAudience ?? '' }}"
                                aria-describedby="basic-addon3" required>
                        </div>
                    </div>

                    <div class="btn-group mr-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Au</span>
                            <input type="date" name="dateFin" class="form-control" id="basic-url" value="{{ $dateFin ?? end($requetes)->prochaineAudience ?? '' }}"
                                aria-describedby="basic-addon3" required>
                        </div>
                    </div>
                    <div class="btn-group mr-lg-2">
                        <button type="submit" title="Filtrer" class="btn btn-default">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>

                </form>

            </div> -->
           
            <div class="category-filter">
                <select id="" class="categoryFilter form-control">
                    <option value="">Filtre par statut</option>
                    <option value="Déposée">Déposée</option>
                    <option value="Terminée">Terminée</option>

                </select>
            </div>
            <table id="filterTable"
                class="filterTable dataTableExport table table-bordered table-hover"
                style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Objet</th>
                        <th>Type de requête</th>
                        <!--<th>Juridiction présidentielle</th>-->
                        <th>demande</th>
                        <th>Parties</th>
                        <th>Date requête</th>
                        <th>Statut</th>
                    </tr> 
                </thead>
                <tbody>
                    @foreach ($requetes as $row)
                    <tr>
                        
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ route('detailRequete', $row->slug) }}">{{ $row->objet }}</a></td>
                        <td>{{ $row->typeRequete }}</td>
                       <!-- <td>{{ $row->juridictionPresidentielle }}</td> -->
                        <td>{{ $row->demandeRequete }}</td> 

                        <td>
                              <!-- Affichage du cabinet -->
                              @foreach($cabinet as $c)
                                    @if($row->idProcedure === $c->idRequete)
                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                    @endif
                                @endforeach

                                <!-- Affichage de l'entreprise adverse -->
                                @foreach($entreprise_adverses as $e)
                                    @if($row->idProcedure === $e->idRequete)
                                        <span>c/ {{ $e->denomination }}</span>
                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                    @endif
                                @endforeach

                                 <!-- Affichage de personne adverse -->
                                 @foreach($personne_adverses as $p)
                                    @if($row->idProcedure === $p->idRequete)
                                        <span>c/ {{ $p->prenom }} {{ $p->nom }}</span>
                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                    @endif
                                @endforeach

                                <!-- Affichage d'autres rôles -->
                                @foreach($autreRoles as $r)
                                    @if($row->idProcedure === $r->idRequete)
                                        @if($r->autreRole === 'mp')
                                            <span>c/ Ministère public</span>
                                        @endif
                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                    @endif
                                @endforeach

                        </td>
                       
                            @if(empty($row->dateRequete))
                            <td>
                                <span>N/A</span>
                            </td>
                            @else
                            <td>{{ date('d/m/Y', strtotime($row->dateRequete)) }} </td>
                             
                            @endif
                        <td>
                            <!--
                                <span>
                                        @if($row->statut=='Terminée')
                                        <small class="label bg-success-light">{{ $row->statut }}</small>
                                        @elseif($row->statut=='Jonction')
                                        <small class="label bg-blue">{{ $row->statut }}</small>
                                        @else
                                        <small class="label bg-warning-light">{{ $row->statut }}</small>
                                        @endif
                                    </span> -->
                             <span>
                                @if($row->statut=='Terminée')
                                    <small class="label bg-success">Terminée</small>
                                @elseif($row->statut=='Déposée')
                                    <small class="label bg-primary">Déposée</small>
                                @elseif($row->statut=='Acceptée')
                                    <small class="label bg-success">Acceptée</small>
                                @elseif($row->statut=='Rejetée')
                                    <small class="label bg-danger">Rejetée</small>

                                @endif
                            </span>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>




</div>
<!-- /.row -->

<script>
document.getElementById('aud').classList.add('active');

function changeTab1() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");
    id1.classList.add("active");
    id2.classList.remove("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}

function changeTab2() {

    var id1 = document.getElementById("t1");
    var id2 = document.getElementById("t2");
    var id3 = document.getElementById("t3");
    var id4 = document.getElementById("t4");
    var id5 = document.getElementById("t5");
    var id6 = document.getElementById("t6");
    var id7 = document.getElementById("t7");
    id1.classList.remove("active");
    id2.classList.add("active");
    id3.classList.remove("active");
    id4.classList.remove("active");
    id5.classList.remove("active");
    id6.classList.remove("active");
    id7.classList.remove("active");

}
</script>
@endsection