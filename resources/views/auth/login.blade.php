@extends('layouts.app')

@section('content')

<!--End Header-->

<div class="inner-banner">
  <div class="container">
    <h3>Login</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="margin-top:40px; min-height:550px">

  <div class="container">
    <div class="login-box">
      <div class="login-area">
        <div class="login-main">
          <h3>Sign in</h3>
          <div class="accent-bg"></div>
          @if ($message = Session::get('success'))
              <div class="alert alert-success">
                  <p>{{ $message }}</p>
              </div>
          @endif
          @if ($message = Session::get('warning'))
              <div class="alert alert-warning">
                  <p>{{ $message }} <a onclick="Resend()" style="cursor:pointer">Resend</a></p>
              </div>
          @endif
          @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                  <p>{{ $message }}</p>
              </div>
          @endif
          <div class="login-form">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" style="width:100%">
              <div class="login-field">
                <span><i class="fas fa-user"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
              @if ($errors->has('email'))
                <div class="error-alert">
                  {{ $errors->first('email') }}
                </div>
              @endif
              <div class="login-field">
                <span><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              @if ($errors->has('password'))
                <div class="error-alert">
                  {{ $errors->first('password') }}
                </div>
              @endif
              <button class="btn login-btn">Sign In</button>
            </form>
          </div>
          <div class="button-area">
            <a class="page-scroll" href="/register">Register</a>| <a href="{{ url('/password/reset') }}">Forgot your password?</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form id="form_resend" method="POST" action="/resendToken">
    <input type="hidden" id="resend_email" name="resend_email" value=""/>
  </form>
  <div class="clearfix"></div>
</section>
<script>
function Resend(){
  @if ($email = Session::get('email'))
    $('#resend_email').val("{{$email}}");
    $('#form_resend').submit();
  @endif
}
</script>
@endsection
