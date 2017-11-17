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
	<link href="<?php echo $this->getWebSkinPath()."css/cart.css";?>" rel="stylesheet" type="text/css" />
<style>
body,.mui-content,.mui-media {background-color:#fff;}
.mui-table-view-cell {border-bottom:8px solid #e2e2e2;}
.mui-table-view-cell p {color:#000;height:22px;line-height:22px;}
.mui-table-view-cell p.spec {color:#8c8c8c;}
.mui-table-view-cell .mui-media {padding-bottom: 10px;}
.mui-table-view .mui-media-object {width:65px;height:65px;margin-left: 5%;border:1px solid #ccc;}
.mui-table-view-cell p.price .market_price {margin-left:5%;color:#8f8f8f;text-decoration:line-through;}
.mui-media-footer {font-size:.8rem;color:red;padding: 0 5%;border-top: 1px solid #e4e4f0;line-height:30px;height:30px;text-align:right;}
</style>
<?php if($cart_list){?>
<div class="list">
	<ul class="mui-table-view">
		<?php foreach($cart_list as $key => $item){?>
	    <li class="mui-table-view-cell mui-media">
				<div class="mui-media-header">
					<div class='t-left'><?php echo isset($item['shortname'])?$item['shortname']:"";?></div>
				</div>
	    	<img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['seller_logo']."/w/60/h/60");?>">
    		<div class="mui-media-body" id="<?php echo isset($item['seller_id'])?$item['seller_id']:"";?>">
					<p><?php echo isset($item['name'])?$item['name']:"";?></p>
					<p class="spec"><?php if($item['use_times']){?><?php echo isset($item['use_times'])?$item['use_times']:"";?>课时<?php }?></p>
					<p class="price">
						<span class="price" id="sum_<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>_<?php echo isset($item['product_id'])?$item['product_id']:"";?>">&yen;<?php echo isset($item['max_price'])?$item['max_price']:"";?></span>
						<?php if($item['market_price']){?><span class="market_price"><?php echo isset($item['market_price'])?$item['market_price']:"";?></span><?php }?>
					</p>
    		</div>
    		<div class="cart-box">
    			<a href='javascript:removeCart("<?php echo isset($item[id])?$item[id]:"";?>");'><i class="icon-trash"></i></a>
    		</div>
				<?php if(sizeof($cart_list) > 1 && $item['max_price'] > $item['tc_price']){?>
				<div class="mui-media-footer">
					搭配其它课程一起购买，减<?php echo $item['max_price'] - $item['tc_price'];?>元
				</div>
				<?php }?>
	    </li>
	    <?php }?>
	</ul>
</div>
<?php }else{?>
<div class="mui-content-padded">
	没有短期课，<a href="<?php echo IUrl::creatUrl("/site/chit1");?>">去看看</a>
</div>
<?php }?>
<?php if( $cart_list){?>
<div class="cart-checkout">
		<div class="cart-checkbox">

		</div>
		<div class="cart-counter">
			  <p class="total-price">合计 : <em class="">&yen; <?php echo isset($count)?$count:"";?></em></p>
		</div>
	  <a href="javascript:check_finish();" id="M_Checkout" class="ui-btn-pink">结算(<?php echo isset($cart_count)?$cart_count:"";?>)</a>
 </div>
 <?php }?>

<script language="javascript">
//移除购物车
function removeCart(id)
{
	if ( id <= 0 )
	{
		mui.toast('参数不正确');
		return false;
	}

	var btnArray = ['否', '是'];
	mui.confirm('您确定要删除此短期课吗？', '提示信息', btnArray, function(e) {
			if (e.index == 1)
			{
				$.get("<?php echo IUrl::creatUrl("/simple/remove_dqk_cart");?>",{"id":id,"random":Math.random()},function(result)
				{
					if ( result == '1')
						window.location.reload();
					else {
						mui.toast(result);
					}
				});
			}
	})
}

function check_finish()
{
	var ids = '<?php echo isset($ids)?$ids:"";?>';
	if ( ids == '')
	{
		mui.toast('请先加入短期课');
		return false;
	} else {
		var _url = '<?php echo IUrl::creatUrl("/site/create_brand_chit_zuhe/ids/@ids@");?>';
		_url = _url.replace('@ids@', ids);
		location.href = _url;
	}
}

$(document).ready(function(){
	$('.mui-media-body').click(function(){
		var _seller_id = $(this).attr('id');
		var url = '<?php echo IUrl::creatUrl("/site/chit1_detail/id/@id@");?>';
		url = url.replace('@id@',_seller_id);
		location.href = url;
	})
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
