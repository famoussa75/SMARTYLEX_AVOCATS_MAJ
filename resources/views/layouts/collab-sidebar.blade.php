<div class="navbar-side">
    <ul class="navbar-nav side-navbar" id="exampleAccordion" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url('/assets/dist/img/sidebar-bg.png');background-size:cover;background-position:20%">

        <!-- Start Dashboard-->
        <li class="nav-item" title="Accueil" id="hm">
            <a class="load nav-link" href="{{route('home')}}" >
                <i class="ti i-cl-0 ti-home"></i>
                <span class="nav-link-text" style="color:white"><b>Accueil</b></span>
            </a>
        </li>
        <!-- End Dashboard -->


        <li class="nav-item" title="Tâche" id="tch">
            <a class="load nav-link" href="{{route('employeeTask')}}" >
                <i class="ti i-cl-0 ti-layers"></i>
                <span class="nav-link-text" style="color:white"><b>Tâches</b></span>
            </a>

        </li>

        <li class="nav-item"  title="Clients" id="clt">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#clients" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 fa fa-users"></i>
                <span class="nav-link-text" style="color:white"><b>Clients</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="clients">

                <li>
                    <a class="load" href="{{ route('clientForme') }}"><span class="submenu">Créer un client</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('CollabClient') }}"><span class="submenu">Liste des clients</span></a>
                </li>

            </ul>
        </li>
        <!-- Start projects -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Affaires" id="aff">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#affaire" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 fa fa-suitcase"></i>
                <span class="nav-link-text" style="color:white"><b>Affaires</b></span>

            </a>
            <ul class="sidenav-second-level collapse" id="affaire">

                <li>
                    <a class="load" href="{{ route('createAffaire') }}"><span class="submenu">Créer une affaire</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('CollabAffaires') }}"><span class="submenu">Liste des affaires</span></a>
                </li>

            </ul>
        </li>
        <!-- End Projects -->

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Couriers" id="cr">
            <a class="load nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#courier" data-parent="#exampleAccordion">
                <i class="ti i-cl-0  fa fa-envelope"></i>
                <span class="nav-link-text" style="color:white"><b>Courriers</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="courier">
                <li>
                    <a class="load" href="{{ route('createCourierDepart') }}"><span class="submenu"> Courriers - Départ</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('createCourierArriver') }}"><span class="submenu"> Courriers - Arrivée</span></a>
                </li>
              
                <li>
                    <a class="load" href="{{ route('allCouriers') }}"><span class="submenu">Tous les courriers</span></a>
                </li>
              
            </ul>
        </li>

         <!-- Start UI Elements -->
         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Audiences" id="aud">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#audiences" data-parent="#exampleAccordion">
                <i class="ti i-cl-0  fa fa-balance-scale"></i>
                <span class="nav-link-text" style="color:white"><b>Procédures</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="audiences">

                <li>
                    <a class="load" href="{{ route('addAudience') }}"><span class="submenu">Créer une procédure</span></a>
                </li>

                <li>
                    <a class="load" href="{{ route('listAudience', 'generale') }}"><span class="submenu">Procédures contradictoires</span></a>
                </li>

                <li>
                    <a class="load" href="{{ route('listRequete') }}"><span class="submenu">Procédures non contradic...</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('listAudience', 'a_venir') }}"><span class="submenu">Procédures à venir</span></a>
                </li>


            </ul>
        </li>
        <!-- Start Advance Apps -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Données externes" id="de">
            <a class="load nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#externe" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 ti-server"></i>
                <span class="nav-link-text" style="color:white"><b>Données externes</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="externe">

                <li>
                    <a class="load" href="{{route('avocats.list')}}"><span class="submenu">Avocats</span></a>
                </li>
                <li>
                    <a class="load" href="{{route('huissiers.list')}}"><span class="submenu">Huissiers</span></a>
                </li>
                <li>
                    <a class="load" href="{{route('notaires.list')}}"><span class="submenu">Notaires</span></a>
                </li>
            </ul>

        </li>
        
      

    </ul>
</div>