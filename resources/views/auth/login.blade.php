
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ClickNet | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/logincode/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/logincode/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/logincode/dist/css/adminlte.min.css') }}">
</head>


<body class="hold-transition login-page" style="background-image: url('{{ asset('/Backgrounds/thumbimg_25361957thumbejpg.jpg') }}'); background-position: center;
  background-repeat: no-repeat;
  background-size: cover;" >
<div class="login-box">
<div class="register-logo">
    <a href="#" style="color: white;"><b>CLick</b>Net</a>
  </div>

  <!-- <img src="/storage/image/ishi.jpg" alt="ishii"> -->
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      @include('inc.messages')

      @if (session('message'))
        <div class="alert alert-danger">{{ session('message') }}</div>
    @endif

      <form method="POST" action="{{ route('login') }}">
                        @csrf
        <div class="input-group mb-3">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>          <div class="input-group-append">
           
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        
        <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
         
          <!-- /.col -->
        </div>
        <br>
        <center>
         
         <button type="submit" class="btn btn-primary btn-block">Sign In</button>
     </center>
      </form>

      <br><br>
      <!-- /.social-auth-links -->
      <div class="row">
      <p class="mb-1">
            <a href="{{ route('register')}}" class="btn btn-success ml-3"> Register</a>
          
    </p>
    <p class="mb-1">
            <a href="{{ route('password.request')}}" class="btn btn-dark ml-3"> Forgot Password ?</a>
          
    </p>
      </div>
     

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>


