@extends('layouts.app')

@section('content')

<div class="inner-banner">
  <div class="container">
    <h3>Privacy Policy</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">

    <h4 class="main-head">MNCenter.online Privacy Policy</h4>
    <section class="faq-det">
      <div class="container">
        This web site is owned and operated by Wealtheagleadverts LTD("We", "our" and "us" ). This Privacy Policy applies to information we collect when you use our website("Service"). By using this site, you agree to the Internet Privacy Policy of this web site ("the web site"), which is set out on this web site page. We reserve the right, at our discretion, to modify or remove portions of this Privacy Policy at any time. We may change this Privacy Policy from time to time. If we make changes, we will notify you by revising the date at the top of the policy. We encourage you to review the Privacy Policy whenever you access the Services or otherwise interact with us to stay informed about our information practices and the ways you can help protect your privacy.
      </div>
    </section>

    <h4 class="main-head">Information You Provide to Us</h4>
    <section class="faq-det">
      <div class="container">
        We collect information you provide directly to us. For example, we collect information when you create an account. The types of information we collect include email address.
      </div>
    </section>

    <h4 class="main-head">Collecting Information for Users</h4>
    <section class="faq-det">
      <div class="container">
        We gather your IP addresses as part of our security protocol. User can log in to the web site only from registered IP addresses. Access time will also be logged. We use cookies to provide you with a better experience. These cookies allow us to increase your security by storing your session ID and are a way of monitoring single user access.
      </div>
    </section>

    <h4 class="main-head">Sharing of Information</h4>
    <section class="faq-det">
      <div class="container">
        Provided and collected information will not be shared to any third parties.
      </div>
    </section>

    <h4 class="main-head">Security</h4>
    <section class="faq-det">
      <div class="container">
        While no online or electronic system is guaranteed to be secure, we take maximum measures to help protect information about you from loss, theft, misuse and unauthorized access.
      </div>
    </section>
    <h4 class="main-head">Account Deactivation</h4>
    <section class="faq-det">
      <div class="container">
        If you wish to delete or deactivate your account, please email us at Info@mncenter.co  We may also retain archived copies of information about you for a certain period of time.
      </div>
    </section>
    <h4 class="main-head">Contact Us</h4>
    <section class="faq-det">
      <div class="container">
        If you have any questions about this Privacy Policy, please contact us at info@mncenter.co .
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
