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
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.min.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript" src="/views/msysseller/javascript/jquery.juploader.js"></script>

<link href="<?php echo $this->getWebSkinPath()."css/manual_activation.css";?>" rel="stylesheet" type="text/css" />
  <form class="mui-input-group" method="post" action="<?php echo IUrl::creatUrl("/ucenter/save_manual_activation");?>">
      <div class="mui-input-row">
          <label>家长姓名</label>
          <input type="text" name="parents_name" class="mui-input-clear" placeholder="请输入家长姓名">
      </div>
      <div class="mui-input-row">
          <label>家长电话</label>
          <input type="number" name="parents_tel" class="mui-input-clear" placeholder="请输入家长电话">
      </div>
      <div class="mui-input-row">
          <label>宝贝姓名</label>
          <input type="text" name="name" class="mui-input-clear" placeholder="请输入宝贝姓名">
      </div>
      <div class="mui-input-row mui-input-birthday">
          <label>宝贝生日</label>
          <input type="text" name="birthday" class="mui-input-clear" placeholder="请选择宝贝生日">
      </div>
      <div class="mui-input-row mui-input-row-sex">
  			<label>宝贝性别</label>
  			<div class="mui-radio mui-left mui-check-left">
  				<label class="auto">男</label>
  				<input type="radio" name="sex" value="1" checked>
  			</div>
  			<div class="mui-radio mui-left mui-check-left">
  				<label class="auto">女</label>
  				<input type="radio" name="sex" value="2">
  			</div>
  		</div>
      <div class="mui-input-row mui-input-row-relation">
        <label>家长关系</label>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">妈妈</label>
          <input type="radio" name="guardian" value="1" checked>
        </div>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">爸爸</label>
          <input type="radio" name="guardian" value="2">
        </div>
        <label></label>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">奶奶</label>
          <input type="radio" name="guardian" value="3">
        </div>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">爷爷</label>
          <input type="radio" name="guardian" value="4">
        </div>
        <label></label>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">外公</label>
          <input type="radio" name="guardian" value="5">
        </div>
        <div class="mui-radio mui-left mui-check-left">
          <label class="auto">外婆</label>
          <input type="radio" name="guardian" value="6">
        </div>
      </div>
      <div class="mui-input-row" id="category" style="display:none;">
        <label>课程分类</label>
        <span>请选择分类</span>
        <i class="icon-angle-right"></i>
      </div>
      <div class="mui-input-row" style="height: auto;margin: 5px 0;">
        <label>宝贝图片</label>
        <?php
          $default_upload_bg = '/views/mobile/skin/blue/images/upload.png';
        ?>
        <div class="image-item space" id="uppic" style="overflow:hidden;background:url(<?php echo isset($default_upload_bg)?$default_upload_bg:"";?>) no-repeat center center;background-size:100% auto;"></div>
        <input type="hidden" name="logo" id="icon" value="">
      </div>
      <div class="mui-card-content">
          <p>重要说明</p>
          <p>1、手册一旦激活，不可修改信息，请务必认真填写；</p>
          <p>2、宝贝照片一旦上传，不可修改，请务必认真拍摄；</p>
          <p>3、学校只根据宝贝照片核实是否本人，如学校判定不是宝贝本人，其有权拒绝您使用，请知晓；</p>
          <p>4、解释权归第三课所有。</p>
      </div>
      <div class="mui-checkbox mui-left">
        <label class="auto">勾选后代表您已经阅读并同意以上重要声明</label>
        <input type="checkbox" name="is_agree" value="1" checked>
      </div>
      <div class="mui-content-padded">
          <input type="hidden" name="category_id" value="0" />
          <input type="hidden" name="code" value="<?php echo isset($code)?$code:"";?>" />
          <button type="button" class="mui-btn mui-btn-primary mui-btn-block" id="confirm">提交激活</button>
      </div>
  </form>

  <script language="javascript">
  var catdata = <?php if($manual_category_list_json){?><?php echo isset($manual_category_list_json)?$manual_category_list_json:"";?><?php }else{?>new Array()<?php }?>;
  var _upload_url = '<?php echo IUrl::creatUrl("/ucenter/pic_upload");?>';
  </script>

  <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/manual_activation.js";?>"></script>

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
