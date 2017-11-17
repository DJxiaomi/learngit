<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->_siteConfig->name;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
			<?php if(!$this->back_url){?>
	    	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<?php }else{?>
				<style>
				.mui-icon-back:before, .mui-icon-left-nav:before {color: #fff;}
				</style>
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("/site/chit1");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_redpacket.css";?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<style>
.mui-pciker-list, .mui-pciker-rule {top:30%;}
</style>
<div class="mui-content-padded">
    <div class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-primary" style="border-bottom:1px solid #cdcdcd;">
        <a class="mui-control-item mui-active" id="3">
            未付款
        </a>
        <a class="mui-control-item" id="1">
            可使用
        </a>
        <a class="mui-control-item" id="2">
            已使用
        </a>
    </div>
</div>
<div id="proplist">
</div>


<div class="confirm_content">
  <div class="confirm">
      <div class="item">
        <label for="">学员姓名：</label>
        <input type="text" name="student_name" value=""/>
      </div>

      <div class="item">
        <label for="">联&nbsp;系&nbsp;&nbsp;人：</label>
        <input type="text" name="accept_name" value=""/>
      </div>
      <div class="item">
        <label for="">联系电话：</label>
        <input type="text" name="mobile" value=""/>
      </div>
      <div class="item confirm_submit">
        <input type="hidden" name="order_id" value=""/>
        <input type="hidden" name="url" value=""/>
        <input type="submit" value="确认"/>
      </div>
  </div>
</div>


<script type="text/javascript">

var userPicker = new mui.PopPicker({
  layer: 3
});
userPicker.setData(<?php echo isset($jsoncats)?$jsoncats:"";?>);

mui.ready(function(){
    getPropList(3);
    mui('.mui-control-item').each(function() {
        var type = this.getAttribute('id');
        this.addEventListener('tap', function(event) {
            getPropList(type);
        });
    });
});

function getPropList(type){
    $('#proplist').html('<div class="mui-content-padded">加载中...</div>');
    $.getJSON(SITE_URL + 'ucenter/ajaxredpacket', {type: type}, function(result){
        var html = '';
        for(var i = 0; i < result.num; i++){
            var json = result[i];
            var bool = true;
            if(bool){
                html += '<div class="mui-card">';
                //if(!json.chit_id){
                if( parseInt(json.chit_id) <= 0) {
                    html += '<div class="mui-card-header">' + json.goods.name + '</div>';
                }
                //if(!json.chit_id){
                if( parseInt(json.chit_id) <= 0) {
                    html += '<div class="mui-card-content">'+
                                '<ul class="mui-table-view">'+
                                    '<li class="mui-table-view-cell mui-media card-list-box">'+
                                        '<a href="' + SITE_URL + 'ucenter/order_detail/id/' + json.id + '">'+
                                            '<div class="mui-media-object mui-pull-left mui-media-object-' + type + '">'+
                                                '<p class="tochit"><em>￥</em>' + json.chit + '</p>'+
                                                '<p class="tobuy">券' + json.order_amount + '抵扣</p>'+
                                            '</div>'+
                                            '<div class="mui-media-body">'+
                                                '<p class="ordbigbt"><span>课程属性:</span>' + (json.goods.value != '' ? json.goods.value : '') + '</p>'+
                                                '<p class="ordbigbt"><span>课程学费:</span>' + json.goods.market_price + '</p>'+
                                                '<p class="ordbigbt"><span>完成状态:</span>' + (json.status == 5 ? '已完成' : '未完成') + '</p>'+
                                            '</div>'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>';
                    if(json.status == 5){

                        if(type == 3 && json.pay_status == 0){
                            html += '<div class="mui-card-footer">'+
                                    '<a href="' + SITE_URL + 'ucenter/order_detail/id/' + json.id + '" class="mui-card-link">去付款</a><a href="javascript:;" onclick="delProp(\'' + json.id + '\')" class="mui-card-link">删除</a></div>';
                        }else{
                            html += '<div class="mui-card-footer">'+
                                    '<a href="' + SITE_URL + 'ucenter/order_detail/id/' + json.id + '" class="mui-card-link">查看详情</a></div>';
                        }
                    }
                }else{
                    //if(parseInt(json.chit_info.id) > 0){
                        html += '<div class="mui-card-content">'+
                                    '<ul class="mui-table-view">'+
                                        '<li class="mui-table-view-cell mui-media card-list-box">'+
                                            '<a href="' + SITE_URL + 'ucenter/order_detail/id/' + json.id + '">'+
                                                '<div class="mui-media-object mui-pull-left mui-media-object-' + type + '">'+
                                                    '<p class="tochit"><em>￥</em>' + json.chit_info.max_order_chit + '</p>'+
                                                '</div>'+
                                            '</a>'+
                                                '<div class="mui-media-body">';
                                                  if ( json.state == 13 || (type == 3 && json.pay_status == 0))
                                                  {
                                                    html += '<div class="mui-action">';
                                                    if(json.state == 13){
                                                        html += '<a data-id="' + json.id + '" data-url="' + SITE_URL + 'ucenter/order_confirm/order_id/' + json.id + '" class="mui-card-link order_confirm">确认使用</a>';
                                                    }
                                                    if(type == 3 && json.pay_status == 0){
                                                        html += '<a href="' + SITE_URL + 'ucenter/order_detail/id/' + json.id + '" class="mui-card-link">去付款</a><a href="javascript:;" onclick="delProp(\'' + json.id + '\')" class="mui-card-link">删除</a>';
                                                    }
                                                    html += '</div>';
                                                  }
                                                  html += '<p class="ordbigbt">&yen' + json.chit_info.max_price + '</p>'+
                                                  '<p class="tospec">' + json.goods_info.name + '</p>'+
                                                  '<p class="tospec">' + json.seller_info.shortname + '</p>'+
                                                  '</div>';
                                        html += '</li>'+
                                    '</ul>';
                        html += '</div>';
                    //}
                }
                html += '</div>';
            }
        }
        $('#proplist').html(html);

        $('#proplist .order_confirm').click(function(){
            var order_id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            userPicker.show(function(items) {
              var _seller_id = items[2].value;
              $('.confirm').find('input[name=order_id]').val(order_id);
              $('.confirm').find('input[name=url]').val(url);
              $.getJSON('/ucenter/get_order_info/order_id/' +order_id ,{},function(content){
                if(content.status == 1){
                  $('.confirm').find('input[name=student_name]').val(content.info.student_name);
                  $('.confirm').find('input[name=accept_name]').val(content.info.accept_name);
                  $('.confirm').find('input[name=mobile]').val(content.info.mobile);
                }
              })
              layer.open({
               type: 1
               ,content: $('.confirm_content').html()
               ,anim: 'up'
               ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 350px; padding:0px 0; border:none;'
             });
             $('.layui-m-layercont .confirm').show();

              $('.confirm_submit input[type=submit]').click(function(){
                  url = url + '/used_seller_id/' + _seller_id;
                  location.href = url;
              })
            });
        })
    });
}

function delProp(order_id){
    $.getJSON(SITE_URL + 'ucenter/order_del', {order_id: order_id}, function(json){
        if(json.msg == 1){
            //todo
        }
        window.location.reload();
    });
}
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item user <?php if($this->getId() == 'ucenter' || ($this->getId() == 'simple' && $_GET['action'] == 'login')){?>mui-hot-user<?php }?>" href="<?php echo IUrl::creatUrl("/simple/login");?>?callback=/ucenter" id="ltelBtn">
	        <span class="mui-tab-label">我的</span>
	    </a>
      <a class="mui-tab-item service" href="<?php echo IUrl::creatUrl("/site/service");?>" id="ltelBtn">
	        <span class="mui-tab-label">客服</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<script type="text/javascript">
mui('body').on('tap', 'a', function(){
    if(this.href != '#' && this.href != ''){
        mui.openWindow({
            url: this.href
        });
    }
    this.click();
});

(function($) {
	$(document).imageLazyload({
		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'
	});
})(mui);
</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
