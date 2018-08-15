@extends('layouts.app')

@section('content')

<!--End Header-->

<div class="inner-banner">
  <div class="container">
    <h3>Two Factor Authentication</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="margin-top:40px; min-height:550px">

  <div class="container">
    <div class="login-box">
      <div class="login-area">
        <div class="login-main">
          <h3>Authentication</h3>
          <div class="accent-bg"></div>
          <div class="login-form">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/token') }}" style="width:100%">
              <div class="login-field">
                <span><i class="fas fa-user"></i></span>
                <input type="text" name="token" class="form-control" placeholder="Token" required>
              </div>

              <button class="btn login-btn">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</section>

@endsection
