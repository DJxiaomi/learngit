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
	<div class="position"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 咨询 </div>
	<div class="clearfix">
	<div class="sidebar f_l">
		<div class="box_2 m_10">
			<div class="title">商品信息</div>
			<div class="content">
				<ul class="prolist clearfix">
					<li>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$this->goodsRow['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$this->goodsRow['img']."/w/167/h/212");?>" alt="<?php echo isset($this->goodsRow['name'])?$this->goodsRow['name']:"";?>" height="212" width="167"></a>
						<p class="pro_title">商品名称：<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$this->goodsRow['id']."");?>"><?php echo isset($this->goodsRow['name'])?$this->goodsRow['name']:"";?></a></p>
						<p>优惠价：<b>￥<?php echo isset($this->goodsRow['sell_price'])?$this->goodsRow['sell_price']:"";?></b></p>
						<p>评价得分：<span class="grade-star g-star<?php echo isset($this->goodsRow['apoint'])?$this->goodsRow['apoint']:"";?>"></span>(<?php echo isset($this->goodsRow['apoint'])?$this->goodsRow['apoint']:"";?>分)</p>
						<p>评论数：<?php echo isset($this->goodsRow['comments'])?$this->goodsRow['comments']:"";?>条</p>
					</li>
					<input type="submit" onclick="joinCart_list(<?php echo isset($this->goodsRow['id'])?$this->goodsRow['id']:"";?>);" value="加入购物车" class="submit_join m_10">
				</ul>
			</div>
		</div>
	</div>
	<div class="wrapper main f_r">
		<div class="wrap_box">
			<form action='<?php echo IUrl::creatUrl("/site/consult_act");?>' method='post' name='consult'>
				<input type='hidden' name='goods_id' value='<?php echo isset($this->goodsRow['id'])?$this->goodsRow['id']:"";?>' />
				<table class="form_table f_l">
					<caption><img src="<?php echo $this->getWebSkinPath()."images/front/consult.gif";?>" width="88" height="23" alt="我要咨询" /></caption>
					<col width="120px" />
					<col />
					<tr>
						<td colspan="2">
							<div class="prompt">
								<span class="red">*</span>&nbsp;声明：您可在购买前对产品包装、颜色、运输、库存等方面进行咨询，我们有专人进行回复！因厂家随时会更改一些产品的包装、
					&nbsp;&nbsp;颜色、产地等参数，所以该回复仅在当时对提问者有效，其他网友仅供参考！咨询回复的工作时间为：周一至周五，9:00至18:00，
					&nbsp;&nbsp;请耐心等待工作人员回复。
							</div>
						</td>
					</tr>
					<tr>
						<th>咨询类型：</th>
						<td>
							<label><input class="radio" type="radio" value="0" name="type" checked=checked />商品咨询</label>
							<label><input class="radio" type="radio" value="1" name="type" />库存及配送</label>
							<label><input class="radio" type="radio" value="2" name="type" />支付问题</label>
							<label><input class="radio" type="radio" value="3" name="type" />发票及保修</label>
							<label><input class="radio" type="radio" value="4" name="type" />促销及商品</label>
						</td>
					</tr>
					<tr>
						<th>咨询内容：</th><td valign="top"><textarea name="question" pattern='required'></textarea></td>
					</tr>
					<tr><th>验证码：</th><td><input type='text' class='gray_s' name='captcha' pattern='^\w{5,10}$' alt='填写下面图片所示的字符' /><label>填写下面图片所示的字符</label></td></tr>
					<tr class="low"><th></th><td><img src='<?php echo IUrl::creatUrl("/site/getCaptcha");?>' id='captchaImg' /><span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha();">换一张</a></span></td></tr>
					<tr><td></td><td><label class="btn"><input type="submit" value="发表咨询" /></label></td></tr>
				</table>
			</form>
		</div>
	</div>
</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'brand'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/brand");?>" id="ztelBtn">
					<span class="mui-tab-label">学校</span>
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
