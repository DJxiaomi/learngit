<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- <title><?php echo $this->_siteConfig->name;?></title> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<!-- <script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script> -->
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<script language="javascript">
var _page_count = <?php echo $paging->totalpage;?>;
var _curr_page = <?php echo isset($page)?$page:"";?>;
var _page_size = <?php echo isset($page_size)?$page_size:"";?>;
var _loading = false;
var _ajax_data_url = 'http://<?php echo get_host();?><?php echo IUrl::creatUrl("/site/get_article3_list_ajax");?>';
</script>
<link href="<?php echo $this->getWebSkinPath()."css/mlmm.css";?>" rel="stylesheet" type="text/css" />
<div class="free_class_content">
  <div class="free_class_hd">
    <a href="http://www.dsanke.com/site/article_detail/id/250"><img src="/views/mobile/skin/blue/images/yqk.jpg" /></a>
  </div>

  <div class="free_class_bd">
    <?php if($article_list){?>
      <ul class="mlmm_content">
      <?php foreach($article_list as $key => $item){?>
      <li>
        <div class="class_image">
          <a href="<?php echo IUrl::creatUrl("/site/article_detail3/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("")."".$item['content']."";?>" /></a>
        </div>
        <div class="class_action">
			姓名：<?php echo isset($item['title'])?$item['title']:"";?>&nbsp; &nbsp; 得票：<?php echo article_thumb_class::get_article_thumb_count($item['id']);?>
        </div>
      </li>
      <?php }?>
    </ul>
    <?php }?>
    <div id="cc"></div>
  </div>
</div>

<script langauge="javascript">
var loadi;
$(window).scroll(function(){
	var a = $(window).scrollTop();
	var load_position = $('#cc').offset().top;
	if( a + $(window).height() > load_position -10 && _loading == false && _curr_page < _page_count )
	{
		_loading = true;
		_curr_page = _curr_page + 1;
		$.get( _ajax_data_url, {page: _curr_page}, function( result ){
			$('.mlmm_content').append( result );
			$('#cc').html('');
			_loading = false;
		});
	}
});
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_discount'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_props'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/366");?>">
	        <span class="mui-tab-label">券</span>
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
<!-- mui('body').on('tap', 'a', function(){ -->
    <!-- if(this.href != '#' && this.href != ''){ -->
        <!-- mui.openWindow({ -->
            <!-- url: this.href -->
        <!-- }); -->
    <!-- } -->
    <!-- this.click(); -->
<!-- }); -->

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