<div class="container-fluid">

   
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption info">
                    <div class="row">
                        <div class="col-4 padd-r-0">
                            <i class="icon ti-user"></i>
                        </div>
                        <div class="col-8">
                            <div class="widget-detail">
                                <h3 class="cl-info infoPrive mb-2">{{count($clients)}}</h3>
                                <h4>Clients du cabinet</h4>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption success">
                    <div class="row">
                        <div class="col-4 padd-r-0">
                            <i class="icon fa fa-envelope"></i>
                        </div>
                        <div class="col-8">
                            <div class="widget-detail">
                            <h3 class="cl-success infoPrive mb-2">{{ count($courrierArriver ?? []) }}</h3>

                                <h4> Courriers Rentrants</h4>
                            </div>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption danger">
                    <div class="row">
                        <div class="col-4 padd-r-0">
                            <i class="icon fa fa-envelope"></i>
                        </div>
                        <div class="col-8">
                            <div class="widget-detail">
                                <h3 class="cl-danger infoPrive mb-2">{{ count($courrierDepart ?? []) }}</h3>

                                <h4> Courriers Sortants</h4>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-3 col-sm-6">
            <div class="widget standard-widget">
                <div class="widget-caption warning">
                    <div class="row">
                        <div class="col-4 padd-r-0">
                            <i class="icon fa fa-line-chart"></i>
                        </div>
                        <div class="col-8">
                            <div class="widget-detail">
                                <h3 class="cl-warning">$0</h3>
                                <span>Caisse du Cabinet</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="widget-line">
                                <span style="width:70%;" class="bg-warning widget-horigental-line"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption warning">
                    <div class="row">
                        <div class="col-4 padd-r-0">
                            <i class="icon fa fa-line-chart"></i>
                        </div>
                        <div class="col-8">
                            <div class="widget-detail">
                                <h3 class="infoPrive mb-2">{{$score[0]->score ?? ''}}</h3>
                                <h4>Mon Score</h4>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="card" style="height:410px;max-height:410px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="#"><h4 class="mb-0"><i class="fa fa-balance-scale"></i> Audiences à venir</h4></a>
                    <!-- <a href="{{ route('listAudience', 'a_venir') }}">Voir plus &nbsp;<i class="fa fa-arrow-right"></i></a> -->
                </div>

                <div class="card-body col-md-12" id="scrollableDiv" style="overflow-y:scroll;  scroll-behavior: smooth; height:285px;">

                    @if(empty($audiences))
                    <h2 style="padding: 50px; color:gray;text-align:center">Aucune audience à venir</h2>
                    @else
                        @foreach($audiences as $w)

                        <div class="ground ground-list-single">
                                <div class="ground-left">
                                    <a class=" btn btn-small font-midium font-13 btn-rounded  w-100" href="#">No
                                        :{{$w->idAudience}}</a>
                                </div>
                                <a href="{{ route('detailAudience', ['id' => $w->idAudience, 'slug' => $w->slug,'niveau'=>$w->niveauProcedural]) }}">
                                <div class="ground-content">
                                    <h6>
                                        <b>
                                            <!-- Ministere public -->
                                                @foreach($autreRoles as $r)
                                                    @if($w->idAudience === $r->idAudience)
                                                        @if($r->autreRole === 'mp')
                                                            <span>Ministère public c/</span>
                                                        @endif
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                @endforeach


                                                <!-- Affichage du cabinet -->
                                                @foreach($cabinet as $c)
                                                    @if($w->idAudience === $c->idAudience && $c->role=='Demandeur')
                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} c/</span>
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                    @if($w->idAudience === $c->idAudience && $c->role=='Appelant(e)')
                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} c/</span>
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                    @if($w->idAudience === $c->idAudience && $c->role=='Demandeur au pourvoi')
                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} c/</span>
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                    @if($w->idAudience === $c->idAudience && $c->role=='Partie civile')
                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} c/</span>
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                    @if($w->idAudience === $c->idAudience && $c->autreRole=='pc')
                                                        <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} c/</span>
                                                        @break <!-- Sortir de la boucle une fois que le match est trouvé -->
                                                    @endif
                                                    
                                                @endforeach

                                            <!-- Affichage de l'entreprise adverse -->
                                                    @php
                                                        $denominations = [];
                                                    @endphp

                                                    @foreach($entreprise_adverses as $e)
                                                        @if($w->idAudience === $e->idAudience && in_array($e->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi','Prevenu / Accusé']))
                                                            @php
                                                                $denominations[] = $e->denomination;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <span>{{ implode(', ', $denominations) }}</span>


                                                <!-- Affichage des personnes adverses -->
                                                    @php
                                                        $personnes = [];
                                                    @endphp

                                                    @foreach($personne_adverses as $p)
                                                        @if($w->idAudience === $p->idAudience && in_array($p->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi','Prevenu / Accusé']))
                                                            @php
                                                                $personnes[] = $p->prenom . ' ' . $p->nom;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <span>{{ implode(', ', $personnes) }}</span>


                                                <!--------------------------------------------------------------- -->
                                                
                                            <!-- Affichage des entreprises adverses -->
                                                @php
                                                    $entreprises = [];
                                                @endphp

                                                @foreach($entreprise_adverses as $e)
                                                    @if($w->idAudience === $e->idAudience && in_array($e->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi','Partie civile']))
                                                        @php
                                                            $entreprises[] = $e->denomination;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                <span>{{ implode(', ', $entreprises) }}</span>


                                                <!-- Affichage des personnes adverses -->
                                                    @php
                                                        $personnes = [];
                                                    @endphp

                                                    @foreach($personne_adverses as $p)
                                                        @if($w->idAudience === $p->idAudience && in_array($p->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi','Partie civile']))
                                                            @php
                                                                $personnes[] = $p->prenom . ' ' . $p->nom;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <span>{{ implode(', ', $personnes) }}</span>


                                                @foreach($cabinet as $c)

                                                    @foreach($autreRoles as $r)
                                                        @if($w->idAudience === $r->idAudience)
                                                            @if($r->autreRole === 'mp')
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Defendeur')
                                                                    <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Intimé(e)')
                                                                    <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Defendeur au pourvoi')
                                                                    <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Prevenu / Accusé')
                                                                    <span>{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                            @else
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Defendeur')
                                                                    <span>c/ {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Intimé(e)')
                                                                    <span>c/ {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Defendeur au pourvoi')
                                                                    <span>c/ {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                                @if($w->idAudience === $c->idAudience && $c->role=='Prevenu / Accusé')
                                                                    <span>c/ {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</span>
                                                                    @break 
                                                                @endif
                                                            @endif
                                                            @break 
                                                        @endif
                                                    @endforeach
                                                
                                                @endforeach 

                                                <!-- Affichage partie civile-->
                                                @php
                                                    $personnes = [];
                                                @endphp

                                                @foreach($personne_adverses as $p)
                                                    @if($w->idAudience === $p->idAudience && in_array($p->autreRole, ['pc']))
                                                        @php
                                                            $personnes[] = $p->prenom . ' ' . $p->nom;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if(empty($personnes))
                                                @else
                                                <span>Partie civile : {{ implode(', ', $personnes) }}</span>
                                                @endif

                                                @php
                                                    $entreprises = [];
                                                @endphp

                                                @foreach($entreprise_adverses as $e)
                                                    @if($w->idAudience === $e->idAudience && in_array($e->autreRole, ['pc']))
                                                        @php
                                                            $entreprises[] = $e->denomination;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if(empty($entreprises))
                                                @else
                                                <span>Partie civile : {{ implode(', ', $entreprises) }}</span>
                                                @endif

                                            


                                                <!-- Affichage Intervenant-->
                                                @php
                                                    $personnes = [];
                                                @endphp

                                                @foreach($personne_adverses as $p)
                                                    @if($w->idAudience === $p->idAudience && in_array($p->autreRole, ['in']))
                                                        @php
                                                            $personnes[] = $p->prenom . ' ' . $p->nom;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if(empty($personnes))
                                                @else
                                                <span>Intervenant : {{ implode(', ', $personnes) }}</span>
                                                @endif

                                                @php
                                                    $entreprises = [];
                                                @endphp

                                                @foreach($entreprise_adverses as $e)
                                                    @if($w->idAudience === $e->idAudience && in_array($e->autreRole, ['in']))
                                                        @php
                                                            $entreprises[] = $e->denomination;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if(empty($entreprises))
                                                @else
                                                <span>Intervenant : {{ implode(', ', $entreprises) }}</span>
                                                @endif
                                        </b>
                                    </h6>
                                    <small class="text-fade">{{$w->objet}}</small><br>
                                    <small class="text-fade label bg-dark" ><b style="font-size:11px">{{$w->semaine}}</b></small>
                                </div>
                                </a>
                        </div>

                        @endforeach

                    @endif

                   

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height:410px;max-height:410px">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-users"></i> Personnes en ligne</h4>

                </div>

                <div class="card-body col-md-12" style="overflow-y:auto; overflow-x:hidden; height:250px;">
                    @foreach($users as $u)
                    @if($u->statut=='actif')
                    <div class="ground ground-list-single">
                        <a href="#">
                            <img class="ground-avatar" src="/{{$u->photo}}" alt="...">
                            <span class="profile-statut bg-online pull-right"></span>
                        </a>

                        <div class="ground-content">
                            <h6><a href="#"><b>{{$u->name}}</b></a></h6>
                            <small class="text-fade">@if($u->role=='Collaborateur') Collaborateur(trice) @elseif($u->role=='Assistant') Assistant(e) @elseif($u->role=='Administrateur') Administrateur(trice) @else @endif</small>
                        </div>

                        <div class="ground-right">
                            <a class="btn btn-small font-midium font-13 btn-rounded btn-success w-100" href="#">Actif</a>
                        </div>
                    </div>
                    @else
                    <div class="ground ground-list-single">
                        <a href="#">
                            <img class="ground-avatar" src="/{{$u->photo}}" alt="...">
                            <span class="profile-statut bg-offline pull-right"></span>
                        </a>

                        <div class="ground-content">
                            <h6><a href="#"><b>{{$u->name}}</b></a></h6>
                            <small class="text-fade">@if($u->role=='Collaborateur') Collaborateur(trice) @elseif($u->role=='Assistant') Assistant(e) @elseif($u->role=='Administrateur') Administrateur(trice) @else @endif</small>
                        </div>

                        <div class="ground-right">
                            <a class="btn btn-small font-midium font-13 btn-rounded btn-danger w-100" href="#">
                                Inactif</a>
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Bar Chart -->
        <div class="col-md-12">
            <div class="card">
                <div class="flex-box padd-10 bb-1">
                    <h4 class="mb-0">Tâches assignées</h4>
                </div>
                <div class="card-body">
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
                        <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:10px;">N°</th>
                                    <th>Tâche</th>
                                    <th>Affaire</th>
                                    <th>Deadline</th>
                                    <th>Statut</th>
                                    <th style="width:10px;">Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach($tachePerso as $row)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td><a class="load" href="{{ route('infosTask', [$row->slug]) }}"> {{ $row->titre }}</a></td>
                                    @if($row->idAffaire==0)
                                    <td>Cabinet</td>
                                    @else
                                    <td>{{ $row->idClient }} - {{ $row->prenom }} {{ $row->nom }} -
                                        {{ $row->nom }}
                                    </td>
                                    @endif
                                    <td>{{ date('d-m-Y', strtotime($row->dateFin)) }}</td>
                                    <td>
                                        @if($row->statut =='validée')
                                        <div class="label" style="background-color:green ;">{{ $row->statut }}</div>
                                        @elseif($row->statut =='En cours')
                                        <div class="label" style="background-color:aqua ;color:green">{{ $row->statut }}
                                        </div>
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
        </div>



    </div>


</div>

<script>
    console.warn = () => {};
    document.getElementById('hm').classList.add('active');
</script>