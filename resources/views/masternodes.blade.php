@extends('layouts.app')

@section('content')

<!--End Header-->
<div class="popup-overlay" style="display:none;"></div>
<div class="deposite-box" id="depositbox" style="display:none;">
  <div class="deposite-head">
    <h3>Deposite</h3>
    <div class="accent-bg"></div>
    <a class="popup-close" id="deposit_close" href="javascript:void(0)"><i class="fas fa-times"></i></a>
  </div>
  <div class="popup-text">
    <p>Please use the address below to deposit new funds</p>
      <div class="dep-box">
        <label>Deposit address</label>
        <div class="clearfix">
          <input type="text" class="form-control deposit-address" id="deposit-address" placeholder="Address" disabled>
          <button class="btn" onclick="copyaddress()">Copy Address</button>
        </div>
      </div>
      <p style="font-weight:bold">Qr Code</p>
      <div class="row" style="text-align:center;padding:20px 0px">
        <div class="qrcode"></div>
      </div>
      <!-- <div class="green-alert">
        New masternodes will be created immediately when the coin amount is prepared.
      </div> -->
    </div>

    <div class="dep-btn">
      <a class="his-btn" href="/deposit_history">Deposite history</a>
      <a  class="clear" id="deposit_close1" href="javascript:void(0)">Cancel</a>
    </div>
  </div>

  <div class="deposite-box" id="withdrawbox" style="display:none;">
    <form id="withdraw_form" method="POST"  action="/withdraw">
    <input name="coin_id" id="coin_id" type="hidden" value=""/>
    <div class="deposite-head">
      <h3>Withdraw</h3>
      <div class="accent-bg"></div>
      <a class="popup-close" id="withdraw_close" href="javascript:void(0)"><i class="fas fa-times"></i></a>
    </div>
    <div class="popup-text">
      <div class="withdraw-box">
        <label>Balance</label>
        <input type="text" name="balance" id="balance" class="form-control withdraw-balance" placeholder="0" value="" disabled/>
      </div>
      <div class="withdraw-box">
        <label>Withdraw Address</label>
        <input type="text" name="to_address" id="to_address" class="form-control" placeholder="0" />
      </div>
      <div class="withdraw-box">
        <label>Withdraw Amount</label>
        <input type="text" name="amount" id="amount" class="form-control withdraw-amount" />
      </div>
      <div class="withdraw-box">
        <label>Tx fee </label>
        <input type="text" class="form-control" id="tx_fee" placeholder="-1" disabled />
        <p style="font-size:10px">A negative value means that you not enough transactions and blocks have been observered to make an estimate.</p>
      </div>
      <p>Please verify your withdrawl address</p>
    </div>

    <div class="dep-btn">
      <a class="his-btn" href="javascript:void(0)" onclick="withdraw()">Withdraw</a>
      <a  class="clear" id="withdraw_close1" href="javascript:void(0)">Cancel</a>
    </div>
    </form>
  </div>

  <div class="deposite-box" id="salebox" style="display:none;">
    <form id="sale_form" method="POST"  action="/buyseats">
      <input name="sale_coin_id" id="sale_coin_id" type="hidden" value=""/>
      <input name="seat_amount" id="seat_amount" type="hidden" value=""/>
      <input name="masternodeid" id="masternodeid" type="hidden" value=""/>
    </form>
    <div class="deposite-head">
      <h3>Buy Seats</h3>
      <div class="accent-bg"></div>
      <a class="popup-close" id="withdraw_close" href="javascript:void(0)"><i class="fas fa-times"></i></a>
    </div>
    <div class="popup-text">
      <div class="withdraw-box">
        <label>Balance</label>
        <input type="text" name="sale_balance" id="sale_balance" class="form-control withdraw-balance" placeholder="0" value="" disabled/>
      </div>
      <div class="withdraw-box">
        <label>Seats Count to Buy <span style="padding-left:20px;font-size:12px">(Need <span id="empty_seats"></span> seats to complete)</span></label>
        <input type="text" name="sale_count_seats" id="sale_count_seats" class="form-control" placeholder="0" oninput="changeSalescount(this.value)"/>
      </div>
      <div class="withdraw-box">
        <label>Total Amount</label>
        <input type="text" name="sale_total_amount" id="sale_total_amount" class="form-control withdraw-amount" disabled/>
      </div>
      <!-- <div class="withdraw-box">
        <label>Tx fee </label>
        <input type="text" class="form-control" id="sale_tx_fee" placeholder="-1" disabled />
        <p style="font-size:10px">A negative value means that you not enough transactions and blocks have been observered to make an estimate.</p>
      </div> -->
      <br><br>
      <p></p>
    </div>

    <div class="dep-btn">
      <a class="his-btn" href="javascript:void(0)" onclick="buy()">Buy</a>
      <a  class="clear" id="sale_close" href="javascript:void(0)">Cancel</a>
    </div>

  </div>

<div class="inner-banner">
  <div class="container">
    <h3>Masternodes</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">
    <!-- <div class="error-alert">

    We are in the process of swapping Deviant coins. Deviant has been temporally removed from the website until swap is not finished.

  </div>

  <div class="green-alert">

  New masternodes will be handled between 19-22 hrs UTC.

</div> -->
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>The request successfully sent! it may take some times for confirmations.</p>
</div>
@endif
@if ($message = Session::get('failed'))
<div class="alert alert-danger">
  <p>The transaction failed!  Please try it after 30 mins!</p>
