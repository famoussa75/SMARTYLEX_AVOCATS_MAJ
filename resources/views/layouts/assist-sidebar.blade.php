<style>
    /* Lien principal du menu */
    .navbar-side .nav-item > .nav-link {
        color: white !important;
        transition: all 0.3s;
    }

    /* Hover : background bleu-vert */
    .navbar-side .nav-item > .nav-link:hover {
        background-color: #009CAA !important; /* bleu-vert */
        color: #fff !important;               /* texte blanc pour contraste */
        transform: translateX(5px);           /* effet léger */
    }

    /* Sous-menu */
    .sidenav-second-level li a:hover {
        background-color: #009CAA !important;
        color: #fff !important;
        transform: translateX(5px);
    }

    /* Toutes les icônes restent dorées */
    .navbar-side i {
        color: #D7AE00 !important;
        transition: color 0.3s;
    }

    /* Optionnel : changer la couleur de l'icône au hover du lien */
    .navbar-side .nav-item > .nav-link:hover i {
        color: #fff !important; /* contraste avec le bleu-vert */
    }

    /* Transition fluide pour liens et sous-menu */
    .navbar-side .nav-link, 
    .sidenav-second-level li a {
        transition: all 0.3s ease;
    }

    /* Classe active pour les liens du menu */
    .navbar-side .nav-item > .nav-link.active,
    .navbar-side .nav-item.active > .nav-link {
        background-color: #D7AE00 !important; /* doré */
        color: #fff !important;               /* texte blanc */
        border-radius: 8px;                   /* coins arrondis pour effet moderne */
    }

    /* Icône de l'élément actif */
    .navbar-side .nav-item.active > .nav-link i,
    .navbar-side .nav-link.active i {
        color: #fff !important; /* icône blanche pour contraste */
    }
</style>



<div class="navbar-side">
    <ul class="navbar-nav side-navbar" id="exampleAccordion" style="
    background:
        radial-gradient(circle at top left, rgba(0, 180, 255, 0.15), transparent 50%),
        radial-gradient(circle at bottom right, rgba(255, 0, 120, 0.15), transparent 45%),
        linear-gradient(135deg, #0f102d, #1a1b4b, #2a135f);
    ">

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
            <a class="load nav-link" href="{{ route('taskForm',[$idAffaire='x','all']) }}">
                <i class="ti i-cl-0 ti-layers"></i>
                <span class="nav-link-text" style="color:white"><b>Tâches</b></span>
            </a>


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
      
        <li>

            <div class="pub-container" id="pubContainer">

                <button id="closePubBtn" class="close-pub-btn">X</button>

                <div class="slider">
                    <div class="slide"><img src="/assets/dist/img/pube1.jpeg" alt="Pub 1"></div>
                    <div class="slide"><img src="/assets/dist/img/pube2.jpeg" alt="Pub 2"></div>
                    <div class="slide"><img src="/assets/dist/img/pube3.jpeg" alt="Pub 3"></div>
                </div>

            </div>

            <!-- Icône en dehors ➜ visible même quand pubContainer est caché -->
            <div id="openPubIcon" class="open-pub-icon btn btn-white" hidden>📢</div>
        </li>
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


<script>
    const pubContainer = document.getElementById("pubContainer");
    const closeBtn = document.getElementById("closePubBtn");
    const openIcon = document.getElementById("openPubIcon");

    // Vérifier état enregistré
    const pubClosed = localStorage.getItem("pubClosed");

    if (pubClosed === "true") {
        pubContainer.style.display = "none";
        openIcon.hidden = false;
    }

    // Fermer la pub
    closeBtn.addEventListener("click", () => {
        pubContainer.style.display = "none";
        openIcon.hidden = false;
        localStorage.setItem("pubClosed", "true"); // Sauvegarde
    });

    // Ouvrir la pub
    openIcon.addEventListener("click", () => {
        pubContainer.style.display = "block";
        openIcon.hidden = true;
        localStorage.setItem("pubClosed", "false"); // Sauvegarde
    });
</script>