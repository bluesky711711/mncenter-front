@extends('layouts.app')

@section('content')

<!--End Header-->

<div class="inner-banner">
  <div class="container">
    <h3>Education Videos</h3>
  </div>
</div>


<style>
.align-left .video-title{
  text-align:left;
}
.align-left .video > iframe{
  float:left;
}

.align-right .video-title{
  text-align:right;
}
.align-right .video > iframe{
  float:right;
}
.row.align-left, .row.align-right{
  padding-top:50px;
}
</style>
<!--Start Part-1-->

<section id="part_1" style="min-height:600px">
  <div class="container">
    <?php
      $i = 0;
      foreach($videos as $video) {
      $i++;
    ?>
    <div class="row @if ($i % 2 == 1) align-left @else align-right @endif" style="@if ($i == 1) padding-top:30px @endif">
      <div class="video-title col-sm-12" style="font-size:25px">{{$video->title}}</div>
      <div class="video col-sm-12" style="padding-top:20px">
        <iframe width="560" height="315" src="{{$video->link}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    </div>
  <?php } ?>
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