</div>
@endif
<div class="mas-table">
  <div class="col-md-4">
    <div class="set-box">
      <div class="ref-head">General Information</div>
      <div class="accent-bg"></div>
      <ul>
        <li><span>Reward Fee:</span>10% </li>
        <li><span>Completed Masternodes:</span>{{count($completed_masternodes)}}</li>
        <li><span>Required Amount for MN:</span>{{$coin->masternode_amount}}</li>
        <li><span>Required for next MN:</span>@if ($preparing_masternode) {{$preparing_masternode->empty_seats}} @endif</li>
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
        <li><span>Total </span>:{{$coin->user_balance}}
          @if (!Auth::guest())
            <a style="cursor:pointer" onclick="withdraw()"><img src="/img/withdraw_icon.png" style="height:20px;float:right;margin-left:20px"/></a>
            <a style="cursor:pointer" onclick="deposit()"><img src="/img/deposit_icon.png" style="height:20px;float:right"/></a>
          @endif
        </li>
        <li><span>Available: </span>{{$coin->user_balance}}</li>
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
        <li><span>Status:</span>{{$coin->status}}</li>
        <li><span>Last Block:</span>{{$coin->blocks}}</li>
        <li><span>Connections:</span>{{$coin->connections}}</li>
        <li><span>Wallet version:</span>{{$coin->walletversion}} </li>
      </ul>
      <div class="clearfix"></div>
    </div>
  </div>

  <div class="col-md-12" style="height:30px"></div>

<table  width="100%" border="0" class="table table-bordered table-striped mb-none" id="datatable-coins" style="font-size:13px; margin:0px; width:100%;">
  <thead>
    <tr>
      <td width="">Name</td>
      <td width="">Status</td>
      <td width="">Empty Seats</td>
      <td width="">Start Date</td>
      <td width="">Address</td>
      <td width="">Rewards 24h</td>
      <td width="">Rewards 7days</td>
      <td width="">Rewards total</td>
      <td>Action</td>
    </tr>
  </thead>
  <tbody id="coin-list">
    @foreach ($masternodes as $masternode)
    <tr id="tr-{{$masternode->id}}" style="line-height:32px">
      <td style="text-align:center"><a href="/masternode/{{$masternode->id}}">{{$masternode->name}}</a></td>
      <td style="text-align:center">{{$masternode->status}}</td>
      <td style="text-align:center">{{$masternode->empty_seats}}</td>
      <td style="text-align:center">@if ($masternode->status=="Completed") {{$masternode->created_at}} @else Not Started @endif</td>
      <td style="text-align:center">@if ($masternode->status=="Completed") {{$masternode->address}} @else Nothing @endif</td>
      <td style="text-align:center">@if ($masternode->status=="Completed") {{$masternode->reward24}} @else 0 @endif</td>
      <td style="text-align:center">@if ($masternode->status=="Completed") {{$masternode->reward7}} @else 0 @endif</td>
      <td style="text-align:center">@if ($masternode->status=="Completed") {{$masternode->rewardtotal}} @else 0 @endif</td>
      <td style="text-align:center">
      @if ($masternode->status != "Completed")
        <button class="btn btn-primary" type="button" id="add_seats" onclick="addseats({{$masternode->id}}, {{$masternode->empty_seats}}, {{$masternode->seat_amount}})">
          Add seats
        </button>
      @endif
      </td>
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
function copyaddress(){
  var copyText = document.getElementById("deposit-address").value;
  console.log(copyText);
  const el = document.createElement('textarea');
  el.value = copyText;
  document.body.appendChild(el);
  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);
  alert("Copied the address to clipboard: " + copyText);
}
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
  address = "{{$coin->address}}";
  option = {
    //render:"table"
    width: 128,
    height: 128,
    text: address
  };
  $('.qrcode').qrcode(option);
  $('.deposit-address').val(address);
  $(".popup-overlay").css("display", "block");
  $("#depositbox").fadeIn('slow');
}

$("#deposit_close1").click(function(){
  $('.qrcode').html("");
  $(".popup-overlay").css("display", "none");
  $("#depositbox").fadeOut('fast');
});


$("#deposit_close").click(function(){
  $('.qrcode').html("");
  $(".popup-overlay").css("display", "none");
  $("#depositbox").fadeOut('fast');
});

function withdraw(){
  coin_id = "{{$coin->id}}";
  balance = "{{$coin->user_balance}}";
  fee = "{{$coin->tx_fee}}";
  $('.withdraw-balance').val(balance);
  $('#tx_fee').val(fee);
  $('#coin_id').val(coin_id);
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

$('.popup-close').click(function(){
  $(".popup-overlay").css("display", "none");
  $("#salebox").fadeOut('fast');
});

$('#sale_close').click(function(){
  $(".popup-overlay").css("display", "none");
  $("#salebox").fadeOut('fast');
});

function addseats(id, empty_seats, seat_amount){
  @if (Auth::guest())
    location.href = '/login';
  @else
  masternodeid = id;
  coin_id = "{{$coin->id}}";
  balance = "{{$coin->user_balance}}";
  //fee = "{{$coin->tx_fee}}";
  $('#sale_balance').val(balance);
  //$('#sale_tx_fee').val(fee);
  $('#sale_coin_id').val(coin_id);
  $('#masternodeid').val(id);
  $('#empty_seats').html(empty_seats);
  $(".popup-overlay").css("display", "block");
  $("#salebox").fadeIn('slow');
  @endif
}


function changeSalescount(val){
  seat_price = parseFloat("{{$coin->seat_price}}");
  $('#sale_total_amount').val(val*seat_price);
}

function buy(){
  sale_balance = $('#sale_balance').val();
  sale_total_amount = $('#sale_total_amount').val();
  if (sale_balance <= sale_total_amount){
    alert('You have not enough balance for this sale!')
    return;
  }
  $('#seat_amount').val($('#sale_count_seats').val());
  $('#sale_form').submit();
}
</script>

@endsection
