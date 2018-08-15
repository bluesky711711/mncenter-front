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
        <a class="his-btn" href="/deposit_history">Deposite history</a>
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
        <a class="his-btn" href="/withdrawal_history">Withdraw</a>
        <a  class="clear" id="withdraw_close1" href="javascript:void(0)">Cancel</a>
      </div>
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

        <div class="mas-table">
          <table width="100%" border="0" class="table table-striped">
            <thead>
              <tr>
                <td width="8%">Action </td>
                <td width="14%">Coin </td>
                <td width="12%"> Total</td>
                <td width="17%"> In Queue </td>
                <td width="9%"> Available</td>
                <td width="6%">  Unconfirmed Deposit</td>
                <td width="7%">  Pending Withdraw </td>
                <td width="10%"> Pending Rewards </td>
                <td width="10%"> Paid Rewards</td>
                <td width="10%"> Commission Earnings </td>
              </tr>
            </thead>
            <tbody>
              @foreach ($coins as $coin)
              <tr>
                <td><div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <i class="fas fa-angle-down"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item depositcl" href="javascript:void(0)">Deposite</a>
                    <a class="dropdown-item withdrawcl" href="javascript:void(0)">Withdraw</a>
                    <a class="dropdown-item" href="/masternodes/coin/{{$coin->id}}">Show Masternodes</a>
                  </div>
                </div> </td>
                <td><a href="masternode-details.html"><img src="/img/{{$coin->coin_name}}.png" alt="icon"></a> {{$coin->coin_name}} ({{$coin->coin_symbol}})</td>
                <td>    	0.00000000 </td>
                <td>    		0</td>
                <td>    	     	0</td>
                <td>    	        	0.00000000</td>
                <td>    	            	0.00000000 </td>
                <td>    	               	0.00000000</td>
                <td>    	                    	0.00000000</td>
                <td>    	                            	0.00000000 </td>
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

      $(".depositcl").click(function(){
        $(".popup-overlay").css("display", "block");
        $("#dipositbox").fadeIn('slow');
      });

      $("#diposit_close").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#dipositbox").fadeOut('fast');
      });

      $("#diposit_close1").click(function(){
        $(".popup-overlay").css("display", "none");
        $("#dipositbox").fadeOut('fast');
      });

      $(".withdrawcl").click(function(){
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
