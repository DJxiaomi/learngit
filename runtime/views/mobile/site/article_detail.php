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
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/article_detail.js";?>"></script>
<script language="javascript">

  var _thumb_url = '<?php echo IUrl::creatUrl("/site/article_reply_thumb_ajax");?>';
  var _share_title = '<?php echo isset($article_info['title'])?$article_info['title']:"";?>';
  var _share_desc = '点击进入';
  var _share_link = '<?php echo isset($share_url)?$share_url:"";?>';
  var _share_img_url = 'http://<?php echo get_host();?>/views/mobile/skin/blue/images/wechat_share_logo.jpg';
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo isset($sign_package_info["appid"])?$sign_package_info["appid"]:"";?>',
    timestamp: <?php echo isset($sign_package_info["timestamp"])?$sign_package_info["timestamp"]:"";?>,
    nonceStr: '<?php echo isset($sign_package_info["noncestr"])?$sign_package_info["noncestr"]:"";?>',
    signature: '<?php echo isset($sign_package_info["signature"])?$sign_package_info["signature"]:"";?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  'onMenuShareAppMessage',
	  'onMenuShareTimeline'
    ]
  });
  wx.ready(function () {
    // 在这里调用 API

	// 分享给朋友
	wx.onMenuShareAppMessage({
		title: _share_title, // 分享标题
		desc: _share_desc, // 分享描述
		link: _share_link, // 分享链接
		imgUrl: _share_img_url, // 分享图标
		type: '', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () {
			// 用户确认分享后执行的回调函数
			//alert('success');
		},
		cancel: function () {
			// 用户取消分享后执行的回调函数
			//alert('cancel');
		}
	});

	// 分享到朋友圈
	wx.onMenuShareTimeline({
		title: _share_title, // 分享标题
		link: _share_link, // 分享链接
		imgUrl: _share_img_url, // 分享图标
		success: function () {
			// 用户确认分享后执行的回调函数
			//alert('success');
		},
		cancel: function () {
			// 用户取消分享后执行的回调函数
			//alert('cancel');
		}
	});
  });
</script>

<link href="<?php echo $this->getWebSkinPath()."css/article_detail.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-content-padded article-content">
	<h4><?php echo isset($article_info['title'])?$article_info['title']:"";?></h4>
	<p>
		<?php if($article_info['username']){?><?php echo isset($article_info['username'])?$article_info['username']:"";?><?php }else{?>第三课<?php }?>
		<span><?php echo date('m-d H:i',strtotime($article_info['create_time']));?></span>
	</p>
	<div class="content">
		<?php echo isset($article_info['content'])?$article_info['content']:"";?>
	</div>
	<?php if($reply_list){?>
	<h5 style="line-height:30px;">全部评论</h5>
	<ul class="mui-table-view">
		<?php foreach($reply_list as $key => $item){?>
		<li class="mui-table-view-cell">
      <div class="user_icon">
        <img src="<?php if($item['head_ico']){?><?php echo isset($item['head_ico'])?$item['head_ico']:"";?><?php }else{?><?php if($item['sex'] != 2){?>/views/default/skin/default/images/man.jpg<?php }else{?>/views/default/skin/default/images/woman.jpg<?php }?><?php }?>" />
      </div>
      <div class="user_info">
  			<p><?php echo isset($user_list[$item['user_id']]['username'])?$user_list[$item['user_id']]['username']:"";?>&nbsp; &nbsp; <?php echo  date('m-d H:i', $item['add_time']);?></p>
  			<p><?php echo isset($item['content'])?$item['content']:"";?></p>
      </div>
      <div class="action">
        <a href="javascript:void(0);" id="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['thumb_count'])?$item['thumb_count']:"";?></a>
      </div>
		</li>
		<?php }?>
	</ul>
	<?php }?>
</div>
<div class="reply-box">
	<?php if($this->user){?>
	<form method="POST" action="<?php echo IUrl::creatUrl("/site/article_reply");?>" id="form_reply">

		<input type="text" name="reply_content" id="reply_content" placeholder="写评论" />

		<input type="submit" class="reply_btn" value="发表" />

		<input type="hidden" name="article_id" value="<?php echo $this->article_id;?>" />

		<input type="hidden" name="type" value="mobile" />

	</form>
	<?php }else{?>
	<a href="<?php echo IUrl::creatUrl("/simple/login");?>">登录</a>进行评论
	<?php }?>
</div>

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

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
