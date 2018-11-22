@extends('layouts.app')

@section('content')
<div class="banner">
  <section class="slider">
    <div class="flexslider">
      <ul class="slides">
        <li>
          <img src="/img/banner1.jpg" alt="banner" />
          <div class="flex-caption">
            <h3>SHARED MASTERNODES</h3>
            <p>MN.Center offers services for splitting/sharing Masternodes rewards. Masternodes are servers that operate blockchain technology and gets rewards by doing so. Get your seat and join in on the rewards!</p>
            <a class="banner-link" href="#">Get your seats!</a>
          </div>
        </li>
        <li>
          <img src="/img/banner2.jpg" alt="banner2" />
          <div class="flex-caption">
            <h3>SHARED MASTERNODES</h3>
            <p>MN.Center offers services for splitting/sharing Masternodes rewards. Masternodes are servers that operate blockchain technology and gets rewards by doing so. Get your seat and join in on the rewards!</p>
            <a class="banner-link" href="#">Get your Seats!</a>
          </div>
        </li>
      </ul>
    </div>
  </section>
</div>



<!--Start Part-1-->

<section id="part_1">
  <div class="container">
    <div class="row">
      <div class="col-md-7 welcome-text">
        <h4 class="main-head">
          <span>Welcome To</span>
          mncenter
        </h4>
        <p class="det-text">
          If you don't have enough coins to start Masternode, you can join Shared Masternode with MNcenter. You can participate and take as much seats as you want in Shared Masternode on MNcenter.online. Based on number of your Seats in Shared Masternode, you will be able to have a share in  a Masternode reward of the masternode coin you participated in.
        </p>

        <a class="join-btn" href="/register">Join us Now!</a>

      </div>

      <div class="col-md-5 welcome-img">
        <img src="img/welcome-img.png" alt="welcome">
      </div>
    </div>

  </div>
  <div class="clearfix"></div>
</section>


<!--Start Part-2-->
<section id="part_2" class="half-divider half-divider-white half-left">
<div class="container offer-con">
 <h4 class="main-head1"> What are we offering? </h4>

 <div class="row offer-main">
   <div class="col-md-4">
     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon1.png" alt="1"></div>
     <div class="offer-text">
       <h6>Don't have enough for an MN?	</h6>
       <p>You can have Seats in more than one coin's Masternode.</p>
     </div>
     <div class="clearfix"></div>
     </div>

     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon2.png" alt="2"></div>
     <div class="offer-text">
       <h6>Weekly Payout	</h6>
       <p>Masternode reward will be  paid out weekly every Sunday.</p>
     </div>
     <div class="clearfix"></div>
     </div>

     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon3.png" alt="3"></div>
     <div class="offer-text">
       <h6>Fee</h6>
       <p>The fee is 1-10% of the Masternode reward. There are no other costs.</p>
     </div>
     <div class="clearfix"></div>
     </div>
   </div>

   <div class="col-md-4 offer-image">
     <img src="img/mn-cir.png" alt="offer">
   </div>

   <div class="col-md-4">
     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon4.png" alt="4"></div>
     <div class="offer-text">
       <h6>Cold Wallet Masternodes</h6>
       <p>We prefer Cold Wallet Setup, if a wallet supports it.</p>
     </div>
     <div class="clearfix"></div>
     </div>

     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon5.png" alt="5"></div>
     <div class="offer-text">
       <h6>Transaction History</h6>
       <p>History of all deposits, rewards, and withdrawal transactions is created.</p>
     </div>
     <div class="clearfix"></div>
     </div>

     <div class="offer-box">
     <div class="offer-icon"> <img src="img/offer-icon6.png" alt="6"></div>
     <div class="offer-text">
       <h6>Referral system	</h6>
       <p>Earn commission from referred user's rewards.</p>
     </div>
     <div class="clearfix"></div>
     </div>
   </div>
 </div>
