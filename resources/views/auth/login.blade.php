
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student Platform | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="/css/app.css">
  <link rel="icon" href="/img/professor.png" type="image/x-icon">
  <script src="/js/app.js"></script>
</head>
<body class="hold-transition login-page">
<a href="/"><img src="img/professor.png" style="max-width:100%; height: 5em" alt="logo"></a>
<div class="login-box">
  <div class="login-logo">
    Student Platform
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in</p>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-4">
          <input id="student_id" type="number" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ old('student_id') }}" required autocomplete="student_id" autofocus placeholder='Student ID'>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-hashtag"></span>
            </div>
          </div>
          @error('student_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="input-group mb-4">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row">
          <div class="col-8">
              <a href="/">Back to Homepage</a>
            {{-- <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="custom-control-label">
                    {{ __('Remember Me') }}
                </label>
            </div> --}}
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Login') }}
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      {{-- <p class="mb-1">
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
      </p> --}}
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>
</html>
