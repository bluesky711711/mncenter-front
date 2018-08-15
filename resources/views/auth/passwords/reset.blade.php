@extends('layouts.app')

@section('content')

        <div class="inner-banner">
         <div class="container">
        <h3>Reset Password</h3>
        </div>
        </div>



<!--Start Part-1-->

<section id="part_1">

<div class="container">
<div class="login-box">
  <div class="login-area">
    <div class="login-main">
    <h3>Password for</h3>
    <div class="accent-bg"></div>
    <div class="login-form">
    <form action="" method="get">
    <label>New password</label>
    <div class="login-field">
      <input type="password" class="form-control" placeholder="password">
      </div>
       <label>New password confirmation</label>
      <div class="login-field">
      <input type="password" class="form-control" placeholder="confirm password">
      </div>


        <button class="btn login-btn">Save</button>

    </form>
    </div>
    <div class="button-area">

      <span>You remeber password?</span> <a class="page-scroll" href="/login">Sign in</a>
      </div>
    </div>
  </div>
</div>
</div>
<div class="clearfix"></div>
</section>
@endsection
