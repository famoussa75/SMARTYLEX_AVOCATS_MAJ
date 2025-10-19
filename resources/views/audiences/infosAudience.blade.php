@extends('layouts.base')
@section('title','Détail de l\'audience')
@section('content')

<style>
    /* Styles pour le bouton */
    .non-cliquable {
        cursor: default; /* Curseur par défaut */
        pointer-events: none; /* Désactiver les événements de pointer */
    }

    /* Styles pour le curseur au survol */
    .non-cliquable:hover {
        cursor: not-allowed; /* Curseur "non autorisé" au survol */
    }

    @keyframes clignotement {
        0% { background-color: #ffcc00; } /* Couleur initiale */
        50% { background-color: #ffffff; } /* Couleur de clignotement */
        100% { background-color: #ffcc00; } /* Couleur initiale */
    }

    /* Appliquer l'animation à la classe .clignotante */
    .clignotante {
        animation: clignotement 1s infinite;
    }
</style>

@if(empty($audience))
<div class="container-fluid @if (Auth::user()->role=='Client') bg-secondary @else  @endif">
    <!-- Title & Breadcrumbs-->
    <div class=" row page-breadcrumbs">
        <div class="row col-md-12 align-self-center">
            <div class="col-md-8">
               texte
            </div>

        </div>

    </div>

    <div class="card">
        <div class="detail-wrapper padd-top-30">
            <div class="row text-center">
                <div class="col-md-12">
                    &nbsp;&nbsp;
                </div>
            </div>
            <div class=" row  mrg-0 detail-invoice">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1" style="text-align: right;border-right:1px solid;padding-top:20px;">
                            <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-12" style="font-size:medium;text-align:center">
                            <p><b>Juridiction :</b> {{ $audience2[0]->nom }} | <b>Objet :</b>
                                {{ $audience2[0]->objet }} |
                                <b>Parties :</b> 
                                @foreach($audience as $w)

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
                                       
                                        @endforeach

                               
                            </p>
                            <p>
                                <b>Niveau procédural :</b> <span
                                    class="label cl-success bg-success-light"><b>{{ $niveau }}</b></span>
                                |
                                <b>Nature :</b> <span
                                    class="label cl-success bg-success-light"><b>{{ $audience2[0]->nature }}</b></span>
                                |
                                <b>Date de création:</b> <span
                                    class="label cl-success bg-success-light"><b>{{ date('d/m/Y', strtotime($audience2[0]->created_at)) }}</b></span>
                            </p>

                        </div>
                        <div class="col-md-1" style="text-align: left;border-left:1px solid;padding-top:20px;">
                            <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                        </div>

                    </div>
                </div>
                <hr />
            </div>
            <div class="row mrg-0">
                <div class="col-md-5 col-sm-5 col-xs-5">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <a href="#" class="fa fa-angle-double-up" style="font-size:7ch; text-align:center;" id="up"></a>
                    <a href="#" class="fa fa-angle-double-down" style="font-size:7ch; text-align:center;" id="down"></a>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                </div>
            </div>
        </div>
    </div>
    <h1 class="text-center" style="padding: 50px;">
        <span class="label cl-danger bg-danger-light" style="padding: 20px;"><i class="fa fa-warning"></i> Aucune
            information disponible pour le moment...</span>
    </h1>
    <p class="text-center">

        <a href="javascript:history.back()" class="cl-white theme-bg btn btn-rounded">
            <i class="fa fa-long-arrow-left"></i> Retour
        </a>
        Les informations pour ce niveau procedural ne sont pas encore enregistrées.
    </p>

</div>
@else
<div class="container-fluid @if (Auth::user()->role=='Client') bg-secondary @else  @endif ">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="row col-md-12 align-self-center">
            <div class="col-md-8">
                @empty($cabinet)
                @else
                <h5 class="theme-cl">
                    <b> {{ $cabinet[0]->idClient }}</b>
                    >
                     @if($is_client==true || Auth::user()->role=='Administrateur')
                    <a class="load theme-cl"
                        href="{{route('clientInfos', [$cabinet[0]->idClient, $cabinet[0]->clientslug])}}">
                        {{ $cabinet[0]->prenom }} {{ $cabinet[0]->nom }} {{ $cabinet[0]->denomination }}
                    </a>
                    @else
                    <a class="load theme-cl"
                        href="#">
                        {{ $cabinet[0]->prenom }} {{ $cabinet[0]->nom }} {{ $cabinet[0]->denomination }}
                    </a>
                    @endif
                    >
                    @if (Auth::user()->role=='Client')
                    <a class="load theme-cl" href="#">
                        {{ $cabinet[0]->idAffaire }} {{ $cabinet[0]->nomAffaire }}
                    </a>
                    @else
                         @if($is_client==true || Auth::user()->role=='Administrateur')
                            <a class="load theme-cl"
                                href="{{ route('showAffaire', [$cabinet[0]->idAffaire,$cabinet[0]->affaireslug]) }}">
                                {{ $cabinet[0]->idAffaire }} {{ $cabinet[0]->nomAffaire }}
                            </a>
                        @else
                        <a class="load theme-cl"
                                href="#">
                                {{ $cabinet[0]->idAffaire }} {{ $cabinet[0]->nomAffaire }}
                            </a>
                        @endif
                    @endif

                    >
                    <span class="label bg-info"><b>Audience</b></span>

                </h5>
                @endif
            </div>
            <div class="col-md-4 text-right" style="float:right">
                <div class=" btn-group">
                    <a href="{{ route('listAudience', 'generale') }}" class="load btn btn-secondary">
                        <i class="fa fa-eye"></i> Voir les audiences
                    </a>
                </div>
               
                &nbsp;&nbsp;
                <div class="dropdown" style="float: right ;">
                    <button class="btn btn-rounded theme-bg dropdown-toggle @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" type="button" id="dropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="top-start"
                        style="position: absolute; transform: translate3d(0px, -18px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class=" dropdown-item " href="{{ route('addAudience') }}" title="Nouvelle audience"><i
                                class="ti-plus mr-2"></i>Créer une audience</a>
                        <a class=" dropdown-item " href="{{route('editAudience',[$audience[0]->slug,$audience[0]->idAudience])}}" title="Modifier cette audience"><i
                                class="ti-pencil mr-2"></i>Editer</a>
                        <a class=" dropdown-item "
                            href="{{route('newLevel',[$audience[0]->slug,$audience[0]->idAudience])}}"
                            title="Passer d'un niveau procedural à un autre"><i class="ti-shift-right-alt"></i> Changer
                            de niveau</a>
                        <a class=" dropdown-item " href="{{route('terminerAudience',[$audience[0]->slug])}}"
                            title="Terminé l'audience"><i class="fa fa-check"></i> Terminé l'audience</a>
                        <a class=" dropdown-item " href="{{route('deleteAud',[$audience[0]->idAudience])}}"
                            title="Reprendre cet audience"><i class="ti-trash mr-2"></i>Supp & Reprendre</a>
                           
                            <div class="dropdown-item text-center">
                                <button class="btn btn-sm btn-primary hidden-print" onclick="exportDivToPDF()">
                                    <i class="ti-download mr-1"></i> Télécharger PDF
                                </button>
                            </div>               


                    </div>
                </div>
            </div>
           

        </div>

    </div>
    
    <div class="row" id="pdfContent1">
        <div class="col-md-12">
            
       
            <div class="card box"  >
                <div class="ruban left @if ($audience[0]->statut=='En cours') rubanEncour @elseif ($audience[0]->statut=='Jonction') rubanJonction @else rubanTerminer @endif ">
                    <span><b>{{ $audience[0]->statut }}</b></span>
                </div>
                <div class="detail-wrapper padd-top-30">
                    <div class="row text-center">
                        <div class="col-md-12">
                            &nbsp;&nbsp;
                        </div>
                    </div>
                    
                    <div class="row  mrg-0 detail-invoice">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-1"
                                    style="text-align: right;border-right:1px solid;padding-top:20px;">
                                    <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12" style="font-size:medium;text-align:center">
                                    <p><b>Juridiction :</b> {{ $audience[0]->nom }} | <b>Objet :</b>
                                        {{ $audience2[0]->objet }} |
                                        <b>Parties :</b> 
                                        @foreach($audience as $w)

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
                                                @if($w->idAudience === $e->idAudience && in_array($e->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi', 'Prevenu / Accusé']))
                                                    @php
                                                        $denominations[] = $e->denomination;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @php
                                                $countDenominations = count($denominations);
                                            @endphp

                                            @if($countDenominations > 3)
                                                <span>{{ implode(', ', array_slice($denominations, 0, 3)) }} et {{ $countDenominations - 3 }} autres</span>
                                            @else
                                                <span>{{ implode(', ', $denominations) }}</span>
                                            @endif



                                            <!-- Affichage des personnes adverses -->
                                            @php
                                                $personnes = [];
                                            @endphp

                                            @foreach($personne_adverses as $p)
                                                @if($w->idAudience === $p->idAudience && in_array($p->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi', 'Prevenu / Accusé']))
                                                    @php
                                                        $personnes[] = $p->prenom . ' ' . $p->nom;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @php
                                                $count = count($personnes);
                                            @endphp

                                            @if($count > 3)
                                                <span>{{ implode(', ', array_slice($personnes, 0, 3)) }} et {{ $count - 3 }} autres</span>
                                            @else
                                                <span>{{ implode(', ', $personnes) }}</span>
                                            @endif



                                            <!--------------------------------------------------------------- -->
                                            
                                            <!-- Affichage des entreprises adverses -->
                                            @php
                                                $entreprises = [];
                                            @endphp

                                            @foreach($entreprise_adverses as $e)
                                                @if($w->idAudience === $e->idAudience && in_array($e->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi', 'Partie civile']))
                                                    @php
                                                        $entreprises[] = $e->denomination;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @php
                                                $countEntreprises = count($entreprises);
                                            @endphp

                                            @if($countEntreprises > 3)
                                                <span>{{ implode(', ', array_slice($entreprises, 0, 3)) }} et {{ $countEntreprises - 3 }} autres</span>
                                            @else
                                                <span>{{ implode(', ', $entreprises) }}</span>
                                            @endif



                                            <!-- Affichage des personnes adverses -->
                                            @php
                                                $personnes = [];
                                            @endphp

                                            @foreach($personne_adverses as $p)
                                                @if($w->idAudience === $p->idAudience && in_array($p->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi', 'Partie civile']))
                                                    @php
                                                        $personnes[] = $p->prenom . ' ' . $p->nom;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @php
                                                $countPersonnes = count($personnes);
                                            @endphp

                                            @if($countPersonnes > 3)
                                                <span>{{ implode(', ', array_slice($personnes, 0, 3)) }} et {{ $countPersonnes - 3 }} autres</span>
                                            @else
                                                <span>{{ implode(', ', $personnes) }}</span>
                                            @endif



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
                                       
                                        @endforeach

                                    </p>
                                    <p>
                                        <b>Niveau procédural :</b> <span
                                            class="label cl-success bg-success-light"><b>{{ $audience[0]->niveauProcedural }}</b></span>
                                        |
                                        <b>Nature :</b> <span
                                            class="label cl-success bg-success-light"><b>{{ $audience[0]->nature }}</b></span>
                                        |
                                        <b>Date de création:</b> <span
                                            class="label cl-success bg-success-light"><b>{{ date('d/m/Y', strtotime($audience[0]->created_at)) }}</b></span>
                                    </p>

                                </div>
                                <div class="col-md-1" style="text-align: left;border-left:1px solid;padding-top:20px;">
                                    <h1 class="theme-cl"> <i class="fa fa-balance-scale"></i></h1>
                                </div>

                            </div>
                        </div>
                        <hr />
                    </div>
                    <div class="row mrg-0">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 mb-5">
                            <!--
                            <a href="#" class="fa fa-angle-double-up" style="font-size:7ch; text-align:center;"
                                id="up"></a>
                            <a href="#" class="fa fa-angle-double-down" style="font-size:7ch; text-align:center;"
                                id="down"></a> -->
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($suivi as $s )
                @if($s->rappelLettre=="A_rappeler")
                <div class="alert alert-info alert-dismissable clignotante" style="padding-bottom:25px;font-size:16px">
                    <input type="hidden" value="{{ $s->slug }}" name="slugSuivit">
                    <i class="fa fa-warning"></i>&nbsp;<b style="font-size:16px">Recours :</b> le délibéré a été vidé, voulez-vous exercer une voie de recours ?&nbsp;
                    <div style="float:right;">
                        <a href="{{route('createCourierDepart', $s->slug )}}" type="button" class="btn btn-primary alert-link" style="color:white">
                            <i class="fa fa-arrow-right"></i>&nbsp;Oui 
                        </a>
                        &nbsp;&nbsp;
                        @if (Auth::user()->role=='Administrateur')
                        <a href="{{ route('annulerAppel',$s->slug) }}" type="button" class="btn btn-danger alert-link" style="color:white">
                            <i class="fa fa-close"></i>&nbsp;Non
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if($s->rappelSignification=="A_rappeler")

                    <div class="alert alert-info alert-dismissable clignotante" style="padding-bottom:25px; font-size:16px">
                        <input type="hidden" value="{{ $s->slug }}" name="slugSuivit">
                        <i class="fa fa-warning"></i>&nbsp;<b style="font-size:16px">Signification :</b> Le délibéré a été vidé. Voulez-vous signifier ?&nbsp;
                         <div style="float:right;">
                            <a href="#" type="button" class="btn btn-primary alert-link" style="color:white" data-toggle="modal" data-target="#modal-signifier">
                                <i class="fa fa-arrow-right"></i>&nbsp;Oui, signifier
                            </a>
                            &nbsp;&nbsp;
                            @if (Auth::user()->role=='Administrateur')
                            <a href="{{ route('annulerSignification',$s->slug) }}" type="button" class="btn btn-danger alert-link" style="color:white">
                                <i class="fa fa-close"></i>&nbsp;Non, ne pas signifier
                            </a>
                            @endif
                         </div>
                    </div>
                
                @endif

            @endforeach
<!--id="audienceInfos" -->
            <div class="card" >
                <div class="row col-md-12 mt-4 mb-4">
                    <div class="col-md-6 input-group">
                        <div class="input-group-btn show">
                            <button type="button" class="btn btn-secondary dropdown-toggle @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="true">
                                Filtrer par niveau
                            </button>
                            <div class="dropdown-menu show" x-placement="top-start"
                                style="position: absolute; transform: translate3d(0px, -213px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="load dropdown-item"
                                    href="{{ route('detailAudience', ['id' => $idAudience, 'slug' => $audience[0]->slug,'1ère instance'])}}">1ère
                                    instance</a>
                                <a class="load dropdown-item"
                                    href="{{ route('detailAudience', ['id' => $idAudience, 'slug' => $audience[0]->slug,'Appel'])}}">Appel</a>
                                <a class="load dropdown-item"
                                    href="{{ route('detailAudience', ['id' => $idAudience, 'slug' => $audience[0]->slug,'Cassation'])}}">Cassation</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($audience[0]->createur=='')
                        @else
                        <p style="text-align:right">Audience créée par : <b>{{$audience[0]->createur}}</b></p>
                        @endif
                    </div>
                    
                </div>
                <div class="row mrg-0">
                    <div class="col-md-12">
                        <br>
                        <!-- The timeline -->
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="@if($audience[0]->statut=='Jonction') bg-secondary @else bg-purple @endif">Suivi d'audience</span>
                                @if (Auth::user()->role=='Client')
                                @else
                                @if ($audience[0]->statut=='Terminée')
                                @else
                                <div class="btn-group text-right">

                                    <a href="#" class="btn btn-secondary @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" data-toggle="modal" data-target="#modal-2"
                                        title="Ajouter un suivi">
                                        <i class="fa  fa-plus-circle ti i-cl-4"></i> Ajouter un suivi
                                    </a>

                                </div>
                                @endif
                                @endif
                            </li>
                            <li>
                                <div class="timeline-item">

                                    @if($audience[0]->niveauProcedural=='Appel')
                                    @if(empty($suiviAppel))
                                    <div class="timeline-body">
                                        <h4 class="text-center">
                                            <span class="label bg-warning">Aucun suivi effectué pour le moment</span>
                                        </h4>
                                    </div>
                                    @else
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table id="" class=" dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th style="width: 220px;">Acte</th>
                                                        <th>Date acte</th>
                                                        <th>Reçu le</th>
                                                        <th>Date limite</th>
                                                        <th>Notifications</th>
                                                        <th>Suivi par</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($suiviAppel as $suivi )
                                                    <tr class="@if(in_array($suivi->idSuivitAppel, $tacheSuivit) && strpos($nomRoutePrecedente, 'tache') !==false)bg-default-light cl-black @else @endif ">
                                                   
                                                        <td>{{ $loop->iteration }} </td>
                                                        <td>
                                                            @if($suivi->dateLimite=='N/A')
                                                            <b>Autres</b><br><br>
                                                            @endif
                                                            {{ $suivi->acte }}
                                                        </td>
                                                        <td>
                                                            @if($suivi->dateActe=='N/A')
                                                            <small class="">N/A</small>
                                                            @else
                                                            <small
                                                                class="label bg-primary">{{ date('d/m/Y', strtotime($suivi->dateActe))}}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($suivi->dateReception=='N/A')
                                                            <small class="">N/A</small>
                                                            @else
                                                            <small
                                                                class="label bg-info">{{ date('d/m/Y', strtotime($suivi->dateReception))}}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($suivi->dateLimite=='N/A')
                                                            <small class="">N/A</small>
                                                            @else
                                                            <small
                                                                class="label bg-danger">{{ date('d/m/Y', strtotime($suivi->dateLimite))}}</small>
                                                            @endif
                                                        </td>
                                                        @if($suivi->email=="envoyer")
                                                        <td style="text-align:center">
                                                            <small class="label bg-success"><i class="fa fa-check"
                                                                    style="font-size:15px"></i> Déjà Envoyé</small>
                                                        </td>
                                                        @else
                                                        <td style="text-align:center">
                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                            <a href="#" class="btn btn-outline-secondary btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" id=""
                                                                onclick="emailModalAppel({{ $suivi->idSuivitAppel }})"
                                                                data-toggle="modal" data-target="#sentSMS"
                                                                title="Envoyer un sms"><i class="fa fa-envelope"
                                                                    style="font-size:15px"></i> Envoyer</a>
                                                            @endif

                                                        </td>
                                                        
                                                        @endif
                                                        <td> {{ $suivi->suiviPar }}</td>

                                                        <td style="text-align: center;">
                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                            @if($suivi->suiviPar==Auth::user()->name)
                                                            <small>
                                                                <a href="{{route('deleteSuiviAppel',$suivi->slug)}}"
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="supprimer"
                                                                    style="font-size:5px;color:red"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>

                                                            @endif
                                                            @endif
                                                            @if (Auth::user()->role=='Administrateur' && in_array($suivi->idSuivitAppel, $tacheSuivit))
                                                            <small>
                                                                <a href="{{route('infosTaskFromAudience', [$suivi->idSuivitAppel])}}" 
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="voir la tâche"
                                                                    style="font-size:5px;"><i
                                                                        class="fa fa-mail-forward"></i></a>
                                                            </small>
                                                          
                                                            @endif
                                                            @if (Auth::user()->role=='Administrateur' && !in_array($suivi->idSuivitAppel, $tacheSuivit))
                                                            <small>
                                                                <a href="{{route('taskForm',[$suivi->idSuivitAppel,'audienceAppel'])}}" 
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="créer une tâche"
                                                                    style="font-size:5px;"><i
                                                                        class="fa fa-legal"></i></a>
                                                            </small>
                                                          
                                                            @endif

                                                            @if (Auth::user()->role!='Administrateur' && in_array($suivi->idSuivitAppel, $tacheSuivit))
                                                            <small>
                                                                <a href="{{ route('infosTaskFromAudience', [$suivi->idSuivitAppel]) }}" 
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="voir la tâche"
                                                                    style="font-size:5px;"><i
                                                                        class="fa fa-mail-forward"></i></a>
                                                            </small>
                                                          
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    @if(empty($suivi))
                                    <div class="timeline-body">
                                        <h4 class="text-center">
                                            <span class="label bg-warning">Aucun suivi effectué pour le moment</span>
                                        </h4>
                                    </div>
                                    @else
                                    
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table id="" class=" dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 220px;">Info</th>
                                                        <th>Date audience</th>
                                                        <th>Date prochaine audience</th>
                                                        <th style="width: 220px;">Décision</th>
                                                        <th>Notifications</th>
                                                        <th>Suivi par</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                               

                                                    @foreach ($suivi as $suivi )
                                                    <tr class="@if(in_array($suivi->idSuivit, $tacheSuivit) && strpos($nomRoutePrecedente, 'tache') !==false)bg-default-light cl-black @else @endif ">
                                                        
                                                        
                                                        <td>
                                                            <div class="panel-group accordion-stylist" id="accordion{{ $loop->iteration }}" role="tablist" aria-multiselectable="true">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                                        <h4 class="panel-title">
                                                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion{{ $loop->iteration }}" href="#collapseTwo{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseTwo">
                                                                                Voir plus
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseTwo{{ $loop->iteration }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                        <div class="panel-body" style="padding:-20px">
                                                                            <h6><b>Président:</b> {{ $suivi->president }}</h6>
                                                                            <h6><b>Greffier(e):</b> {{ $suivi->greffier }}</h6>
                                                                            <h6><b>Durée:</b> {{ $suivi->heureDebut }} - {{ $suivi->heureFin }}</h6>
                                                                            <h6><b>Pièce(s):</b></h6>
                                                                            @foreach($fichiers as $f)
                                                                            @if($suivi->slug==$f->slugSource)
                                                                            <a class="load"
                                                                                href="{{route('readFile', [$f->slug,'x'])}}">
                                                                                <i class="fa fa-file-pdf-o"
                                                                                    style="font-size:1.5em; color:red;"></i>
                                                                            </a>

                                                                            @endif
                                                                            @endforeach

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if(empty( $suivi->dateAudience))
                                                                <small
                                                                class="label bg-info">N/A</small>
                                                            @else
                                                                <small
                                                                    class="label bg-info">{{ date('d/m/Y', strtotime( $suivi->dateAudience))}}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if( $suivi->dateProchaineAudience=='N/A')
                                                            <small class="label bg-warning">N/A</small>
                                                            @else
                                                            <small
                                                                class="label bg-info">{{ date('d/m/Y', strtotime( $suivi->dateProchaineAudience))}}</small>
                                                            @endif
                                                        </td>
                                                        <td> 
                                                            {{ $suivi->decision }} 
                                                            @if($suivi->extrait)
                                                            <br><br><b>Extrait</b>
                                                            <hr style="margin-top:-1px;margin-bottom:7px">
                                                            {{ $suivi->extrait }} 
                                                            @endif
                                                        </td>

                                                       
                                                        @if($suivi->email=="envoyer")
                                                        <td style="text-align:center">
                                                            <small class="label bg-success"><i class="fa fa-check"
                                                                    style="font-size:15px"></i> Déjà Envoyé</small>
                                                        </td>
                                                        @else
                                                        <td style="text-align:center">
                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                            <a href="#" class="btn btn-outline-secondary btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" id=""
                                                                onclick="emailModal({{ $suivi->idSuivit }})"
                                                                data-toggle="modal" data-target="#sentSMS"
                                                                title="Envoyer un sms"><i class="fa fa-envelope"
                                                                    style="font-size:15px"></i> </a>
                                                            @endif

                                                        </td>
                                                        @endif
                                                        <td> {{ $suivi->suiviPar }}</td>

                                                        <td style="text-align: center;">
                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                            
                                                                @if($suivi->suiviPar==Auth::user()->name)
                                                                <small>
                                                                    <a href="{{route('deleteSuiviAud',$suivi->slug)}}"  onclick="event.preventDefault(); confirmDelete(this.href)" type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="supprimer"
                                                                        style="font-size:5px;color:red"><i
                                                                            class="ti-trash"></i></a>
                                                                </small>

                                                                @endif

                                                            @endif
                                                            @if ( in_array($suivi->idSuivit, $tacheSuivit))
                                                            <small>
                                                                <a href="{{route('infosTaskFromAudience', [$suivi->idSuivit])}}" 
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="voir la tâche"
                                                                    style="font-size:5px;"><i
                                                                        class="fa fa-mail-forward"></i></a>
                                                            </small>
                                                          
                                                            @endif
                                                            @if ( !in_array($suivi->idSuivit, $tacheSuivit))
                                                            <small>
                                                                <a href="{{route('taskForm',[$suivi->idSuivit,'audience'])}}" 
                                                                    type="" class="@if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" title="créer une tâche"
                                                                    style="font-size:5px;"><i
                                                                        class="fa fa-legal"></i></a>
                                                            </small>
                                                          
                                                            @endif

                                                           
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                    @endif

                                </div>
                            </li>
                        </ul>
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class=" @if($audience[0]->statut=='Jonction') bg-secondary @else bg-blue @endif" style="color:white">Parties concernées</span>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th>Parties</th>
                                                        <th>Role</th>
                                                        <th>Avocats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($cabinet as $c )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($c->role=='Autre')
                                                            @if($c->autreRole=='in')
                                                            <small class="label bg-success">Intervenant</small>
                                                            @elseif($c->autreRole=='pc')
                                                            <small class="label bg-success">Partie civile</small>
                                                            @elseif($c->autreRole=='mp')
                                                            <small class="label bg-success">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-success">{{ $c->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(Session::has('cabinetSession'))
                                                            @foreach (Session::get('cabinetSession') as $cab)
                                                            <span>{{$cab->nomCourt}}</span>
                                                            @endforeach
                                                            @else
                                                            <span>Le cabinet</span>
                                                            @endif
                                                            @foreach($avocats as $a1)
                                                            @if($a1->idPartie==$c->idPartie)
                                                             <span>{{$a1->prenomAvc}} {{$a1->nomAvc}}</span>
                                                            @else
                                                            @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($personne_adverses as $p )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $p->prenom }} {{ $p->nom }}
                                                        </td>
                                                        <td>
                                                            @if($p->role=='Autre')
                                                            @if($p->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($p->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($p->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $p->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($avocats as $a2)
                                                            @if($a2->idPartie==$p->idPartie)
                                                            <span>{{$a2->prenomAvc}} {{$a2->nomAvc}}</span>
                                                            @else
                                                            @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @foreach ($entreprise_adverses as $e )
                                                    <tr style="text-align: center;">

                                                        <td>
                                                            {{ $e->denomination }}
                                                        </td>
                                                        <td>
                                                            @if($e->role=='Autre')
                                                            @if($e->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($e->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($e->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @else
                                                            <small class="label bg-danger">{{ $e->role }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($avocats as $a3)
                                                            @if($a3->idPartie==$e->idPartie)
                                                            <span>{{$a3->prenomAvc}} {{$a3->nomAvc}}</span>
                                                            @else
                                                            @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                    @endforeach

                                                    <!-- <tr style="text-align: center;">
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach($autreRoles as $r)
                                                            @if($r->autreRole=='in')
                                                            <small class="label bg-warning">Intervenant</small>
                                                            @elseif($r->autreRole=='pc')
                                                            <small class="label bg-warning">Partie civile</small>
                                                            @elseif($r->autreRole=='mp')
                                                            <small class="label bg-warning">Ministère public</small>
                                                            @endif
                                                            @endforeach
                                                        </td>
                                                    </tr> -->


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </li>

                        </ul>
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="@if($audience[0]->statut=='Jonction') bg-secondary @else bg-red @endif" style="color:white">Acte introductif d'instance</span>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    @foreach($acteIntroductif as $a)
                                    <div class="timeline-body">
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h3>{{$a->typeActe}}#{{$loop->iteration}}</h3>
                                            <hr>
                                            <!-- <h5><b>Nature de l'action :</b> </h5>
                                            <hr> -->
                                        </div>
                                        @if($a->typeActe=='Contredit' && !empty($contredit))
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° concernée :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numConcerner"
                                                        value="{{$contredit[0]->numConcerner}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° decision :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numDecisConcerner"
                                                        value="{{$contredit[0]->numDecisConcerner}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date du contredit
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateContredit"
                                                        value="{{date('d/m/Y', strtotime($contredit[0]->dateContredit))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date de la decision
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateContredit"
                                                        value="{{date('d/m/Y', strtotime($contredit[0]->dateContredit))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($a->typeActe=='Assignation' && !empty($assignation))
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° RG :</label>
                                                    <input type="text" class="form-control" id="inputRG"
                                                        data-error=" veillez saisir le N° RG" name="numRg"
                                                        value="{{$assignation[0]->numRg}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="client" class="control-label">Huissier
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputRG"
                                                        data-error=" veillez saisir le N° RG" name="idHuissier"
                                                        value="{{$assignation[0]->prenomHss}} {{$assignation[0]->nomHss}}"
                                                        disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">Réçue par :</label>
                                                    <input type="text" class="form-control" id="inpuRC"
                                                        data-error=" veillez saisir le nom du receveur"
                                                        name="recepteurAss" value="{{$assignation[0]->recepteurAss}}"
                                                        disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date assignation
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputASN"
                                                        data-error=" veillez saisir la date asignation"
                                                        name="dateAssignation"
                                                        value="{{date('d/m/Y', strtotime($assignation[0]->dateAssignation))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputFDAT" class="control-label">Date de la 1ère
                                                        comparution
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputFDAT"
                                                        data-error=" veillez saisir la Date de la première comparution"
                                                        name="datePremiereComp"
                                                        value="{{date('d/m/Y', strtotime($assignation[0]->datePremiereComp))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputENAS" class="control-label">Date enrôlement
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputENAS"
                                                        data-error=" veillez saisir la date d'enroulement"
                                                        name="dateEnrollement"
                                                        value="{{date('d/m/Y', strtotime($assignation[0]->dateEnrollement))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="mentionP" class="control-label">Mention particulière
                                                        :</label>
                                                    <textarea id="mentionP" cols="4" rows="2" class="form-control"
                                                        data-error=" veillez saisir la mention particulière"
                                                        name="mentionParticuliere" value=""
                                                        disabled>{{$assignation[0]->mentionParticuliere}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            @if($audience[0]->isChild=='oui')
                                            @else
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièces :</label>
                                                    @foreach($pieceAS as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        @if (Auth::user()->role=='Client')
                                                        @else
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button"   onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                           
                                        @endif
                                        @if($a->typeActe=='Requete' && !empty($requete))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° d'Enregistrement
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="numRgRequete"
                                                        value="{{$requete[0]->numRg}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de la requete
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateRequete"
                                                        value="{{date('d/m/Y', strtotime($requete[0]->dateRequete))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date d'arrivée (Greffe)
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateArriver"
                                                        value="{{date('d/m/Y', strtotime($requete[0]->dateArriver))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Juridiction presidentielle
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ"
                                                        name="juriductionPresidentielle"
                                                        value="{{$requete[0]->juriductionPresidentielle}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                             @if($audience[0]->isChild=='oui')
                                             @else
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièces :</label>
                                                    <hr style="margin-top:-5px">
                                                    @foreach($pieceREQ as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        @if (Auth::user()->role=='Client')
                                                        @else
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button"  onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger  btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                             @endif
                                        </div>
                                        @endif
                                        @if($a->typeActe=="Declaration d'appel" && !empty($declarationAppel))
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° RG :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numRG"
                                                        value="{{$declarationAppel[0]->numRg}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° du jugement d'instance
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numJugement"
                                                        value="{{$declarationAppel[0]->numJugement}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Date de l'appel
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="dateAppel"
                                                        value="{{date('d/m/Y', strtotime($declarationAppel[0]->dateAppel))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>


                                        </div>
                                        @endif
                                        @if($a->typeActe=='Pourvoi' && !empty($pourvoi))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">N° de pourvoi :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="numPourvoi"
                                                        value="{{$pourvoi[0]->numPourvoi}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">N° décision:</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="numDecisConcerner"
                                                        value="{{$pourvoi[0]->numDecision}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date pourvoi :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="datePourvoi"
                                                        value="{{date('d/m/Y', strtotime($pourvoi[0]->datePourvoi))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date de la décision :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateDecision"
                                                        value="{{date('d/m/Y', strtotime($pourvoi[0]->dateDecision))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                        @if($a->typeActe=='Opposition' && !empty($opposition))
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° RG :</label>
                                                    <input type="text" class="form-control" id="inputRG"
                                                        data-error=" veillez saisir le N° RG" name="numRgOpp"
                                                        value="{{$opposition[0]->numRg}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="client" class="control-label">Huissier
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputRG"
                                                        data-error=" veillez saisir le N° RG" name="idHuissierOpp"
                                                        value="{{$opposition[0]->prenomHss}} {{$opposition[0]->nomHss}}"
                                                        disabled>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">Réçue par :</label>
                                                    <input type="text" class="form-control" id="inpuRC"
                                                        data-error=" veillez saisir le nom du receveur"
                                                        name="recepteurAssOpp" value="{{$opposition[0]->recepteurAss}}"
                                                        disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de l'acte :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateActe"
                                                        value="{{date('d/m/Y', strtotime($opposition[0]->dateActe))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputFDAT" class="control-label">Date de la 1ère
                                                        comparution
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputFDAT"
                                                        data-error=" veillez saisir la Date de la première comparution"
                                                        name="datePremiereCompOpp"
                                                        value="{{date('d/m/Y', strtotime($opposition[0]->datePremiereComp))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputENAS" class="control-label">Date enrôlement
                                                        :</label>
                                                    <input type="text" class="form-control" id="inputENAS"
                                                        data-error=" veillez saisir la date d'enroulement"
                                                        name="dateEnrollementOpp"
                                                        value="{{date('d/m/Y', strtotime($opposition[0]->dateEnrollement))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date de la prochaine audience
                                                        :</label>
                                                    <input type="text" class="form-control dateProchaine" id=""
                                                        data-error=" veillez saisir la date" name="dateProchaineAud"
                                                        value="{{date('d/m/Y', strtotime($opposition[0]->dateProchaineAud))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">N° Décision concernée :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir le N°" name="numDecisConcerner"
                                                        value="{{$opposition[0]->numDecision}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="mentionP" class="control-label">Mention particulière
                                                        :</label>
                                                    <textarea id="mentionP" cols="4" rows="2" class="form-control"
                                                        data-error=" veillez saisir la mention particulière"
                                                        name="mentionParticuliereOpp"
                                                        disabled>{{$opposition[0]->mentionParticuliere}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                             @if($audience[0]->isChild=='oui')
                                             @else
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièces :</label>
                                                    <hr style="margin-top:-5px">
                                                    @foreach($pieceOpp as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        @if (Auth::user()->role=='Client')
                                                        @else
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button"  onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger  btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                             @endif
                                        </div>
                                        @endif
                                        @if($a->typeActe=='PV introgatoire' && !empty($pvIntrogatoire))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date d'audition :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="dateAudition"
                                                        value="{{date('d/m/Y', strtotime($pvIntrogatoire[0]->dateAudition))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Identité de l'OPJ :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="identiteOPJ"
                                                        value="{{$pvIntrogatoire[0]->identiteOPJ}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Infractions :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="infractions"
                                                        value="{{$pvIntrogatoire[0]->infractions}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date d'audience :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="dateAudience"
                                                        value="{{date('d/m/Y', strtotime($pvIntrogatoire[0]->dateAudience))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($a->typeActe=='Requisitoire' && !empty($requisitoire))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° d'instruction / No RP
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir le N°" name="numInstruction"
                                                        value="{{$requisitoire[0]->numInstruction}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Procureur :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="procureur"
                                                        value="{{$requisitoire[0]->procureur}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Chef d'accusation
                                                        :</label>
                                                    <textarea name="chefAccusationReq" class="form-control" id=""
                                                        cols="30" rows="10"
                                                        disabled>{{$requisitoire[0]->chefAccusation}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                        @if($a->typeActe=='Ordonnance Renvoi' &&
                                        !empty($ordonnanceRenvois))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">N° de l'ordonnance
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir le N°" name="numOrd"
                                                        value="{{$ordonnanceRenvois[0]->numOrd}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Cabinet d'instruction :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="cabinetIns"
                                                        value="{{$ordonnanceRenvois[0]->cabinetIns}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Procédure :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="typeProcedure"
                                                        value="{{$ordonnanceRenvois[0]->typeProcedure}}" disabled>

                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Chef d'accusation
                                                        :</label>
                                                    <textarea name="chefAccusationOrd" class="form-control" id=""
                                                        cols="30" rows="10"
                                                        disabled>{{$ordonnanceRenvois[0]->chefAccusation}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                        @if($a->typeActe=='Citation directe' && !empty($citationDirect))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Saisi par:</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="saisi"
                                                        value="{{$citationDirect[0]->saisi}}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="huissier">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Huissier :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="idHuissier"
                                                        value="{{$citationDirect[0]->prenomHss}} {{$citationDirect[0]->nomHss}}"
                                                        disabled>

                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Reçue par :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="recepteurCitation"
                                                        value="{{$citationDirect[0]->recepteurCitation}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="dateSignification">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date de signification :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="dateSignification"
                                                        value="{{date('d/m/Y', strtotime($citationDirect[0]->dateSignification))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Date & Heure de l'audience
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="dateHeureAud"
                                                        value="{{date('d/m/Y', strtotime($citationDirect[0]->dateHeureAud))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Mention particulière :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez saisir la date" name="mentionParticuliere"
                                                        value="{{$citationDirect[0]->mentionParticuliere}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Chef d'accusation
                                                        :</label>
                                                    <textarea name="chefAccusation" class="form-control" id="" cols="30"
                                                        rows="10"
                                                        disabled>{{$citationDirect[0]->chefAccusation}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                        @if($a->typeActe=='PCPC' && !empty($pcpcs))
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="datePcpc"
                                                        value="{{ date('d/m/Y', strtotime($pcpcs[0]->datePcpc)) }}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Référence :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="reference"
                                                        value="{{$pcpcs[0]->reference}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de prochaine
                                                        audience :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="dateProchaineAud"
                                                        value="{{  date('d/m/Y', strtotime($pcpcs[0]->dateProchaineAud ))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>


                                        </div>
                                        @endif
                                        @if($a->typeActe=='Citation' && !empty($citations))
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h2>Signification de la citation à comparaitre</h2>
                                            <hr>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Huissier :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="idHuissier"
                                                        value="{{$citations[0]->prenomHss}} {{$citations[0]->nomHss}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="inputPr" class="control-label">Date de la signification :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="reference"
                                                        value="{{  date('d/m/Y', strtotime($citations[0]->dateSignification ))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="" class="control-label">Signification faite à :</label>

                                                <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="personneCharger"
                                                        value="{{$citations[0]->personneCharger}} {{$citations[0]->personneCharger}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align:center ;">
                                            <hr>
                                            <h2>Citation</h2>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="inputPr" class="control-label">N° RG :</label>
                                                <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numRgCitation"
                                                        value="{{$citations[0]->numRg}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">Date de la citation :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateCitation"
                                                        value="{{  date('d/m/Y', strtotime($citations[0]->dateCitation ))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="inputPr" class="control-label">Date audience :</label>
                                                <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateAudience"
                                                        value="{{  date('d/m/Y', strtotime($citations[0]->dateAudience ))}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="" class="control-label">Lieu d'audience:</label>
                                                <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="lieuAudience"
                                                        value="{{$citations[0]->lieuAudience}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                            @if($audience[0]->isChild=='oui')
                                            @else
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Pièces :</label>
                                                    @foreach($pieceCita as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        @if (Auth::user()->role=='Client')
                                                        @else
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button" onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                        @if($a->typeActe=='Autre acte' && !empty($autreActes))
                                        <div class="row col-md-12">
                                            @foreach($autreActes as $a)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputPr" class="control-label">{{ $a->mention }}</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error=" veillez remplir ce champ" name="valeur"
                                                        value="{{ $a->valeur }}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>
                                    @endforeach
                                    

                                    @if($audience[0]->isChild=='oui')
                                        <hr>
                                        <label for="inputRPAV" class="control-label mb-4"><b>Audiences initiales :</b></label><br>
                                        @foreach($audienceParents as $aud)
                                            <a href="{{ route('detailAudience', ['id' => $aud->idAudience, 'slug' => $aud->slug, $aud->niveauProcedural]) }}">Audience n°: {{ $aud->idAudience }} - Objet : {{  $aud->objet }}</a><br>
                                        @endforeach
                                        <hr>
                                        <label for="inputRPAV" class="control-label mb-4"><b>Pièces des audiences initiales :</b></label>
                                        @foreach($pieceParents as $p)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                        class="toggle"
                                                        title="Cliquer pour afficher le contenu du fichier"><i
                                                            class="fa  fa-file-pdf-o"
                                                            style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                </div>
                                                @if (Auth::user()->role=='Client')
                                                @else
                                                <div class="col-md-2">
                                                    <small>
                                                        <a href="{{route('deletePiece',$p->slug)}}"
                                                            type="button"  onclick="event.preventDefault(); confirmDelete(this.href)"
                                                            class="btn btn-outline-danger btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                class="ti-trash"></i></a>
                                                    </small>
                                                </div>
                                                @endif
                                            </div>
                                            <hr>
                                        @endforeach
                                        @foreach($autrePieceParents as $p)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                        class="toggle"
                                                        title="Cliquer pour afficher le contenu du fichier"><i
                                                            class="fa  fa-file-pdf-o"
                                                            style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                </div>
                                                @if (Auth::user()->role=='Client')
                                                @else
                                                <div class="col-md-2">
                                                    <small>
                                                        <a href="{{route('deletePiece',$p->slug)}}"
                                                            type="button" onclick="event.preventDefault(); confirmDelete(this.href)"
                                                            class="btn btn-outline-danger btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                class="ti-trash"></i></a>
                                                    </small>
                                                </div>
                                                @endif
                                            </div>
                                            <hr>
                                        @endforeach

                                    @elseif($audience[0]->isChild=='non')
                                        <hr>
                                        <label for="inputRPAV" class="control-label mb-4"><b>Audience de jonction :</b></label><br>
                                        @foreach($audienceFils as $aud)
                                                <a href="{{ route('detailAudience', ['id' => $aud->idAudience, 'slug' => $aud->slug, $aud->niveauProcedural]) }}">Audience n°: {{ $aud->idAudience }} - Objet : {{  $aud->objet }}</a>
                                        @endforeach
                                        <hr>
                                        <label for="inputRPAV" class="control-label mb-4"><b>Autre(s) audience(s) initiale(s) :</b></label><br>
                                        @foreach($audienceParents as $aud)
                                            @if($aud->idAudience == $audience[0]->idAudience)
                                            @else
                                                <a href="{{ route('detailAudience', ['id' => $aud->idAudience, 'slug' => $aud->slug, $aud->niveauProcedural]) }}">Audience n°: {{ $aud->idAudience }} - Objet : {{  $aud->objet }}</a>
                                            @endif
                                        @endforeach

                                    @endif



                                </div>
                            </li>
                             <li>
                               <div class="timeline-item">
                                    @foreach($acteSignifications as $s)
                                    <div class="timeline-body">
                                        <div class="col-md-12" style="text-align:center ;">
                                            <h3>Signification</h3>
                                            <hr>
                                            <!-- <h5><b>Nature de l'action :</b> </h5>
                                            <hr> -->
                                        </div>
                                       
                                        <div class="row col-md-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">N° Jugement :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="numJugement"
                                                        value="{{$s->numJugement}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inpuRC" class="control-label">Date de la signification:</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateSignification"
                                                        value="{{$s->dateSignification}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Huissier
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="idHss"
                                                        value="{{$s->prenomHss}} {{$s->nomHss}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Reçu par
                                                        :</label>
                                                    <input type="text" class="form-control" id=""
                                                        data-error="veillez remplir ce champ" name="dateContredit"
                                                        value="{{$s->recepteur}}" disabled>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputASN" class="control-label">Reserve
                                                        :</label>
                                                    <textarea class="form-control" name="reserve" id="" cols="30" rows="5" disabled>{{$s->reserve}}</textarea>
                                                  
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputRPAV" class="control-label">Copie de la signification :</label>
                                                    @foreach($pieceSign as $p)
                                                    <div class="row mb-2">
                                                        <div class="col-md-10">
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </div>
                                                        @if (Auth::user()->role=='Client')
                                                        @else
                                                        <div class="col-md-2">
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button"  onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger btn-sm"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        

                                    </div>
                                    @endforeach
                                </div>
                            </li>

                        </ul>
                        <!-- The timeline -->
                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="@if($audience[0]->statut=='Jonction') bg-secondary @else bg-green text-white @endif">Pièces supplémentaires</span>
                                @if (Auth::user()->role=='Client')
                                @else
                                <div class="btn-group text-right">
                                    <a href="#" class="btn btn-secondary @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif" data-toggle="modal"
                                        data-target="#modal-fichier" title="Ajouter un suivi">
                                        <i class="fa  fa-plus-circle ti i-cl-4"></i> Ajouter une pièce
                                    </a>
                                </div>
                                @endif
                            </li>
                            <li>
                                <div class="timeline-item">
                                    @if(!empty($pieceSupplement))
                                    <div class="timeline-body">
                                        <div class="table-responsive">

                                            <table id="" class=" dataTableExport table table-bordered table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5px;text-align:center">Pièces</th>

                                                        <th style="width:5px;text-align:center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($pieceSupplement as $p )
                                                    <tr>

                                                        <td>
                                                            <a class="" href="{{route('readFile', [$p->slug, 'x'])}}"
                                                                class="toggle"  
                                                                title="Cliquer pour afficher le contenu du fichier"><i
                                                                    class="fa  fa-file-pdf-o"
                                                                    style="color:red; font-size:1.5em;"></i>&nbsp;&nbsp;{{$p->nomOriginal}}</a>
                                                        </td>

                                                        <td style="text-align: center;">

                                                            @if (Auth::user()->role=='Client')
                                                            @else
                                                            <small>
                                                                <a href="{{route('deletePiece',$p->slug)}}"
                                                                    type="button" onclick="event.preventDefault(); confirmDelete(this.href)"
                                                                    class="btn btn-outline-danger  btn-sm @if($audience[0]->statut=='Jonction') non-cliquable bg-secondary @endif"><i
                                                                        class="ti-trash"></i></a>
                                                            </small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @else
                                    <div class="timeline-body">
                                        <h4 class="text-center">
                                            <span class="label bg-warning">Aucune pièce pour le moment</span>
                                        </h4>
                                    </div>
                                    @endif
                                </div>
                            </li>

                        </ul>

                        <ul class="timeline timeline">
                            <!-- timeline item -->
                            <li class="time-label">
                                <span class="bg-success" style="color:white">Autres procédures liées</span>
                                <div class="btn-group text-right">
                                    <a href="#" class="btn btn-secondary" data-toggle="modal"
                                        data-target="#modal-requeteLier" title="Ajouter un suivi">
                                        <i class="fa  fa-link ti i-cl-4"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="col-md-12">

                                             <h4 class="text text-center bg-primary  text-white m-2 p-2"> Procédure contraditoires </h4>

                                             @if((empty($audiences_contraditoire) && empty($audiences_contraditoire_lier)))
                                                <h4 class="text-center">
                                                    <span class="label bg-warning">aucune liaisons effectué</span>
                                                </h4>
                                             @else

                                                @if(empty($audiences_contraditoire) && empty($contraditoire_requete))
                                                    <h4 class="text-center">
                                                        
                                                    </h4>
                                                @else
                                                    @foreach($audiences_contraditoire as $r)

                                                    
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">

                                                            
                                                                    <a class="" href="{{ route('detailAudience', ['id' => $r->idAudience, 'slug' => $r->slug, 'niveau' => $r->niveauProcedural]) }}"
                                                                    class="toggle"
                                                                    title="Cliquer pour afficher le contenu du fichier"> 

                                                                        
                                                                        {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                                        @foreach($audience_contraditoire_partie2 as $client)
                                                                            @if($client->idAudience == $r->idAudience)
                                                                                
                                                                               
                                                                                {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                                c/
                                                                               
                                                                                @foreach($procedure_autreRole as $p1)
                                                                                    @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                                        @if($p1->autreRole == 'pc')
                                                                                            <small>(Partie civile)</small>
                                                                                        @elseif($p1->autreRole == 'in')
                                                                                            <small>(Intervenant)</small>
                                                                                        @elseif($p1->autreRole == 'mp')
                                                                                            <small>(Ministère public)</small>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach

                                                                            @endif
                                                                        @endforeach


                                                                       

                                                                        {{-- Entreprises adverses liées à l'audience --}}
                                                                        @foreach($audience_contraditoire_entreprise_adverses as $entreprise)
                                                                            @if($entreprise->idProcedureLier == $r->idProcedureLier)
                                                                                {{ $entreprise->denomination ?? '' }}
                                                                            @endif
                                                                        @endforeach

                                                                        {{-- Entreprises adverses liées à l'audience --}}
                                                                        @foreach($audience_contraditoire_entreprise_adverses2 as $entreprise)
                                                                            @if($entreprise->idProcedureLier == $r->idProcedureLier)
                                                                                {{ $entreprise->denomination ?? '' }}
                                                                            @endif
                                                                        @endforeach

                                                                        {{-- Personnes adverses liées à l'audience --}}
                                                                        @foreach($audience_contraditoire_personne_adverses as $personne)
                                                                    
                                                                            @if($personne->idProcedureLier == $r->idProcedureLier)
                                                                                {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                            @endif
                                                                        @endforeach
                                                                        {{-- Personnes adverses liées à l'audience --}}
                                                                        @foreach($audience_contraditoire_personne_adverses2 as $personne)
                                                                    
                                                                            @if($personne->idProcedureLier == $r->idProcedureLier)
                                                                                {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                            @endif
                                                                        @endforeach
                                                                    </a>
                                                                   
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"
                                                                        type="button"
                                                                        class="btn btn-outline-danger"
                                                                        onclick="event.preventDefault(); confirmDelete(this.href)">
                                                                            <i class="ti-trash"></i>
                                                                        </a>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            
                                            

                                                @if(!empty($audiences_contraditoire_lier))
                                                    
                                                    @foreach($audiences_contraditoire_lier as $r)
                                                                                                    
                                                            <div class="mb-2 p-2 border rounded">
                                                                
                                                                <a href="{{ route('detailAudience', [
                                                                    'id' => $r->idAudience,
                                                                    'slug' => $r->slug,
                                                                    'niveau' => $r->niveauProcedural
                                                                ]) }}">
                                                                

                                                                {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                                @foreach($audience_contraditoire_partie as $client)
                                                                    @if($client->idAudience == $r->idAudience)
                                                                        
                                                                        
                                                                        {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                        c/
                                                                        
                                                                        @foreach($procedure_autreRole1 as $p1)
                                                                        
                                                                            @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                           
                                                                                @if($p1->autreRole == 'pc')
                                                                                    <small>(Partie civile)</small>
                                                                                @elseif($p1->autreRole == 'in')
                                                                                    <small>(Intervenant)</small>
                                                                                @elseif($p1->autreRole == 'mp')
                                                                                    <small>(Ministère public)</small>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach


                                                                   

                                                                  
                                                                    {{-- Entreprises adverses liées à l'audience --}}
                                                                    @foreach($audience_contraditoire_entreprise_adverses as $entreprise)
                                                                        @if($entreprise->idAudience == $r->idAudience)
                                                                            {{ $entreprise->denomination ?? '' }}
                                                                        @endif
                                                                    @endforeach

                                                                    {{-- Personnes adverses liées à l'audience --}}
                                                                    @foreach($audience_contraditoire_personne_adverses as $personne)
                                                                        @if($personne->idAudience == $r->idAudience)
                                                                            {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                        @endif
                                                                    @endforeach
                                                                    
                                                                    
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"
                                                                    type="button"
                                                                    class="btn btn-outline-danger"
                                                                    onclick="event.preventDefault(); confirmDelete(this.href)">
                                                                        <i class="ti-trash"></i>
                                                                </a>
                                                                    
                                                            </div>
                                                    
                                                    @endforeach
                                            
                                                @else
                                                @endif   

                                            @endif

                                              

                                            <h4 class="text text-center bg-primary  text-white m-2 p-2" >Procédure  non  contraditoires </h4>


                                            @if((empty($procedure_requete) && empty($requete_contraditoire)))
                                                <h4 class="text-center">
                                                    <span class="label bg-warning"> aucune liaisons effectué </span>
                                                </h4>
                                            @else

                                                @if(empty($procedure_requete))
                                                    <h4 class="text-center">
                                                    
                                                    </h4>
                                                @else
                                                    
                                                    @foreach($procedure_requete as $r)
                                                

                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                        <!--    <a class="" href="{{ route('detailRequete', $r->slug) }}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier">{{ $r->objet }} - {{ date('d/m/Y', strtotime($r->dateRequete))}}</a>-->
                                                                <a class="" href="{{ route('detailRequete', $r->slug) }}"
                                                                class="toggle"
                                                                title="Cliquer pour afficher le contenu du fichier">
                                                                
                                                              
                                                                {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                                @foreach($procedure_requete_clients as $client)
                                                                    @if($client->idProcedureLier == $r->idProcedureLier)
                                                                        {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                        c/
                                                                        @foreach($procedure_autreRole_requete as $p1)
                                                                        
                                                                            @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                           
                                                                                @if($p1->autreRole == 'pc')
                                                                                    <small>(Partie civile)</small>
                                                                                @elseif($p1->autreRole == 'in')
                                                                                    <small>(Intervenant)</small>
                                                                                @elseif($p1->autreRole == 'mp')
                                                                                    <small>(Ministère public)</small>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                
                                                                
                                                                {{-- Entreprises adverses liées à l'audience --}}
                                                                @foreach($procedure_requete_entreprise_adverses_requetes as $entreprise)
                                                                    @if($entreprise->idProcedureLier == $r->idProcedureLier)
                                                                        {{ $entreprise->denomination ?? '' }}
                                                                    @endif
                                                                @endforeach
                                                            
                                                            
                                                                {{-- Personnes adverses liées à l'audience --}}
                                                                @foreach($procedure_requete_personne_adverses_requetes as $personne)
                                                                
                                                                    @if($personne->idProcedureLier == $r->idProcedureLier)
                                                                        {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                    @endif
                                                                @endforeach
                                                            
                                                            </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="{{ route('deleteRequeteLier', $r->idProcedureLier) }}"
                                                                    type="button"
                                                                    class="btn btn-outline-danger  "
                                                                    onclick="event.preventDefault(); confirmDelete(this.href)">
                                                                        <i class="ti-trash"></i>
                                                                </a>


                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                                


                                                @if(!empty($requete_contraditoire))
                                                    
                                                    @foreach($requete_contraditoire as $requeteLiers)
                                                        <div class="mb-2 p-2 border rounded">
                                                            <a href="{{ route('detailRequete', ['slug' => $requeteLiers->slugSource]) }}">
                                                                
                                                                {{-- Clients liés à l'audience en cours avec leur rôle --}}
                                                                @foreach($requete_contraditoire_partie as $client)
                                                                
                                                                    @if($client->idProcedure == $requeteLiers->idProcedure)
                                                                        {{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}
                                                                        
                                                                        c/
                                                                        @foreach($procedure_autreRole_requete1 as $p1)
                                                                        
                                                                            @if($client->idProcedureLier == $p1->idProcedureLier)
                                                                           
                                                                                @if($p1->autreRole == 'pc')
                                                                                    <small>(Partie civile)</small>
                                                                                @elseif($p1->autreRole == 'in')
                                                                                    <small>(Intervenant)</small>
                                                                                @elseif($p1->autreRole == 'mp')
                                                                                    <small>(Ministère public)</small>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach

                                                                

                                                                {{-- Entreprises adverses liées à l'audience --}}
                                                                @foreach($requete_contraditoire_entreprise_adverses as $entreprise)

                                                                    @if($entreprise->idProcedure == $requeteLiers->idProcedure)
                                                                        {{ $entreprise->denomination ?? '' }}
                                                                    @endif
                                                                @endforeach

                                                                {{-- Personnes adverses liées à l'audience --}}
                                                                @foreach($requete_contraditoire_presonne_adverses as $personne)
                                                            
                                                                    @if($personne->idProcedure == $requeteLiers->idProcedure)
                                                                        {{ $personne->prenom ?? '' }} {{ $personne->nom ?? '' }}
                                                                    @endif
                                                                @endforeach
                                                            </a>

                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <a href="{{ route('deleteRequeteLier', $requeteLiers->idProcedureLier) }}"
                                                            type="button"
                                                            class="btn btn-outline-danger"
                                                            onclick="event.preventDefault(); confirmDelete(this.href)">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif



                                        </div>
                                                                       
                                    </div>                                    

                                </div>
                            </li>
                          
                        </ul>
   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="add-popup modal fade" id="modal-fichier" tabindex="-1" role="dialog" aria-labelledby="addcontact">
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
                <h4 class="modal-title"><i class="fa fa-file"></i> Joindre un fichier</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('addFileAudience') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-12 col-sm-12">

                            <input type="file" accept="image/*,.pdf," class="fichiers form-control" name="fichiers[]"
                                multiple required>
                            <input type="hidden" name="slugAudience" value="{{$audience[0]->slug}}">


                        </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="" class="theme-bg btn btn-rounded btn-block " style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="modal-requeteLier" tabindex="-1" role="dialog" aria-labelledby="addRequete">
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
                <h4 class="modal-title"><i class="fa fa-link"></i> Lier cette procedure à une autre</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('lierRequeteManuelContraditoire') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row "  >
                        <div class="col-md-4 cacher"  >
                            <div class="form-group">
                                <label for="client" class="control-label">Selectionner le
                                    client*
                                    :</label>
                                    <select class="form-control select2" name="idClient" id="client" onchange="var idclient=$(this).val(); clientReqFunction(idclient)" style="width:100%" data-placeholder="">
                                        <option value=""> </option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->idClient }}">
                                            {{ $client->prenom }}
                                            {{ $client->nom }}
                                            {{ $client->denomination }}
                                        </option>
                                        @endforeach
                                    </select>

                            </div>
                         

                        </div>
                        <div class="col-md-4 cacher" id="affaireContent-req" hidden>

                            <div class="form-group">
                                <label for="affaire" class="control-label">Affaire du client
                                    concerné*
                                    :</label>
                                <select data-placeholder="Affaire du client concerné" style="width: 100%;height:28px" name="" id="affaireClient-req" >

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="affaire" class="control-label">Procédure(s) 
                                    concernant le client*
                                    :</label>
                                <select class="form-control select2" data-placeholder="" multiple style="width: 100%;height:28px" name="contraditoireLier[]" id="requeteClient" required>
                                    <option value="" disabled>-- Choisissez --</option>
                                
                                </select>   
                                <input type="hidden" name="slugProcedure" id="currentSlug" value="{{$audience[0]->slug}}">

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="" class="theme-bg btn btn-rounded btn-block " style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal-signification -->
<div class="add-popup modal fade" id="modal-signifier" tabindex="-1" role="dialog" aria-labelledby="addcontact">
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
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Signification d'un jugement</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('saveSignification') }}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="row col-md-12 col-sm-12 mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">N° Jugement</label>
                                    <input type="text" class="form-control" name="numJugement"  id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Date signification</label>
                                    <input type="datetime-local" class="form-control" name="dateSignification"  id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Huissier</label>
                                    <select class="form-control select2" name="idHss" style="width: 100%;" id="">
                                        <option value="" selected disabled>-- Choisissez --</option>
                                        @foreach ($huissiers as $h )
                                        <option value={{$h->idHss}}>
                                            {{$h->prenomHss}} {{$h->nomHss}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Reçu par</label>
                                    <input type="text" class="form-control" name="recepteur"  id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Copie de la signification</label>
                                    <input type="file" accept="image/*,.pdf," class="form-control" name="fileSignification" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Reserve</label>
                                    <textarea name="reserve" id="" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="slugAudience" value="{{$audience[0]->slug}}">


                        </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="" class="theme-bg btn btn-rounded btn-block " style="width:50%;">
                                        Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal-suivi audience -->
<div class="modal modal-box-2 fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Ajouter un suivi à l'audience</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">

                            @if($audience[0]->niveauProcedural=='Appel')
                            <!-- form appel -->
                            <form class="padd-20" method="post" action="{{route('suiviAudienceAppel')}}"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="idAudience" value={{$audience[0]->idAudience}}>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Actes</label>
                                            <select class="form-control select js-example-tags" id="acteDecision"
                                                data-placeholder="" style="width: 100%;" name="acte" required>
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                <option value="Conclusions">Conclusions</option>
                                                <option value="Invitation à conclure">Invitation à conclure</option>
                                                <option value="Injonction à conclure">Injonction à conclure</option>
                                                <option value="PV de constat de carence">PV de constat de carence
                                                </option>
                                                <option value="Avenir d'audience">Avenir d'audience</option>
                                                <option value="Conférence de mise en état/cloture">Conférence de mise en
                                                    état/cloture</option>
                                                <option value="Mise en délibéré">Mise en délibéré</option>
                                                <option value="Délibéré prorogé">Délibéré prorogé</option>
                                                <option value="Renvoi">Renvoi</option>
                                                <option value="Autre">Autre</option>
                                            </select>

                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                </div>
                              
                                <div class="row mrg-0" id="conclusion">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-3 "
                                                    style="padding-top: 20px;margin-right:-70px;">Conclusions de
                                                    l'</label>
                                                <div class="col-3">
                                                    <select class="form-control select" data-placeholder=""
                                                        style="width: 100%;margin-top:10px;" id="appelantIntimeConclusion"
                                                        name="appelantIntimeConclusion">
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        <option value="Appelant">Appelant</option>
                                                        <option value="Intimé(e)">Intimé(e)
                                                        </option>

                                                    </select>
                                                </div>
                                                <label for="example-text-input" class="col-3 col-form-label"
                                                    style="padding-top: 20px;margin-right:-90px;">en date du</label>
                                                <div class="">
                                                    <input class="form-control" name="dateActeConclusion" type="date"
                                                        value="" id="dateActeConclusion">
                                                </div>
                                                <label for="example-text-input" class="col-3 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">reçues par la cour
                                                    le</label>
                                                <div class="">
                                                    <input class="form-control" name="dateReceptionConclusion"
                                                        type="date" value="" id="dateReceptionConclusion"> .
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0" id="invitationAconclure">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-4"
                                                    style="padding-top: 20px;margin-right:-90px;">Invitation à conclure
                                                    du</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateActeInvitation" type="date"
                                                        value="" id="dateActeInvitation">
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">pour les ecritures
                                                    de l'</label>
                                                <div class="">
                                                    <select class="form-control select js-example-tags"
                                                        data-placeholder="" style="width: 100%;margin-top:10px" id="appelantIntimeInvitation"
                                                        name="appelantIntimeInvitation">
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        <option value="Appelant">Appelant</option>
                                                        <option value="Intimé(e)">Intimé(e)
                                                        </option>

                                                    </select>
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">à deposer au plutard
                                                    le</label>
                                                <div class="">
                                                    <input class="form-control" name="dateLimiteInvitation" type="date"
                                                        id="dateLimiteInvitation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0" id="injonctionAconclure">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-4"
                                                    style="padding-top: 20px;margin-right:-80px;">Injonction à conclure
                                                    du</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateActeInjonction" type="date"
                                                        value="" id="dateActeInjonction">
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">pour les ecritures
                                                    de l'</label>
                                                <div class="">
                                                    <select class="form-control select" data-placeholder=""
                                                        style="width: 100%;margin-top:10px" id="appelantIntimeInjonction"
                                                        name="appelantIntimeInjonction">
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        <option value="Appelant">Appelant</option>
                                                        <option value="Intimé(e)">Intimé(e)
                                                        </option>

                                                    </select>
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">à deposer au plutard
                                                    le</label>
                                                <div class="">
                                                    <input class="form-control" name="dateLimiteInjonction" type="date"
                                                        value="" id="dateLimiteInjonction">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="pvConstat">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-5"
                                                    style="padding-top: 20px;margin-right:-100px;">PV de constat de
                                                    carence fait le</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateActeConstat" type="date"
                                                        value="" id="dateActeConstat">
                                                </div>


                                                <div class="form-group mt-4">
                                                    <label style="margin-left:16px">par l'huissier &nbsp;&nbsp;</label>
                                                    <select class="form-control select2" name="huissierConstat"
                                                        style="width: 50%;" id="huissierConstat">
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        @foreach ($huissiers as $h )
                                                        <option value="{{$h->prenomHss}} {{$h->nomHss}}">
                                                            {{$h->prenomHss}} {{$h->nomHss}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="avenirConstat">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-4"
                                                    style="padding-top: 20px;margin-right:-100px;">Avenir d'audience du
                                                </label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateActeAvenir" type="date"
                                                        value="" id="dateActeAvenir">
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-170px;">servi par l'</label>
                                                <div class="col-5">
                                                    <select class="form-control select" data-placeholder=""
                                                        style="width: 100%;margin-top:10px" id="appelantIntimeAvenir"
                                                        name="appelantIntimeAvenir">
                                                        <option value="" selected disabled>-- Choisissez --</option>
                                                        <option value="Appelant">Appelant</option>
                                                        <option value="Intimé(e)">Intimé(e)
                                                        </option>

                                                    </select>
                                                </div>
                                                <label for="example-text-input" class="col-4 col-form-label"
                                                    style="padding-top: 20px;margin-right:-110px;">pour l'audience
                                                    du</label>
                                                <div class="">
                                                    <input class="form-control" name="dateProchaineAudienceAvenir" type="date"
                                                        value="" id="dateProchaineAudienceAvenir">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="conference">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-6"
                                                    style="padding-top: 20px;margin-right:-50px;">Conférence de mise en
                                                    état/cloture en date du</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateEtat" type="date" value=""
                                                        id="dateEtat">
                                                </div>

                                                <label for="example-text-input" class="col-5"
                                                    style="padding-top: 20px;margin-right:-100px;">Reçu le </label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateConferenceRecu" type="date"
                                                        value="" id="dateConferenceRecu">
                                                </div>
                                                <label for="example-text-input" class="col-5"
                                                    style="padding-top: 20px;margin-right:-100px;">Devant se tenir au
                                                    plus tard le </label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateExpConference" type="date"
                                                        value="" id="dateExpConference">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="miseDeliberer">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-6"
                                                    style="padding-top: 20px;margin-right:-80px;">Mise en délibéré pour
                                                    décision être rendue le</label>
                                                <div class="col-3">
                                                    <input class="form-control dateRecep" name="dateDeliberer" type="date"
                                                        value="" id="dateDeliberer">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="delibererProroger">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-4"
                                                    style="padding-top: 20px;margin-right:-100px;">Date de l'acte</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateActeProrogé" type="date" value=""
                                                        id="dateActeProrogé">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-4"
                                                    style="padding-top: 20px;margin-right:-100px;">Délibéré prorogé
                                                    au</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateProrogé" type="date" value=""
                                                        id="dateProrogé">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="Renvoi">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <label for="example-text-input" class="col-3"
                                                    style="padding-top: 20px;margin-right:-100px;">Renvoi au</label>
                                                <div class="col-3">
                                                    <input class="form-control" name="dateRenvoiAppel" type="date"
                                                        value="" id="dateRenvoiAppel">
                                                </div>

                                                <label for="example-text-input" class="col-2"
                                                    style="padding-top: 20px;margin-right:-80px;">Pour</label>
                                                <div class="col-6">
                                                    <input class="form-control" name="raisonRenvoi" type="text" value=""
                                                        id="raisonRenvoi">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0" id="autreActe">

                                    <div class="row mrg-0">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <div class="flex-box align-items-center">
                                                        <label for="PDate" class="control-label">Date de la prochaine
                                                            d'audience</label>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="NA">
                                                            <label for="NA">Non Applicable (N/A)</label>
                                                        </span>
                                                    </div>
                                                </div>
                                                <input type="date" class="form-control dateProchaine" name="dateProchaineAudience"
                                                    data-error=" veillez entrer la date de la prochaine audience" required
                                                    id="PDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="">

                                            <div class="col-9">
                                                <label for="" class="control-label">Mentionnez l'acte ici</label>
                                                <textarea class="form-control" name="autres" id="autres" cols="30"
                                                    rows="50"></textarea>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="header-title m-t-0">Pièces(Facultative)</h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" accept="image/*,.pdf," class="fichiers form-control"
                                                    name="fichiers[]" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                                    style="width:50%;"> Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @else
                            <!-- form premiere instance -->
                            <form class="padd-20" method="post" action="{{ route('suiviAudience') }}"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Date audience </label>
                                            <input type="number" name="idAudience"
                                                value="{{ $audience[0]->idAudience }}" id="idAudienceAssign" hidden>
                                            <input type="date" class="form-control" id="inputPName"
                                                data-error=" entrer la date de l'audience" name="dateAudience" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="flex-box align-items-center">
                                                    <label for="PDate" class="control-label">Date de la prochaine
                                                        d'audience</label>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="NA">
                                                        <label for="NA">Non Applicable (N/A)</label>
                                                    </span>
                                                </div>
                                            </div>
                                            <input type="date" class="form-control dateProchaine" name="dateProchaineAudience"
                                                data-error=" veillez entrer la date de la prochaine audience" required
                                                id="PDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEm" class="control-label">Décision</label>
                                            <select class="form-control select2 js-example-tags" data-placeholder=""
                                                style="width: 100%;" id="decision" name="decision" required>
                                                <option value="" selected disabled>-- Choisissez --</option>
                                                <option value="renvoi">Renvoi</option>
                                                <option value="miseDeliberer">Mise en delibéré</option>
                                                <option value="viderDeliberer">Vidé du delibéré</option>
                                                <option value="autre">Autre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="row mrg-0" id="renvoi" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-2 col-form-label"
                                                    style="padding-top: 20px;margin-right:-30px;">Renvoyée au</label>
                                                <div class="col-3">
                                                    <input class="form-control dateRecep" name="dateRenvoi" type="date" value=""
                                                        id="dateRenvoi">
                                                </div>
                                                <label for="example-text-input" class="col-2 col-form-label"
                                                    style="padding-top: 20px;margin-right:-80px;">pour</label>
                                                <div class="col-6">
                                                    <input class="form-control" name="RenvoiPour" type="text" value=""
                                                        id="example-text-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0" id="miseDeliberer" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-6 col-form-label"
                                                    style="padding-top: 20px;margin-right:-70px;">Mise en délibéré pour
                                                    décision être rendue le</label>
                                                <div class="col-3">
                                                    <input class="form-control dateRecep" type="date" name="dateMiseDeliberer"
                                                        value="" id="example-text-input">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" mrg-0" id="viderDeliberer" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="example-text-input" class="col-5 col-form-label"
                                                    style="padding-top: 20px;margin-right:-110px;">Vidé du delibéré en
                                                    faveur de</label>
                                                <div class="col-6">
                                                    <input class="form-control" type="text" name="viderDeliberer"
                                                        value="" id="example-text-input">
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="">Extrait</label>
                                            <textarea name="extrait" id="" class="form-control" cols="30" rows="5"></textarea>
                                                 
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0" id="autreDecision" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" name="autreDecision"
                                                        value="" placeholder="Saisissez la decision."
                                                        id="example-text-input">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="heureDebut" class="control-label">Heure de début de
                                                l'audience</label>
                                            <input type="time" class="form-control" id="heureDebut" name="heureDebut"
                                                data-error=" veillez entrer l'heure de début de l'audience" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="heureFin" class="control-label">Heure de fin de
                                                l'audience</label>
                                            <input type="time" class="form-control" id="inputEm" name="heureFin"
                                                data-error=" veillez entrer l'heure de fin de l'audience" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPr" class="control-label">Président</label>
                                            <input type="text" class="form-control" id="inputPr" name="president"
                                                data-error=" veillez entrer le complet du président" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputGr" class="control-label">Gréffier(ère)</label>
                                            <input type="text" class="form-control" id="inputGr" name="greffier"
                                                data-error="veillez saisir le nom complet du gréffier" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="header-title m-t-0">Pièces(Facultative)</h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" accept="image/*,.pdf," class="fichiers form-control"
                                                    name="fichiers[]" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                                    style="width:50%;"> Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-suivi audience -->

<!-- modal-suivi audience appel-->
<div class="modal modal-box-2 fade" id="modal-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Ajouter un suivi à l'audience</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-suivi audience appel -->



<!-- modal-sent-message -->
<div class="modal fmodal-box-2 fade" id="sentSMS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" onclick="closeMail()" class="text-white" data-dismiss="modal"
                            aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-envelope"></i> Envoi via e-mail</h4>
            </div>
            @if($plan=='standard')
            <div class="modal-body text-center" style="padding:30px">
                <h2 class="bg-warning"><i class="fa fa-exclamation-triangle"></i> Module Premium</h2>
                <p style="font-size:18px">Chèr(e) utilisateur ce module ne figure pas sur le plan <b>standard</b> auquel vous
                    avez souscri. Veuillez contacter notre équipe pour passer au <b>premium</b> si vous voulez obtenir ce
                    module. <br>
                    visitez notre site web pour voir les différents plans <a href="https://www.smartylex.com#prix"
                        target="_blank" style="color:blue"><i class="fa fa-arrow-right"></i> www.smartylex.com</a>
                </p>

            </div>
            @else
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">


                            <!-- form start -->
                            <form class="padd-20" method="post" action="{{ route('sendMail') }}" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-4">
                                    <h5><i class="fa fa-language"></i> Traduire</h5>
                                    <div class="onoffswitchLang">
                                        <input type="checkbox" name="onoffswitchLang" class="onoffswitchLang-checkbox"
                                            id="defaultwitch" checked="" style="width:5px">
                                        <label class="onoffswitchLang-label label-default" for="defaultwitch">
                                            <span class="onoffswitchLang-inner"></span>
                                            <span class="onoffswitchLang-switch"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">À :</label>
                                            @empty($cabinet)
                                            <input type="text" class="form-control" id="phone"
                                                data-error="Entrer la date de l'audience" name="email" value="">
                                            @else
                                            <input type="text" class="form-control" id="phone"
                                                data-error="Entrer la date de l'audience" name="email"
                                                value="{{ $cabinet[0]->email }}{{ $cabinet[0]->emailEntreprise }}">
                                            @endif
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Cc :</label>
                                            <select multiple="" name="emails[]" class="form-control select2"
                                                data-placeholder="Recherchez..." style="width: 100%;" id="personne"
                                                data-error="erre">
                                                <option value="{{$paramCabinet[0]->emailAudience}}" selected>
                                                    {{$paramCabinet[0]->emailAudience}}</option>
                                                @foreach ($annuaires as $a)
                                                <option value="{{ $a->email }}">{{ $a->email }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Objet :</label>
                                            <div style="border: 1px solid;padding:5px;">
                                                <p>Compte rendu d'audience -  @foreach($audience as $w)

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

                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Message :</label>
                                            <div id="message-box"
                                                style="overflow-y:auto; overflow-x:hidden;height:289px;">

                                            </div>

                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputPName" class="control-label">Pièce(s) jointe(s) :</label>
                                            <input type="file" class="fichiers form-control" id="phone"
                                                name="attachment[]" multiple="multiple">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="idSuivit" name="idSuivit">
                                <input type="hidden" id="idSuivitAppel" name="idSuivitAppel">
                                <div class="row mrg-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-rounded btn-block theme-bg"
                                                    style="width:50%;"><i class="fa fa-send"></i> Envoyer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- End modal-sent-message -->




<script>
// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function(e) {

            var fichiersInput = this.querySelectorAll(
                ".fichiers"
                ); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name +
                            " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});





// fonction de renvoi du suivit d'audience pour l'envoi d'sms
function emailModal(id) {
    document.getElementById('message-box').innerHTML = "";
    $.ajax({
        type: "GET",
        url: `/fetch-suivitAudience/${id}`,
        dataType: "json",
        success: function(response) {



            $.each(response.suivitAud, function(key, value) {

                $('#message-box').append(
                    `
                        <input name="juridiction" type="hidden" class="form-control"  id="" value="{{ $audience[0]->nom }}">
                        <input name="dateAudience" type="hidden" class="form-control"  id="" value="${value.dateAudience}">
                        <input name="idAudience" type="hidden" class="form-control"  id="" value="{{ $audience[0]->idAudience }}">
                        <input name="objetAudience" type="hidden" class="form-control"  id="" value="{{ $audience[0]->objet }}">
                        <input name="decision" type="hidden" class="form-control"  id="" value="${value.decision}">
                        @empty($cabinet)
                        @else
                        <input name="affaire" type="hidden" class="form-control"  id="" value="{{ $cabinet[0]->nomAffaire }}">
                        @endif
                        <input name="parties" id="" hidden
                         value="@foreach($cabinet as $c){{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} @endforeach @if(!empty($personne_adverses)) @foreach($personne_adverses as $p)c/ {{ $p->prenom }} {{ $p->nom }} @endforeach @else @endif @if(!empty($entreprise_adverses)) @foreach($entreprise_adverses as $e) c/ {{ $e->denomination }}  @endforeach @else @endif"
                        >
                        <div style="border: 1px solid;padding:10px;">
                            <p>Madame/Monsieur</p><br>
                            @if(Session::has('cabinetSession'))
                            @foreach (Session::get('cabinetSession') as $cabinetInfo)
                            <p>{{$cabinetInfo->nomCourt}} vous informe :</p>
                            @endforeach
                            @endif
                           
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Juridiction :</b> {{ $audience[0]->nom }}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Audience du :</b> ${value.dateAudience}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Parties :</b> @foreach($audience as $w)

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

                                @endforeach
                            </p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Objet :</b> {{ $audience[0]->objet }}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Décision :</b> ${value.decision} </p>
                            @empty($cabinet)
                            @else
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Affaire :</b> {{ $cabinet[0]->nomAffaire }}</p>
                            @endif
                            <p>
                                <label for="example-text-input" class="col-12 col-form-label" style="padding-top: 20px;margin-right:-110px;">Commentaire/Observation</label>
                                <div class="col-12">
                                        <textarea name="commentaire" id="" cols="70" rows="4"></textarea>
                                </div>
                            </p>
                            <p>N'hesitez pas à nous contacter pour toute précision complémentaire.</p>
                            @if($paramCabinet[0]->nomCabinet=='ASK AVOCATS')
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Maître Jonas KOUROUMA </b> Tel: +224 623 20 70 63 / Email: jkourouma@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Amara CISSE </b> Tel: +224 612 12 50 02 / Email: acisse@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Sayon OULARE </b> Tel: +224 612 12 50 01 / Email: sayonoulare@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Karamo Oulen TOURE </b> Tel: +224 612 12 50 07 / Email: ktoure@ask-avocats.com </p> 
                            @endif   
                            <br><br>
                            <p>Cordialement</p><br>
                    
                            <?php echo $paramCabinet[0]->signature; ?>
                        </div>
                        `
                )
                document.getElementById('idSuivit').value = value.idSuivit;

            });


        },

        error: function(jqXHR, textStatus, errorThrown) {
            console.log(`JQHR ${jqXHR} \n statut: ${textStatus}\n error: ${errorThrown}`);
        }
    });
}

function emailModalAppel(id) {
    document.getElementById('message-box').innerHTML = "";
    $.ajax({
        type: "GET",
        url: `/fetch-suivitAudienceAppel/${id}`,
        dataType: "json",
        success: function(response) {



            $.each(response.suivitAudAppel, function(key, value) {

                $('#message-box').append(
                    `
                        <input name="juridiction" type="hidden" class="form-control"  id="" value="{{ $audience[0]->nom }}">
                        <input name="dateAudience" type="hidden" class="form-control"  id="" value="${value.dateLimite}">
                        <input name="idAudience" type="hidden" class="form-control"  id="" value="{{ $audience[0]->idAudience }}">
                        <input name="objetAudience" type="hidden" class="form-control"  id="" value="{{ $audience[0]->objet }}">
                        <input name="decision" type="hidden" class="form-control"  id="" value="${value.acte}">
                        @empty($cabinet)
                        @else
                        <input name="affaire" type="hidden" class="form-control"  id="" value="{{ $cabinet[0]->nomAffaire }}">
                        @endif
                        <input name="parties" id="" hidden
                         value="@foreach($cabinet as $c){{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} @endforeach @if(!empty($personne_adverses)) @foreach($personne_adverses as $p)c/ {{ $p->prenom }} {{ $p->nom }} @endforeach @else @endif @if(!empty($entreprise_adverses)) @foreach($entreprise_adverses as $e) c/ {{ $e->denomination }}  @endforeach @else @endif"
                        >
                        <div style="border: 1px solid;padding:10px;">
                            <p>Madame/Monsieur</p><br>
                            @if(Session::has('cabinetSession'))
                            @foreach (Session::get('cabinetSession') as $cabinetInfo)
                            <p>{{$cabinetInfo->nomCourt}} vous informe :</p>
                            @endforeach
                            @endif
                           
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Juridiction :</b> {{ $audience[0]->nom }}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Audience du :</b> ${value.dateActe}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Parties :</b> @foreach($audience as $w)

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

                                @endforeach
                            </p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Objet :</b> {{ $audience[0]->objet }}</p>
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Décision :</b> ${value.acte} </p>
                            @empty($cabinet)
                            @else
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Affaire :</b> {{ $cabinet[0]->nomAffaire }}</p>
                            @endif
                            <p>
                                <label for="example-text-input" class="col-12 col-form-label" style="padding-top: 20px;margin-right:-110px;">Commentaire/Observation</label>
                                <div class="col-12">
                                        <textarea name="commentaire" id="" cols="70" rows="4"></textarea>
                                </div>
                            </p>
                            <p>N'hesitez pas à nous contacter pour toute précision complémentaire.</p>
                            @if($paramCabinet[0]->nomCabinet=='ASK AVOCATS')
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Maître Jonas KOUROUMA </b> Tel: +224 623 20 70 63 / Email: jkourouma@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Amara CISSE </b> Tel: +224 612 12 50 02 / Email: acisse@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Sayon OULARE </b> Tel: +224 612 12 50 01 / Email: sayonoulare@ask-avocats.com </p>                        
                            <p><i class="fa fa-circle"></i>&nbsp;&nbsp;<b>Karamo Oulen TOURE </b> Tel: +224 612 12 50 07 / Email: ktoure@ask-avocats.com </p> 
                            @endif   
                            <br><br>
                            <p>Cordialement</p><br>
                    
                            <?php echo $paramCabinet[0]->signature; ?>
                        </div>
                        `
                )
                document.getElementById('idSuivitAppel').value = value.idSuivitAppel;

            });


        },

        error: function(jqXHR, textStatus, errorThrown) {
            console.log(`JQHR ${jqXHR} \n statut: ${textStatus}\n error: ${errorThrown}`);
        }
    });
}

function closeMail(params) {
    $('#message-box').html("");
}
</script>
@endif

<script>
document.getElementById('aud').classList.add('active');



</script>
<script>
    function clientReqFunction(idclient) {
        console.log("ID du client sélectionné :", idclient);
    }
</script>

@endsection