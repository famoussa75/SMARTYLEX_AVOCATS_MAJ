<style>
    .pub-container {
        width: 200px;
        height: 30vh;
        overflow: hidden;
        position: relative;
        margin: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .slider {
        display: flex;
        flex-wrap: nowrap;
        width: 300%;
        height: 100%;
        animation: slide 15s infinite ease-in-out;
    }

    .slide {
        flex: 0 0 33.333%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        transition: transform 0.2s ease;
    }

    .slide:hover {
        transform: scale(0.80);
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.2s ease;
    }

    /* Animation professionnelle avec transitions douces */
    @keyframes slide {
        0% { 
            transform: translateX(0);
            animation-timing-function: ease-out;
        }
        26% { 
            transform: translateX(0);
            animation-timing-function: ease-in;
        }
        33% { 
            transform: translateX(-33.333%);
            animation-timing-function: ease-out;
        }
        59% { 
            transform: translateX(-33.333%);
            animation-timing-function: ease-in;
        }
        66% { 
            transform: translateX(-66.666%);
            animation-timing-function: ease-out;
        }
        92% { 
            transform: translateX(-66.666%);
            animation-timing-function: ease-in;
        }
        100% { 
            transform: translateX(0);
        }
    }

    /* Indicateurs de progression */
    .pub-container::before {
        content: '';
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        z-index: 10;
    }

    /* Barre de progression animée */
    .progress-bar {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 2px;
        z-index: 11;
        animation: progress 25s infinite linear;
        transform-origin: left center;
    }

    @keyframes progress {
        0% { 
            width: 0;
            left: 50%;
        }
        33% { 
            width: 80px;
            left: 50%;
        }
        33.1% { 
            width: 0;
            left: 50%;
        }
        66% { 
            width: 80px;
            left: 50%;
        }
        66.1% { 
            width: 0;
            left: 50%;
        }
        99% { 
            width: 80px;
            left: 50%;
        }
        100% { 
            width: 0;
            left: 50%;
        }
    }

    /* Overlay pour meilleure lisibilité */
    .slide::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 30%;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.5));
        pointer-events: none;
    }

    /* Effet de flou pendant la transition */
    .slider {
        backdrop-filter: blur(0px);
        transition: backdrop-filter 0.3s ease;
    }

    .slider:active {
        backdrop-filter: blur(2px);
    }
</style>


<div class="navbar-side" >
    <ul class="navbar-nav side-navbar" id="exampleAccordion" style="background: linear-gradient(rgba(0,0,0,0.2),rgba(0,0,0,0.2)), url('/assets/dist/img/sidebar-bg.png');background-size:cover;background-position:20%">
  
        <!-- Start Dashboard-->
        <li class="nav-item" title="Accueil" id="hm">
            <a class="load nav-link" href="{{route('home')}}">
                <i class="ti i-cl-0 ti-home"></i>
                <span class="nav-link-text" style="color:white"><b>Accueil</b></span>
            </a>
        </li>
        <!-- End Dashboard -->

        <!-- Start Messages -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tâche" id="tch">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#taches" data-parent="#exampleAccordion">
                
                <i class="ti i-cl-0 ti-layers"></i>
                <span class="nav-link-text" style="color:white"><b>Tâches</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="taches">

                <li>
                    <a class="load" href="{{ route('taskForm',[$idAffaire='x','all']) }}"><span class="submenu">Créer une tâche</span></a>
                </li>

                <li>
                    <a class="load" href="{{ route('allTasks') }}"><span class="submenu">Liste des tâches</span> </a>
                </li>
            </ul>

        </li>
        <!-- End Messages -->


        <!-- Start Messages -->
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
                    <a class="load" href="{{ route('allClient') }}"><span class="submenu">Liste des clients</span></a>
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
                    <a class="load" href="{{ route('allAfaires') }}"><span class="submenu">Liste des affaires</span></a>
                </li>

            </ul>
        </li>
        <!-- End Projects -->

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
        <!-- End UI Elements -->

        <!-- Start UI Elements -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Couriers" id="cr">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#courier" data-parent="#exampleAccordion">
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
       
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Facturation" id="fact">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#Facturation" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 fa fa-money"></i>
                <span class="nav-link-text" style="color:white"><b>Facturation</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Facturation">

                <li>
                    <a  href="{{ route('factureForm') }}"><span class="submenu">Créer une facture</span></a>
                </li>
                <li>
                    <a  href="{{ route('histoFacture') }}"><span class="submenu">Historique des factures</span></a>
                </li>
            </ul>

        </li>
        
        <!-- End UI Elements -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ressources Humaines" id="rh">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#RH" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 ti-user"></i>
                <span class="nav-link-text" style="color:white"><b>Ressources Humaines</b></span>
            </a>
            <ul class="sidenav-second-level collapse" id="RH">

                <li>
                    <a class="load" href="{{ route('formPersonnel') }}"><span class="submenu">Ajouter un personnel</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('userForm') }}"><span class="submenu">Compte Utilisateur</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('personneCard') }}"><span class="submenu">Liste du personnel</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('clientPersonnel') }}"><span class="submenu">Affecter un client au personnel</span></a>
                </li>
                
            </ul>

        </li>

        <!-- Start Advance Apps -->
        <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gestion" id="ges">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#Gestion" data-parent="#exampleAccordion">
                <i class="ti i-cl-0 fa fa-cog"></i>
                <span class="nav-link-text" style="color:white">Gestion</span>
            </a>
            <ul class="sidenav-second-level collapse" id="Gestion">

                <li>
                    <a class="load" href="{{ route('gestion') }}"><span class="submenu">Administration</span></a>
                </li>
                <li>
                    <a class="load" href="{{ route('userForm') }}"><span class="submenu">Compte Utilisateur</span></a>
                </li>
            </ul>

        </li> -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="parametre avancé" id="pa">
            <a class="nav-link" href="{{route('paramAvance')}}">
                <i class="ti i-cl-0 fa fa-wrench"></i>
                <span class="nav-link-text" style="color:white"><b>Paramètres avancés</b></span>
            </a>

        </li>
        <!-- Start Advance Pages -->

        <!-- Start Advance Apps -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Données externes" id="de">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#externe" data-parent="#exampleAccordion">
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
                <li>
                    <a class="load" href="{{route('annuaires.list')}}"><span class="submenu">Annuaires</span></a>
                </li>
            </ul>

        </li>

        <div class="pub-container ">
            <div class="slider">
                <div class="slide"><img src="/assets/dist/img/29.png" alt="Pub 1"></div>
                <div class="slide"><img src="/assets/dist/img/43.png" alt="Pub 2"></div>
                <div class="slide"><img src="/assets/dist/img/123.png" alt="Pub 3"></div>
            </div>
        </div>

    </ul>
   

</div>


<script>
  const slider = document.querySelector(".slider");
    let paused = false;

    document.querySelector(".pub-container").addEventListener("mouseenter", () => {
    slider.style.animationPlayState = "paused"; // pause au survol
    });

    document.querySelector(".pub-container").addEventListener("mouseleave", () => {
    slider.style.animationPlayState = "running"; // reprend après
    });

</script>
