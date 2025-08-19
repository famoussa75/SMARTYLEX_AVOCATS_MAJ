<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<title>
    @yield('title')
</title>

@include('layouts.css')

<style>
    /* public/css/styles.css */


div,p,span,td,th,label,a,b {
    font-size: 14.5px;
}

.submenu{
    color:white;
    font-weight: 25px;
}

.submenu:hover{
    color:gray;
}

/* Ajoutez d'autres styles globaux ici */
/* public/css/styles.css */

.card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 
                0 3px 10px rgba(0, 0, 0, 0.1); /* Ombre douce */
    border-radius: 10px; /* Coins arrondis pour un effet plus doux */
    transition: box-shadow 0.3s ease; /* Transition pour l'effet de survol */
}

/* public/css/styles.css */


</style>

<style>
.horloge {
    background: white;
    border-radius: 50%;
    border: 5px solid #23B574;

    width: 280px;
    height: 280px;
    position: relative;
    align-content: center;
    left: 20%;
}

.content {
    width: 280px;
    height: 280px;
    position: relative;
}

.munite,
.heure {
    position: absolute;
    width: 8px;
    height: 100px;
    background: #000000;
    margin: auto;
    top: -39%;
    border-radius: 50%;

    left: 0;
    bottom: 0;
    right: 0;
    transform-origin: bottom center;
    transform: rotate(0deg);
    box-shadow: 0 0 10px rgba(0, 0, 0, .4);
}

.munite {
    position: absolute;
    width: 6px;
    height: 130px;
    background: #000000;
    top: -46%;
    left: 0;
    right: 0;
    transform: rotate(60deg);
}

.seconde {
    position: absolute;
    width: 2px;
    height: 90px;
    background: #df2a0be8;
    margin: auto;
    top: -30%;
    left: 0;
    border-radius: 50%;
    bottom: 0;
    right: 0;
    transform-origin: bottom center;
    transform: rotate(85deg);
}

.point {
    position: absolute;
    margin: auto;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: white;
    border: 2px solid black;
}

.decompte {
    position: absolute;
    margin: auto;
    padding: 0;
    right: 0;
    left: 0;
    text-align: center;
    font-family: sans serif;
    color: white;
    width: 100%;
}

.clientUl {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: transparent;
    position: sticky;
    top: 0;
}

.clientLi {
    float: left;
}

.clientLi a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.clientLi a:hover:not(.active) {
    background-color: #111;
}

.activeClient {
    background-color: #04AA6D;
}

.password-container {
    position: relative;
    display: inline-block;
}

.password-container input[type="password"] {
    padding-right: 30px; /* Laissez de l'espace pour l'icône */
}

