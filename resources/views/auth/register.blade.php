<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from drizvato.com/demo/adminfier-template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Sep 2019 13:25:13 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
    @if(Session::has('cabinetSession'))
    @foreach (Session::get('cabinetSession') as $cabinet)
    <span>{{$cabinet->nomCourt}}</span>
    @endforeach
    @else
    Le cabinet
    @endif
    </title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assets/plugins/themify/css/themify.css') }}" rel="stylesheet" type="text/css">

    <!-- Angular Tooltip Css -->
    <link href="{{ asset('assets/plugins/angular-tooltip/angular-tooltips.css') }}" rel="stylesheet">

    <!-- Page level plugin CSS -->
    <link href="{{ asset('assets/dist/css/animate.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/dist/css/adminfier.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/adminfier-responsive.css') }}" rel="stylesheet">

    <!-- Custom styles for Color -->

    <!-- <link id="jssDefault" rel="stylesheet" href="{{ asset('assets/dist/css/skins/default.css') }}') }}"> -->
</head>

<body class="red-skin">

    <div class="container-fluid">
        <div class="row">
            <div class="hidden-xs hidden-sm col-lg-6 col-md-6 theme-bg" style="background-image:url('assets/dist/img/sidebar-bg.jpeg');background-size:container">
                <div class="clearfix">
                    <div class="logo-title-container text-center" style="margin-top: -120px;">
                        <h1 class="cl-white text-upper"><b></b></h1>
                        @if(Session::has('cabinetSession'))
                        @foreach (Session::get('cabinetLogo') as $c)
                        <img class="img-responsive mb-2" src="{{URL::to('/')}}/{{$c->logo}}" alt="Logo Icon" style="height: 80px;background-color:white;padding:5px;border-radius:10px">
                        @endforeach
                        @endif
                        <div class="copy animated fadeIn">
                        @if(Session::has('cabinetSession'))
                        @foreach (Session::get('cabinetSession') as $cabinet)
                        <span>{{$cabinet->nomCourt}}</span>
                        <b class="" style="color:#11b672">{{$cabinet->slogan}}<br></b>
                        @endforeach
                        @endif
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6 login-ch-sideBar animated fadeInRightBig">

                <div class="login-container animated ">

                    <h2 class="text-center text-upper"> Création du premier adminstrateur </h2>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :statut="session('statut')" />

                    <!-- Validation Errors -->

                    <x-auth-validation-errors :errors="$errors" />
                    <form method="POST" action="{{ route('register') }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <!-- Name -->
                        <div class="form-group">
                            <input name="statut" value="actif" hidden />
                            <x-input id="name" class="form-control" type="text" name="name" placeholder="Nom complet" required autofocus />

                            <i class="fa fa-user-o"></i>
                        </div>
                        <div class="form-group">
                            <x-input id="initial" class="form-control" type="text" name="initial" placeholder="Initial -Ex: ASK" required autofocus />

                            <i class="fa fa-user-o"></i>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <x-input id="email" class="form-control" type="email" name="email" placeholder="e-mail" required />
                            <i class="fa fa-envelope-o"></i>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="mot de passe" />
                            <i class="fa fa-lock"></i>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Confirme le mot de passe" required />
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">Photo (Facultative)</label>
                            <x-input type="file" class="fichiers form-control" name="photo" accept="image/*" />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">

                            <div class="flex-box align-items-center">
                                <x-button class="btn  theme-bg" style="width:50%;">
                                    {{ __('Enregistrer') }}
                                </x-button>
                                <a data-toggle="tooltip" class="theme-cl" data-original-title="Déja un compte" href="{{ route('login') }}">
                                    {{ __('Déja un compte ? connexion') }}
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- .login-container -->
            </div> <!-- .login-ch-sideBar -->
        </div> <!-- .row -->
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}">
    </script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/plugins/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Slick Slider Js -->
    <script src="{{ asset('assets/plugins/slick-slider/slick.js') }}"></script>

    <!-- Slim Scroll -->
    <script src="{{ asset('assets/plugins/slim-scroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/dist/js/adminfier.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jQuery.style.switcher.js') }}"></script>
    <script>
        $('.dropdown-toggle').dropdown()
    </script>
    <script>
        // Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");
   
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function (e) {
           
            var fichiersInput = this.querySelectorAll(".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name + " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});
    </script>

</body>

</html>