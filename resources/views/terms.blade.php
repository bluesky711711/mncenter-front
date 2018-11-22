@extends('layouts.app')

@section('content')

<div class="inner-banner">
  <div class="container">
    <h3>Terms and Conditions</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">

    <h4 class="main-head">Terms of Service </h4>

    <section class="faq-det">
      <div class="container">
        This website ("site") is operated by Wealtheagleadverts LTD ("we", "us" or "our"). Your use of this site is governed by these terms of use. By accessing and browsing this site you agree to be bound by these terms of use. We make this site available to you to in order to provide information about our services. We reserves the right to change or modify these Terms at any time and in our sole discretion. If we makes changes to these Terms, we will provide notice of such changes, such as by sending you a notification, providing notice through the Services, and/or updating the "Last Updated" date at the top of these Terms. Your continued use of the Services will confirm your acceptance of the revised Terms. If you do not agree to the amended Terms, you must stop using the Services.
      </div>
    </section>

    <h4 class="main-head">Intellectual Property Rights </h4>

    <section class="faq-det">
      <div class="container">
        All intellectual property on this site, including without limitation any trademarks, text, graphics (except coin logos) and copyright, is owned by us or our content suppliers. We are the exclusive owner of all rights in the compilation, design and layout of this site.
      </div>
    </section>

    <h4 class="main-head">Right to Use Site and Content </h4>

    <section class="faq-det">
      <div class="container">
        You may use this site only for the purposes for which it is provided. You must not use this site for fraudulent or other unlawful activity or otherwise do anything to damage or disrupt this site. Multiple accounts for the purpose of defrauding, circumventing bans, soliciting or abusing MNCenter.online services will result in immediate termination of all related accounts, including seizure of all on-site digital property. If you need to open another account please contact info@mncenter.online so that previous account can be deactivated or deleted.
      </div>
    </section>

    <h4 class="main-head">Your Information </h4>

    <section class="faq-det">
      <div class="container">
        You are responsible for maintaining the confidentiality of your account and password and for preventing unauthorized access to your account. You agree to accept responsibility for all activities that occur under your account or password. You should take all necessary steps to ensure that your password is kept confidential and secure and should inform us immediately if you have any reason to believe that your password has become known to anyone else, or if the password is being, or is likely to be, used in an unauthorized manner.
      </div>
    </section>

    <h4 class="main-head">Liability </h4>

    <section class="faq-det">
      <div class="container">
        We will not be liable for any damages, losses or expenses, or indirect losses or consequential damages of any kind, suffered or incurred by you in connection with your access to or use of this site or the content on or accessed through it. MNCenter.online is not responsible for potential losses caused by wallet fork conditions, outages or hardware failure.
      </div>
    </section>

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
    // $(function(){
    // SyntaxHighlighter.all();
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
