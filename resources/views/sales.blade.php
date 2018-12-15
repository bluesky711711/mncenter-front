@extends('layouts.app')

@section('content')

<div class="inner-banner">
  <div class="container">
    <h3>My Sales</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">
    <div class="mas-table">
      <table width="100%" border="0" class="table table-striped">
        <thead>
            <tr>
                <td>Sale ID</td>
                <td>Coin</td>
                <td>MasterNode ID</td>
                <td>Seats Count</td>
                <td>Total Price</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($sales as $sale)
            <tr id="{{$sale->id}}">
                <td>{{$sale->id}}</td>
                <td>@if (isset($sale->masternode->coin->coin_name)) {{$sale->masternode->coin->coin_name}} @endif</td>
                <td>@if (isset($sale->masternode->id)) {{$sale->masternode->id}} @endif</td>
                <td>{{$sale->sales_amount}}</td>
                <td>{{$sale->total_price}}</td>
                <td>{{$sale->status}}</td>
            </tr>
        @endforeach
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
