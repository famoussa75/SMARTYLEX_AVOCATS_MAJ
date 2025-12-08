<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>{{ $cabinet[0]->nomCabinet ?? 'Votre cabinet' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/build/css/demo.css') }}">
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">

  <!-- Font Awesome (pour l’icône) -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


  <link rel="shortcut icon" href="{{ URL::to('/') }}/{{ $cabinet[0]->logo ?? '' }}" />

  <style>
    body {
      background: url('{{ asset('assets/dist/img/bg.png') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      height: 100vh;
      min-height: 500px;
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px 180px 15px;
    }


    .login-card {
      background: rgba(0, 0, 0, 0.7);
      border-radius: 1rem;
      padding: 40px;
      max-width: 450px;
      width: 100%;
      color: white;
      box-shadow: 0 0 30px rgba(0,0,0,0.4);
    }

    .login-card input {
      background: #f9f9f9;
      border: none;
    }

    .login-card input:focus {
      box-shadow: none;
      border: 1px solid #ffc107;
    }

    .logo {
      max-height: 80px;
      background: white;
      border-radius: 12px;
      padding: 6px;
    }

    .btn-warning {
      font-weight: bold;
    }

    /* 🟡 Carousel pub en bas */
    .pub-carousel-container {
      position: absolute;
      bottom: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.6);
      padding: 10px 0;
      z-index: 5;
      box-shadow: 0 -2px 12px rgba(0,0,0,0.2);
    }

    .pub-img {
      height: 100px;
      width: 100%;
      object-fit: contain;              /* Affiche l'image entière sans la couper */
      border-radius: 16px;
      display: flex;
      justify-content: center;
      align-items: center;
    }


    @media (max-width: 768px) {
      .pub-img {
        height: 70px;
        object-fit: contain;  /* même ici */
      }
    }



  </style>

</head>
<body>


  <!-- 🧾 FORMULAIRE DE CONNEXION -->
  <div class="login-container">
    <div class="login-card text-center">
    <div id="alertAbonnement"></div>

      <img src="{{ URL::to('/') }}/{{ $cabinet[0]->logo ?? '' }}" class="logo mb-3" alt="Logo">
      <h2 class="mb-2">Bienvenue</h2>
      <p class="text-light mb-4">Veuillez vous connecter à votre espace</p>

      @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
      @endif

      <x-auth-session-status class="mb-3 text-danger" :statut="session('statut')" />
      <x-auth-validation-errors :errors="$errors" />

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <x-input id="email" class="form-control mb-3" type="email" name="email" :value="old('email')" required placeholder="Adresse email" />
        <x-input id="password" class="form-control mb-3" type="password" name="password" required placeholder="Mot de passe" />

        <div class="form-check text-start mb-3">
          <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
          <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
        </div>

        <x-button class="btn btn-outline-warning w-100 mb-3">Se connecter</x-button>
      </form>

      <div class="text-light mb-2">
        <a href="{{ route('password.request') }}" class="text-decoration-none text-warning">
          <i class="bi bi-unlock"></i> Mot de passe oublié ?
        </a>
      </div>

      @if($user <= 0)
        <div class="text-light">
          Pas de compte administrateur ?<br>
          <a href="{{ route('register') }}" class="text-warning text-decoration-none">Créer un compte</a>
        </div>
      @endif

      <hr class="text-secondary mt-4">
      <div>
        <a href="https://smartylex.com/contact" class="text-white text-decoration-none" target="_blank">
          <strong> >> Souscrivez pour une nouvelle plateforme << </strong>
        </a>
      </div>
    </div>
  </div>

  <!-- 📢 CAROUSEL AVEC 3 IMAGES PAR SLIDE -->
  <div class="pub-carousel-container">
    <div id="pubCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="container">
            <div class="row text-center">
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub1.jpg') }}" class="pub-img img-fluid" alt="Pub 1"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://judicalex-gn.org/" target="_blank"><img src="{{ asset('assets/dist/img/pub2.jpg') }}" class="pub-img img-fluid" alt="Pub 2"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub3.jpg') }}" class="pub-img img-fluid" alt="Pub 3"></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="container">
            <div class="row text-center">
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub4.jpg') }}" class="pub-img img-fluid" alt="Pub 4"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://judicalex-gn.org/" target="_blank"><img src="{{ asset('assets/dist/img/pub5.jpg') }}" class="pub-img img-fluid" alt="Pub 5"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub6.jpg') }}" class="pub-img img-fluid" alt="Pub 6"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL ABONNEMENT EXPIRE -->
  <div class="modal fade" id="modalAbonnementExpire"
      data-backdrop="static" data-keyboard="false"
      tabindex="-1" role="dialog" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg">

              <div class="modal-body text-center p-5">

                  <div class="mb-4">
                      <i class="fa fa-times-circle fa-4x text-danger"></i>
                  </div>

                  <h4 class="font-weight-bold mb-3 text-danger">
                      Abonnement expiré
                  </h4>

                  <p class="text-muted mb-4">
                      Votre abonnement est arrivé à expiration.<br>
                      Veuillez le renouveler pour continuer à utiliser la plateforme.
                  </p>

                  <div class="mt-4 text-left">
                    <p class="font-weight-bold mb-2">
                        📞 Contactez notre service commercial :
                    </p>

                    <p class="mb-1">
                        <i class="fa fa-phone text-danger mr-2"></i>
                        <a href="tel:+224613870892" class="text-dark font-weight-bold">
                            +224 613 87 08 92
                        </a>
                    </p>

                    <p class="mb-0">
                        <i class="fa fa-phone text-danger mr-2"></i>
                        <a href="tel:+224612735577" class="text-dark font-weight-bold">
                            +224 612 73 55 77
                        </a>
                    </p>
                </div>


              </div>
          </div>
      </div>
  </div>


  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper.js (obligatoire pour Bootstrap 4) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.min.js"></script>

  <script>
    let dateOuverturePlateforme = "{{ $cabinet[0]->created_at ?? '' }}";
    let planAbonnement = "{{ $cabinet[0]->plan ?? '' }}";

    const planDurations = {
        gratuit: 2,
        decouverte: 6,
        classique: 12,
        avance: 18,
        premium: 24
    };

    if (dateOuverturePlateforme && planDurations[planAbonnement]) {

        const today = new Date();
        const startDate = new Date(dateOuverturePlateforme);

        const expirationDate = new Date(startDate);
        expirationDate.setMonth(expirationDate.getMonth() + planDurations[planAbonnement]);

        const diffDays = Math.ceil((expirationDate - today) / (1000 * 60 * 60 * 24));

        const alertDiv = document.getElementById('alertAbonnement');


        if (diffDays <= 0) {
          $('#modalAbonnementExpire').modal('show');
        }
        else if (diffDays <= 30) {
            alertDiv.innerHTML = `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-exclamation-triangle mr-2"></i> Abonnement bientôt expiré !</strong>
                    Il vous reste <strong>${diffDays} jour(s)</strong> avant l’expiration de votre abonnement.
                </div>
            `;
        }
    }
  </script>
</body>
</html>
