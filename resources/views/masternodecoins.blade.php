@extends('layouts.app')

@section('content')

<div class="popup-overlay" style="display:none;"></div>
<div class="deposite-box" id="dipositbox" style="display:none;">
  <div class="deposite-head">
    <h3>Deposite</h3>
    <div class="accent-bg"></div>
    <a class="popup-close" id="diposit_close" href="javascript:void(0)"><i class="fas fa-times"></i></a>
  </div>
  <div class="popup-text">

    <p>
      Please use the address below to deposit new funds</p>

      <div class="dep-box">
        <label>Deposite address</label>
        <div class="clearfix">
          <input type="text" class="form-control" placeholder="Address">
          <button class="btn" >Generate Address</button>
        </div>
      </div>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>

      <div class="green-alert">

        New masternodes will be handled between 19-22 hrs UTC.

      </div>
    </div>

    <div class="dep-btn">
      <a class="his-btn" href="#">Deposite history</a>
      <a  class="clear" id="diposit_close1" href="javascript:void(0)">Cancel</a>
    </div>
  </div>

  <div class="deposite-box" id="withdrawbox" style="display:none;">
    <div class="deposite-head">
      <h3>Withdraw</h3>
      <div class="accent-bg"></div>
      <a class="popup-close" id="withdraw_close" href="javascript:void(0)"><i class="fas fa-times"></i></a>
    </div>
    <div class="popup-text">

      <div class="withdraw-box">
        <label>Blance</label>
        <input type="text" class="form-control" placeholder="0">
      </div>
      <div class="withdraw-box">
        <label>Amount</label>
        <input type="text" class="form-control" >
      </div>

      <div class="withdraw-box">
        <label>Tx fee</label>
        <input type="text" class="form-control" placeholder="0.01" >
      </div>

      <div class="withdraw-box">
        <label>Withdrawl</label>
        <input type="text" class="form-control" placeholder="0">
      </div>
      <div class="withdraw-box">
        <label>Address</label>
        <input type="text" class="form-control" placeholder="0">
      </div>
      <p>Please verify your withdrawl address </p>

    </div>

    <div class="dep-btn">
      <a class="his-btn" href="#">Withdraw</a>
      <a  class="clear" id="withdraw_close1" href="javascript:void(0)">Cancel</a>
    </div>
  </div>

<!--End Header-->

<div class="inner-banner">
  <div class="container">
    <h3>Masternodes</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">
    <div class="mas-table">
      <table  width="100%" border="0" class="table table-bordered table-striped mb-none" id="datatable-coins" style="font-size:13px; margin:0px; width:100%">
          <thead>
          <tr>
              <td width="15%">Coin</td>
              <td width="9%">	Completed MN</td>
              <td width="15%">Coins needed for a Seat</td>
              <td width="11%">Required for MN</td>
              <td width="21%">Coins in Queue</td>
              <td width="17%">Required for next MN</td>
              <td width="10%">Coin price</td>
              <td width="10%">MN price</td>
          </tr>
          </thead>
          <tbody id="coin-list">
            @foreach ($coins as $coin)
                <tr id="tr-{{$coin->id}}" style="line-height:32px">
                    <td style="text-align:center"><a href="/masternodes/coin/{{$coin->id}}"><img src="/img/{{$coin->coin_name}}.png" alt="icon" style="width:17px;height:auto"> {{$coin->coin_name}} ({{$coin->coin_symbol}}) </a></td>
                    <td style="text-align:center">{{$coin->completed_mn_count}}</td>
                    <td style="text-align:center">{{$coin->seat_price}}</td>
                    <td style="text-align:center">{{$coin->masternode_amount}}</td>
                    <td style="text-align:center">@if ($coin->queue_masternode) {{$coin->queue_masternode->seat_amount * $coin->seat_price}} ({{$coin->queue_masternode->seat_amount * 100 / $coin->queue_masternode->total_seats}}%) @endif</td>
                    <td style="text-align:center">@if ($coin->queue_masternode) {{$coin->queue_masternode->empty_seats * $coin->seat_price}} ({{$coin->queue_masternode->empty_seats * 100 / $coin->queue_masternode->total_seats}}%) @endif</td>
                    <td style="text-align:center">{{$coin->coin_price}} $</td>
                    <td style="text-align:center">{{$coin->coin_price * $coin->masternode_amount}} $</td>
                </tr>
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <div class="clearfix"></div>
</section>

<!--Start Part-2-->
<script>
$(document).ready(function(){
  $('#datatable-coins').dataTable({searching: false, "pageLength": 20, "bLengthChange": false,  "order": [[ 1, "desc" ]]});
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
// $(function(){
//   SyntaxHighlighter.all();
// });
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
