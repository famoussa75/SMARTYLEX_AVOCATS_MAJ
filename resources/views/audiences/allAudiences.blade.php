@extends('layouts.base')
@section('title','Audiences Contradictoires')
@section('content')


<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        {{-- Titre et icône --}}
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper me-3">
                <i class="fa fa-balance-scale"></i>
            </div>
            <div>
                @if($typeListe == 'a_venir')
                    <h4 class="page-title mb-1">
                        Procédures <span class="page-subtitle">› À venir</span>
                    </h4>
                @elseif($typeListe == 'filtrer')
                    <h4 class="page-title mb-1">
                        Procédures <span class="page-subtitle">› Contradictoires</span>
                    </h4>
                @else
                    <h4 class="page-title mb-1">
                        Procédures <span class="page-subtitle">› Contradictoires</span>
                    </h4>
                @endif
            </div>
        </div>

        {{-- Boutons --}}
        <div class="d-flex align-items-center mt-2 mt-md-0">
            <a href="{{ route('addAudience') }}" title="Créer une audience" class="btn btn-gradient-custom me-2">
                <i class="fa fa-plus me-1"></i> Créer une nouvelle procédure
            </a>&nbsp;

            @if($typeListe == 'a_venir')
                <a href="{{ route('listAudience', 'generale') }}" title="Toutes les audiences" class="btn btn-outline-primary-custom">
                    <i class="fa fa-list me-1"></i> Toutes les audiences
                </a>
            @elseif($typeListe == 'filtrer')
                <a href="{{ route('listAudience', 'generale') }}" title="Toutes les audiences" class="btn btn-outline-primary-custom">
                    <i class="fa fa-list me-1"></i> Toutes les audiences
                </a>
            @else
                <a href="{{ route('listAudience', 'a_venir') }}" title="Audiences à venir" class="btn btn-outline-primary-custom">
                    <i class="fa fa-calendar me-1"></i> Audiences à venir
                </a>
            @endif
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
                <p><b>NB:</b> Les procédures à venir se déroulent entre le dernier vendredi à <b> 12h :00min :00s</b> et le vendredi suivant à  <b>11h :59 min :59s</b></p>
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
                    <tr onclick="window.location='{{ route('detailAudience', ['id' => $row['idAudience'], 'slug' => $row['slugAud'], 'niveau' => $row['niveauProcedural']]) }}'" style="cursor:pointer;">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['numRg'] ?? 'N/A' }}</td>
                        <td>
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
                                
                        </td>

                        <td>

                            {{ $row['objet'] }}
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
                            @if (empty($row['dateAudience']) || $row['dateAudience'] == 'N/A')
                                <small class="label bg-light text-dark">Suivi à compléter</small>
                            @else
                                @if(strtotime($row['dateAudience']) < strtotime(date('Y-m-d')))
                                    <small class="label bg-light text-dark">Suivi à compléter</small>
                                @else
                                    {{ date('d/m/Y', strtotime($row['dateAudience'])) }}
                                
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