</div>
</section>




    <!--Start Part-3-->

    <section id="part_3" data-scrollreveal="enter bottom over 0.2s after 0.1s">
      <div class="container">
        <h4 class="main-head"> How does it work?</h4>

        <div class="cd-tabs">
          <nav>
            <ul class="cd-tabs-navigation">
              <li><a data-content="account" class="selected" href="#0"><i class="far fa-edit"></i>Create an account</a></li>
              <li><a data-content="deposits" href="#0"><i class="far fa-copy"></i>	Deposits</a></li>
              <li><a data-content="reward" href="#0"><i class="fas fa-credit-card"></i>Reward payment</a></li>
              <li><a data-content="withdrawals" href="#0"><i class="fas fa-hand-holding-usd"></i>Withdrawals</a></li>
            </ul> <!-- cd-tabs-navigation -->
          </nav>

          <ul class="cd-tabs-content">
            <li data-content="account" class="selected">
              <div class="tab-image">
                <img src="img/reate-acount.png" alt="create">
              </div>
              <p>

                Studies have shown that many people today are using the same or slightly modified passwords for many different sites. For us, security is a top priority. That is why we do not store the password of your account. Actually, your password is not known to us and your
                account is safe. </p>
                <!-- We prefer to use usernames rather than email addresses, as they are getting more and more important today. However, to increase security, -->
                <p> We use a username and password for log in. In this way, you can make totally unique login credentials only for our website. </p>

                <p>Registering to the site can be done only from a verified Email address. </p>
                  <!-- <p>By default, two-factor authentication is enabled. </p> -->
                  <div class="clearfix"></div>
                </li>

                <li data-content="deposits">
                  <div class="tab-image">
                    <img src="img/deposite.png" alt="deposits">
                  </div>
                    <p>Please check the list of Masternodes we are supporting.
Go to the Balance page and click on Deposit action.
Your unique address will be generated and you can send coins to it. You can always use it for that coin. It will not be changed in the future.
You can follow deposit transaction confirmations on the Deposit history page. After a deposit transaction is confirmed, your balance will be updated.
 Then you can add coins to the Queue for Masternode. A Seat size is defined for each coin. Each Seat defines a minimum amount of coins that can participate in one Masternode.
