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
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("".$this->back_url."");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php 
    $title = '订单详情';
    if ($this->order_info['statement'] != 2 )
      $callback = IUrl::creatUrl('/ucenter/order');
    else
      $callback = IUrl::creatUrl('/ucenter/redpacket');
?>

<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_order_detail.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-card student_info">
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <li class="mui-table-view-cell"><span>学员姓名：</span><?php echo isset($this->order_info['accept_name'])?$this->order_info['accept_name']:"";?></li>
            <li class="mui-table-view-cell"><span>联系电话：</span><?php echo isset($this->order_info['mobile'])?$this->order_info['mobile']:"";?></li>
            <!-- <li class="mui-table-view-cell"><span>验证码：</span><b class="green"><?php echo isset($goods_list[0]['verification_code'])?$goods_list[0]['verification_code']:"";?></b></li> -->
        </ul>
    </div>
</div>
<div class="mui-card">
    <div class="mui-card-header">
      <div class='t-left'><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
      <div class='t-right'><?php echo Order_Class::orderStatusText($orderStatus);?></div>
    </div>
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <?php foreach(Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$this->order_info['order_id'])) as $key => $good){?>
            <?php $good_info = JSON::decode($good['goods_array'])?>
            <?php $i++;?>
            <li class="mui-table-view-cell mui-media">
                <a href="<?php if($this->order_info['statement'] == 1){?><?php echo IUrl::creatUrl("/site/products/id/".$good['goods_id']."");?><?php }else{?>javascript:void(0);<?php }?>">
                    <img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$good['img']."/w/80/h/80");?>">
                    <div class="mui-media-body">
                        <p><?php echo isset($good_info['name'])?$good_info['name']:"";?></p>
                        <p class='price'>
                          <span class='t-left'>￥<?php echo isset($good['goods_price'])?$good['goods_price']:"";?></span>
                          <span class='t-right'>x <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?></span>
                        </p>
                    </div>
                </a>
            </li>
            <?php }?>

            <div class="mui-media-info">
              共<?php echo isset($i)?$i:"";?>件商品 合计：<span class='price'>￥<?php echo $good['goods_nums']*$good['real_price'];?></span>
            </div>

            <div class="mui-input-group">
                <div class="mui-button-row">
                    <?php if(in_array($orderStatus,array(1,2))){?>
                    <a href="javascript:void(0);" class="mui-btn mui-btn-primary cancel">取消</a>
                    <?php }?>
                    <?php if($orderStatus == 2 && $this->order_info['order_role'] == 1){?>
                      <a href="javascript:void(0);"  class="mui-btn mui-btn-danger" onclick="javascript:window.location.href = '<?php echo IUrl::creatUrl("/block/doPay/order_id/".$this->order_info[order_id]."");?>'">付款</a>
                    <?php }?>

                    <?php if(Order_Class::isRefundmentApply($this->order_info) && $this->order_info['statement'] == 1){?>
                      <a href="<?php echo IUrl::creatUrl("/ucenter/refunds_edit/order_id/".$this->order_info['order_id']."");?>" class="mui-btn mui-btn-primary">申请退款</a>
                    <?php }?>

                    <?php if(in_array($orderStatus,array(11,3))){?>
                      <a href="<?php echo IUrl::creatUrl("/ucenter/order_status/order_id/".$this->order_info['order_id']."/op/confirm");?>" class="mui-btn mui-btn-primary">确认报到</a>
                    <?php }?>
                    <?php if($this->order_info['statement'] == 2 && in_array($orderStatus,array(4))){?>
                      <a href="javascript:void(0);" class="mui-btn mui-btn-primary brand_chit_confirm">确认使用</a>
                    <?php }?>
                </div>
            </div>

        </ul>
    </div>
</div>

<div class="mui-card order_log">
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <li class="mui-table-view-cell"><span>订单编号</span>：<?php echo isset($this->order_info['order_no'])?$this->order_info['order_no']:"";?></li>
            <?php $orderStep = Order_Class::orderStep($this->order_info)?>
            <?php foreach($orderStep as $eventTime => $stepData){?>
            <li class="mui-table-view-cell"><span><?php echo isset($eventTime)?$eventTime:"";?></span><?php echo isset($stepData)?$stepData:"";?></li>
            <?php }?>
        </ul>
    </div>
</div>

<script language="javascript">
var _order_id = <?php echo isset($order_id)?$order_id:"";?>;
$(document).ready(function(){
    $('.cancel').click(function(){
        mui.confirm('你确认要关闭此订单吗？', '取消订单', ['取消', '确定'], function(e){
            if(e.index == 1){
                var _post_url = '<?php echo IUrl::creatUrl("/ucenter/order_status_ajax");?>';
                Lx.common.loading();
                mui.post( _post_url, {order_id: _order_id, op: 'cancel'}, function(data){
                    if ( data == '1'){
                        window.location.reload();
                    }
                })
            }else{
                Lx.common.loadingClose();
            }
        });
    });

    $('.brand_chit_confirm').click(function(){
        mui.confirm('请选择要代金券的使用场景？', '使用代金券', ['线下使用', '线上使用'], function(e){
            if(e.index == 1){
                console.log('线上使用');
                <?php if($chit_info['product_id']){?>
                  location.href = '<?php echo IUrl::creatUrl("/simple/cart2n/num/1/type/product/id/" . $chit_info[product_id]); ?>';
                <?php }else{?>
                  location.href = '<?php echo IUrl::creatUrl("/simple/cart2n/num/1/type/goods/id/" . $chit_info[goods_id]); ?>';
                <?php }?>
            }else{
                console.log('线下使用');
                location.href = '<?php echo IUrl::creatUrl("/ucenter/redpacket_detail/id/" . $chit_info[id] . "/order_id/" . $order_id); ?>';
            }
        });
    });
})
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">学习通</span>
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

</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
