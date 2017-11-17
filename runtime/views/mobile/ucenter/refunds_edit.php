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
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<div class="main f_r">
    <div class="uc_title">
        <label class="current"><span>退款申请</span></label>
    </div>

	<div class="box">
		<form action="<?php echo IUrl::creatUrl("/ucenter/refunds_update");?>" method="post" callback="checkForm();">
			<input type="hidden" name="order_id" value="<?php echo isset($this->orderRow['id'])?$this->orderRow['id']:"";?>" />
			<table class="border_table" width="100%" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="140px" />
					<col />
				</colgroup>
				<tr>
					<th>订单号：</th>
					<td><?php echo isset($this->orderRow['order_no'])?$this->orderRow['order_no']:"";?></td>
				</tr>

				<tr>
					<th>退款商品：</th>
					<td>
						<?php foreach(Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$this->orderRow['id'])) as $key => $good){?>
						<?php $good_info = JSON::decode($good['goods_array'])?>
						<?php if($good['is_send'] != 2){?>
						<p>
							<label>
								<input type="checkbox" name="order_goods_id[]" value="<?php echo isset($good['id'])?$good['id']:"";?>" />
								<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$good['goods_id']."");?>" target='_blank'><?php echo isset($good_info['name'])?$good_info['name']:"";?><?php if($good_info['value']){?><?php echo isset($good_info['value'])?$good_info['value']:"";?><?php }?> X <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?></a>
							</label>
						</p>
						<?php }?>
						<?php }?>
					</td>
				</tr>

				<tr>
					<th>退款理由：</th>
					<td>
						<textarea name="content" id="content" style="width:95%;height:300px" pattern="required"></textarea>
						<label>请写明退款理由，上传问题商品图片</label>
					</td>
				</tr>

				<tr>
					<th></th>
					<td>
						<label class="btn"><input type="submit" value="提交退款" /></label>
						<label class="btn"><input type="reset" value="重置" /></label>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type="text/javascript">
//编辑器载入
KindEditorObj = KindEditor.create('#content',
{
	items : [
		'fontsize', '|', 'forecolor','bold', 'italic', 'underline',
		'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
		'insertunorderedlist', '|', 'emoticons', 'image', 'link']
});

//提交表单检查
function checkForm()
{
	if($('#content').val() == '')
	{
		alert('请填写退款原因');
		return false;
	}

	if($('[name="order_goods_id[]"]:checked').length == 0)
	{
		alert('请选择要退款的商品');
		return false;
	}
	return true;
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
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'brand'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/brand");?>" id="ztelBtn">
					<span class="mui-tab-label">学校</span>
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
