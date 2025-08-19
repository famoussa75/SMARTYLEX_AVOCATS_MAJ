<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    @if(Session::has('cabinetSession'))
      @foreach (Session::get('cabinetSession') as $cabinet)
        {{ $cabinet->nomCourt }}
      @endforeach
    @else
      Le cabinet
    @endif
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  @if(Session::has('cabinetLogo'))
    @foreach (Session::get('cabinetLogo') as $logo)
      <link rel="shortcut icon" href="{{ URL::to('/') }}/{{ $logo->logo }}" />
    @endforeach
  @endif
  <style>
    body {
      background: url('{{ asset('assets/dist/img/bg.png') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }
    .reset-container {
      height: 100vh;
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .reset-card {
      background: rgba(0, 0, 0, 0.7);
      border-radius: 1rem;
      padding: 40px;
      max-width: 500px;
      width: 100%;
      color: white;
      box-shadow: 0 0 30px rgba(0,0,0,0.4);
    }
    .reset-card input {
      background: #f9f9f9;
      border: none;
    }
    .reset-card input:focus {
      box-shadow: none;
      border: 1px solid #ffc107;
    }
    .btn-primary, .btn-warning, .btn-block {
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
      object-fit: cover;
      border-radius: 10px;
      width: 100%;
      border: 1px solid #ddd;
    }

    @media (max-width: 768px) {
      .pub-img {
        height: 80px;
      }
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <div class="reset-card text-center">
      <h2 class="mb-3"><i class="bi bi-key"></i> Réinitialisation du mot de passe</h2>
      <p class="text-light mb-4"><i class="bi bi-info-circle"></i> Renseignez votre adresse email, puis cliquez sur <strong>« Générer le lien de réinitialisation »</strong>. Vous recevrez un lien par e-mail pour réinitialiser votre compte.</p>

      <x-auth-session-status class="mb-3 text-danger" :statut="session('statut')" />
      <x-auth-validation-errors :errors="$errors" />

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3 text-start">
          <label for="email" class="form-label">Adresse email</label>
          <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="d-grid gap-2 mb-2">
          <x-button class="btn btn-warning">Générer le lien de réinitialisation</x-button>
        </div>

        <div class="d-grid">
          <a href="{{ route('login') }}" class="btn btn-outline-light">Se connecter</a>
        </div>
      </form>
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
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub1.jpg') }}" class="pub-img" alt="Pub 1"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://judicalex-gn.org/" target="_blank"><img src="{{ asset('assets/dist/img/pub2.jpg') }}" class="pub-img" alt="Pub 2"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub3.jpg') }}" class="pub-img" alt="Pub 3"></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="container">
            <div class="row text-center">
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub4.jpg') }}" class="pub-img" alt="Pub 4"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://judicalex-gn.org/" target="_blank"><img src="{{ asset('assets/dist/img/pub5.jpg') }}" class="pub-img" alt="Pub 5"></a>
              </div>
              <div class="col-md-4 col-4">
                <a href="https://smartylex.com/" target="_blank"><img src="{{ asset('assets/dist/img/pub6.jpg') }}" class="pub-img" alt="Pub 6"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>