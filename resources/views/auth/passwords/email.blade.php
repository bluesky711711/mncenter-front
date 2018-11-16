@extends('layouts.app')

@section('content')
<div class="inner-banner">
 <div class="container">
<h3>Forgot your password?</h3>
</div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:590px">

<div class="container">
<div class="login-box">
<div class="login-area">
<div class="login-main">
<h3>Password for</h3>
<div class="accent-bg"></div>
<div class="login-form">
  @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
  @endif
  @if ($message = Session::get('failed'))
      <div class="alert alert-danger">
          <p>{{ $message }}</p>
      </div>
  @endif
<form class="form-horizontal" role="form" method="POST"  action="/forgetpassword">
<label>Your Email:</label>
<div class="login-field">
<input type="email" name="email" class="form-control" placeholder="Email">
@if ($errors->has('email'))
    <span class="color:#fff">{{ $errors->first('email') }}</span>
@endif
</div>
<button class="btn login-btn">Send</button>
</form>

</div>
<div class="button-area">

<span>You remember password?</span> <a class="page-scroll" href="/login">Sign in</a>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</section>

<!--Start Part-2-->







@endsection
