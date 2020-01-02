(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 43)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });
// Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#rt_affix',
    offset: 46
  });  

/* copy loaded thumbnails into carousel */
$('.panel .img-responsive').on('load', function() {
  
}).each(function(i) {
  if(this.complete) {
    var item = $('<div class="item"></div>');
    var itemDiv = $(this).parent('a');
    var title = $(this).parent('a').attr("title");
    
    item.attr("title",title);
    $(itemDiv.html()).appendTo(item);
    item.appendTo('#modalCarousel .carousel-inner'); 
    if (i==0){ // set first item active
     item.addClass('active');
    }
  }
});

/**** Quality Button ****/
jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.pass_select input');
    jQuery('.pass_select').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });

/**** Quality Button ****/






/* activate the carousel */
$('#modalCarousel').carousel({interval:false});

/* change modal title when slide changes */
$('#modalCarousel').on('slid.bs.carousel', function () {
  $('.modal-title').html($(this).find('.active').attr("title"));
})

/* when clicking a thumbnail */
$('.panel-thumbnail>a').click(function(e){
  
    e.preventDefault();
    var idx = $(this).parents('.panel').parent().index();
    var id = parseInt(idx);
    
    $('#myModal').modal('show'); // show the modal
    $('#modalCarousel').carousel(id); // slide carousel to selected
    return false;
});



  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });
  $('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
  }, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
  });
 $('.nvbar').click(function(){
       $('.navbar-collapse').addClass('show');
       $('body').addClass('fixed');
   });
 $('.nvclose').click(function(){
       $('.navbar-collapse').removeClass('show');
       $('body').removeClass('fixed');
   });
 $('.search_icon').click(function(){
       $('.search_input').toggleClass('show');
       $('body').addClass('fixed');      
   }); 
  
 $('#rt_lodging_btn').click(function(){ 
       $('#rt_lodging').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#rt_gallery_btn').click(function(){ 
       $('#rt_gallery').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#rt_map_btn').click(function(){ 
       $('#rt_map').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#rt_review_btn').click(function(){ 
       $('#rt_review').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#rt_rooms_btn').click(function(){ 
       $('#rt_rooms').addClass('show');
       $('body').addClass('fixed');          
   });
 $('#rt_lodging_extra1_btn').click(function(){ 
       $('#rt_lodging_extra1').addClass('show');
       $('body').addClass('fixed');          
   });
 $('#rt_lodging_extra1_room_btn').click(function(){ 
       $('#rt_lodging_extra1_room').addClass('show');
       $('body').addClass('fixed');          
   });
 $('#rt_lodging_extra2_btn').click(function(){ 
       $('#rt_lodging_extra2').addClass('show');
       $('body').addClass('fixed');          
   });
 $('#rt_lodging_extra2_room_btn').click(function(){ 
       $('#rt_lodging_extra2_room').addClass('show');
       $('body').addClass('fixed');          
   });
