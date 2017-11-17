jQuery(".LoginBox").slide();
jQuery(".focusBox").slide( { mainCell:".bd ul",autoPlay:true, delayTime:0} );
jQuery(".ConGC-ListBox").slide();
jQuery(".footerUp-main").slide();
$(function(){
  $('.sidebar-list li').mouseenter(function(){
    $(this).parent().find("li").removeClass('active');
    $(this).addClass('active');
  })

    $('.conA-right ul li').mouseenter(function(){
        $(this).children('.blank-tit').show();
      })
    $('.conA-right ul li').mouseleave(function(){
        $(this).children('.blank-tit').hide();
      })
});
