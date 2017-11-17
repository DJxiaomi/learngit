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
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php $callback = IUrl::creatUrl('/ucenter/index');?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_tutor.css";?>" rel="stylesheet" type="text/css" />

  <?php if($tutor_list){?>
  <?php foreach($tutor_list as $key => $item){?>
  <div class="mui-card">
      <div class="mui-card-content">
          <div class="mui-card-content-inner">
              <p class="ordbigbt"><span>性别：</span><?php echo  get_gender_title($item['gender']);?></p>
              <p class="ordbigbt"><span>年级：</span><?php echo category_class::get_category_title($item['grade_level']);?></p>
              <p class="ordbigbt"><span>分类：</span><?php echo category_class::get_category_title($item['grade']);?></p>
              <p class="ordbigbt"><span>最近考分：</span><?php echo isset($item['lastest_scores'])?$item['lastest_scores']:"";?></p>
              <p class="ordbigbt"><span>期望考分：</span><?php echo isset($item['expected_scores'])?$item['expected_scores']:"";?></p>
              <p class="ordbigbt"><span>最低报酬：</span><?php echo isset($item['lowest_reward'])?$item['lowest_reward']:"";?></p>
              <p class="ordbigbt"><span>状态：</span><?php echo tutor_class::get_tutor_status_title($item['status'], $item['is_publish']);?>
                  <?php if($item['contract_addr']){?><span><a href="<?php echo IUrl::creatUrl("")."".$item['contract_addr']."";?>" target="_blank">查看合同</a></span><?php }?>
              </p>

              <p class="ordbigbt"><span>发布日期：</span><?php echo date('Y-m-d',$item['create_time']);?></p>
          </div>
      </div>
      <div class="mui-card-footer">
          <a href="<?php echo IUrl::creatUrl("/ucenter/tutor_add/id/".$item['id']."");?>" class="mui-card-link">查看详情</a>
          <a href="<?php echo IUrl::creatUrl("/ucenter/tutor_del/id/".$item['id']."");?>" class="mui-card-link">删除</a>
      </div>
  </div>
  <?php }?>
  <?php }else{?>
  <div class="mui-card">
      <div class="mui-card-content">
          <div class="mui-card-content-inner">
              没有任何家教信息
          </div>
      </div>
  </div>
  <?php }?>

	<div class="mui-card">
	    <div class="mui-card-content">
	        <div class="mui-card-content-inner">
							<button type="button" class="mui-btn mui-btn-primary mui-btn-outlined mui-add">发布家教</button>
					</div>
			</div>
	</div>

	<script type="text/javascript">
		$(function(){
				mui('body').on('tap', '.mui-add',function(){
					document.location.href = '<?php echo IUrl::creatUrl("/ucenter/tutor_add");?>';
				});
		});
	</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
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