$('#rt_car_btn').click(function(){ 
       $('#rt_car').addClass('show');
       $('body').addClass('fixed');          
   }); 
 $('#pkg_prc_btn').click(function(){ 
       $('#pkg_prc').addClass('show'); 
       $('body').addClass('fixed');         
   }); 

 $('.rt_close').click(function(){ 
       $('.rt_popup').removeClass('show');
       $('body').removeClass('fixed');        
  });

 /***** Accommodation Details ******/
 $('#accom_gallery_btn').click(function(){ 
       $('#accom_gallery').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#accom_ginfo_btn').click(function(){ 
       $('#accom_ginfo').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#accom_rooms_btn').click(function(){ 
       $('#accom_rooms').addClass('show');
       $('body').addClass('fixed');        
   }); 
 $('#accom_map_btn').click(function(){ 
       $('#accom_map').addClass('show');
       $('body').addClass('fixed');          
   });
 $('#accom_notes_btn').click(function(){ 
       $('#accom_notes').addClass('show');
       $('body').addClass('fixed');          
   });
 $('.accom_close').click(function(){ 
       $('.rt_popup').removeClass('show');
       $('body').removeClass('fixed');        
  });
   

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 56
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Accomm Detail ///
  $('#accom_opinion').click(function(){     
       $('#accom-form').toggle(); 
   });
   $('.bfmenu').click(function(){     
       $('.right-menu').toggle();  
   });
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);  
   $('.navbar .dropdown-item').on('click', function (e) {
        var $el = $(this).children('.dropdown-toggle');
        var $parent = $el.offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if (!$parent.parent().hasClass('navbar-nav')) {
            if ($parent.hasClass('show')) {
                $parent.removeClass('show');
                $el.next().removeClass('show');
                $el.next().css({"top": -999, "left": -999});
            } else {
                $parent.parent().find('.show').removeClass('show');
                $parent.addClass('show');
                $el.next().addClass('show');
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }
           // e.preventDefault();
            e.stopPropagation();
        }
    });

    $('.navbar .dropdown').on('hidden.bs.dropdown', function () {
      //  $(this).find('li.dropdown').removeClass('show open');
        $(this).find('ul.dropdown-menu').removeClass('show open');
    });
})(jQuery); // End of use strict
$(document).ready(function() {
$(".carousel").swipe({
  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

    if (direction == 'left') $(this).carousel('next');
    if (direction == 'right') $(this).carousel('prev');

  },
  allowPageScroll:"vertical"

});
$('.count').prop('readonly', true);
        $(document).on('click','.plus',function(){
        $('.count').val(parseInt($('.count').val()) + 1 );
        if ($('.count').val() == 6) {
             $(this).addClass('disabled');
        }
        });
          $(document).on('click','.minus',function(){
          $('.count').val(parseInt($('.count').val()) - 1 );
            if ($('.count').val() == 1) {
            $('.count').val(2);
            $(this).addClass('disabled');
          } else if ($('.plus').val() < 6){
           $('.plus').removeClass('disabled');
          } 
    });
$('.count_flight').prop('readonly', true);
        $(document).on('click','.plus',function(){
        $('.minus').removeClass('disabled');
        $('.count_flight').val(parseInt($('.count_flight').val()) + 1 );
        if ($('.count_flight').val() == 6) {
             $(this).addClass('disabled');
        }
        });
          $(document).on('click','.minus',function(){
          $('.count_flight').val(parseInt($('.count_flight').val()) - 1 );
            if ($('.count_flight').val() == 0) {
            $('.count_flight').val(1);
          } else if ($('.plus').val() == 6){
           $('.plus').removeClass('disabled');
          } 
    });
if($('input[name=pack_adult]').val()==1){
  $('input[name=pack_adult]').val(2)
}
$('.rt_child').prop('readonly', true);
        $(document).on('click','.plus1',function(){
        $('.minus1').removeClass('disabled');
        $('.rt_child').val(parseInt($('.rt_child').val()) + 1 );
        if ($('.rt_child').val() == 6) {
             $(this).addClass('disabled');
        } else if ($('.rt_child').val() == 0){
           $('.minus1').removeClass('disabled');
          } 
        });
          $(document).on('click','.minus1',function(){
          $('.rt_child').val(parseInt($('.rt_child').val()) - 1 );
            if ($('.rt_child').val() == 0) {
            $('.minus1').addClass('disabled');
            //$('.count').val(1);
          } else if ($('.plus1').val() < 6){
           //alert(1);
           $('.plus1').removeClass('disabled');
          } 
    });
$('.rt_infant').prop('readonly', true);
        $(document).on('click','.plus2',function(){
        $('.minus2').removeClass('disabled');
        $('.rt_infant').val(parseInt($('.rt_infant').val()) + 1 );
        if ($('.rt_infant').val() == 6) {
             $(this).addClass('disabled');
        } else if ($('.rt_infant').val() == 0){
           $('.minus2').removeClass('disabled');
          } 
        });
          $(document).on('click','.minus2',function(){
          $('.rt_infant').val(parseInt($('.rt_infant').val()) - 1 );
            if ($('.rt_infant').val() == 0) {
            $('.minus2').addClass('disabled');
            //$('.count').val(1);
          } else if ($('.plus2').val() < 6){
          //alert(1);
           $('.plus2').removeClass('disabled');
          } 
    });
/*whole box link*/
    $('body').on('click', '.rt-packframes', function(event) {
      var href=$(this).find('a').attr('href');
      window.location.href=href;
    });
    $('body').on('click', '.pkgflt_secc', function(event) {
      var href=$(this).find('a').attr('href');
      window.location.href=href;
    });

});
 $(document).ready(function(){
   $("#rt_warning").modal('hide');
   $('.show_more_review').on('click touchstart', function (){
     $(this).parent().addClass("show");
     $('.ranking-discription.show .show_more_review').hide(); 
     $('.ranking-discription.show .show_less_review').show();
    });
    $('.show_less_review').on('click touchstart', function () {
      $('.ranking-discription').removeClass("show");
      $('.ranking-discription .show_more_review').show();
      $('.ranking-discription .show_less_review').hide();
  });
  $('.notes_transaction').click( function(){
      $('.remarks_sect').toggleClass("show");
       $(this).text($(this).text() == 'הערות לעסקה'  ?  'סגירה' : 'הערות לעסקה');
  });
  $('.rt_active').click( function(){
  $('.daterangepicker_input').addClass("rt_actdiv");
  });
  
});
$('#date_popup_cont').scroll(function() { 
    var scroll = $('#date_popup_cont').scrollTop();
    if (scroll >= 40) {
        $('#date_popup_cont').addClass("cal_fix");
    }
    else 
    {
    $('#date_popup_cont').removeClass("cal_fix");
    }
});
$(document).ready(function(){
  $('.sf_src').on('click touchstart', function () {
      $('.search-sec').addClass("show");
       event.preventDefault();
      
  });
   $('.sf_close').on('click touchstart', function () {
     $('.search-sec').removeClass("show");
      event.preventDefault();
    
  });
 
});