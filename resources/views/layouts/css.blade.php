<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        @if(Session::has('cabinetSession'))
        @foreach (Session::get('cabinetSession') as $cabinet)
        {{$cabinet->nomCourt}}
        @endforeach
        @else
        Le cabinet
        @endif
    </title>



    <style>
    
    HTML CSSResult Skip Results Iframe
EDIT ON




/*ruban avec image*/
#headline{
  position: relative;
  margin:auto;
  background:#555;
  width: 260px; /* 300 - 40 padding */
  min-height: 275px;
  margin-top: -37px;
  padding: 70px 20px 20px 20px;;
}

#headline #corner{
  display: block;
  position: absolute;
  top:0;
  left: -4.5%;
  width: 14px;
  height: 18px; 
  background: url(http://luiszuno.com/themes/zeni/img/sidebar-corner.png) no-repeat;
}

.first{width:auto;margin-top:50px;height:19px}

/*Etiquette avec pseudo élement*/
#bloc {
  position: relative;
  width: 30%;
  padding: 1em 1.5em;
  margin: 2em auto;
  color: #fff;
  background: #97C02F;
}
#bloc:before {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  border-width: 0 20px 20px 0;
  border-style: solid;
  border-color: #658E15 #fff;
}

/*Ruban avec pseudo element by Naoya*/
.box{

  margin:  0 auto;
  background-color: #ccc;
  position: relative;
}

.ruban {
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: absolute;
}
.ruban::before,
.ruban::after {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 5px solid #000;
}

.ruban span {
  position: absolute;
  display: block;
  width: 225px;
  padding: 15px 0;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
  color: #fff;
  text-align: center;
}

.rubanEncour span {
    background-color: #f7bb4a;
}

.rubanJonction span {
    background-color: #1f87ff;
}

.rubanTerminer span {
    background-color: #658E15;
}

.rubanEnvoyer span {
    background-color: #658E15;
}

.rubanNonEnvoyer span {
    background-color: #f7bb4a;
}

.left {
  top: -10px;
  left: -10px;
}

.left::before {
  top: 0;
  right: 0;
}
.left::after {
  bottom: 0;
  left: 0;
}
.left span {
  right: -25px;
  top: 30px;
  transform: rotate(-45deg);
}

.flou {
  filter: blur(5px); /* Ajustez la valeur de flou selon vos besoins */
  }

