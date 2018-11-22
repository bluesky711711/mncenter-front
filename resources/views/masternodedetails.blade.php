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

<div class="inner-banner">
  <div class="container">
    <h3>Masternode details</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1">
  <div class="container">
    <div class="mas-top">
      <div class="col-md-4">
        <div class="set-box">
          <div class="ref-head">Masternode Information</div>
          <div class="accent-bg"></div>
          <ul>
            <li><span>Status:</span>{{$masternode->status}} </li>

            <li><span>Start Date:</span>@if ($masternode->status == "Completed") {{$masternode->created_at}} @else Not Started @endif</li>
            <li><span>Address:</span>@if ($masternode->status == "Completed") {{$masternode->address}} @else Nothing @endif</li>



          </ul>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="set-box">
          <div class="ref-head">Your Balance</div>
          <div class="accent-bg"></div>
          <ul>
            <li><span>Needed For a Seat: </span>{{$coin->seat_price}}</li>
            <li><span>Total </span>:0.0000 @if (!Auth::guest()) <a style="cursor:pointer" onclick="withdraw()"><img src="/img/withdraw_icon.png" style="height:20px;float:right;margin-left:20px"/></a>
              <a style="cursor:pointer" onclick="deposit()"><img src="/img/deposit_icon.png" style="height:20px;float:right"/></a> @endif
            </li>
            <li><span>Available: </span>0.0000</li>
            <li><span>In Queue: </span>0</li>
            <li><span>Profit: </span>0
              @if (!Auth::guest())
                <a href="/reward_history" style="cursor:pointer"><img src="/img/profit_icon.png" style="height:20px;float:right;"/></a>
              @endif
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="set-box">
          <div class="ref-head">Main Wallet</div>
          <div class="accent-bg"></div>
          <ul>
            <li><span>Status:</span>Active</li>
            <li><span>Last Block:</span>347221</li>
            <li><span>Block Time:</span>14.07.2018 09:29</li>
            <li><span>Wallet Read Time:</span>14.07.2018 09:34 </li>
          </ul>
          <div class="clearfix"></div>
        </div>
      </div>

    </div>

    <div class="rew-area col-md-12">
      <h4 class="main-head"> Reward Transactions</h4>


      <div class="mas-table">
        <table  width="100%" border="0" class="table table-bordered table-striped mb-none" id="datatable-coins" style="font-size:13px; margin:0px; width:100%;">
          <thead>
            <tr>
              <td width="">Name</td>
              <td width="">Status</td>
              <td width="">Reward Date</td>
              <td width="">Reward Amount</td>
              <td width="">To</td>
            </tr>
          </thead>
          <tbody id="coin-list">
            @foreach ($rewards as $reward)
            <tr id="tr-{{$reward->id}}" style="line-height:32px">
              <td style="text-align:center">{{$masternode->name}}</td>
              <td style="text-align:center">{{$reward->status}}</td>
              <td style="text-align:center">{{$reward->created_at}}</td>
              <td style="text-align:center">{{$reward->reward_amount}}</td>
              <td style="text-align:center">{{$reward->user->name}}</td>
            </tr>
            @endforeach
          </tbody>

        </table>
        @if (count($rewards) == 0)
          <div style="text-align:center;font-size:25px;padding:20px">No Any Rewards!</div>
        @endif
      </div>



    </div>

    <div class="chartara col-md-12">
      <div class="col-md-7">
        <div class="chart chart-md" id="flotPie" style="height:400px"></div>
        <script type="text/javascript">

        var flotPieData = [{
          label: "Required Seats",
          data: [
            [1, 100]
          ],
          color: '#0088cc'
        }];


        </script>
      </div>

      <div class="col-md-5 chart-table">
        <div class="mas-table">
          <table width="100%" border="0" class="table table-striped">
            <thead>
              <tr>
                <td width="14%">Nickname </td>
                <td width="8%">	Amount </td>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>

        </div>
      </div>

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
(function() {
  if( $('#flotPie').get(0) ) {
    var plot = $.plot('#flotPie', flotPieData, {
      series: {
        pie: {
          show: true,
          combine: {
            color: '#999',
            threshold: 0.1
          }
        }
      },
      legend: {
        show: false
      },
      grid: {
        hoverable: true,
        clickable: true
      }
    });
  }
})();


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

function deposit(){
  $(".popup-overlay").css("display", "block");
  $("#dipositbox").fadeIn('slow');
}

$("#diposit_close").click(function(){
  $(".popup-overlay").css("display", "none");
  $("#dipositbox").fadeOut('fast');
});

$("#diposit_close1").click(function(){
  $(".popup-overlay").css("display", "none");
  $("#dipositbox").fadeOut('fast');
});

function withdraw(){
  $(".popup-overlay").css("display", "block");
  $("#withdrawbox").fadeIn('slow');
};

$("#withdraw_close1").click(function(){
  $(".popup-overlay").css("display", "none");
  $("#withdrawbox").fadeOut('fast');
});

$("#withdraw_close").click(function(){
  $(".popup-overlay").css("display", "none");
  $("#withdrawbox").fadeOut('fast');
});
</script>

@endsection
