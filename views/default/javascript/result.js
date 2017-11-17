$(document).ready(function() {

    $(".show_list").find(".every:last").css("margin-right", " 0px");
    $(".assure").find("li:last").css("margin-right", " 0px");

    $(".site-user li:not(.no-select)").mouseenter(function() {
        $(this).addClass("on");
        $(this).children(".nav_dropdown").show();
    });
    $(".site-user li").mouseleave(function() {
        $(this).removeClass("on");
        $(this).children(".nav_dropdown").hide();
    });

    $('.appointment .select').mouseleave(function () {
        $('.dropdown-menu').hide();
    });

    //首页 动态显示老师的更多信息
    $(".show_list .every").mouseover(function() {
        $(this).data('mo', true);
        if ($(this).data('rmo') == true) {
            return;
        }
        $(this).data('rmo', true);
        $(this).find(".t_data .Speech").show();
        $(this).find(".t_data").animate({
                top: '76px',
                height: '124px'
            },
            'normal');
    });
    $(".show_list .every").mouseout(function() {
        $(this).data('mo', false);
        var me = $(this);
        setTimeout(function() {
                if (me.data('mo') == true || me.data('rmo') != true) {
                    return;
                }
                me.data('rmo', false);
                me.find(".t_data").stop(true, true);
                me.find(".t_data .Speech").hide();
                me.find(".t_data").animate({
                        top: '144px',
                        height: '56px'
                    },
                    'normal');
            },
            100);
    });

    //首页"请他教怎么样？你说了算..."滚屏
    var num = $(".comm_list").find("li").length;
    var nowPage    = 1;
    var totalPage  = Math.ceil(num / 2);
    var comm_box_w = $('.comm_list li').outerWidth();
    var pageWidth  = 1216;
    $('.comm_list').width(comm_box_w * num);
    $("#comm_prev").click(function() {
        nowPage--;
        if (nowPage < 1) {
            nowPage = totalPage;
        }
        $(".comm_list").animate({
            left: -pageWidth * (nowPage - 1)
        });
    });
    $("#comm_next").click(function() {
        nowPage++;
        if (nowPage > totalPage) {
            nowPage = 1;
        }
        $(".comm_list").animate({
            left: -pageWidth * (nowPage - 1)
        });
    });

    //首页菜单 动态显示二级菜单
    var is_leave = false;
    $(".all_sort li").mouseenter(function() {
        is_leave = false;
        $(".sort_list_box").show();
        $(this).addClass("on").siblings().removeClass();
        $(".sort_list_box > ul").hide().eq($('.all_sort li').index(this)).show();
    });

    $(".all_sort li").mouseleave(function() {
        is_leave = true;
        setTimeout(function() {
                if (is_leave) {
                    $(".all_sort li").removeClass("on");
                    $(".sort_list_box").hide();
                }
            },
            100);
        $(".sort_list_box").mouseenter(function() {
            is_leave = false;
        });
        $(".sort_list_box").mouseleave(function() {
            is_leave = true;
            $(".all_sort li").removeClass("on");
            $(".sort_list_box").hide();
        });
    });

    //教师列表仿复选框
    $(".check_list a").click(function() {
        var on = $(this).hasClass("on");
        if (on == true) {
            $(this).removeClass("on");
        } else {
            $(this).addClass("on");
        }
    });

    //教师列表筛选下拉框
    $(".dropdown .bt").mouseenter(function() {
        $(this).parent(".dropdown").css({
            "background": "#ffffff",
            "border-top": "1px solid #eeeeee"
        });
        $(this).siblings(".down").show();
    });

    $(".dropdown").mouseleave(function() {
        $(this).css({
            "background": "#ffffff",
            "border-top": "none"
        });
        $(this).children(".down").hide();
    });


    //登录
    $(".login .tab li:first").css("border-right", "1px solid #dcdcdc");
    $(".login .tab li").click(function() {
        $(this).addClass("on").siblings().removeClass();
        $(this).find('input[type="radio"]').attr('checked', 'checked');
    });

    $(".inputtxt input").focus(function() {
        $(this).css("color", "#646464");
        $(this).parents("li").addClass("on");
    });
    $(".inputtxt input").blur(function() {
        $(this).parents("li").removeClass("on");
    });
    //教师列表全部分类隐藏显示
    $("#show_sort").hover(function() {
        // $(".show_sort").show();
    });
    $(".page-header,.allMenu").hover(function () {
        if($('.allgroup').hasClass('index') == false){
            $(".show_sort").hide();
        }
    });

    $(".show_sort").mouseleave(function() {
        if($(this).hasClass('index') != false){
            $(this).hide();
        }
    });

    $(".btn-default").click(function(){
        $(this).siblings("ul").show();
    });
    $(".dropdown-menu a").click(function(){
        $(this).parent().parent().find('li').removeClass('active');
        $(this).parent().addClass('active');
        var btn = $(this).parents("ul").siblings("a.btn-default");
        var tagetId = btn.data('target');
        btn.text($(this).text());
        $('#'+tagetId).val($(this).data('value'));
        $(this).parents("ul").hide();
        //如果是选择授课方式，则将更新老师科目价格
        if($(this).hasClass('teaching_mode_one')){
            $('.subject_price').text($(this).attr('data-price'));
        }
    });

    $(".tab-nav-default a").last().css("border-right","none");

    $(".dropdown-reg .active a").click(function(){
        $(this).parents("ul").siblings("a.btn-default").text($(this).text());
        $(this).parents("ul.dropdown-reg").hide();
        });

    $(".btn-down").click(function(){
        $(this).siblings("ul").show();
    });
    $(".dropdown-list li").click(function(){
        var btn = $(this).parents("ul").siblings(".btn-down");
        var tagetId = btn.data('target');
        btn.text($(this).text());
        $('#'+tagetId).val($(this).data('value'));
        $(this).parents("ul.dropdown-list").hide();
    });
    $(".Edit").click(function(){
        if($(this).text() == '取消'){
            title = $(this).attr('title');
            title = title ? title : '编辑';
            $(this).parents("h2").siblings(".box").show();
            $(this).parents("h2").siblings(".form-baseinfo").hide();
            $(this).text(title);
        }else{
            $(this).parents("h2").siblings(".box").hide();
            $(this).parents("h2").siblings(".form-baseinfo").show();
            $(this).text('取消');
        }
    });
    $(".btn-cancel").click(function(){
        $(this).parents(".info").children(".box").show();
        $(this).parents(".info").children(".form-baseinfo").hide();
    });

    $(".teaching_mode_list li").on('click','li',function(){
        //如果是选择授课方式，则将更新老师科目价格
        $('.subject_price').text($(this).attr('price'));
    });
    //通用下拉选择，点击显示下拉选择内容
    $('.form-select .selected-name').click(function () {
        $(this).next('ul').show();
        $(this).next('ul').width($(this).outerWidth());
    })
    //通用下拉选择，选择下拉选中项，进行相关操作
    $('.form-select ul li').click(function () {
        var value = $(this).attr('value');
        var val   = $(this).attr('val');
        var text  = $(this).text();
        var price = $(this).attr('price');
        val = value ? value : (val ? val : value);

        $(this).parent().parent().find('input').val(val);
        $(this).parent().parent().find('ul').hide();
        $(this).parent().parent().find('.selected-name .label').text(text);
        $(this).parent().parent().find('ul li').removeClass('selected');
        $(this).addClass('selected');
        $('.subject-price strong').html(price);

        $('input[name=id]').val(val);
    });
    //通用下拉选择，鼠标离开隐藏下拉框
    $('.form-select').mouseleave(function () {
        $(this).find('ul').hide();
    });

    //约课
    $('.btn-zx').click(function(){
      var _id = $('input[name=id]').val();
      if ( _id == '')
      {
        layer.alert('请选择科目');
      } else {
        num = $("input[name=num]").val();
        num = (num > 0 ) ? num : 1;
        location.href = '/simple/cart2/num/' + num + '/statement/4/seller_tutor_id/' + _id;
      }
    })
});
