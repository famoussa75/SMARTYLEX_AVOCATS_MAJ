@extends('layouts.base')
@section('title','Liste des audiences')
@section('content')
<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            @if($typeListe == 'a_venir')
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Procédures > <span class="label bg-info"><b>À venir</b></span></h4>
            @elseif($typeListe == 'filtrer')
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Procédures > <span class="label bg-info"><b>Contradictoires</b></span></h4>
            @else
            <h4 class="theme-cl"><i class="fa fa-balance-scale"></i> Procédures > <span class="label bg-info"><b>Contradictoires</b></span></h4>
            @endif
        </div>

        <div class="col-md-7 text-right">

            <div class="btn-group">
                <a href="{{ route('addAudience') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une nouvelle procédure
                </a>
            </div>
            @if($typeListe == 'a_venir')
            <div class="btn-group">
                <a href="{{ route('listAudience', 'generale') }}" title="Audiences à venir"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-list"></i> Toutes les audiences
                </a>
            </div>
            @elseif($typeListe == 'filtrer')
            <div class="btn-group">
                <a href="{{ route('listAudience', 'generale') }}" title="Audiences à venir"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-list"></i> Toutes les audiences
                </a>
            </div>

            @else
            <div class="btn-group">
                <a href="{{ route('listAudience', 'a_venir') }}" title="Toutes les audiences"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-date"></i> Audiences à venir
                </a>
            </div>
            @endif
           
            <!-- <div class="btn-group">
                <a href="{{ route('createJonctionEtape1') }}" title="Créer une audience"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-plus"></i> Créer une jonction
                </a>
            </div> -->
        </div>
    </div>



    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">
        @if (empty($formattedAudiences))
        <div class="alert alert-warning alert-dismissable" style="height: 100px;">
            <div class="card-body">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">×</button>
                <div class="text-center">
                    <span>Aucune audience trouvée,
                    </span>
                    <a class="load" href="{{ route('addAudience') }}">
                        <i class="fa fa-plus"></i> cliquer pour créer une nouvelle audience
                    </a>
                </div>
            </div>
        </div>
        @else

        <div class="table-responsive">

            <div class="col-md-12 align-self-center mb-4">
                <form method="post" action="{{route('filtreAudience')}}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf

                    <div class="btn-group mr-lg-2">
                        <h4 class="theme-cl"><i class="fa fa-filter"></i> Audiences</h4>
                    </div>


                    <div class="btn-group mr-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Du</span>
                            <input type="date" name="dateDebut" class="form-control" id="basic-url" value="{{ $dateDebut ?? $dateDernierVendredi ?? '' }}"
                                aria-describedby="basic-addon3" required>
                        </div>

                    </div>
                    

                    <div class="btn-group mr-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Au</span>
                            <input type="date" name="dateFin" class="form-control" id="basic-url" value="{{ $dateFin ?? $dateProchainVendredi ?? '' }}"
                                aria-describedby="basic-addon3" required>
                        </div>

                    </div>
                    

                    <div class="btn-group mr-lg-2">
                        <button type="submit" title="Filtrer" class="btn btn-default">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>

                </form>

            </div>
            @if(isset($dateDernierVendredi) && $dateDernierVendredi != '' && isset($dateProchainVendredi) && $dateProchainVendredi != '')
                <p><b>NB:</b> Les procédures à venir sont dans l'interval du dernier vendredi à <b>12:00:00</b> au prochain vendredi à <b>11:59:59</b>.</p>
            @endif
   
            <div class="category-filter">
                <select id="categoryFilter1" class="categoryFilter1 form-control">
                    <option value="">Filtre par niveau</option>
                    <option value="1ère instance">1ère instance</option>
                    <option value="Appel">Appel</option>
                    <option value="Cassation">Cassation</option>

                </select>
            </div>
            <div class="category-filter">
                <select id="categoryFilter2" class="categoryFilter2 form-control">
                    <option value="">Filtre par statut</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminée">Terminée</option>

                </select>
            </div>
            <table id="filterTable2"
                class="filterTable2 dataTableExport table table-bordered table-hover"
                style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>N°RG</th>
                        <th>Parties</th>
                        <th>Objet</th>
                        <th>Niveau Procedural</th>
                        <th>Prochaine audience</th>
                        <th>Statut</th>
                    </tr> 
                </thead>
                <tbody>
              
                    @foreach ($formattedAudiences as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['numRg'] ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('detailAudience', ['id' => $row['idAudience'], 'slug' => $row['slugAud'], 'niveau' => $row['niveauProcedural']]) }}"
                            data-toggle="tooltip" title="Voir plus de cette audience">
                                <span>{{ $row['ministerePublic'] }}</span>
                                <span>
                                    @if(is_array($row['parties']) && !empty($row['parties']))
                                        {{ implode(', ', $row['parties']) }}
                                    @else
                                       {{ $row['parties'] }}
                                    @endif
                                </span>
                                
                                <span>
                                    @if(is_array($row['partieCivile']) && !empty($row['partieCivile']))
                                        Partie civile : {{ implode(', ', $row['partieCivile']) }}
                                    @else
                                        {{ $row['partieCivile'] }}
                                    @endif
                                </span>
                                <span>
                                    @if(is_array($row['intervenant']) && !empty($row['intervenant']))
                                        Intervenant : {{ implode(', ', $row['intervenant']) }}
                                    @else
                                       {{ $row['intervenant'] }}
                                    @endif
                                </span>
                                
                            </a>
                        </td>

                        <td>
                            <a href="{{ route('detailAudience', ['id' => $row['idAudience'], 'slug' => $row['slugAud'] ,$row['niveauProcedural'] ]) }}"
                                data-toggle="tooltip" title="Voir plus de cette audience">
                                {{ $row['objet'] }}
                            </a>
                        </td>
                        <td>
                            <span>
                                @if($row['niveauProcedural']=='1ère instance')
                                <small class="label bg-success">{{ $row['niveauProcedural'] }}</small>
                                @elseif($row['niveauProcedural']=='Appel')
                                <small class="label bg-warning">{{ $row['niveauProcedural'] }}</small>
                                @else
                                <small class="label bg-danger">{{ $row['niveauProcedural'] }}</small>
                                @endif
                            </span>
                        </td>
                        <td>
                            @php
                                $dateAudience= $row['prochaineAudience'];
                            @endphp

                            @if (empty($dateAudience) || $dateAudience == 'N/A')
                                N/A
                            @else
                                @if (strtotime($dateAudience) < strtotime(date('Y-m-d')))
                                    <span class="label bg-danger">suivi incomplet</span>
                                @else
                                    {{ date('d/m/Y', strtotime($dateAudience)) }}
                                @endif
                            @endif

                                
                        </td>
                        <td>
                            <span>
                                @if($row['statutAud']=='Terminée')
                                <small class="label bg-success-light">{{ $row['statutAud'] }}</small>
                                @elseif($row['statutAud']=='Jonction')
                                <small class="label bg-blue">{{ $row['statutAud'] }}</small>
                                @else
                                <small class="label bg-warning-light">{{ $row['statutAud'] }}</small>
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
</script>
@endsection