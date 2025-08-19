<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $cabinet[0]->nomCabinet ?? 'Votre cabinet' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{URL::to('/')}}/{{$cabinet[0]->logo ?? ''}}" />
  <style>
    body {
      background: url('{{ asset('assets/dist/img/bg.png') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }
    .verification-container {
      height: 100vh;
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .verification-card {
      background: rgba(0, 0, 0, 0.7);
      border-radius: 1rem;
      padding: 40px;
      max-width: 500px;
      width: 100%;
      color: white;
      box-shadow: 0 0 30px rgba(0,0,0,0.4);
    }
    .verification-card input {
      background: #f9f9f9;
      border: none;
    }
    .verification-card input:focus {
      box-shadow: none;
      border: 1px solid #ffc107;
    }
    .logo {
      max-height: 80px;
      background: white;
      border-radius: 12px;
      padding: 6px;
    }
    .btn-primary {
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
  <div class="verification-container">
    <div class="verification-card text-center">
      <img src="{{ URL::to('/') }}/{{ $cabinet[0]->logo ?? '' }}" class="logo mb-3" alt="Logo">
      <h2 class="mb-2"><i class="bi bi-shield-lock"></i> Vérification 2FA</h2>
      <p class="text-light mb-4">Un code vous a été envoyé par email.</p>

      <p class="text-light">Adresse : {{ substr(auth()->user()->email, 0, 5) . '******' . substr(auth()->user()->email,  -2) }}</p>

      @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
      @endif
      @if ($message = Session::get('error'))
        <div class="alert alert-danger">{{ $message }}</div>
      @endif

      <x-auth-session-status class="mb-3 text-danger" :statut="session('statut')" />
      <x-auth-validation-errors :errors="$errors" />

      <form method="POST" action="{{ route('2fa.store') }}">
        @csrf
        <div class="mb-3 text-start">
          <label for="code" class="form-label">Code de confirmation</label>
          <input id="code" type="number" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autofocus>
          @error('code')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('2fa.resend') }}" class="text-warning text-decoration-none">Renvoyer le code ?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Valider</button>
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
