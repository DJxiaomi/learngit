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
    $title = '代金券组合详情';
    $callback = IUrl::creatUrl('/ucenter/redpacket_zuhe');
?>

<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_order_zuhe_detail.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-card student_info">
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <li class="mui-table-view-cell"><span>学员姓名：</span><?php echo isset($this->order_info['accept_name'])?$this->order_info['accept_name']:"";?></li>
            <li class="mui-table-view-cell"><span>联系电话：</span><?php echo isset($this->order_info['mobile'])?$this->order_info['mobile']:"";?></li>
        </ul>
    </div>
</div>
<div class="mui-card">
    <div class="mui-card-header">
      <div class='t-left'>第三课</div>
      <div class='t-right'><?php echo Order_Class::orderStatusText($orderStatus);?></div>
    </div>
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <?php if($detail_list){?>
              <li>
                <div class="pname"><b>短期课名称</b></div>
                <div class="pprice"><b>价格</b></div>
                <div class="ptime"><b>可使用次数</b></div>
              </li>
              <?php foreach($detail_list as $key => $item){?>
              <li class="mui-table-view-cell mui-media">
                  <div class="pname"><?php echo isset($item['name'])?$item['name']:"";?></div>
                  <div class="pprice"><?php echo isset($item['max_price'])?$item['max_price']:"";?></div>
                  <div class="ptime"><?php echo isset($item['availeble_use_times'])?$item['availeble_use_times']:"";?></div>
              </li>
              <?php }?>
            <?php }?>

            <div class="mui-media-info">
              共<?php echo sizeof($detail_list);?>个课程 合计：<span class='price'>&yen;<?php echo isset($this->order_info['order_amount'])?$this->order_info['order_amount']:"";?></span>
            </div>

            <?php if(!in_array($orderStatus,array(3))){?>
            <div class="mui-input-group">
                <div class="mui-button-row">
                    <?php if(in_array($orderStatus,array(1,2))){?>
                    <a href="javascript:void(0);" class="mui-btn mui-btn-primary cancel">取消</a>
                    <?php }?>
                    <?php if($orderStatus == 2 && $this->order_info['order_role'] == 1){?>
                        <a href="javascript:void(0);"  class="mui-btn mui-btn-danger" onclick="javascript:window.location.href = '<?php echo IUrl::creatUrl("/block/doPay/order_id/".$this->order_info[order_id]."");?>'">付款</a>
                    <?php }?>
                </div>
            </div>
            <?php }?>
        </ul>
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
