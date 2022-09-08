<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Siamawolu Admin</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/adminlte/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ route('dashboard') }}" class="h1"><strong>Siamawolu Admin</strong></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Selamat Datang!</p>

        <form action="{{ route('login') }}" method="post">
          @csrf
          @error('auth_failed')
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ $message }}
            </div>
          @enderror

          @error('username')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="input-group mb-3">
            <input name="username" type="text" class="form-control @error('username') {{ 'is-invalid' }} @enderror"
              placeholder="Username" value="{{ old('username') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          @error('password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="input-group mb-3">
            <input name="password" type="password"
              class="form-control @error('password') {{ 'is-invalid' }} @enderror" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input name="remember" type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/adminlte/adminlte.min.js') }}"></script>
</body>

</html>
