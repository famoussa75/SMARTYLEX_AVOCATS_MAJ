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
    <link href="{{URL::to('/')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{URL::to('/')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template -->
    <link href="{{URL::to('/')}}/assets/plugins/themify/css/themify.css" rel="stylesheet" type="text/css">

    <!-- Angular Tooltip Css -->
    <link href="{{URL::to('/')}}/assets/plugins/angular-tooltip/angular-tooltips.css" rel="stylesheet">

    <!-- Page level plugin CSS -->
    <link href="{{URL::to('/')}}/assets/dist/css/animate.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{URL::to('/')}}/assets/dist/css/adminfier.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/assets/dist/css/adminfier-responsive.css" rel="stylesheet">

    <!-- Custom styles for Color -->

    <!-- <link id="jssDefault" rel="stylesheet" href="{{URL::to('/')}}/assets/dist/css/skins/default.css') }}"> -->
</head>

<body class="red-skin">

    <div class="container-fluid">
        <div class="row">
            <div class="hidden-xs hidden-sm col-lg-6 col-md-6 theme-bg">
                <div class="clearfix">
                    <div class="logo-title-container text-center" style="margin-top: -120px;">
                        <h3 class="cl-white text-upper">ASK AVOCATS</h3>
                        <img class="img-responsive" src="{{URL::to('/')}}/assets/dist/img/logo.png') }}" alt="Logo Icon" style="height: 300px;">

                        <div class="copy animated fadeIn">
                            <p class="cl-white">Best dashboard with multi features for Lawyers !<br></p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6 login-ch-sideBar animated fadeInRightBig">

                <div class="login-container animated fadeInRightBig">

                    <h2 class="text-center text-upper" id="headLogin">Création du premier compte Administrateur de
                        l'application</h2>
                    <div class="" id="loginForm">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            <div class="form-group">
                                <input name="email" value=" {{old('email')}} " type="email" class="form-control" id="inputEmail3" placeholder="Email" required autofocus>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group help">
                                <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <a href="#" class="pass-view fa fa-eye"></a>
                            </div>

                            <div class="form-group">
                                <div class="flex-box align-items-center">
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="remember_me" name="remember" value="1">
                                        <label for="remember_me">Remember me</label>
                                    </span>
                                    <!--
                                        
                                        <a href="#" data-toggle="tooltip" class="theme-cl" data-original-title="Forgot Password">Forgot Password?</a>
                                    
                                    -->
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="flex-box align-items-center">
                                    <input type="submit" class="btn theme-bg" value="Connexion">
                                    <p>Pas de compte Administrateur ? <a class="load" href="{{ route('register') }}" data-toggle="tooltip" class="theme-cl" data-original-title="Créer un compte admininstrateur">Créer</a>.</a></p>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="" id="registerForm">
                        <form class="form-horizontal" method="post" action="{{route('register')}}">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Nom complet" required autofocus>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group help">
                                <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <a href="#" class="pass-view fa fa-eye"></a>
                            </div>
                            <div class="form-group help">
                                <input type="password" class="form-control" placeholder="Confirmation du mot de passe">
                                <i class="fa fa-lock"></i>
                            </div>
                            <div class="form-group">
                                <div class="flex-box align-items-center">
                                    <button type="submit" class="btn theme-bg">Enregistrer</button>
                                    <p>Déja inscrit ? <a class="load" href="{{route('login')}}" data-toggle="tooltip" class="theme-cl" data-original-title="Login">Connexion.</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- .login-container -->

            </div> <!-- .login-ch-sideBar -->
        </div> <!-- .row -->
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::to('/')}}/assets/plugins/jquery/jquery.min.js">
    </script>
    <script src="{{URL::to('/')}}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL::to('/')}}/assets/plugins/jquery-easing/jquery.easing.min.js"></script>

    <!-- Slick Slider Js -->
    <script src="{{URL::to('/')}}/assets/plugins/slick-slider/slick.js"></script>

    <!-- Slim Scroll -->
    <script src="{{URL::to('/')}}/assets/plugins/slim-scroll/jquery.slimscroll.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{URL::to('/')}}/assets/dist/js/adminfier.js"></script>
    <script src="{{URL::to('/')}}/assets/dist/js/jQuery.style.switcher.js"></script>


    <script>
        $('.dropdown-toggle').dropdown()
    </script>

</body>

</html>