<div class="container-fluid">

    <!-- row -->
    <div class="row" >
        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box  widget standard-widget">
                <div class="widget-caption info">
                    <a href="{{ route('personneCard') }}">
                        <div class="row">
                            <div class="col-4 padd-r-0">
                                <i class="icon ti-user"></i>
                            </div>
                            <div class="col-8">
                                <div class="widget-detail">
                                    <h3 class="cl-info infoPrive mb-2" >{{count($personnels)}}</h3>
                                    <h4>Employés</h4>
                                </div>
                            </div>
                           
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">

            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption danger">
                    <a href="{{ route('allClient') }}">
                        <div class="row">
                            <div class="col-4 padd-r-0">
                                <i class="icon icon ti-medall"></i>
                            </div>
                            <div class="col-8">
                                <div class="widget-detail">
                                    <h3 class="cl-danger infoPrive mb-2">{{count($clients)}}</h3>
                                    <h4>Clients</h4>
                                </div>
                            </div>
                          
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="col-md-3 col-sm-6">
            <div class="contact-grid-box widget standard-widget">
                <div class="widget-caption success">
                    <a href="{{ route('allAfaires') }}">
                        <div class="row">

                            <div class="col-4 padd-r-0">
                                <i class="icon ti-briefcase"></i>
                            </div>
                            <div class="col-8">
                                <div class="widget-detail">
                                    <h3 class="cl-success infoPrive mb-2">{{count($affaires)}}</h3>
                                    <h4>Affaires</h4>
                                </div>
                            </div>
                           

                        </div>
                    </a>
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
                    <a href="{{ route('allCouriers') }}">
                        <div class="row">
                            <div class="col-4 padd-r-0">
                                <i class="icon fa fa-envelope"></i>
                            </div>
                            <div class="col-8">
                                <div class="widget-detail">
                                    <h3 class="cl-warning infoPrive mb-2">{{$Tcourier}}</h3>
                                    <h4>Courriers</h4>
                                </div>
                            </div>
                           
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->

    <div class="row">

        <!-- Bar Chart -->
        <div class="col-md-8 col-sm-12" style="padding-right:5px;height:auto">
            <div class="card" style="height:565px;max-height:565px;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-star"></i> Meilleurs Employés</h4>
                </div>
                <div class="card-body">
                    <div id="chartdiv"></div>
                </div>
            </div>
           
        </div>

        <div class="col-md-4 col-sm-12" style="padding-left:0px;">
            <div class="card" style="background-color: #0d99b5;">
                <div class="card-header">
                    <i class="fa font-20  fa-globe" style="color:white"></i>
                    <h6 class=" text-right" style="color:white"><b>Nouveautés</b></h6>
                </div>
                <div class="card-body">

                    <div class="social-card-slide">

                        <div class="social-slide">

                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        style="background-color: white; text-align:center;height:4em;width:4em;padding-top:5px;border-radius:50px">
                                        <i class="ti ti-user font-40" style="color:#085b8f"></i>
                                    </div>

                                </div>
                                <div class="col-md-9" style="height: 50px;">
                                    <h5 style="color:white"><b>Nouveau Client</b></h5>
                                    @if(!empty($lastClient))
                                    <a class="load"
                                        href="{{route('clientInfos',[$lastClient[0]->idClient,$lastClient[0]->slug])}}"
                                        style="color:white">
                                        <p>{{$lastClient[0]->prenom}} {{$lastClient[0]->nom}}
                                            {{$lastClient[0]->denomination}}<br>

                                        </p>
                                    </a>
                                    @else
                                    <h4>Aucune Information</h4>
                                    @endif
                                </div>

                            </div>


                        </div>
                        <div class="social-slide">

                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        style="background-color: white; text-align:center;height:4em;width:4em;padding-top:5px;border-radius:50px">
                                        <i class="fa fa-suitcase font-40" style="color:#085b8f"></i>
                                    </div>

                                </div>
                                <div class="col-md-9" style="height: 50px;">
                                    <h5 style="color:white"><b>Nouvelle Affaire</b></h5>
                                    @if(!empty($lastAffaire))
                                    <a class="load"
                                        href="{{route('showAffaire',[$lastAffaire[0]->idAffaire,$lastAffaire[0]->slug])}}"
                                        style="color:white">
                                        <p>{{$lastAffaire[0]->nomAffaire}}</p>
                                    </a>
                                    @else
                                    <h4>Aucune Information</h4>
                                    @endif

                                </div>
                            </div>


                        </div>

                        <div class="social-slide">

                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        style="background-color: white; text-align:center;height:4em;width:4em;padding-top:5px;border-radius:50px">
                                        <i class="ti ti-pencil-alt font-40" style="color:#085b8f"></i>
                                    </div>

                                </div>
                                <div class="col-md-9" style="height: 50px;">
                                    <h5 style="color:white"><b>Nouvelle tâche</b></h5>
                                    @if(!empty($lastTache))
                                    <a class="load" href="{{route('infosTask',[$lastTache[0]->slug])}}"
                                        style="color:white">
                                        <p>{{$lastTache[0]->titre}}</p>
                                    </a>
                                    @else
                                    <h4>Aucune Information</h4>
                                    @endif

                                </div>
                            </div>


                        </div>

                        <div class="social-slide">

                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        style="background-color: white; text-align:center;height:4em;width:4em;padding-top:5px;border-radius:50px">
                                        <i class="fa fa-balance-scale font-40" style="color:#085b8f"></i>
                                    </div>

                                </div>
                                <div class="col-md-9" style="height: 50px;">
                                    <h5 style="color:white"><b>Nouvelle Audience</b></h5>
                                    @if(!empty($lastAudience))
                                    <a class="load"
                                        href="{{route('detailAudience',[$lastAudience[0]->idAudience,$lastAudience[0]->slug,$lastAudience[0]->niveauProcedural])}}"
                                        style="color:white">
                                        <p>{{$lastAudience[0]->objet}}</p>
                                    </a>
                                    @else
                                    <h4>Aucune Information</h4>
                                    @endif
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
            <div class="card" style="margin-top:-25px; height:410px;max-height:410px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('listAudience', 'a_venir') }}"><h4 class="mb-0"><i class="fa fa-balance-scale"></i> Audiences à venir</h4></a>
                    <a href="{{ route('listAudience', 'a_venir') }}">Voir plus &nbsp;<i class="fa fa-arrow-right"></i></a>
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

    </div>
    <div class="row" style="margin-top:-25px;padding-left:14px;padding-right:14px">
       
            <!-- Première carte -->
            <div class="col-md-8 col-sm-12 card" style="padding-right:0px; height:auto;border:solid 1px #dee3e7">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-database"></i> Situation des tâches</h4>
                </div>
                <div class="card-body" style="font-size:40px;">
                    <canvas id="pie-chart" width="10" height="5" style="padding-bottom:20px;"></canvas>
                </div>
            </div>

            <!-- Deuxième carte -->
            <div class="card col-md-4 col-sm-12" style="border-left:solid 5px #dee3e7">
               
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-users"></i> Employés actifs</h4>
                </div>
                <div class="card-body" style="overflow-y:auto; overflow-x:hidden; height:565px; max-height:565px;">
                    @foreach($users as $u)
                    @if($u->statut=='actif')
                    <div class="ground ground-list-single">
                        <img class="ground-avatar" src="/{{$u->photo}}" alt="...">
                        <span class="profile-statut bg-online pull-right"></span>
                        <div class="ground-content">
                            <h6><a href="{{ route('infosPersonne', [$u->slug]) }}"><b>{{$u->name}}</b></a></h6>
                            <small class="text-fade">@if($u->role=='Collaborateur') Collaborateur(trice) @elseif($u->role=='Assistant') Assistant(e) @elseif($u->role=='Administrateur') Administrateur(trice) @else @endif</small>
                        </div>
                        <div class="ground-right">
                            <a class="btn btn-small font-midium font-13 btn-rounded btn-success w-100" href="#">Actif</a>
                        </div>
                    </div>
                    @else
                    <div class="ground ground-list-single">
                        <img class="ground-avatar" src="/{{$u->photo}}" alt="...">
                        <span class="profile-statut bg-offline pull-right"></span>
                        <div class="ground-content">
                            <h6><a href="{{ route('infosPersonne', [$u->slug]) }}"><b>{{$u->name}}</b></a></h6>
                            <small class="text-fade">@if($u->role=='Collaborateur') Collaborateur(trice) @elseif($u->role=='Assistant') Assistant(e) @elseif($u->role=='Administrateur') Administrateur(trice) @else @endif</small>
                        </div>
                        <div class="ground-right">
                            <a class="btn btn-small font-midium font-13 btn-rounded btn-danger w-100" href="#">Inactif</a>
                        </div>
                    </div>
                    @endif
                    @endforeach
              
                </div>
            </div>
        
    </div>

    <!-- /.row -->

