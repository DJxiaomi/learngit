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
<script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.all.min.js"></script>
<style>
    .format{clear:both;margin:5px 0;}
    #contentbox img{width:100%;}
    .img_outer{position:relative;}
    .img_outer .img_modify{position:absolute;top:10px;left:2px;     font-size: 14px;
    font-weight: 400;
    line-height: 1.42;
    display: inline-block;
    margin-bottom: 0;
    padding: 6px 12px;
    cursor: pointer;
    -webkit-transition: all;
    transition: all;
    -webkit-transition-timing-function: linear;
    transition-timing-function: linear;
    -webkit-transition-duration: .2s;
    transition-duration: .2s;
    text-align: center;
    vertical-align: top;
    white-space: nowrap;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 3px;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    background-color: #fff;
    background-clip: padding-box;}
    .img_outer .img_del{position:absolute;top:10px;right:2px;}
    .headpic{position: fixed; top:44px;left:0;z-index:9999;display: none;}
    .rules {width: 96%;margin-left:3%;}
    .rules img {max-width: 100%;}
    .slides img {max-width: 100%;}
</style>
<div class="article-add">
    <form method="post" action="<?php echo IUrl::creatUrl("/ucenter/article_update_mobile2");?>" enctype='multipart/form-data' id="articleForm">
        <?php if($article['id']){?><input type="hidden" name="id" value="<?php echo isset($article['id'])?$article['id']:"";?>"  /><?php }?>
        <input type="hidden" name="content" id="content" />
        <input type="hidden" name="formatcontent" id="formatcontent" />
        <div class="slides"><img src="/views/mobile/skin/blue/images/yjzy_header.jpg" /></div>
		<h5 class="mui-content-padded">发布您的课程报告</h5>
        <div class="mui-card">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <!-- <label>标题</label> -->
                    <input type="text" name="name" id="name" value="<?php echo isset($article['name'])?$article['name']:"";?>" placeholder="姓名" />
                </div>
            </div>
        </div>
        <div class="mui-card">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <!-- <label>标题</label> -->
                    <input type="text" name="tel" id="tel" value="<?php echo isset($article['tel'])?$article['tel']:"";?>" placeholder="电话号码" />
                </div>
            </div>
        </div>
        <div class="mui-card">
            <div class="mui-input-group">
                <div class="mui-input-row">
                    <!-- <label>标题</label> -->
                    <input type="text" name="title" id="title" value="<?php echo isset($article['title'])?$article['title']:"";?>" placeholder="课程报告标题" />
                </div>
            </div>
        </div>
        <!-- <h5 class="mui-content-padded">文章内容</h5> -->
        <div class="mui-input-row mui-textarea-row" id="contentbox">
             <?php if($article['formats']){?>
                <?php $index = 0?>
            <?php foreach($article['formats'] as $key => $item){?>
                <?php if(!empty($item)){?>
                <?php if(preg_match('/img/', $item)){?>
                <div class="img_outer"><?php echo isset($item)?$item:"";?><a class="img_modify" id="img_<?php echo isset($index)?$index:"";?>" href="javascript:void(0);">修改</a><button class="img_del">删除</button></div>
                <?php $index++?>
                <?php }else{?>
                <textarea rows="5" class="format" id="content_c<?php echo isset($key)?$key:"";?>" data-type="txt" placeholder="课程报告内容"><?php echo isset($item)?$item:"";?></textarea>
                <?php }?>
                <?php }?>
            <?php }?>
            <?php }else{?>
            <textarea rows="5" class="format" id="content_m" data-type="txt" placeholder="课程报告内容">
学校位置：
学校环境：
学费：
上课的内容及感受：
您的建议：</textarea>
            <?php }?>


        </div>
        <div class="mui-content-padded" style="height:1%;overflow:hidden;">
            <button type="button" class="muiprimary" id="uppic" data-btn="">插入图片</button>
            <button type="button" class="muidanger" onclick="addContent('content')" style="display:none;">插入内容</button>
        </div>
        <div class="mui-content-padded">
            <button type="button" id="postarticle" class="mui-btn mui-btn-primary mui-btn-block" data-loading-text = "提交中" data-loading-icon-position="right">发表课程报告</button>
        </div>
    </form>

    <div class="rules">
      <img src="/views/mobile/skin/blue/images/yjzj_1.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_2.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_3.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_4.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_5.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_6.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_7.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_8.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_9.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_10.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_11.jpg" />
      <img src="/views/mobile/skin/blue/images/yjzj_12.jpg" />
    </div>

</div>




<div class="headpic" data-btn=""></div>

<script>
if($('#content_m').length > 0){
    //createEditor('content_m');
}

$(function(){
    $('#postarticle').on('click',function(){
        getContent();
    })

    $('textarea[id^=content_c]').each(function(i){
        var vname = $(this).attr('id');
        createEditor(vname);
    })

    $('#contentbox').find('img').each(function(i){
        $(this).addClass('format').attr('data-type','image');
    })

    $('#contentbox').on('tap','.img_del',function(){
        $(this).parent('.img_outer').remove();
    })

    $(document).on('tap','.img_modify',function(){
        $('.headpic').attr('data-btn',$(this).attr('id'));
        $('#jUploader-file1').click();
    })

});

$.jUploader({
    button: 'uppic',
    action: '<?php echo IUrl::creatUrl("/ucenter/article_upload");?>',
    allowedExtensions: ['jpg', 'png', 'gif', 'jpeg'],
    onComplete: function(fileName, response){
      if(response.success){
        var img_id = $('.headpic').attr('data-btn');
        if(img_id != ''){
            $('#'+img_id).siblings('img').attr('src','/'+response.fileurl);
            $('.headpic').attr('data-btn','');
        }else{
            var num = $('.img_outer').length;
            $('#contentbox').append('<div class="img_outer"><img width="100%" class="format" data-type="image" src="/' + response.fileurl + '" /><a class="img_modify" id="img_'+num+'">修改</a><button class="img_del" style="display:none;">删除</button></div>');
        }
      }else{
        alert('上传失败');
      }
    }
});

function createEditor(_str){
    UE.getEditor(_str,{
        elementPathEnabled : false,
        toolbars: [
            ['justifyleft', 'justifyright', 'justifycenter', 'justifyjustify','fontsize' ]
        ],
    });
}

function addContent(type){
    var num = $('.format').length;
    var cname = 'content'+num;
    var imgurl = '<input type="file" class="file" name="imgurl[]">',
        content = '<textarea rows="5" class="format" id="'+cname+'" data-type="txt" placeholder="文章内容"></textarea>';
    if(type == 'file'){
        $('#contentbox').append(imgurl);
    }else if(type = 'content'){
        $('#contentbox').append(content);
        createEditor(cname);
    }else{
        return;
    }
}

function getContent(){
    if($('#name').val() == ''){
        mui.toast('请输入姓名');
        return false;
    }
    if($('#tel').val() == ''){
        mui.toast('请输入电话号码');
        return false;
    }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    if(!myreg.test($('#tel').val()))
    {
      mui.toast('手机号码格式不正确');
      return false;
    }
    if($('#title').val() == ''){
        mui.toast('请输入试听报告标题');
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
    if ( content == '')
    {
      mui.toast('请输入试听报告的内容');
      return false;
    }

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
