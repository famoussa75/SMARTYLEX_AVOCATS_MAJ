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
    @if(Session::has('cabinetLogo'))
    @foreach (Session::get('cabinetLogo') as $logo)
    <link rel="shortcut icon" href="{{URL::to('/')}}/{{$logo->logo}}" />
    @endforeach
    @endif
    <!-- Custom styles for Color -->

    <!-- <link id="jssDefault" rel="stylesheet" href="{{ asset('assets/dist/css/skins/default.css') }}') }}"> -->
</head>

<body class="red-skin" style="background-image:url('assets/dist/img/bg.png');background-size:cover;">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-50">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-center">

                    <div class="card  text-white animated fadeIn" style="border-radius: 1rem; background:rgba(12,13,12,0.7);">
                        <div class="card-body p-2 text-center">


                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-white"> <i class="fa fa-lock"></i> Mettre à jour le mot de passe</h2>

                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4" :statut="session('statut')" />

                                <!-- Validation Errors -->
                                <x-auth-validation-errors :errors="$errors" />

                                <form method="POST" action="{{ route('password.update2') }}">
                                    @csrf

                                    <!-- Password Reset Token -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <!-- Email Address -->
                                    <div>
                                        <div class="form-group">
                                            <x-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="Email" />
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mt-4">
                                        <div class="form-group">
                                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required />
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mt-4">
                                        <div class="form-group">
                                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                                                type="password"
                                                                name="password_confirmation" placeholder="Confirmer le mot de passe" class="form-control" required />
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="btn btn-rounded btn-block  theme-bg">
                                            {{ __('Reinitialiser le mot de passe') }}
                                        </x-button>
                                    </div>
                                </form>
                               
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
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

        // function checkUser() {
        //     // Les variables globales du programme
        //     const date = new Date().toLocaleString();

        //     const date1 = new Date().toLocaleTimeString();

        //     const date2 = new Date('07/10/2022 22:41:41').toLocaleTimeString()

        //     console.log(` data ${date1} > ${date2}`);
        //     var userMail = $('#email').val();


        //     $.ajax({
        //         type: "GET",
        //         url: `/check-user/${userMail}`,
        //         dataType: "json",
        //         success: function(response) {
        //             $.each(response.users, function(key, value) {

        //                 //alert(`Password ${value.password}`)
        //                 if (value.lastConnexion == null) {
        //                     sessionStorage.setItem('derniereConnexion', date);
        //                     updateConnexion(date);

        //                 } else {
        //                     sessionStorage.setItem('derniereConnexion', lastConnexion);
        //                     // Comparaison des dates pour la deconnexion de l'utilisateur
        //                 }
        //             });
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             console.log('Erreur de connexion')
        //             //console.log(`JQHR ${jqXHR} \n statut: ${textStatus}\n error: ${errorThrown}`);
        //         }
        //     });
        // }
    </script>
</body>

</html>


