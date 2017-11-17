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
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/prolist.css";?>">
<div class="card-list-box">
    <div class="box"><h5>详细信息</h5></div>
    <ul class="mui-table-view">
        <li class="mui-table-view-cell mui-media">
            <div class="mui-media-object mui-pull-left">
                <p class="tobuy">满<?php echo isset($chit['amount'])?$chit['amount']:"";?>元可用</p>
                <p class="tochit"><em>￥</em><?php echo isset($chit['max_order_chit'])?$chit['max_order_chit']:"";?></p>
            </div>
            <div class="mui-media-body">
                <p><em class="totip"><?php if($chit['seller_id'] == 366){?>通用券<?php }else{?>专用券<?php }?></em><?php if($chit['type'] == 2){?><em class="totip totip-1">赠送</em><?php }?><?php echo isset($chit['shortname'])?$chit['shortname']:"";?></p>
                <p class="tospec limitnum">
                    <?php if($chit['limitnum']){?>每人限购<?php echo isset($chit['limitnum'])?$chit['limitnum']:"";?>张<?php }else{?>无限制数量<?php }?>
                </p>
                <p class="maxprice"><?php echo isset($chit['max_price'])?$chit['max_price']:"";?>元抢券</p>
                <a class="buycard" onclick="buy_now_ding_card('<?php echo isset($chit['id'])?$chit['id']:"";?>', '<?php echo isset($chit['max_price'])?$chit['max_price']:"";?>')"><?php if($chit['type'] == 2){?>点击领券<?php }else{?>点击购买<?php }?></a>
            </div>
        </li>
        <?php if($chit['limitinfo']){?>
        <div class="box"><h5>券说明</h5></div>
        <li class="mui-table-view-cell">
            <h6><?php echo isset($chit['limitinfo'])?$chit['limitinfo']:"";?></h6>
        </li>
        <?php }?>
        <?php if($chit['content']){?>
        <div class="box"><h5>使用说明</h5></div>
        <li class="mui-table-view-cell">
            <div class="rich_media" style="margin:0px auto;padding:0px;font-family:'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif;font-size:medium;"><?php echo isset($chit['content'])?$chit['content']:"";?></div>
        </li>
        <?php }?>
    </ul>
</div>
<script type="text/javascript">
function buy_now_ding_card(id, _input_dprice){
	var buyNums  = 1;
	//var type = 'chit';
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/5280/num/@buyNums@/type/product/statement/2/ischit/1/chitid/@chitid@");?>';
		url = url.replace('@chitid@',id).replace('@buyNums@',buyNums);
	var _input_stime = 1;
	url += '/stime/' + _input_stime;
	url += '/dprice/' + _input_dprice;

	window.location.href = url;
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
			<a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit");?>" id="ztelBtn">
					<span class="mui-tab-label">代金券</span>
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
