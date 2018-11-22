@extends('layouts.app')

@section('content')
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
          <input type="text" name="to_address" id="to_address" class="form-control" placeholder="" />
        </div>
        <div class="withdraw-box">
          <label>Withdraw Amount</label>
          <input type="text" name="amount" id="amount" class="form-control withdraw-amount" />
        </div>
        <div class="withdraw-box">
          <label>Tx fee </label>
          <input type="text" class="form-control" id="tx_fee" placeholder="-1" disabled />
          <p style="font-size:10px">A negative value means that the platform will handle it automatically as optimized amount.</p>
        </div>
        <p>Please verify your withdrawl address</p>
      </div>

      <div class="dep-btn">
        <a class="his-btn" href="javascript:void(0)" onclick="withdraw()">Withdraw</a>
        <a  class="clear" id="withdraw_close1" href="javascript:void(0)">Cancel</a>
      </div>
      </form>
    </div>
    <!--End Header-->
    <div class="inner-banner">
      <div class="container">
        <h3>Balance</h3>
      </div>
    </div>

    <!--Start Part-1-->

    <section id="part_1" style="min-height:590px">
      <div class="container">
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
          <table width="100%" border="0" class="table table-striped">
            <thead>
              <tr>
                <td width="8%">Action </td>
                <td width="15%">Coin </td>
                <td width="12%"> Total</td>
                <td width="17%"> In Queue </td>
                <td width="10%"> Available</td>
                <td width="15%">  Unconfirmed Deposit</td>
                <td width="10%">  Pending Withdraw </td>
                <td width="15%"> Paid Rewards</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($coins as $coin)
              <tr>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @if ($coin->status == "Deactive") disabled @endif>
                      Action <i class="fas fa-angle-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item depositcl" data-address="{{$coin->address}}" href="javascript:void(0)">Deposite</a>
                      <a class="dropdown-item withdrawcl" data-coin_id="{{$coin->id}}}" data-balance="{{$coin->user_balance}}" data-fee="{{$coin->tx_fee}}" href="javascript:void(0)">Withdraw</a>
                      <a class="dropdown-item" href="/masternodes/coin/{{$coin->id}}">Show Masternodes</a>
                    </div>
                  </div>
                </td>
                <td><a href="masternode-details.html"><img src="/img/{{$coin->coin_name}}.png" alt="icon"></a> {{$coin->coin_name}} ({{$coin->coin_symbol}})</td>
                <td>  {{$coin->total_amount}}</td>
                <td>  {{$coin->total_amount - $coin->user_balance}}</td>
                <td>  {{number_format($coin->user_balance, 4)}}</td>
                <td>  {{$coin->pending_withdraw_amount}}</td>
                <td>  {{$coin->pending_deposit_amount}}</td>
                <td>  {{$coin->paid_reward_amount}}</td>
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

      $(".depositcl").click(function(){
        address = $(this).data('address');
        option = {
          //render:"table"
          width: 128,
          height: 128,
          text: address
        };
        $('.qrcode').html('');
        $('.qrcode').qrcode(option);
        $('.deposit-address').val(address);
        $(".popup-overlay").css("display", "block");
        $("#depositbox").fadeIn('slow');

      });

      $("#deposit_close").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#depositbox").fadeOut('fast');
      });

      $("#deposit_close1").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#depositbox").fadeOut('fast');
      });

      $(".withdrawcl").click(function(){
        coin_id = $(this).data('coin_id');
        balance = $(this).data('balance');
        console.log(balance);
        fee = $(this).data('fee');
        $('.withdraw-balance').val(balance);
        $('#tx_fee').val(fee);
        $('#coin_id').val(coin_id);
        $(".popup-overlay").css("display", "block");
        $("#withdrawbox").fadeIn('slow');
      });

      $("#withdraw_close1").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#withdrawbox").fadeOut('fast');
      });

      $("#withdraw_close").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#withdrawbox").fadeOut('fast');
      });
    });

    function withdraw(){
      console.log('withdraw');
      amount = $('#amount').val();
      if (amount > 0){
        console.log('amount');
      } else {
        alert('Please input the amount correctly!');
        return;
      }
      console.log('amount', amount);
      balance = $('#balance').val();
      console.log('balance', balance);
      //tx_fee = $('#tx_fee').val();
      if (parseFloat(amount) < parseFloat(balance)){
        $('#withdraw_form').submit();
      } else {
        alert('Your balance is not enough for this transaction!');
      }
    }
  </script>
  <script type="text/javascript">

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
