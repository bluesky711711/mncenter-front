@extends('layouts.app')

@section('content')
<div class="inner-banner">
 <div class="container">
<h3>Reset Password</h3>
</div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:590px">

<div class="container">
<div class="login-box">
<div class="login-area">
<div class="login-main">
<h3>Successful password recovery!</h3>
<div class="accent-bg"></div>
<div class="login-form">
<form class="form-horizontal" role="form" method="GET"  action="{{ url('/login') }}">
<p>We have sent your new link! Use it to log in to our site.</p>
<p>if you experience any problem, please let us know!</p>
<button class="btn login-btn">BACK TO LOGIN!</button>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</section>
