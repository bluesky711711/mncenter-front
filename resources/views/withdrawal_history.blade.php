@extends('layouts.app')

@section('content')

<div class="inner-banner">
  <div class="container">
    <h3>Withdrawal Historys</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">

    <div class="mas-table">
      <table width="100%" border="0" class="table table-striped">
        <thead>
          <tr>
            <td>Withdraw ID</td>
            <td>Coin </td>
            <td>Amount</td>
            <td>Status</td>
            <td>Address </td>
            <td>Withdrawal Date</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($withdrawals as $withdrawal)
          <tr>
            <td>	{{$withdrawal->id}}  </td>
            <td>  {{$withdrawal->coin->coin_name}}  </td>
            <td>  {{$withdrawal->amount}}</td>
            <td>  {{$withdrawal->status}} </td>
            <td>  {{$withdrawal->to_address}} </td>
            <td>  {{$withdrawal->created_at}} </td>
          </tr>
          @endforeach
          @if (count($withdrawals) == 0)
          <div class="row" style="text-align:center;padding-top:20px">
            <span style="font-size:25px">No any withdrawls yet!</span>
          </div>
          @endif
        </tbody>
      </table>
    </div>
  </div>
  <div class="clearfix"></div>
</section>
<script>
$(document).ready(function(){
  $(".same").click(function(){
    var sliderid = $(this).attr("id");

    var n = sliderid.split('-');
    var indid = (n[1]);

    $( ".openSlide" ).slideUp( "fast", function() {
      $( ".tabActive" ).removeClass( "tabActive" );

    });

    $( "#1stslide-" + indid ).slideDown( "fast", function() {
      $( "#atab-" + indid ).removeClass( "tabinActive").addClass("tabActive");

    });



  });
});
</script>
<script type="text/javascript">
$(function(){
  SyntaxHighlighter.all();
});
$(window).load(function(){
  $('.flexslider').flexslider({
    animation: "fade",
    start: function(slider){
      $('body').removeClass('loading');
    }
  });

  $('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
  }, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
  });
});
</script>

@endsection
