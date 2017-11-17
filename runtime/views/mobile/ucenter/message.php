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
	<div class="main f_r">
    <div class="uc_title m_10">
        <label class="current"><span>短消息</span></label>
    </div>
    <table class="list_table m_10" width="100%" cellpadding="0" cellspacing="0">
    	<colgroup>
	        <col />
	        <col width="160px" />
	        <col width="120px" />
	        <col width="120px" />
    	</colgroup>

        <thead><tr><th>标题</th><th>发送时间</th><th>状态</th><th>操作</th></tr></thead>
		<tbody>
        	<?php $queryMessageList = Api::run('getUcenterMessageList',$msgIds)?>
			<?php foreach($queryMessageList->find() as $key => $item){?>
        	<tr>
            	<td class="t_l"><label class="blue"><?php echo isset($item['title'])?$item['title']:"";?></label></td>
            	<td><?php echo isset($item['time'])?$item['time']:"";?></td>
            	<td id="msg_id_<?php echo isset($item['id'])?$item['id']:"";?>"><?php if($msgObj->is_read($item['id'])){?>已读<?php }else{?>未读<?php }?></td>
            	<td class="blue">
            		<a class='blue' href="<?php echo IUrl::creatUrl("/ucenter/message_del/id/".$item['id']."");?>">删除</a>
            		<a class="blue" href="javascript:void(0)" onclick='show_msg(this,<?php echo JSON::encode($item);?>)'>查看</a>
            	</td>
            </tr>
			<?php }?>

            <tr id='show_msg' class="show" style="display:none">
            	<td colspan="4">
            		<i class="close f_r" onclick='$("#show_msg").hide();'></i>
            		<b class="orange">详细内容：</b><p class="gray indent mt_10" id='content'></p>
            	</td>
            </tr>
        </tbody>
        <tfoot><tr><td colspan="4" class="t_l"><?php echo $queryMessageList->getPageBar();?></td></tr></tfoot>
    </table>
</div>

<script type="text/javascript">
//阅读消息
function show_msg(_self,obj)
{
    $('#show_msg').insertAfter($(_self).parent().parent());
    $('#show_msg #content').html(obj.content);
    $('#show_msg').show();

    $.get("<?php echo IUrl::creatUrl("/ucenter/message_read");?>",{"id":obj.id},function(data){
	    if(data == 1)
	    {
	    	$("#msg_id_"+obj.id).addClass('bold');
	    	$("#msg_id_"+obj.id).html('已读');
	    }
    });
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
