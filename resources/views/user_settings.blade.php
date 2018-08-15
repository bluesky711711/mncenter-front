@extends('layouts.app')

@section('content')


<div class="inner-banner">
  <div class="container">
    <h3>User Settings</h3>
  </div>
</div>



<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">

    <div class="col-md-6">
      <div class="set-box">
        <form action="" method="get">
          <label>Nickname</label>
          <input type="text" class="form-control">

          <label>Discord Username</label>
          <input type="text" class="form-control">

          <button class="btn setbtn">Save</button>
        </form>
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="set-box">
        <div class="ref-head">Referral Information</div>
        <div class="accent-bg"></div>
        <ul>
          <li><span>Code:</span>referral-{{$user->id}}</li>
          <li><span>Referred:</span>0</li>
          <li><span>Earnings:</span>0.0%</li>



        </ul>
        <div class="clearfix"></div>
      </div>
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
