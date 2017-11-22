<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title>康卓商城 个人中心</title>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.picker.js";?>"></script>
        <link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/weui/weui.css";?>">
        <link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/mui.min.css";?>">
        <link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/icons-extra.css";?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/app.css";?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/common.css";?>" />
        <link href="<?php echo $this->getWebSkinPath()."css/cart.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
    </head>
    
    <body>
        
        <nav class="mui-bar mui-bar-tab">
            <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/site/index");?>">	
                <span class="mui-icon mui-icon-home"></span>
            	<span class="mui-tab-label">首页</span>
            </a>
            <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/simple/cart");?>">	
                <span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
    	        <span class="mui-tab-label">购物车</span>
            </a>
            <a class="mui-tab-item mui-active" href="<?php echo IUrl::creatUrl("/ucenter/index");?>">	
                <span class="mui-icon mui-icon-contact"></span>
            	<span class="mui-tab-label">个人中心</span>
            </a>
        </nav>


        <?php $callback = IUrl::creatUrl('/ucenter/index');?>
        <link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->getWebSkinPath()."css/ucenter_order.css";?>" rel="stylesheet" type="text/css" />
        <script language="javascript">
        var _type = <?php echo isset($type)?$type:"";?>;
        var _page_count = <?php echo isset($page_count)?$page_count:"";?>;
        var _curr_page = <?php echo isset($page)?$page:"";?>;
        var _page_size = <?php echo isset($page_size)?$page_size:"";?>;
        var _loading = false;
        var _ajax_data_url = '<?php echo IUrl::creatUrl("/ucenter/get_order_list_ajax");?>';
        </script>

        <div class="mui-content">
            <div id="tabbar-with-contact" class="mui-control-content mui-active">
                <header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
                    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
                    	<h1 class="mui-title" style="color:#fff"><?php echo $this->title;?></h1>
                </header>
                
                <h5 class="mui-content-padded"  style="margin-top:46px"></h5>
                <div class="mui-tab">
                  <ul>
                    <li <?php if($type == 1){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/ucenter/order/type/1");?>">已付款</a></li>
                    <li <?php if($type == 2){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/ucenter/order/type/2");?>">待付款</a></li>
                    <li <?php if($type == 3){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/ucenter/order/type/3");?>">已完成</a></li>
                    <li <?php if($type == 4){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/ucenter/order/type/4");?>">已取消</a></li>
                  </ul>
                </div>
                
                
                <?php if($order_list){?>
                <div class="content">
                  <?php foreach($order_list as $key => $item){?>
                  <div class="mui-card">
                      <div class="mui-card-header">
                        <div class='t-left'><?php echo isset($item['seller_info']['shortname'])?$item['seller_info']['shortname']:"";?> > </div>
                        <div class='t-right'><?php echo isset($item['status_str'])?$item['status_str']:"";?></div>
                      </div>
                      <div class="mui-card-content">
                          <ul class="mui-table-view">
                              <?php if($item['statement'] == 1){?>
                              <li class="mui-table-view-cell mui-media">
                                  <a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>">
                                      <img class="mui-media-object mui-pull-left" src="<?php if($item['statement'] != 2){?><?php echo IUrl::creatUrl("/pic/thumb/img/".$item['goods'][img]."/w/80/h/80");?><?php }else{?>/views/default/skin/default/images/xuexiquan.jpg<?php }?>">
                                      <div class="mui-media-body" style="margin-top:10px">
                                          <p><?php echo isset($item['goods']['name'])?$item['goods']['name']:"";?> <?php if($item['statement'] == 3){?>(定金)<?php }?></p>
                                          <p><span>课程属性：</span><?php echo isset($item['goods']['value'])?$item['goods']['value']:"";?></p>
                                          <p class='price'>
                                            <span class='t-left'><?php echo isset($item['goods']['goods_price'])?$item['goods']['goods_price']:"";?></span>
                                            <span class='t-right'>x <?php echo isset($item['goods']['goods_nums'])?$item['goods']['goods_nums']:"";?></span>
                                          </p>
                                      </div>
                                  </a>
                              </li>
                              <?php }elseif( $item['statement'] == 2){?>
                              <?php foreach($item['brand_chit_list'] as $key => $it){?>
                              <li class="mui-table-view-cell mui-media">
                                  <a href="<?php echo IUrl::creatUrl("/site/chit1_detail/id/".$it['seller_id']."");?>">
                                      <img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("")."".$it['logo']."";?>">
                                      <div class="mui-media-body">
                                          <p><?php echo isset($it['name'])?$it['name']:"";?></p>
                                          <p><?php echo isset($it['use_times'])?$it['use_times']:"";?>课时</p>
                                          <p class='price'>
                                            <span class='t-left'>&yen;<?php if(sizeof($item['brand_chit_list']) > 1){?><?php echo isset($it['tc_price'])?$it['tc_price']:"";?><?php }else{?><?php echo isset($it['max_price'])?$it['max_price']:"";?><?php }?></span>
                                            <span class='t-right'>x 1</span>
                                          </p>
                                      </div>
                                  </a>
                              </li>
                              <?php }?>
                              <?php }elseif( $item['statement'] == 4){?>
                              <li class="mui-table-view-cell mui-media">
                                  <a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>">
                                      <img class="mui-media-object mui-pull-left" src="<?php if($item['statement'] != 2){?><?php echo IUrl::creatUrl("/pic/thumb/img/".$item['goods'][img]."/w/80/h/80");?><?php }else{?>/views/default/skin/default/images/xuexiquan.jpg<?php }?>">
                                      <div class="mui-media-body">
                                          <p><?php echo isset($item['goods']['name'])?$item['goods']['name']:"";?></p>
                                          <p class='price'>
                                            <span class='t-left'><?php echo isset($item['goods']['goods_price'])?$item['goods']['goods_price']:"";?></span>
                                            <span class='t-right'>x <?php echo isset($item['goods']['goods_nums'])?$item['goods']['goods_nums']:"";?></span>
                                          </p>
                                      </div>
                                  </a>
                              </li>
                              <?php }?>
                          </ul>
                          <div class="mui-media-info">
                            <?php if($item['statement'] == 1){?>共1件商品<?php }elseif($item['statement'] == 2){?>共<?php echo sizeof($item['brand_chit_list']);?>个<?php if($item['zuhe_id'] > 0 ){?>短期课<?php }else{?>代金券<?php }?><?php }?> 合计：<span class='price'>&yen;<?php echo $item['order_amount'];?></span>
                          </div>
                      </div>
                      <div class="mui-card-footers">
                          <a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>">查看详情</a>
                          <?php if($item['order_status_t'] == 2){?>
                            <a href="javascript:void(0);" onclick="javascript:window.location.href = '<?php echo IUrl::creatUrl("/block/doPay/order_id/".$item['id']."");?>'">付款</a>
                          <?php }?>
                
                          <?php if($item['order_status_t'] == 13){?>
                              <a href="<?php echo IUrl::creatUrl("/ucenter/order_confirm/order_id/".$item['id']."");?>"><?php if($item['statement'] == 4){?>确认聘用<?php }else{?>确认报到<?php }?></a>
                          <?php }?>
                      </div>
                  </div>
                  <?php }?>
                  <div id="cc"></div>
                </div>
                <?php }else{?>
                <div class="mui-card">
                    <div class="mui-card-content">
                        <div class="mui-card-content-inner">
                            <center>
                                <h5>
                                    没有订单，<a href="<?php echo IUrl::creatUrl("/site/index");?>">去看看</a>
                                </h5>
                            </center>
                        </div>
                    </div>
                </div>
                <?php }?>
                
                

                
            </div>
        </div>
        
        <script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
        <script>
        mui.init({swipeBack: true });
        mui('nav').on('tap', 'a', function () {
            document.location.href = this.href;
        });
        </script>
        <script language="javascript">
        var loadi;
        $(window).scroll(function(){
        	var a = $(window).scrollTop();
        	var load_position = $('#cc').offset().top;
        	if( a + $(window).height() > load_position -10 && _loading == false && _curr_page < _page_count )
        	{
        		_loading = true;
        		//$('#cc').html("<img src='/views/mobile/skin/new/images/loading2.gif'>&nbsp; 努力加载中...");
        		_curr_page = _curr_page + 1;
        		$.get( _ajax_data_url, {page: _curr_page}, function( result ){
        			$('.content').append( result );
        			$('#cc').html('');
        			_loading = false;
        		});
        	}
        });
        </script>
    </body>
</html>