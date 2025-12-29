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
                /* --- En-tête de page moderne --- */
                .page-header-custom {
                    border: 1px solid #e5e7eb;
                    transition: all 0.3s ease;
                }

                .page-header-custom:hover {
                    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
                }

                /* --- Icône principale --- */
                .icon-wrapper {
                    width: 50px;
                    height: 50px;
                    border-radius: 12px;
                    background: linear-gradient(135deg, #2b6cb0, #805ad5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                    font-size: 22px;
                    margin-right: 15px;
                    box-shadow: 0 4px 12px rgba(128, 90, 213, 0.3);
                }

                /* --- Titres et sous-titres --- */
                .page-title {
                    font-weight: 700;
                    color: #111827;
                    text-transform: uppercase;
                    letter-spacing: .5px;
                    margin-bottom: 2px;
                }

                .page-subtitle {
                    color: #6b7280;
                    font-size: 15px;
                    font-weight: 400;
                }

                .page-description {
                    color: #9ca3af;
                    font-size: 13px;
                }

                /* --- Boutons personnalisés --- */
                .btn-gradient-custom {
                    background: linear-gradient(90deg, #2b6cb0, #805ad5);
                    border: none;
                    color: #fff !important;
                    border-radius: 10px;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    padding: 8px 16px;
                }

                .btn-gradient-custom:hover {
                    transform: translateY(-2px);
                    opacity: 0.9;
                    box-shadow: 0 4px 10px rgba(128, 90, 213, 0.4);
                }

                .btn-outline-primary-custom {
                    border: 1px solid #2b6cb0;
                    color: #2b6cb0 !important;
                    border-radius: 10px;
                    transition: all 0.3s ease;
                    padding: 8px 12px;
                }

                .btn-outline-primary-custom:hover {
                    background: #2b6cb0;
                    color: #fff !important;
                    box-shadow: 0 4px 10px rgba(43, 108, 176, 0.3);
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

      <style>


          /* Table */
          table.filterTable, table.filterTable2, table.filterTable3, table.filterTable4, table.filterTable5, table.filterTable6, table.filterTable7 {
              width: 100%;
              border-collapse: separate;
              border-spacing: 0;
              font-size: 0.95rem;
          }

        

          /* En-tête */
          table.filterTable thead tr, table.filterTable2 thead tr, table.filterTable3 thead tr, table.filterTable4 thead tr, table.filterTable5 thead tr, table.filterTable6 thead tr, table.filterTable7 thead tr {
              background-color: #009CAA; /* couleur unique */
              color: white;
              text-align: left;
              font-weight: 600;
          }


          /* Ligne de tableau */
          table.filterTable tbody tr, table.filterTable2 tbody tr, table.filterTable3 tbody tr, table.filterTable4 tbody tr, table.filterTable5 tbody tr, table.filterTable6 tbody tr, table.filterTable7 tbody tr {
              transition: all 0.3s ease;
              cursor: pointer;
          }


          table.filterTable tbody tr:hover, table.filterTable2 tbody tr:hover, table.filterTable3 tbody tr:hover, table.filterTable4 tbody tr:hover, table.filterTable5 tbody tr:hover, table.filterTable6 tbody tr:hover, table.filterTable7 tbody tr:hover {
              background-color: rgba(0, 156, 170, 0.1);
          }

          /* Cellules */
          table.filterTable td, table.filterTable2 td, table.filterTable3 td, table.filterTable4 td, table.filterTable5 td, table.filterTable6 td , table.filterTable7 td{
              padding: 12px 10px;
              vertical-align: middle;
          }


          /* Liens */
          .filterTable a.load,  .filterTable2 a.load,  .filterTable3 a.load,  .filterTable4 a.load,  .filterTable5 a.load,  .filterTable6 a.load , .filterTable7 a.load{
              color: #009CAA;
              text-decoration: none;
              transition: color 0.3s;
          }



          .filterTable a.load:hover,  .filterTable2 a.load:hover,  .filterTable3 a.load:hover,  .filterTable4 a.load:hover,  .filterTable5 a.load:hover,  .filterTable6 a.load:hover, .filterTable7 a.load:hover {
              color: #D7AE00;
              text-decoration: underline;
          }


          /* Action icon */
          .filterTable td i.fa-info-circle,  .filterTable2 td i.fa-info-circle,  .filterTable3 td i.fa-info-circle,  .filterTable4 td i.fa-info-circle,  .filterTable5 td i.fa-info-circle,  .filterTable6 td i.fa-info-circle, .filterTable7 td i.fa-info-circle {
              color: #D7AE00;
              font-size: 1.2rem;
              transition: color 0.3s;
          }


          .filterTable td i.fa-info-circle:hover,  .filterTable2 td i.fa-info-circle:hover,  .filterTable3 td i.fa-info-circle:hover,  .filterTable4 td i.fa-info-circle:hover,  .filterTable5 td i.fa-info-circle:hover,  .filterTable6 td i.fa-info-circle:hover, .filterTable7 td i.fa-info-circle:hover {
              color: #009CAA;
          }

          /* Filtre catégorie */
          .category-filter {
              margin-bottom: 15px;
              max-width: 200px;
          }

          .categoryFilter {
              border-radius: 8px;
              border: 1px solid #ccc;
              padding: 6px 12px;
          }

          /* Scrollbar si nécessaire */
          .table-responsive::-webkit-scrollbar {
              height: 6px;
              width: 6px;
          }

          .table-responsive::-webkit-scrollbar-thumb {
              background: #D7AE00;
              border-radius: 3px;
          }

          .table-responsive::-webkit-scrollbar-track {
              background: rgba(0,0,0,0.05);
          }
      </style>

      <style>
        /* ===============================
        FORMULAIRES — STYLE GLOBAL PRO
        =============================== */

      .form-control {
          border-radius: 12px;
          border: 1px solid #e5e7eb;
          font-size: 14px;
          color: #374151;
          transition: border-color 0.2s ease, box-shadow 0.2s ease;
      }

      /* Focus élégant & cohérent */
      .form-control:focus {
          border-color: #009CAA;
          box-shadow: 0 0 0 3px rgba(0, 156, 170, 0.15);
          outline: none;
      }

      label.required,
      .control-label.required {
          display: inline-block; /* ou block si tu veux */
      }

      label.required::after,
      .control-label.required::after {
          content: " *";
          color: #e11d48;
          font-weight: 700;
      }



      /* Placeholder */
      .form-control::placeholder {
          color: #9ca3af;
          font-size: 13px;
      }

      /* Désactivé / readonly */
      .form-control:disabled,
      .form-control[readonly] {
          background-color: #f9fafb;
          opacity: 1;
          cursor: not-allowed;
      }

      /* Select & textarea */
      select.form-control,
      textarea.form-control {
          border-radius: 12px;
      }

      /* ===============================
        EXCEPTIONS SPÉCIFIQUES
        =============================== */

      /* Champs avec icône (mot de passe) */
      .password-wrapper .form-control {
          padding-right: 48px; /* espace pour icône */
      }

      /* Taille large optionnelle */
      .form-control-lg {
          padding: 14px 18px;
          font-size: 15px;
      }

      .control-label,
      label {
          font-weight: 500;
          color: #1f2937;
          margin-bottom: 6px;
      }

      /* ===============================
        SELECT2 STYLE HARMONISÉ
        =============================== */

      /* Container Select2 */
      .select2-container .select2-selection--single {
          height: 44px; /* même hauteur que form-control */
          padding: 6px 12px; /* ajustement interne */
          border-radius: 12px;
          border: 1px solid #e5e7eb;
          background-color: #ffffff;
          transition: border-color 0.2s ease, box-shadow 0.2s ease;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 32px; /* centrer le texte verticalement */
          color: #374151;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 36px;
          right: 10px;
          width: 36px;
          top: 50%;
          transform: translateY(-50%);
      }

      .select2-container--default.select2-container--focus .select2-selection--single {
          border-color: #009CAA;
          box-shadow: 0 0 0 3px rgba(0, 156, 170, 0.15);
      }

      /* Disabled Select2 */
      .select2-container--default.select2-container--disabled .select2-selection--single {
          background-color: #f9fafb;
          cursor: not-allowed;
      }

      /* Multi-select */
      .select2-container--default .select2-selection--multiple {
          border-radius: 12px;
          border: 1px solid #e5e7eb;
          min-height: 44px;
          padding: 4px 12px;
          background-color: #ffffff;
      }

      .select2-container--default .select2-selection--multiple .select2-selection__choice {
          background-color: #009CAA;
          color: #ffffff;
          border-radius: 999px;
          padding: 0 8px;
          margin-top: 4px;
      }

      </style>
      <style>
          /* =============================
        VARIABLES GLOBALES BOUTONS
        ============================= */
      :root{
        --btn-bg-1: #009CAA;              /* Couleur principale */
        --btn-bg-2: #007f85;              /* Gradient secondaire */
        --btn-text: #ffffff;
        --btn-radius: 12px;
        --btn-padding: 0.65rem 1.15rem;
        --btn-font-size: 1rem;
        --btn-shadow: 0 6px 18px rgba(3, 12, 30, 0.18);
        --btn-focus-ring: 3px;
        --btn-disabled-opacity: 0.55;
      }

      /* =============================
        BOUTONS SUBMIT (AUTO WIDTH)
        ============================= */
      input[type="submit"],
      button[type="submit"],
      button[aria-pressed],
      input[type="button"].submit-like{

        /* ✅ largeur selon le contenu */
        width: auto;
        min-width: max-content;
        max-width: 100%;

        /* Reset & layout */
        -webkit-appearance: none;
        appearance: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        white-space: nowrap;

        /* Spacing & typo */
        padding: var(--btn-padding);
        font-size: var(--btn-font-size);
        line-height: 1;
        text-align: center;

        /* Styling */
        color: var(--btn-text);
        background-image: linear-gradient(135deg, var(--btn-bg-1), var(--btn-bg-2));
        border: none;
        border-radius: var(--btn-radius);
        box-shadow: var(--btn-shadow);
        cursor: pointer;

        /* UX */
        transition:
          transform 160ms ease,
          box-shadow 160ms ease,
          filter 160ms ease;
        user-select: none;
        text-decoration: none;
        vertical-align: middle;
        -webkit-tap-highlight-color: transparent;
      }

      /* =============================
        HOVER / ACTIVE
        ============================= */
      input[type="submit"]:hover,
      button[type="submit"]:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 26px rgba(3, 12, 30, 0.20);
        filter: brightness(1.03);
      }

      input[type="submit"]:active,
      button[type="submit"]:active{
        transform: translateY(0);
        box-shadow: 0 6px 14px rgba(3, 12, 30, 0.14);
      }

      /* =============================
        FOCUS ACCESSIBLE
        ============================= */
      input[type="submit"]:focus-visible,
      button[type="submit"]:focus-visible{
        outline: none;
        box-shadow:
          0 8px 20px rgba(3,12,30,0.16),
          0 0 0 var(--btn-focus-ring) rgba(0,156,170,0.18);
      }

      /* =============================
        DISABLED
        ============================= */
      input[type="submit"][disabled],
      button[type="submit"][disabled]{
        cursor: not-allowed;
        opacity: var(--btn-disabled-opacity);
        transform: none;
        box-shadow: none;
        filter: grayscale(0.1) brightness(0.95);
      }

      /* =============================
        VARIANTS TAILLE
        ============================= */
      .btn-sm{
        padding: 0.35rem 0.7rem;
        font-size: 0.875rem;
        border-radius: 10px;
      }

      .btn-lg{
        padding: 0.9rem 1.6rem;
        font-size: 1.125rem;
        border-radius: 14px;
      }

      /* =============================
        ICONES (SVG INLINE)
        ============================= */
      .btn-icon svg{
        width: 1.1em;
        height: 1.1em;
        display: block;
        flex-shrink: 0;
      }

      /* =============================
        BOUTON FULL WIDTH (OPTIONNEL)
        ============================= */
      .btn-full{
        width: 100%;
      }

      /* =============================
        STYLE GHOST (SECONDAIRE)
        ============================= */
      .btn-ghost{
        background-image: none;
        background-color: transparent;
        color: var(--btn-bg-1);
        border: 1.5px solid rgba(0,156,170,0.18);
        box-shadow: none;
      }

      .btn-ghost:hover{
        background-color: rgba(0,156,170,0.06);
        filter: none;
      }

      /* =============================
        REDUCTION DES ANIMATIONS
        ============================= */
      @media (prefers-reduced-motion: reduce){
        input[type="submit"],
        button[type="submit"]{
          transition: none;
        }
      }


      .form-control,
      .form-select {
        border-width: 1px !important;
        border-color: gray !important;
      }

      /* bordure du champ Select2 */
    .select2-container .select2-selection--single {
      border-width: 1px !important;
      border-color: gray !important;
      border-radius: 4px; /* ou ce que tu veux */
    }

    .select2-container .select2-selection--multiple {
      border-width: 1px !important;
      border-color: gray !important;
      border-radius: 4px;
      min-height: 38px;
    }





</style>
</head>