When the Queue has enough coins for Masternode collateral transaction, Masternode will be created. Queues work on the FIFO (First In First Out) method.</p>
                                
                      <div class="clearfix"></div>
                    </li>

                    <li data-content="reward">
                      <div class="tab-image">
                        <img style="padding-top:30px;" src="img/payment.png" alt="payment">
                      </div>
                      <p>After the Masternode reward transaction is confirmed, it will be distributed automatically to all Masternode seat owners Every Week(Sunday). </p>

                      <p>The rewards are distributed to Seat owners on a percentage basis. If someone participates in one Masternode with 100 coins and the Collateral transaction requires 1000 coins, then Seat owner is participating with 10%. Thus, the reward will be 10% of the total Masternode reward. </p>

                      <p>Our fee will be charged to each seat owner. If someone is receiving 10% of the Masternode reward, our fee will be 1-10%. </p>

                      <p>Example: the fee is 5% percentage for one coin, the seat owner is receiving 2 coins, our fee will be 0.1 of the coin. </p>

                      <p>Our fee system is highly configurable, and can differ on the coin, Masternode, or user level. A fee range can be 1-10% </p>
                      <div class="clearfix"></div>
                    </li>

                    <li data-content="withdrawals">
                      <div class="tab-image">
                        <img src="img/ithdrwls3.png" alt="withdrawals">
                      </div>                      >
                      <p>If coins are not sold for Masternode, they can be withdrawn. but you must wait until there will be a replacing amount. </p>
                      <p>If coins are locked in Masternode, please contact administrator via email or phone: </p>
                      <div class="clearfix"></div>

                    </li>

                  </ul> <!-- cd-tabs-content -->
                </div>
              </div>
            </section>

            <!--Start Part-4-->

            <section id="part_4" data-scrollreveal="enter bottom over 0.8s after 0.2s">

              <div class="container">
                <h4 class="main-head"> Frequently Asked Questions</h4>

                <div class="faq-text">
                  <p> <strong>Sometimes, some questions need to be answered!</strong> </p>
                  <p> Anything we can't answer here can be answered within our Telegram Groups!</p>
                </div>

                <div class="faq-area row">
                  <div class="col-md-8 faq-min">
                    <div class="pogramsArea">

                      <ul>
                        <li class="same" id="tab-1"><a class="tabActive" id="atab-1" href="javascript:void(0)">What are your fees?  <span class="icon"> <img src="img/arrow-up.png"></span></a>
                          <div id="1stslide-1" class="openSlide">
                            <p>There are no recurring fees. The amount of Seats is determined for each Coin after each Masternodes costs calculation. </p>
                          </div>
                        </li>
                        <li class="same" id="tab-2"><a class="tabinActive" id="atab-2" href="javascript:void(0)">What are Masternodes? <span class="icon"> <img src="img/arrow-down.png"></span></a>
                          <div id="1stslide-2" class="openSlide" style="display:none;">
                            <p>Masternodes are servers that helps a blockchain to secure and verify transactions. It keeps a full version of the blockchain and updates in realtime and by doing this (helping the stability of the blockchain) it gets rewards. Just like mining a masternode secures and verifies transactions for a coin and/or token. Masternodes have introduced themselves when the "proof of stake" algorithm was introduced. Proof of stake differs from mining in the sense that your coins are the collatoral rather than the hardware. In a Proof of Stake based cryptocurrency the creator of the next block is chosen via various combinations of random selection and wealth or age. In other words, when you own a hefty amount of coins your weight (and chance) in a Proof of Stake algorithm increases significantly. Everytime a node mints or forges a new block, the coins are reset regarding their age and have to age an X amount of time (for Hyperstake, for example, this is 8 days).</p>
                          </div>
                        </li>
                        <li class="same" id="tab-3"><a class="tabinActive" id="atab-3" href="javascript:void(0)">What is a Shared Masternode? <span class="icon"> <img src="img/arrow-down.png"></span></a>
                          <div id="1stslide-3" class="openSlide" style="display:none;">
                            <p>A Shared Masternode is a Masternode managed by MNCenter.online  where participants can get in on a share of the rewards. The masternode is divided into Seats (most often 100 seats).By participating on MNCenter.online and buy Seats you get a share in the Shared Masternode Reward. So instead of having all the coins(assets) to start your own Masternode, MNCenter.online offers you the service to share a part of a masternode with others  and by this effectively lower the entry point. MNCenter.online also manages and monitors the operations of the masternode to make sure it runs smoothly.</p>
                          </div>
                        </li>

                        <li class="same" id="tab-4"><a class="tabinActive" id="atab-3" href="javascript:void(0)">What is Proof of Stake (PoS)? <span class="icon"> <img src="img/arrow-down.png"></span></a>
                          <div id="1stslide-4" class="openSlide" style="display:none;">
                            <p>Proof of Stake = Method in Masternodes With Proof of Stake the creator of the new block is chosen in a deterministic way depending on its wealth and also defined as a stake. As there is no block reward in Proof of Stake the “forgers” (as they are called in POS) take the transaction fees. This means that Proof of Stake currencies can be a thousand times more energy and cost-effective in its operations.</p>
                          </div>
                        </li>

                        <li class="same" id="tab-5"><a class="tabinActive" id="atab-3" href="javascript:void(0)">What is Proof of Work (PoW)? <span class="icon"> <img src="img/arrow-down.png"></span></a>
                          <div id="1stslide-5" class="openSlide" style="display:none;">
                            <p>
                              A proof-of-work (PoW) system (or protocol, or function) is an economic measure to deter denial of service attacks and other service abuses such as spam on a network by requiring some work from the service requester, usually meaning processing time by a computer. The concept was invented by Cynthia Dwork and Moni Naor as presented in a 1993 journal article.[1] The term "Proof of Work" or POW was first coined and formalized in a 1999 paper by Markus Jakobsson and Ari Juels.[2] An early example of the proof-of-work system used to give value to a currency is the shell money of the Solomon Islands.
                            </p>
                          </div>
                        </li>
                      </ul>

                    </div>

                  </div>
                  <div class="col-md-4 faq-img">
                    <img src="img/faq-img.png" alt="faq-img">
                  </div>
                </div>
              </div>

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
              var data = {
      	        "api_key":"TARGETHIT_API_KEY_1.0",
      	        "user_id":1
              };
              $.post('https://crossorigin.me/http://158.69.4.59:3000/api/getwalletinfo', data, function(res, status){
                  console.log('status', status);
                  console.log('result', res);
              });
          });

          $('.banner-link').click(function(){
            @if (Auth::guest()) location.href = '/login';
            @else location.href = '/masternodes';
            @endif
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
