@extends('layouts.app')

@section('content')

<div class="inner-banner">
  <div class="container">
    <h3>Registration</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1">

  <div class="container">
    <div class="login-box">
      <div class="login-area">
        <div class="login-main">
          <h3>Registration</h3>
          <div class="accent-bg"></div>
          <div class="login-form">
            <form id="register-form" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
              {{ csrf_field() }}
              <label>Username</label>
              <div class="login-field">
                <input type="text" name="name" class="form-control" placeholder="User Name" required>
              </div>
              <label>Email</label>
              <div class="login-field">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
              @if ($errors->has('email'))
              <div class="error-alert">
                {{ $errors->first('email') }}
              </div>
              @endif
              <label>Password</label>
              <div class="login-field">
                <input type="password" name="password" class="form-control" placeholder="New password" required>
              </div>

              <label>Password confirmation </label>
              <div class="login-field">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm the new password" required>
              </div>

              @if ($errors->has('password'))
              <div class="error-alert">
                {{ $errors->first('password') }}
              </div>
              @endif

              <label>Referral Code</label>


              <div class="login-field">
                <input type="text" class="form-control" name="referral_code" placeholder="Enter referral code">
              </div>


              <div class="mdl-grid mdl-cell mdl-cell--12-col" style="padding:10px 0px">
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="agreeForService">
                  <input type="checkbox" id="agreeForService" class="mdl-checkbox__input" onclick="toggleAgree()">
                  <span>I have checked <a href="/terms" target="_blank">terms</a> and <a href="/policy" target="_blank">policy</a></span>
                </label>
              </div>
              <button id="submitBtn" class="btn login-btn" disabled>Register</button>
            </form>
          </div>
          <div class="button-area">
            <a href="{{ url('/password/reset') }}">Forgot your password?</a> | <span>Already have an account?</span> <a class="page-scroll" href="/login">Sign in</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</section>
<script>
function toggleAgree() {
    var isAgree = document.getElementById("agreeForService").checked
    if(!isAgree) {
        $("#submitBtn").attr('disabled', 'disabled');
    } else {
        $("#submitBtn").removeAttr('disabled');
    }
}
</script>
@endsection
