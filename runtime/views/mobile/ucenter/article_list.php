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
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter_article.css";?>" />
<?php  $type = $_GET['type'] + 0;?>

<?php $callback = IUrl::creatUrl('/ucenter/index');?>
<?php if($article_list){?>
<?php foreach($article_list as $key => $item){?>
<div class="mui-card">
    <div class="mui-card-header"><?php echo isset($item['title'])?$item['title']:"";?></div>
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            <p class="ordbigbt"><span>发布时间：</span><?php echo isset($item['create_time'])?$item['create_time']:"";?></p>
            <p class="ordbigbt t-left"><span>回复总数：</span><i class="ordbigbt-price"><?php echo isset($item['reply_count'])?$item['reply_count']:"";?></i></p>
            <p class="ordbigbt t-right"><span>浏览量：</span><i class="ordbigbt-price"><?php echo isset($item['views'])?$item['views']:"";?></i></p>
        </div>
    </div>
    <div class="mui-card-footer">
        <a class="mui-card-link del_btn" href="javascript: void(0);" _id="<?php echo isset($item[id])?$item[id]:"";?>">删除</a>
        <a class="mui-card-link" href="<?php echo IUrl::creatUrl("/ucenter/article_add/id/".$item['id']."");?>">修改</a>
    </div>
</div>
<?php }?>
<?php }else{?>
<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            暂时没有任何文章
        </div>
    </div>
</div>
<?php }?>

<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
						<button type="button" class="mui-btn mui-btn-primary mui-btn-outlined mui-add">发布文章</button>
				</div>
		</div>
</div>


<script type="text/javascript">
$(function(){
		mui('body').on('tap', '.mui-add',function(){
			document.location.href = '<?php echo IUrl::creatUrl("/ucenter/article_add");?>';
		})
    mui('body').on('tap', '.del_btn', function(){
        var id = this.getAttribute('_id');
        mui.confirm('确定删除文章吗？', '删除文章', ['取消', '删除'], function(e) {
            if (e.index == 1) {
                mui.getJSON('<?php echo IUrl::creatUrl("/ucenter/article_ajax_del");?>', {id: id}, function(json){
                    if(json.msg == 1){
                        mui.toast('删除成功');
                        window.location.reload();
                    }else if(json.msg == -1){
                        mui.toast('信息不正确');
                    }else if(json.msg == -2){
                        mui.toast('文章不存在或者已被删除');
                    }else{
                        mui.toast('删除失败');
                    }
                });
            }
        })
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
