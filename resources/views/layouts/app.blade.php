<!DOCTYPE html>
<html>
<head>

  <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Mncenter</title>

  <!-- Bootstrap Core CSS -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <link rel="shortcut icon" href="/img/fav-icon.png">

  <!-- Custom CSS -->
  <link href="/css/style.css" rel="stylesheet">

  <link href="/css/flexslider.css" rel="stylesheet">
  <link href="/css/responsiv.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="/assets/vendor/datatables/media/css/dataTables.bootstrap4.css" />
  <link rel="stylesheet" href="/assets/vendor/morris/morris.css" />
  <link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
  <link rel="stylesheet" href="/assets/vendor/chartist/chartist.min.css" />
  <!-- jQuery -->
  <script src="/js/jquery.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> -->

  <!-- Bootstrap Core JavaScript -->
  <script src="/js/bootstrap.js"></script>

  <!-- Plugin JavaScript -->
  <script defer src="/js/jquery.flexslider.js"></script>


  <script src="/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>
  <script src="/assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="/assets/vendor/flot/jquery.flot.js"></script>
  <script src="/assets/vendor/flot.tooltip/flot.tooltip.js"></script>
  <script src="/assets/vendor/flot/jquery.flot.pie.js"></script>
  <script src="/assets/vendor/flot/jquery.flot.categories.js"></script>
  <script src="/assets/vendor/flot/jquery.flot.resize.js"></script>
  <script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/assets/vendor/chartist/chartist.js"></script>
  <script src="/js/jquery.qrcode.min.js"></script>

  <script src="/js/main.js"></script>
</head>

<body >
  <!--Start Header-->
  <div id="page-top" data-scrollreveal="enter fadeIn over 0.1s after 0.1s" >
    <!--Start Header-->
    <header class="topheader">
      <nav class="navbar navbar-default">

        <div class="head-top">
          <div class="container">
            <ul class="header-num">
              <!-- <li><i class="fas fa-phone"></i> +91 123 456 7890</li> -->
              <li><i class="far fa-envelope"></i>  info@Mncenter.co</li>
            </ul>
          </div>
        </div>
        <div class="header-bottom">
          <div class="container">
            <div class="logo col-md-4">
              <a href="/"> <img src="/img/logo.png" alt="Snippet-logo" style="height:55px"></a>
            </div>

            <div class="nav-main col-md-8">
              <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>


              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li><a class="page-scroll" href="/home">Home</a></li>
                  <li><a class="page-scroll" href="/faq"> FAQ</a></li>
                  <li><a class="page-scroll" href="/masternodes">MasterNodes</a></li>
                  @if (!Auth::guest())
                  <li><a class="page-scroll" href="/balances">Balances</a></li>
                  <li><a class="page-scroll" href="/videos">Videos</a></li>
                  @endif
                  <li class="dropdown header-dropdown">
                    @if (!Auth::guest())
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i style="margin-right:6px;" class="far fa-user"></i>{{Auth::user()->name}}<b class="caret"></b></a>
                    @else
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i style="margin-right:6px;" class="far fa-user"></i>Account <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu header-dropdown-menu">
                      @if (!Auth::guest())
                      <li><a href="/deposit_history">Deposit History</a></li>
                      <li><a href="/withdrawal_history">Withdrawal History</a></li>
                      <li><a href="/reward_history">Reward History</a></li>
                      <li><a href="/user_settings">User settings	</a></li>
                      <li><a href="/2fa">Security setting</a></li>
                      <li><a href="#" onclick="Logout(event)">Logout</a></li>
                      @else
                      <li><a href="/login">Sign in</a></li>
                      <li><a href="/register">Register</a></li>
                      @endif
                    </ul>
                  </li>
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </nav>


    </header>

    @yield('content')
    <!--Start Part-5-->
    <!--Start Footer-->
    <footer>
      <style>
      .terms{
        color:#a4a3a3;
      }
      .terms:hover{
        color:#fff;
        cursor: pointer;
      }
      </style>
      <div class="container">
        <p class="copy">Copyright 2018 | All rights reserved. </p>
        <p style="text-align:center;display:inline; width:258px; left:50%; margin-left:-330px;position:relative"><a href="/terms" class="terms" >Terms and conditions</a> | <a href="/policy" class="terms" >Privacy Policy.</a> </p>
        <ul class="fooyet-social">
<<<<<<< HEAD
          <li> <a href="https://www.facebook.com/MNcenter-356799748397050/"><i class="fab fa-facebook-f"></i></a></li>
          <li> <a href="https://discord.gg/6M5DZf"><i class="fab fa-discord"></i></a></li>
=======
          <li> <a href="#"><i class="fab fa-facebook-f"></i></a></li>
          <li> <a href="#"><i class="fab fa-twitter"></i></a></li>
          <li> <a href="#"><i class="fab fa-linkedin-in"></i></a></li>
          <li> <a href="#"><i class="fab fa-google-plus-g"></i></a></li>
          <li> <a href="#"><i class="fab fa-youtube"></i></a></li>
>>>>>>> 7a4e851b96054207ef56cee2b4b89b1044712c7e
        </ul>
        <div class="clearfix"></div>
      </div>
    </footer>
  </body>
  <script>
  function Logout(e) {
    e.preventDefault();
    document.getElementById('logout-form').submit();
  }

  function detectmob() {
    console.log(window.innerWidth, window.innerHeight);
     if(window.innerWidth <= 800) {
       return true;
     } else {
       return false;
     }
  }

  $('.navbar-toggle').click(function(){
    console.log('toggle');
    if (detectmob()){
      setTimeout(function(){
        $('.header-dropdown').removeClass('open').addClass('open');
      }, 100);
    }
  });
  </script>
  </html>