/*Autre Ruban avec pseudo element */
.ruban2 {
    width: 500px;
    margin: 10px auto;
    padding: 0 10px 0;
    position: relative;
    color: #444;
    background: #fff;
    border: 1px solid #d2d2d2;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.ruban2 h3 {
    display: block;
    height: 30px;
    line-height: 1.5;
    width: 512px;
    margin: 0;
    padding: 5px 10px;
    position: relative;
    left: -16px;
    top: 8px;
    color: #cfcfcf;
    background: #333;
    background: linear-gradient(top, #383838 0%, #262626 100%);
    border-radius: 2px 2px 0 0;
    box-shadow: 0 1px 2px rgba(0,0,0,0.3);
}
.ruban2 h3::before,
.ruban2 h3::after {
    content: '';
    display: block;
    width: 0;
    height: 0;
    position: absolute;
    bottom: -10px;
    z-index: -1;
    border: 5px solid;
    border-color: #242424 transparent transparent transparent;    
}
.ruban2 h3::before {left: 0;}
.ruban2 h3::after {right: 0;}

/*Menu avec Ruban*/

.access{max-width:500px;margin:auto}
.triangle-l {
  border-color: transparent #793e3e transparent transparent;
  border-style:solid;
  border-width:9px;
  height:0px;
  width:0px;
  position: relative;
  left: -18px;
  top: -9px;
  z-index: -1; 
}

.triangle-r {
  border-color: transparent transparent transparent #793e3e;
  border-style:solid;
  border-width:9px;
  height:0px;
  width:0px;
  position: relative;
  left: 500px;
  top: -26px;
  z-index: -1; 
}

#access .menu ul {
  margin: 0;
  list-style-type: none;
  letter-spacing: normal;
  position: relative;
  text-align: center;
  z-index: 1001;
  height: 42px;
  margin: 0 -9px;
  background: #b05a5a;
}
#access .menu ul li {
  position: relative;
  display: inline-block;
  padding: 0 15px;
  z-index: 101;
  padding-top: 8px;
  background: none;
  height: 34px;
}
#access .menu ul li a {
  display: inline-block;
  text-decoration: none;
  font-size: 14px;
  line-height: 1;
  color: #f3f3f3;
}
#access .menu ul li a:hover, 
#access .menu ul li.active a, 
#access .menu ul li a.selected {
  color: #3c3c3c;
}
/*Bloc avec etiquette*/
.content{
  width:500px; 
  height:500px;
  background-color:#eee; 
  margin: 0 auto;
  position:relative;
  overflow:hidden;
}
.corner{
  position:absolute;
  width:200px;
  height:200px;
  background-color:#999;
  -webkit-transform:rotate(45deg);
 transform:rotate(45deg);
  top:-100px;
  right:-100px
}



    select.form-control {
        display: inline;
        width: 200px;
        margin-left: 25px;
        margin-bottom: 15px;
    }

    .large-text-big {
        font-size: 25pt;
        /* Ajustez la taille de police selon vos besoins */
    }

    .large-text {
        font-size: 18pt;
        /* Ajustez la taille de police selon vos besoins */
    }

    .large-text-mini {
        font-size: 11pt;
        /* Ajustez la taille de police selon vos besoins */
     }

    .large-image-big {
        max-width : 240px;
        /* Ajustez la largeur de l'image selon vos besoins */
        height: auto;
    }

    .large-image {
        max-width : 170px;
        /* Ajustez la largeur de l'image selon vos besoins */
        height: auto;
    }

    .large-image-mini {
        max-width : 100px;
        /* Ajustez la largeur de l'image selon vos besoins */
        height: auto;
    }
    
    .borderFacture{
        border:1px solid
    }

    .factureImage{
        width : 100%; max-width : 100px;
        height : auto;
        background-color:white;
        border-radius:5%;
    }
    </style>

    <style>
    * {
        font-family: sans-serif;
    }


    .pager div {
        float: left;
        border: 1px solid #085B8F;
        margin: 5px;
        padding: 10px;
        background-color: white;
    }

    .pager div.disabled {
        opacity: 0.25;
    }

    .pager .pageNumbers a {
        display: inline-block;
        padding: 0 10px;
        color: gray;
        font-weight: bold;
    }

    .pager .pageNumbers a.active {
        color: #085B8F;
    }

    .pager {
        overflow: hidden;
    }

    .paginate-no-scroll .items div {
        height: 250px;
    }
    </style>

    <!-- CSS input file -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/cssFile/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/cssFile/demo.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/cssFile/component.css') }}" />



    <!-- CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- CSS de Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('assets/build/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/build/css/intlTelInput.css') }}">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assets/plugins/themify/css/themify.css') }}" rel="stylesheet" type="text/css">

    <!-- Angular Tooltip Css -->
    <link href="{{ asset('assets/plugins/angular-tooltip/angular-tooltips.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->

    <!-- Page level plugin CSS -->
    <link href="{{ asset('assets/dist/css/animate.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/slick-slider/slick.css') }}" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/dist/css/adminfier.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/dist/css/adminfier-responsive.css') }}" rel="stylesheet">

    <!-- Custom styles for Color -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/default.css') }}">

    <!-- Page dataTables -->
    <link rel="stylesheet" href="{{ asset('assets/DataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/DataTables/css/buttons.dataTables.min.css') }}">

    <!-- Page level plugin CSS -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Page level plugin CSS -->
    <link href="{{ asset('assets/dist/css/animate.css') }}" rel="stylesheet">


    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}">

    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.css') }}">

    @if(Session::has('cabinetLogo'))
    @foreach (Session::get('cabinetLogo') as $logo)
    <link rel="shortcut icon" href="{{URL::to('/')}}/{{$logo->logo}}" />
    @endforeach
    @endif
    <!-- Custom styles for Color -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        /* Style pour le div à télécharger */
        #factureDiv {
            width: 210mm; /* A4 Width */
            height: auto; /* A4 Height */
            padding: 20px;
            font-family: Arial, sans-serif;
            background: white;
            font-size:8px;
        }
    </style>

<style>
  .infoPrive {
        transition: filter .3s;
        filter: blur(5px); /* masque visuel initial */
    }
    .infoPrive.revealed {
        filter: none;
    }

</style>
</head>