@extends('layouts.app')

@section('content')


<div class="inner-banner">
  <div class="container">
    <h3>User Settings</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">

    <!-- <div class="col-md-6">
      <div class="set-box">
        <form action="" method="get">
          <label>Nickname</label>
          <input type="text" class="form-control">

          <label>Discord Username</label>
          <input type="text" class="form-control">

          <button class="btn setbtn">Save</button>
        </form>
        <div class="clearfix"></div>
      </div>
    </div> -->

    <div class="col-md-6">
      <div class="set-box">
        <div class="ref-head">Referral Information</div>
        <div class="accent-bg"></div>
        <ul>
          <li><span>Code:</span>referral-{{$user->id}}</li>
          <li><span>Referred:</span>{{count($referrals)}}</li>
          <li><span>Earnings:</span>1%</li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="set-box">
        <div class="ref-head">Reset Password</div>
        <div class="accent-bg"></div>
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
        <form class="form-horizontal" role="form" method="POST"  action="/changepassword">
        <input type="hidden" name="id" value="{{$user->id}}" />
        <label>New password:</label>
        <div class="login-field">
          <input type="password" name="password" class="form-control">
        </div>
        <label>Confirm password:</label>
        <div class="login-field">
          <input type="password" name="password-confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Reset</button>
        </form>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</section>

@endsection
