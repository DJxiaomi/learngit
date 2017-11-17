var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    loop: true,
    autoplay: 3000
});

Lx.common.lazyload();
$(function(){
	var left = ($(window).width() - 1200) / 2;
	$('.cattree').css('left', left).show();

  var pos = {
      left: {
          top: '0',
          left: '-100%'
      },
      right: {
          top: '0',
          left: '100%'
      },
      bottom: {
          top: '100%',
          left: '0'
      },
      top: {
          top: '-100%',
          left: '0'
      }
  };
  $('.schoolbox').each(function () {
      new MouseDirection(this, {
          enter: function ($element, dir) {
              var $content = $element.find('.schoolmc').removeClass('trans');
              $content.css(pos[dir]);
              $content[0].offsetWidth;
              $content.addClass('trans');
              $content.stop().animate({left: '0', top: '0'}, 200);
          },
          leave: function ($element, dir) {
              $element.find('.schoolmc').stop().animate(pos[dir]);
          }
      });
  });

  $('.side-box li').mouseover(function(){
    $(this).parent().find("li").removeClass('active');
    $(this).addClass('active');
  });

  $('.Title .t-right li').hover(function(){
    $(this).parent().find('li').removeClass('active');
    $(this).addClass('active');
    var _index = $(this).index();
    $(this).parent().parent().parent().parent().find('.conbox-top').hide();
    $(this).parent().parent().parent().parent().find('.conbox-top').eq(_index).show();

    var _parent_left = $(this).parent().offset().left;
    var _left = $(this).offset().left - _parent_left;
    var _width = $(this).width() + 32;
    $(this).parent().parent().find('.active_bg').css('left', _left);
    $(this).parent().parent().find('.active_bg').css('width', _width);
  }, function(){});

  $('.conbox-top li').hover(function(){
    $(this).addClass('active');
  }, function(){
    $(this).removeClass('active');
  });

  $('.Title .t-right .active_bg').each(function(i){
    var _width = $(this).parent().find('li').eq(0).width();
    _width = _width + 32;
    $(this).css('width',_width);
  })

  $('.cattree').find('.catbox').on({
    mouseenter:function(){
      var cid = $(this).data('id')
        ,index = $(this).index()
        ,newArr = []
        ,str = '';
      for(var v in catlist){
        if(cid == catlist[v]['id']){
          newArr = catlist[v]['child'];
          break;
        }
      }
      for(var i=0 ; i < newArr.length ; i++ )
      {
        str += '<dl class="level_item">';
        str += '<dt><a href="' + caturl + '?cat=' + newArr[i]['id'] + '">' + newArr[i]['name'] + ' ></a></dt>';
        for(var j=0 ; j < newArr[i]['child'].length ; j++)
        {
          str += '<dd><a href="' + caturl + '?cat=' + newArr[i]['child'][j]['id'] + '">' + newArr[i]['child'][j]['name'] + '</a></dd>'
        }
        str += '</dl>';
      }
      $('.second_level').attr('id','second_level_'+index).html(str).stop().animate({
        width:'700px',
        opacity:1,
      });
    },
    mouseleave:function(){
      $('.second_level').stop().animate({
        width:'0px',
        opacity:0,
      });
    }
  })
  $('.second_level').on({
    mouseenter:function(){
      $(this).stop();
    },
    mouseleave:function(){
      $(this).stop().animate({
        width:'0px',
        opacity:0,
      });
    }
  })
});
