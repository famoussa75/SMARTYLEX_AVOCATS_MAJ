<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from drizvato.com/demo/adminfier-template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Sep 2019 13:25:13 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> @if(Session::has('cabinetSession'))
    @foreach (Session::get('cabinetSession') as $cabinet)
    {{$cabinet->nomCourt}}
    @endforeach
    @else
    Le cabinet
    @endif
  </title>

    <!-- Bootstrap core CSS -->
    <link href="{{URL::to('/')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{URL::to('/')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css">

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

    <!-- <link id="jssDefault" rel="stylesheet" href="{{URL::to('/')}}/assets/dist/css/skins/default.css"> -->
</head>

<body class="red-skin">

    <div class="container-fluid">
        <div class="row">
            <div class="hidden-xs hidden-sm col-lg-6 col-md-6 theme-bg">
                <div class="clearfix">
                    <div class="logo-title-container text-center" style="margin-top: -120px;">
                        <h3 class="cl-white text-upper">ASK AVOCATS</h3>
                           <img class="img-responsive" src="{{URL::to('/')}}/assets/dist/img/logo.png"
                            alt="Logo Icon" style="height: 300px;">
                           
                            <div class="copy animated fadeIn">
                                <p class="cl-white">Best dashboard with multi features for Lawyers !<br></p>
                            </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6 login-ch-sideBar animated fadeInRightBig">

                <div class="login-container animated fadeInRightBig">

                    <h2 class="text-center text-upper">Création du premier compte Administrateur</h2>
                    <form class="form-horizontal">

                        <div class="form-group">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Full Name">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email or Username">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="form-group help">
                            <input type="password" class="form-control" placeholder="Password">
                            <i class="fa fa-lock"></i>
                            <a href="#" class="pass-view fa fa-eye"></a>
                        </div>

                        <div class="form-group help">
                            <input type="password" class="form-control" placeholder="Confirm Password">
                            <i class="fa fa-lock"></i>
                        </div>

                        <div class="form-group">
                            <div class="flex-box align-items-center">
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                    <label for="checkbox1">Remember me</label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="flex-box align-items-center">
                                <button type="submit" class="btn theme-bg">log in</button>
                                <p>Already Have An Account <a href="login.html" data-toggle="tooltip" class="theme-cl"
                                        data-original-title="Login">Log In Here.</a></p>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- .login-container -->

            </div> <!-- .login-ch-sideBar -->
        </div> <!-- .row -->
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::to('/')}}/assets/plugins/jquery/jquery.min.js"></script>
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