<?php $isProducts= IFilter::act(IReq::get('is_products'),'int');?>
<?php $tmpType   = IFilter::act(IReq::get('type'));?>
<?php $seller_id = IFilter::act(IReq::get('seller_id'),'int');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
<style>
.__address * {padding: 0;margin: 0;list-style: none;}
.__address .__address_alert li {position: relative;margin: 20px 0;}
.__address .__address_alert li .__item {
	position: absolute;height: 10px;line-height: 10px;background: #fff;top: -7px;padding: 0 10px;left: 5px;
	color: #999;font-size: 11px;z-index: 1;
}
.__address .__address_alert li .__text,.__address .__address_alert li select {
	display: block;width: 100%;height: 16px;line-height: 16px;border-radius: 0;padding: 10px 0;border: none;
	background: #fff;text-indent: 10px;box-shadow: 0 0 0 1px #ddd;
}
.__address .__address_alert li select {
	width: 100%;height: 36px;line-height: 36px;padding: 0;margin: 0;
}
.__address .__address_alert li .__btn{
	min-height: 36px;line-height:1;box-shadow: 0 0 0 1px #ddd;color:#999;background: #fafafa;font-size: 13px;
}
.__address .__address_alert li .__catbox {
	margin-top: 5px;
}
.__address .__address_alert li .__catbox .btn{
	display: inline-block;padding: 5px;color: #fff;background: blue;border: none;margin-right: 5px;
}
</style>
</head>
<body class="__address">
	<section class="__address_alert">
		<form action='<?php echo IUrl::creatUrl("/block/goods_list/type/".$tmpType."");?>' method='post'>
			<input type='hidden' name='is_products' value='<?php echo isset($isProducts)?$isProducts:"";?>' />
			<input type='hidden' name='seller_id' value='<?php echo isset($seller_id)?$seller_id:"";?>' />
			<ul>
				<li>
					<span class="__item">商品名称</span>
					<input type='text' class='__text' name='keywords' />
				</li>
				<li>
					<span class="__item">商品货号</span>
					<input type='text' class='__text' name='goods_no' />
				</li>
				<li>
					<span class="__item">商品分类：</span>
					<input class="__btn __text" type="button" name="_goodsCategoryButton" value="设置分类">
					<p class="__catbox" id="__categoryBox"></p>
					<?php plugin::trigger('goodsCategoryWidget',array("name" => "category_id"))?>
				</li>
				<li>
					<span class="__item">商品价格下限</span>
					<input type='text' class='__text' name='min_price'  pattern='float' empty />
				</li>
				<li>
					<span class="__item">商品价格上限</span>
					<input type='text' class='__text' name='max_price'  pattern='float' empty />
				</li>
				<li>
					<span class="__item">显示数量</span>
					<select name='show_num'>
						<option value='10' selected='selected'>10</option>
						<option value='20'>20</option>
					</select>
				</li>
			</ul>
		</form>
	</section>
</body>
</html>
