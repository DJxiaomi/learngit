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
	<?php $callback = IUrl::creatUrl('/ucenter/article_list');?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
<div class="article-add">
    <form method="post" action="<?php echo IUrl::creatUrl("/ucenter/article_update_mobile");?>" enctype='multipart/form-data' id="articleForm">
        <?php if($article['id']){?><input type="hidden" name="id" value="<?php echo isset($article['id'])?$article['id']:"";?>"  /><?php }?>
        <input type="hidden" name="content" id="content" />
        <input type="hidden" name="formatcontent" id="formatcontent" />
        <h5 class="mui-content-padded">发布您的文章</h5>
        <div class="mui-card">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <!-- <label>标题</label> -->
                    <input type="text" name="title" id="title" value="<?php echo isset($article['title'])?$article['title']:"";?>" placeholder="文章标题" />
                </div>
            </div>
        </div>
        <!-- <h5 class="mui-content-padded">文章内容</h5> -->
        <div class="mui-input-row mui-textarea-row" id="contentbox">
             <?php if($article['formats']){?>
            <?php foreach($article['formats'] as $key => $item){?>
                <?php if(!empty($item)){?>
                <?php if(preg_match('/img/', $item)){?>
                <?php echo isset($item)?$item:"";?>
                <?php }else{?>
                <textarea rows="5" class="format" data-type="txt" placeholder="文章内容"><?php echo isset($item)?$item:"";?></textarea>
                <?php }?>
                <?php }?>
            <?php }?>
            <?php }else{?>
            <textarea rows="5" class="format" data-type="txt" placeholder="文章内容"></textarea>
            <?php }?>

    <button type="button" class="muiprimary" id="uppic">插入图片</button>
    <button type="button" class="muidanger" onclick="addContent('content')">插入内容</button>
</div>
        <div class="mui-content-padded">
            <button type="button" id="postarticle" class="mui-btn mui-btn-primary mui-btn-block" data-loading-text = "提交中" data-loading-icon-position="right">发表文章</button>
        </div>
    </form>
</div>



<script>
$(function(){
    document.getElementById('postarticle').addEventListener('tap', function(){
        getContent();
    });
});

$.jUploader({
    button: 'uppic',
    action: '<?php echo IUrl::creatUrl("/ucenter/article_upload");?>',
    allowedExtensions: ['jpg', 'png', 'gif', 'jpeg'],
    onComplete: function(fileName, response){
      if(response.success){
        $('#contentbox').append('<img width="100%" class="format" data-type="image" src="/' + response.fileurl + '" />');
      }else{
        alert('上传失败');
      }
    }
});
function addContent(type){
    var imgurl = '<input type="file" class="file" name="imgurl[]">',
        content = '<textarea rows="5" class="format" data-type="txt" placeholder="文章内容"></textarea>';
    if(type == 'file'){
        $('#contentbox').append(imgurl);
    }else if(type = 'content'){
        $('#contentbox').append(content);
    }else{
        return;
    }
}

function getContent(){
    if($('#title').val() == ''){
        mui.toast('请输入文章标题');
        return false;
    }
    var content = '', formatcontent = '';
    $('.format').each(function(i, el){
        var type = $(el).attr('data-type');
        var src = $(el).attr('src');
        var txt = $(el).val();
        if(type == 'image'){
            content += '<img src="' + src + '">';
            formatcontent += '<img src="' + src + '">' + '||';
        }else if(type == 'txt'){
            content += txt;
            formatcontent += txt + '||';
        }else{
            content += '';
            formatcontent += '';
        }
    });

    $('#content').val(content);
    $('#formatcontent').val(formatcontent);

    $('#articleForm').submit();
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
