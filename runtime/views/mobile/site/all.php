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
	<link href="<?php echo $this->getWebSkinPath()."css/index.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/index.js";?>"></script>


<!--栏目-->
<div class="index-category" style="margin-top: 15px;">
    <ul class="clearfix">
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/pro_list?&cat=1");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_1.png";?>" /></div>
                <div class="ct">婴幼儿</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/pro_list?&cat=2");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_2.png";?>" /></div>
                <div class="ct">中小学</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/pro_list?&cat=4");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_3.png";?>" /></div>
                <div class="ct">文学艺术</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/pro_list?&cat=196");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_4.png";?>" /></div>
                <div class="ct">益智体育</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/tutor");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_5.png";?>" /></div>
                <div class="ct">家教辅导</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/pro_list?&cat=6");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_6.png";?>" /></div>
                <div class="ct">职业技能</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/activity_zhuanti");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_7.png";?>" /></div>
                <div class="ct">热点专题</div>
            </a>
        </li>
        <!-- <li>
            <a href="<?php echo IUrl::creatUrl("/site/activity_free_class");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_9.png";?>" /></div>
                <div class="ct">免费课</div>
            </a>
        </li> -->
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/article/cid/2");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_10.png";?>" /></div>
                <div class="ct">新闻资讯</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/chit");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_11.png";?>" /></div>
                <div class="ct">领券</div>
            </a>
        </li>
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/activity_discount");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_12.png";?>" /></div>
                <div class="ct">享优惠</div>
            </a>
        </li>
        <!-- <li>
            <a href="<?php echo IUrl::creatUrl("/site/brand/category_id/14");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_13.png";?>" /></div>
                <div class="ct">学习用品</div>
            </a>
        </li> -->
        <li>
            <a href="<?php echo IUrl::creatUrl("/site/user_tutor_list");?>">
                <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_14.png";?>" /></div>
                <div class="ct">找学生</div>
            </a>
        </li>
    </ul>
</div>
<!--栏目-->

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">教育手册</span>
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
