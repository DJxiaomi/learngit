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
	<?php $callback = IUrl::creatUrl('/ucenter/article_list');?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
<style>
.mui-check-left {width:22%;float:left;}
</style>
<div class="article-add">
    <form method="post" action="<?php echo IUrl::creatUrl("/ucenter/article_update_mobile3");?>" enctype='multipart/form-data' id="articleForm">
        <?php if($article['id']){?><input type="hidden" name="id" value="<?php echo isset($article['id'])?$article['id']:"";?>"  /><?php }?>
        <input type="hidden" name="content" id="content" />
        <input type="hidden" name="formatcontent" id="formatcontent" />
        <h5 class="mui-content-padded">填写报名信息</h5>
        <div class="mui-card">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <!-- <label>标题</label> -->
                    <input type="text" name="title" id="title" value="<?php echo isset($article['title'])?$article['title']:"";?>" placeholder="小孩的姓名" />
                </div>
            </div>
        </div>

        <div class="mui-card">
          <div class="mui-input-group">
              <div class="mui-input-row">
                  <!-- <label>标题</label> -->
                  <input type="text" name="age" id="age" value="<?php echo isset($article['age'])?$article['age']:"";?>" placeholder="小孩的年龄" />
              </div>
          </div>
        </div>

        <div class="mui-card">
          <div class="mui-input-group">
              <div class="mui-input-row">
                  <!-- <label>标题</label> -->
                  <input type="text" name="tel" id="tel" value="<?php echo isset($article['tel'])?$article['tel']:"";?>" placeholder="家长联系电话" />
              </div>
          </div>
        </div>

        <div class="mui-card">
          <div class="mui-input-group">
              <div class="mui-input-row">
                  <label>家长是否教师</label>
                  <div class="mui-radio mui-left mui-check-left">
                    <label class="auto">是</label>
                    <input type="radio" name="is_teacher" value="1">
                  </div>
                  <div class="mui-radio mui-left mui-check-left">
                    <label class="auto">否</label>
                    <input type="radio" name="is_teacher" value="0" checked>
                  </div>
              </div>
          </div>
        </div>






        <!-- <h5 class="mui-content-padded">文章内容</h5> -->
        <div class="mui-input-row mui-textarea-row" id="contentbox">
            <button type="button" class="muiprimary" id="uppic">上传宝宝的图片</button>
            <button type="button" class="muidanger" onclick="addContent('content')" style="display:none;">插入内容</button>
        </div>
        <div class="mui-content-padded">
            <input type="hidden" name="images" value="" />
            <button type="button" id="postarticle" class="mui-btn mui-btn-primary mui-btn-block" data-loading-text = "提交中" data-loading-icon-position="right">提交信息</button>
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
        $('#contentbox').html('<img width="100%" class="format" data-type="image" src="/' + response.fileurl + '" />');
        var img = $("input[name=images]").val();
        if ( img == '')
        {
            $("input[name=images]").val(response.fileurl);
        } else {
            $("input[name=images]").val(img + ',' + response.fileurl);
        }

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
        mui.toast('请输入小孩的姓名');
        return false;
    }
    if($('#age').val() == ''){
        mui.toast('请输入小孩的年龄');
        return false;
    }
    if($('#tel').val() == ''){
        mui.toast('请输入家长联系电话');
        return false;
    }
    var img = $("input[name=images]").val();
    if ( img == '' )
    {
      mui.toast('请上传宝宝的图片');
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
