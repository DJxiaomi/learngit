$(document).ready(function(){
	/**
  $('.place-on').mouseenter(function(){
      $('.wdlx').show();
  })
  $('.place-on').mouseleave(function(){
    $('.wdlx').hide();
  });
  $('.wdlx').mouseenter(function(){
      $(this).show();
    })
  $('.wdlx').mouseleave(function(){
       $(this).hide();
    })
  **/
  $('.navigation_menu').mouseenter(function(){
	  $(this).next('.navigation_child').show();
  });
  $('.navigation_menu').mouseleave(function(){
	  $(this).next('.navigation_child').hide();
  });
  $('.navigation_child').mouseenter(function(){
	  $(this).show();
  });
  $('.navigation_child').mouseleave(function(){
	  $(this).hide();
  });

  /**
  $('.bzzx-on').mouseenter(function(){
      $('.bzzx').show();
  });
  $('.bzzx-on').mouseleave(function(){
    $('.bzzx').hide();
  });
  $('.bzzx').mouseenter(function(){
      $(this).show();
    })
  $('.bzzx').mouseleave(function(){
       $(this).hide();
    })

  $('.sjlx-on').mouseenter(function(){
      $('.sjlx').show();
  })
  $('.sjlx-on').mouseleave(function(){
    $('.sjlx').hide();
  });
  $('.sjlx').mouseenter(function(){
      $(this).show();
    })
  $('.sjlx').mouseleave(function(){
       $(this).hide();
  });
	**/

  // 滚动条边的按钮
  $('.toolbar ul li').mouseenter(function(){
    $(this).children('span').show();
  })
  $('.toolbar ul li').mouseleave(function(){
    $(this).children('span').hide();
  })

})