.password-container .pass-view {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>

<script>
/**
 * Fonction permettant de caculer le temps pour faire bouger l'horloge
 *
 */
let messageDate = null;
let derniereDate = null;

function horloge() {
    // Les constantes contenant les differantes valeurs de la date (Heure, Munite, Seconde)
    const date = new Date();
    //let heurs = ((date.getHours() + 11 ) % 12 +1);
    let heurs = ((date.getHours()) % 24);
    let munites = date.getMinutes();
    let secondes = date.getSeconds();


    // Affectation des valeurs
    // Convertion des differantes valeurs de la date (Heure, Munite, Seconde) en degré
    const heurDeg = heurs * 30;
    const muniteDeg = munites * 6;
    const secondeDeg = secondes * 6;

    // Affichage des valeures en degré sur l'horloge

    // Condition pour afficher le temps dans la meilleur condition
    if (heurs < 10) {
        heurs = `0${heurs}h`;
    } else {
        heurs = `${heurs}h`;
    }


    if (munites < 10) {
        munites = `0${munites}min`;
    } else {
        munites = `${munites}min`;
    }
    if (secondes < 10) {
        secondes = `0${secondes}sec`;
    } else {
        secondes = `${secondes}sec`;
    }

    document.querySelector('.H').innerHTML = heurs + ':';
    document.querySelector('.M').innerHTML = munites + ':';
    document.querySelector('.S').innerHTML = secondes;


    document.querySelector('.heure').style.transform = `rotate(${heurDeg}deg)`;
    document.querySelector('.munite').style.transform = `rotate(${muniteDeg}deg)`;
    document.querySelector('.seconde').style.transform = `rotate(${secondeDeg}deg)`;

    messageDate = `${heurs} : ${munites} : ${secondes}`

}



</script>



<body class="fixed-nav sticky-footer @if (Auth::user()->theme) {{Auth::user()->theme}} @else blue-skin @endif"
    id="page-top" style="height:100%">

    <!-- ===============================
                Navigation Start
		====================================-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav"
        style="background: linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.1)), url('/assets/dist/img/sidebar-bg.png');background-size:cover;">
        <!-- Start Header -->
        <header class="header-logo" style="background-color:transparent">
            @if(Auth::user()->role =='Client')
            @else
            <a class="nav-link text-center mr-lg-3 hidden-xs" id="sidenavToggler" style="color:white"><i
                    class="ti-align-left"></i></a>
            @endif
            <a class="load navbar-brand" href="{{ route('home') }}" style="display: flex; align-items: center;">
                @if(Session::has('cabinetLogo'))
                    @foreach (Session::get('cabinetLogo') as $logo)
                        <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-image: url('{{ URL::to('/') }}/{{$logo->logo}}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-color: white; border-radius: 5%; margin-right: 5px;">
                        </div>
                    @endforeach
                @endif
                @if(Session::has('cabinetSession'))
                    @foreach (Session::get('cabinetSession') as $cabinet)
                        <b style="font-size: 16px; color: white; margin-left: 10px;">{{$cabinet->nomCourt}}</b>
                    @endforeach
                @endif
            </a>
        </header>
        <!-- End Header -->
        @if(Auth::user()->role =='Client')
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="ti-align-left"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">

            <ul class="navbar-nav ml-left clientUl">
                <li class="clientLi"><a href="{{route('home')}}" id="hm"><i class="fa fa-home"></i> Accueil</a></li>
                <li class="clientLi"><a href="{{route('clientInfos', [Auth::user()->idClient,'x'])}}" id="clt"><i
                            class="fa fa-user"></i> Mon portail</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <!-- Notification -->
                <li class="nav-item dropdown">
                    <h4 style="color:white" class="mt-2">{{ Auth::user()->name }}</h4>
                </li>
                <!-- End Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-0 user-img a-topbar__nav a-nav" id="userDropdown" href="#"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <img class="" src="{{URL::to('/')}}/{{Auth::user()->photo}}" alt="user-img"
                            style="width: auto; height: 50px; object-fit: cover;border-radius:40%;border: 2px white solid ;"
                            alt="...">

                        <span class="profile-status bg-online pull-right"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated flipInX" aria-labelledby="userDropdown">
                        <li class="cl-white theme-bg top-header-dropdown ">
                            <div class="header-user-pic">

                                <img class="" src="{{URL::to('/')}}/{{Auth::user()->photo}}" alt="..."
                                    style="width: auto; height: 50px; object-fit: cover;border-radius:40%;border: 2px white solid ;">

                                <span class="profile-status bg-online pull-right"></span>
                            </div>
                            <div class="header-user-det">
                                <span class="a-dropdown--title">{{ Auth::user()->name }}</span>
                                <span class="a-dropdown--subtitle">{{ Auth::user()->email }}</span> <br>
                            </div>
                        </li>
                        @if(Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Client' )
                        &nbsp;
                        @else
                        <li>
                            <a class="load dropdown-item" href="{{ route('infosPersonne2', Auth::user()->email) }}"><i
                                    class="ti-user"></i> &nbsp;&nbsp;Mon profil</a>
                        </li>
                        @endif
                        <li>
                            <a class="load dropdown-item" href="{{ route('editPassword', Auth::user()->email) }}"
                                title="Joindre un fichier à cette tâche"><i class="ti-lock"></i> &nbsp;&nbsp;Modifier
                                mon mot de passe</a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="cl-white theme-bg" style="width:100%"><i
                                        class="fa fa-power-off"></i>&nbsp;&nbsp; Se deconnecter</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>


        @else
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="ti-align-left"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!-- =============== Start Side Menu ============== -->
            @if(Auth::user()->role =='Administrateur')
            @include('layouts.admin-sidebar')
            @elseif(Auth::user()->role =='Collaborateur')
            @include('layouts.collab-sidebar')
            @elseif(Auth::user()->role=="Assistant")
            @include('layouts.assist-sidebar')
            @else
            @endif
            <!-- =============== End Side Menu ============== -->
            <!-- =============== Search Bar ============== -->
            <ul class="navbar-nav ml-left" style="padding-left:10PX ;">
                <li class="row nav-item">
                    <div class="col-md-9">
                        <form class="form-inline my-1 my-lg-0 mr-lg-2" style="width:300px ;">
                            <div class="input-group col-md-12" style="border-radius: 5px; border:1px solid white">
                                <span class="input-group-btn" style="margin-left:-10px ;">
                                    <button class="btn btn-primary" type="button">
                                        <i class="ti-search"></i>
                                    </button>
                                </span>
                                <input class="form-control" type="text" placeholder="Reherche..." id="searchTask">
                            </div>
                        </form>
                    </div>



                </li>



            </ul>
            <!-- =============== End Search Bar ============== -->
            <!-- =============== Header Rightside Menu ============== -->
            <ul class="navbar-nav ml-auto">

                <!-- Notification -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle mr-lg-3 a-topbar__nav a-nav" id="alertsDropdown"
                        onclick="newNotificationListe()" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti-bell"></i>
                        <div id="totalNotif">
                        </div>
                        <span class="hidden-lg hidden-md mrg-l-10">Nouvelles Notifications</span>
                    </a>
                    <div class="dropdown-menu animated flipInX" aria-labelledby="alertsDropdown">
                        <div class="theme-bg top-header-dropdown text-center" id='nbNotif'>
                        </div>
                        <div class="ground-list ground-hover-list" id="notification-box">
                        </div>
                        <!-- <a class="load dropdown-item view-all" href="#">Voir tous</a> -->
                    </div>
                </li>
                <!-- End Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-0 user-img a-topbar__nav a-nav" id="userDropdown" href="#"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <img class="" src="{{URL::to('/')}}/{{Auth::user()->photo}}" alt="user-img"
                            style="width: auto; height: 40px; object-fit: cover;border-radius:40%;border: 2px white solid ;"
                            alt="...">

                        <span class="profile-status bg-online pull-right"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated flipInX" aria-labelledby="userDropdown">
                        <li class="cl-white theme-bg top-header-dropdown ">
                            <div class="header-user-pic">

                                <img class="" src="{{URL::to('/')}}/{{Auth::user()->photo}}" alt="..."
                                    style="width: auto; height: 50px; object-fit: cover;border-radius:40%;border: 2px white solid ;">

                                <span class="profile-status bg-online pull-right"></span>
                            </div>
                            <div class="header-user-det">
                                <span class="a-dropdown--title">{{ Auth::user()->name }}</span>
                                <span class="a-dropdown--subtitle">{{ Auth::user()->email }}</span> <br>
                            </div>
                        </li>
                        @if(Auth::user()->role == 'Administrateur')
                        &nbsp;
                        @else
                        <li>
                            <a class="load dropdown-item" href="{{ route('infosPersonne2', Auth::user()->email) }}"><i
                                    class="ti-user"></i> &nbsp;&nbsp;Mon profil</a>
                        </li>
                        @endif
                        <li>
                            <a class="load dropdown-item" href="{{ route('editPassword', Auth::user()->email) }}"
                                title="Joindre un fichier à cette tâche"><i class="ti-lock"></i> &nbsp;&nbsp;Modifier
                                mon mot de passe</a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="cl-white theme-bg" style="width:100%"><i
                                        class="fa fa-power-off"></i>&nbsp;&nbsp; Se deconnecter</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- =============== End Header Rightside Menu ============== -->
        </div>
        <button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()"><i class="spin fa fa-cog"
                aria-hidden="true"></i></button>
        @endif

    </nav>
    <!-- =====================================================
		                    End Navigations
		======================================================= -->
    <div class="@if (Auth::user()->role =='Client')  @else content-wrapper @endif ">

        <!-- La division contenant le resultat de la recherche-->
        <div id="resultSearch" hidden>
            <div class="container-fluid">
                <!-- Resultat des recherches dans Courier Depart-->
                <div class="row" id="searData">
                    <div class="col-md-12">
                        <h4 class="theme-cl mb-3"><i class="fa fa-search"></i> Résultats dans Clients</h4>
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-item">
                                    <div class="container timeline-body row" id="dataSearch5">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resultat des recherches dans tache-->
                <div class="row" id="searData">
                    <div class="col-md-12">
                        <h4 class="theme-cl mb-3"><i class="fa fa-search"></i> Résultats dans tâches</h4>
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-item">
                                    <div class="container timeline-body row" id="dataSearch">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resultat des recherches dans Affaire-->
                <div class="row" id="searData">
                    <div class="col-md-12">
                        <h4 class="theme-cl mb-3"><i class="fa fa-search"></i> Résultats dans Affaires</h4>
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-item">
                                    <div class="container timeline-body row" id="dataSearch2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role=='Administrateur' || Auth::user()->role=='Assistant')
                <!-- Resultat des recherches dans Courier Depart-->
                <div class="row" id="searData">
                    <div class="col-md-12">
                        <h4 class="theme-cl mb-3"><i class="fa fa-search"></i> Résultats dans Courriers - Départ</h4>
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-item">
                                    <div class="container timeline-body row" id="dataSearch3">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resultat des recherches dans Courier Depart-->
                <div class="row" id="searData">
                    <div class="col-md-12">
                        <h4 class="theme-cl mb-3"><i class="fa fa-search"></i> Résultats dans Courriers - Arrivée</h4>
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-item">
                                    <div class="container timeline-body row" id="dataSearch4">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                @endif
                <div class="row" id="searchErrors">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="detail-wrapper padd-top-30">
                                <div class="timeline-body" id="resultStat">
                                    <h4 class="text-center">
                                        <span class="label bg-warning" id="res">Aucun résultat trouvé, veuillez
                                            réessayer</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <audio controls src="{{URL::to('/')}}/assets/dist/son/notification.mp3" id="son" hidden>
            <a href="{{URL::to('/')}}/assets/dist/son/notification.mp3">
                Download audio
            </a>
        </audio>


        <!-- declacheur modal success -->
        <div class="modal modal-box" hidden>
            <a href="#modal-success" class="btn-modal" data-toggle="modal" data-target="#modal-success"
                id="btnSuccess">Reuissie</a>
        </div>
        <!-- modal-operation success -->
        <div class="modal modal-box-2 fade" id="modal-success" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="myModalLabel">

                    <div class="modal-body" style="height: 350px; background-color:whitesmoke">
                        <button type="button" class="close" id="btnClose" data-dismiss="modal"
                            aria-hidden="true">&times;</button>

                        <!-- <div class="" style="text-align: center;">
                            <h4><span style="color:#23B574" id="spanMessageSuccess"></span></h4>
                        </div> -->

                        <img src="{{URL::to('/')}}/assets/dist/img/success.gif" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal-success -->

        <!-- declacheur modal error -->
        <div class="modal modal-box" hidden>
            <a href="#modal-error" class="btn-modal" data-toggle="modal" data-target="#modal-error"
                id="btnError">Echec</a>
        </div>
        <!-- modal-operation error -->
        <div class="modal modal-box-2 fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="myModalLabel">

                    <div class="modal-body" style="height: 350px; background-color:whitesmoke">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <div class="" style="text-align: center;">
                            <h2>Échec</h2>
                            <h4><span style="color:brown" id="spanMessageError"></span></h4>
                        </div>

                        <img src="{{URL::to('/')}}/assets/dist/img/error.gif" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal-error -->

        <!-- modal-loading -->
        <div id="loadingModal" class="modal-box-2 modal" style="background-color: rgba(7, 8, 7, 0.6);" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="myModalLabel3"
                    style="height: 350px; background-color:transparent;padding-top:150px">
                    <img src="{{URL::to('/')}}/assets/dist/img/loading.gif" alt="...">
                    <h2 style="text-align: center;color: white">Chargement en cours...</h2>
                </div>
            </div>
        </div>
        <!-- End modal-loading -->
        <div hidden>
        <a href="" data-toggle="modal" id="lanceModal" data-target="#updatePassword" onclick=""><i class="fa fa-trash" style="color:brown ;"></i></a>
        
        <input type="hidden" name="lastConnexion" id="lastConnexion" value="{{Auth::user()->lastConnexion}}">
        </div>
           
        <div class="add-popup modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="updatePassword">
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
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Changez votre mot de passe</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('password.update')}}">
                            @csrf
                            <div class="row mrg-0">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <p><b>Important :</b> Pour des raisons de sécurité et de confidentialité nous vous conseillons de modifier le mot de passe par defaut.</p>
                                        <hr>
                                            <div class="mb-4">
                                                <label for="current_password">Mot de passe par defaut</label><br>
                                         
                                                <div class="password-container">
                                                    <input type="password" class="form-control" name="current_password"  id="mpasswordField" style="width:40em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                                    <i class="pass-view fa fa-eye" id="mtogglePasswordField"></i>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="password">Nouveau Mot de passe</label><br>

                                                <div class="password-container">
                                                    <input type="password" class="form-control" name="password"  id="mpasswordField2" style="width:40em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                                    <i class="pass-view fa fa-eye" id="mtogglePasswordField2"></i>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="password_confirmation">Confirmer le nouveau mot de passe</label><br>

                                                <div class="password-container">
                                                    <input type="password" class="form-control" name="password_confirmation"  id="mpasswordField3" style="width:40em" data-error=" veillez saisir le mot de passe" placeholder="" required>
                                                    <i class="pass-view fa fa-eye" id="mtogglePasswordField3"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg-0">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button type="submit" class="theme-bg btn btn-rounded btn-block"
                                                style="width:50%;">
                                                Valider</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="defaultContent">
            @yield('content')
        </div>
        @include('layouts.footer')

        @include('layouts.js')

    </div>


    <script>
   
   $(document).ready(function() { 
   

        console.clear();    

    });


        


            
       var lastConnexion = $('#lastConnexion').val();
       var modalPassword = document.getElementById('updatePassword');

       if (lastConnexion==1) {
       
       } else {
        $('#lanceModal').click();
       }

        // Afficher le modal de chargement
        function showLoadingModal() {
            var modal = document.getElementById('loadingModal');
            modal.style.display = 'block';

            setTimeout(() => {
                modal.style.display = 'none';
            }, 5000);
        }

        // Masquer le modal de chargement
        function hideLoadingModal() {
            var modal = document.getElementById('loadingModal');
            modal.style.display = 'none';
        }


        window.addEventListener('beforeunload', function(event) {

            // Les champs ne sont pas valides.
            showLoadingModal();

        });

        window.addEventListener('load', function() {
            // Masquer le modal de chargement
            hideLoadingModal();
        });

        window.addEventListener('popstate', function(event) {

            if (event.state && event.state.page === 'previous') {

                hideLoadingModal();
            }
            if (event.state && event.state.page === 'next') {

                hideLoadingModal();
            }

        });

        function voir(param, idNotif) {

            var url = '{{route("vueNotif", [":p",":i"])}}';
            url = url.replace(':p', param);
            url = url.replace(':i', idNotif);
            location.href = url
        }

        // fonction permettante d'ajouter un tag
        function addTag(tagInfo, idTage) {
            $.ajax({
                type: "GET",
                url: `/add/tageInfo/${tagInfo}/${idTage}`,
                dataType: "json",
                success: function(response) {
                    //console.log(response.message)
                    getMyTag();
                    $('#tagsValue').prop('selectedIndex', -1).trigger('change');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de retourner la liste des informations en fonction du type
        // (Affaire, Client, Taches)
        function getTag(type) {
            $.ajax({
                type: "GET",
                url: `/get/tagsBy/${type}/data`,
                dataType: "json",
                success: function(response) {
                    $('#dataTags').removeAttr('hidden');
                    $('#tagsValue').html('');
                    $.each(response.tags, function(key, value) {
                        if (response.type == 'affaire') {
                            $('#tagsValue').append(`
                                    <option value="${value.id}">${value.nom}</option>
                                    `);
                        }
                        if (response.type == 'client') {
                            $('#tagsValue').append(`
                                        <option value="${value.id}">${value.prenom} ${value.nom}</option>
                                   `);
                        }
                        if (response.type == 'tache') {
                            $('#tagsValue').append(`
                                    <option value="${value.id}">${value.titre}</option>
                                    `);
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de chercher les tags d'un utilisateur
        function getMyTag() {
            $.ajax({
                type: "GET",
                url: `/getMyTag`,
                dataType: "json",
                success: function(response) {
                    if (response.tags.length > 0) {
                        $('#getTagData').html(`<h4>Tags : </h4>&nbsp;&nbsp;
                            <span id="allTag"></span>
                            `);
                        $('#allTag').html('');
                        $.each(response.tags, function(key, value) {
                            $('#allTag').append(`
                                <a href="/redirectTag/${value.idData}/${value.slug}/${value.type}" class="label label-info">${value.tags}</a>
                                `)
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });

        }

        $('#idTag').on('click', function(e) {
            $('#tagContent').removeAttr('hidden');
        })

        $('#tags').on('keyup', function(e) {
            var val = e.target.value.toLowerCase();
            if (val.includes('@client')) {
                getTag('@client');
            }
            if (val.includes('@tache')) {
                getTag('@tache');
            }
            if (val.includes('@affaire')) {
                getTag('@affaire');
            }
        });

        $('#tagsValue').on('change', function(e) {
            $('#tagContent').attr('hidden', true);
            $(this).parent().attr('hidden', true);
            let type = $('#tags').val();
            $('#tags').val('');
            addTag(type, this.value);
        });

        getMyTag();

        $('#clock-In').css('background-color', '#23B574');
        $('#clock-Out').css('background-color', '#23B574');

        $('#clock-In').on('click', function(e) {

            $(this).attr('hidden', true);

            $('#clock-Out').css('background-color', '#df2a0be8');
            $('#clock-Out').removeAttr('hidden');

            $('#horlogeContent').css('border-color', '#df2a0be8');
            $('#clockHearder').css('background-color', '#df2a0be8');
            $('#messageClock').text(`Présence confirmé, heure de démarrage : ${messageDate}`)
            clockIn();
        });
        $('#clock-Out').on('click', function(e) {

            $(this).attr('hidden', true);

            $('#clock-In').css('background-color', '#23B574');
            $('#clock-In').removeAttr('hidden');

            $('#horlogeContent').css('border-color', '#23B574');
            $('#clockHearder').css('background-color', '#23B574');
            $('#messageClock').text(`Fin de travail confirmé, heure d'arrêt : ${messageDate}`);

            clockOut(derniereDate, messageDate);
        });
        // fonction permettante de verifier et effectuer le clockIn
        function clockIn() {
            $.ajax({
                type: "GET",
                url: `/get/clockStat`,
                dataType: "json",
                success: function(response) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }
        // fonction permettante de verifier et effectuer le clockIn
        function clockOut(dA, dD) {

            $.ajax({
                type: "GET",
                url: `/get/clockOut/${dA}/${dD}delay`,
                dataType: "json",
                success: function(response) {
                    //alert(response.success);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de recuperer une tache correspondante
        // a la recherche
        function getTacheSearch(search) {

            $.ajax({
                type: "GET",
                url: `/getTaskSearch/${search}`,
                dataType: "json",
                success: function(response) {
                    var stat = '';
                    var errorStatus = true;
                    $('#dataSearch').html(``);
                    $.each(response.tache, function(key, value) {

                        // Construire une ligne contenant les informations de tous les champs
                        if (value.titre.includes(search)) {
                            errorStatus = false;
                            $('#dataSearch').append(`
                                <div class="col-md-3 col-sm-6">
                                    <div class="card outline-primary mb-3 text-center" style="height: 10em;">
                                        <a class="load" href = "/tache/view/${value.slug}">
                                            <div class="card-detail-block">
                                                <i class="ti i-cl-3 ti-layers" style="font-size: 20px;"></i>
                                                <blockquote class="card-detail-blockquote">
                                                    <h6 style="text-transform: uppercase;">
                                                        <b style="font-family: Gill Sans, sans-serif; ">
                                                        ${value.titre}
                                                        </b>
                                                    </h6>
                                                </blockquote>
                                            </div>
                                        </a>
                                    </div>
                                 </div>`)
                        }
                    });

                    if (response.tache == '') {
                        $('#dataSearch').append(
                            `<h4 style="color:Red; text-align:center; margin-left:50%">Aucune information trouvée . . .</h4> `
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de recuperer une affaire correspondante
        // a la recherche
        function getAffaireSearch(search) {

            $.ajax({
                type: "GET",
                url: `/getAffaireSearch/${search}`,
                dataType: "json",
                success: function(response) {
                    var stat = '';
                    var errorStatus = true;
                    $('#dataSearch2').html(``);
                    $.each(response.affaire, function(key, value) {

                        // Construire une ligne contenant les informations de tous les champs
                        if (value.nomAffaire.includes(search)) {
                            errorStatus = false;
                            $('#dataSearch2').append(`
                                        <div class="col-md-3 col-sm-6">
                                                    <div class="card outline-warning mb-3 text-center" style="height: 10em;">
                                                    <a class="load" href = "/affaire/view/${value.idAffaire}/${value.slug}">
                                                            <div class="card-detail-block">
                                                                <i class="ti i-cl-6 ti-bag" style="font-size: 20px;"></i>
                                                                <blockquote class="card-detail-blockquote">
                                                                    <h6 style="text-transform: uppercase;">
                                                                        <b style="font-family: Gill Sans, sans-serif; ">
                                                                        ${value.nomAffaire}
                                                                        </b>
                                                                    </h6>

                                                                </blockquote>
                                                            </div>
                                                        </a>
                                                    </div>
                                        </div>`)
                        }
                    });

                    if (response.affaire == '') {
                        $('#dataSearch2').append(
                            `<h4 style="color:Red; text-align:center; margin-left:50%">Aucune information trouvée . . .</h4> `
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   // console.log( `JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de recuperer un courier depart correspondante
        // a la recherche
        function getCourierDepSearch(search) {

            $.ajax({
                type: "GET",
                url: `/getCourierDepartSearch/${search}`,
                dataType: "json",
                success: function(response) {
                    var stat = '';
                    var errorStatus = true;
                    $('#dataSearch3').html(``);
                    $.each(response.courierDepart, function(key, value) {

                        // Construire une ligne contenant les informations de tous les champs
                        if (value.objet.includes(search)) {
                            errorStatus = false;
                            $('#dataSearch3').append(`
                                <div class="col-md-4 col-sm-6">
                                    <div class="card outline-danger mb-3 text-center" style="height: 10em;">
                                    <a class="load" href = "/courier_depart/viewFonction/${value.slug}">
                                            <div class="card-detail-block">
                                                <i class="ti i-cl-5 fa fa-envelope" style="font-size: 20px;"></i>
                                                <blockquote class="card-detail-blockquote">
                                                    <h6 style="text-transform: uppercase;">
                                                        <b style="font-family: Gill Sans, sans-serif; ">
                                                        ${value.objet}
                                                        </b>
                                                    </h6>

                                                </blockquote>
                                            </div>
                                        </a>
                                    </div>
                                </div>`)
                        }
                    });

                    if (response.courierDepart == '') {
                        $('#dataSearch3').append(
                            `<h4 style="color:Red; text-align:center; margin-left:50%">Aucune information trouvée . . .</h4> `
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        function getClientSearch(search) {

            $.ajax({
                type: "GET",
                url: `/getClientSearch/${search}`,
                dataType: "json",
                success: function(response) {
                    var stat = '';
                    var errorStatus = true;
                    $('#dataSearch5').html(``);
                    $.each(response.clients, function(key, value) {

                        var denomination = value.prenom;
                        var prenom = value.nom;
                        var nom = value.denomination;

                        if (denomination === null) {
                            denomination = ''
                        }
                        if (prenom === null) {
                            prenom = ''
                        }
                        if (nom === null) {
                            nom = ''
                        }

                        // Construire une ligne contenant les informations de tous les champs

                        errorStatus = false;
                        $('#dataSearch5').append(`
                        <div class="col-md-4 col-sm-6">
                            <div class="card outline-primary mb-3 text-center" style="height: 10em;">
                            <a class="load" href = "/client/view/${value.idClient}/${value.slug}">
                                    <div class="card-detail-block">
                                        <i class="ti i-cl-5 fa fa-user" style="font-size: 20px;"></i>
                                        <blockquote class="card-detail-blockquote">
                                            <h6 style="text-transform: uppercase;">
                                                <b style="font-family: Gill Sans, sans-serif; ">
                                                   ${[value.prenom, value.nom, value.denomination].filter(Boolean).join(' ')}

                                                </b>
                                            </h6>

                                        </blockquote>
                                    </div>
                                </a>
                            </div>
                        </div>`)

                    });

                    if (response.clients == '') {
                        $('#dataSearch5').append(
                            `<h4 style="color:Red; text-align:center; margin-left:50%">Aucune information trouvée . . .</h4> `
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log( `JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        // Fonction permettante de recuperer un courier arriver correspondante
        // a la recherche
        function getCourierArrSearch(search) {

            $.ajax({
                type: "GET",
                url: `/getCourierArriverSearch/${search}`,
                dataType: "json",
                success: function(response) {
                    var stat = '';
                    var errorStatus = true;
                    $('#dataSearch4').html(``);
                    $.each(response.courierArriver, function(key, value) {

                        // Construire une ligne contenant les informations de tous les champs
                        if (value.objet.includes(search)) {
                            errorStatus = false;
                            $('#dataSearch4').append(`
                                <div class="col-md-4 col-sm-6">
                                    <div class="card outline-success mb-3 text-center" style="height: 10em;">
                                    <a class="load" href = "/courier_arriver/view/${value.slug}">
                                            <div class="card-detail-block">
                                                <i class="ti i-cl-6 fa fa-envelope" style="font-size: 20px;"></i>
                                                <blockquote class="card-detail-blockquote">
                                                    <h6 style="text-transform: uppercase;">
                                                        <b style="font-family: Gill Sans, sans-serif; ">
                                                        ${value.objet}
                                                        </b>
                                                    </h6>
                                                </blockquote>
                                            </div>
                                        </a>
                                    </div>
                                </div>`)
                        }
                    });

                    if (response.courierArriver == '') {
                        $('#dataSearch4').append(
                            `<h4 style="color:Red; text-align:center; margin-left:50%">Aucune information trouvée . . .</h4> `
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        let result = ''

        let searchContent = '';
        var searchValue = '';

        $('#searchErrors').attr('hidden', true);
        $('#searchTask').on('keyup', function(e) {
            searchContent = e.target.value;
            searchValue = $('#searchTask').val().toLowerCase();


            if (searchContent.length > 0) {
                $('#defaultContent').attr('hidden', true);
                $('#resultSearch').removeAttr('hidden');
                getTacheSearch(searchValue);
                getAffaireSearch(searchValue);
                getCourierDepSearch(searchValue);
                getCourierArrSearch(searchValue);
                getClientSearch(searchValue);
            } else {
                $('#defaultContent').removeAttr('hidden');
                $('#resultSearch').attr('hidden', true);
            }

        });


        $('#clock-In').css('background-color', '#23B574');
        $('#clock-Out').css('background-color', '#23B574');

        $('#clock-In').on('click', function(e) {

            $(this).attr('hidden', true);

            $('#clock-Out').css('background-color', '#df2a0be8');
            $('#clock-Out').removeAttr('hidden');

            $('#horlogeContent').css('border-color', '#df2a0be8');
            $('#clockHearder').css('background-color', '#df2a0be8');
            $('#messageClock').text(`Présence confirmé, heure de démarrage : ${messageDate}`)
            clockIn();
        });
        $('#clock-Out').on('click', function(e) {

            $(this).attr('hidden', true);

            $('#clock-In').css('background-color', '#23B574');
            $('#clock-In').removeAttr('hidden');

            $('#horlogeContent').css('border-color', '#23B574');
            $('#clockHearder').css('background-color', '#23B574');
            $('#messageClock').text(`Fin de travail confirmé, heure d'arrêt : ${messageDate}`);

            clockOut(derniereDate, messageDate);
        });

        // fonction permettante de verifier et effectuer le clockIn
        function clockIn() {

            $.ajax({
                type: "GET",
                url: `/get/clockStat`,
                dataType: "json",
                success: function(response) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }
        // fonction permettante de verifier et effectuer le clockIn
        function clockOut(dA, dD) {

            $.ajax({
                type: "GET",
                url: `/get/clockOut/${dA}/${dD}delay`,
                dataType: "json",
                success: function(response) {
                    alert(response.success);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }

        function voir(param, idNotif) {

            var url = '{{route("vueNotif", [":p",":i"])}}';
            url = url.replace(':p', param);
            url = url.replace(':i', idNotif);
            location.href = url
        }


    </script>

    @if (session()->has('success'))
    <script>
    var btnSuccess = document.getElementById('btnSuccess');
    var btnClose = document.getElementById('btnClose');
    var span = document.getElementById('spanMessageSuccess');
    var message = "{{ session()->get('success') }}";
    //span.innerHTML = message;
    btnSuccess.click();

    setTimeout(() => {
        btnClose.click();
    }, 2000);
    </script>
    @endif
    @if (session()->has('error'))
    <script>
    var btnError = document.getElementById('btnError');
    var span = document.getElementById('spanMessageError');
    var message = "{{ session()->get('error') }}";
    span.innerHTML = message;
    btnError.click();
    </script>
    @endif

    <script>

    </script>

</body>

</html>