</div>




<style>
#chartdiv {
    width: 100%;
    height: 400px;
}
</style>


<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<!-- Chart code -->
<script>
    console.warn = () => {};

    


am5.ready(function() {

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Set data
    var data = [

        @foreach($personnelsGraph as $p) {
            name: "{{$p->initialPersonnel}}",
            steps: parseInt({{$p->score}}),

            pictureSettings: {
                src: "/{{$p->photo}}",
            },

        },
        @endforeach

    ];



    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none",
            paddingBottom: 40,
            paddingTop: 50,
            paddingLeft: 0,
            paddingRight: 0,
        })
    );

    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

    var xRenderer = am5xy.AxisRendererX.new(root, {});
    xRenderer.grid.template.set("visible", false);

    var xAxis = chart.xAxes.push(
        am5xy.CategoryAxis.new(root, {
            paddingTop: 30,
            categoryField: "name",
            renderer: xRenderer
        })
    );


    var yRenderer = am5xy.AxisRendererY.new(root, {});
    yRenderer.grid.template.set("strokeDasharray", [3]);

    var yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
            min: 0,
            renderer: yRenderer
        })
    );

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            name: "Income",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "steps",
            categoryXField: "name",
            sequencedInterpolation: true,
            calculateAggregates: true,
            maskBullets: false,
            tooltip: am5.Tooltip.new(root, {
                dy: -30,
                pointerOrientation: "vertical",
                labelText: "{valueY}"
            })
        })
    );

    series.columns.template.setAll({
        strokeOpacity: 0,
        cornerRadiusBR: 10,
        cornerRadiusTR: 10,
        cornerRadiusBL: 10,
        cornerRadiusTL: 10,
        maxWidth: 40,
        fillOpacity: 0.9
    });

    var currentlyHovered;

    series.columns.template.events.on("pointerover", function(e) {
        handleHover(e.target.dataItem);
    });

    series.columns.template.events.on("pointerout", function(e) {
        handleOut();
    });

    function handleHover(dataItem) {
        if (dataItem && currentlyHovered != dataItem) {
            handleOut();
            currentlyHovered = dataItem;
            var bullet = dataItem.bullets[0];
            // bullet.animate({
            //   key: "locationY",
            //   to: 0,
            //   duration: 600,
            //   easing: am5.ease.out(am5.ease.cubic)
            // });
        }
    }

    function handleOut() {
        if (currentlyHovered) {
            var bullet = currentlyHovered.bullets[0];
            bullet.animate({
                key: "locationY",
                to: 1,
                duration: 600,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }
    }

    var circleTemplate = am5.Template.new({});

    series.bullets.push(function(root, series, dataItem) {
        var bulletContainer = am5.Container.new(root, {});
        var circle = bulletContainer.children.push(
            am5.Circle.new(
                root, {
                    radius: 34
                },
                circleTemplate
            )
        );

        var maskCircle = bulletContainer.children.push(
            am5.Circle.new(root, {
                radius: 27
            })
        );

        // only containers can be masked, so we add image to another container
        var imageContainer = bulletContainer.children.push(
            am5.Container.new(root, {
                mask: maskCircle
            })
        );

        var image = imageContainer.children.push(
            am5.Picture.new(root, {
                templateField: "pictureSettings",
                centerX: am5.p50,
                centerY: am5.p50,
                width: 60,
                height: 60
            })
        );

        return am5.Bullet.new(root, {
            locationY: 1,
            sprite: bulletContainer
        });
    });

    // heatrule
    series.set("heatRules", [{
            dataField: "valueY",
            min: am5.color(0xe5dc36),
            max: am5.color(0x5faa46),
            target: series.columns.template,
            key: "fill"
        },
        {
            dataField: "valueY",
            min: am5.color(0xe5dc36),
            max: am5.color(0x5faa46),
            target: circleTemplate,
            key: "fill"
        }
    ]);

    series.data.setAll(data);
    xAxis.data.setAll(data);

    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineX.set("visible", false);
    cursor.lineY.set("visible", false);

    cursor.events.on("cursormoved", function() {
        var dataItem = series.get("tooltip").dataItem;
        if (dataItem) {
            handleHover(dataItem);
        } else {
            handleOut();
        }
    });

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear();
    chart.appear(1000, 100);

}); // end am5.ready()
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
        labels: ["Validée", "En Cours", "Suspendu", "Hors Délais"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#03C988", "#4682A9", "grey", "#e6005c"],
            data: [{{$Tvalider}}, {{$Tencours}}, {{$Tsuspendus}}, {{$ThorsDelais}}]

        }]
    },
    options: {
        title: {
            display: true,
            text: 'Nombre de tâche dans chaque categorie',

        }
    }
});
</script>

<script>
document.getElementById('hm').classList.add('active');


</script>