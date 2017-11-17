<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品列表</title>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
</head>
<?php $dev = IClient::getDevice()?>
<?php if($dev=="pc"){?>
<body>
<div class="pop_win" style="width:690px;height:550px;overflow-y:scroll">
	<div class="content">
		<table class="border_table" style="width:100%">
			<colgroup>
				<col width="150px" />
				<col />
				<col width="90px" />
				<col width="70px" />
			</colgroup>
			<tbody>
				<?php if($this->data){?>
				<?php foreach($this->data as $key => $item){?>
				<tr>
					<td>
						<label class='attr'>
							<input type='<?php echo ($this->type == null) ? 'checkbox' : $this->type;?>' name='id[]' value="<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>" id="goods<?php echo isset($key)?$key:"";?>" />
							<?php echo isset($item['goods_no'])?$item['goods_no']:"";?>
							<script>$("#goods<?php echo isset($key)?$key:"";?>").attr('data',JSON.stringify(<?php echo JSON::encode($item);?>));</script>
						</label>
					</td>
					<td class="t_l">
						<?php echo isset($item['name'])?$item['name']:"";?>
						<?php $spec_array=Block::show_spec($item['spec_array']);?>
						<?php foreach($spec_array as $specName => $specValue){?>
						<p><?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?></p>
						<?php }?>
					</td>
					<td>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
					<td><img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" width="40px" class="img_border" /></td>
				</tr>
				<?php }?>
				<?php }else{?>
				<tr>
					<td colspan="4">对不起，没有找到相关商品</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>
<?php }else{?>
<body class="__goods">
	<section class="__goods_list">
		<ul>
			<?php if($this->data){?>
			<?php foreach($this->data as $key => $item){?>
			<li>
				<label>
					<input type='<?php echo ($this->type == null) ? 'checkbox' : $this->type;?>' name='id[]' value="<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>" data='<?php echo JSON::encode($item);?>' />
					<div class="__goods_item">
						<img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>"  />
						<h4><?php echo isset($item['name'])?$item['name']:"";?></h4>
						<em>价格：￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></em>
					</div>
				</label>
			</li>
			<?php }?>
			<?php }else{?>
			对不起，没有找到相关商品
			<?php }?>
		</ul>
	</section>
<style>
.__goods {width: 290px;}
.__goods,.__goods * {margin: 0;padding: 0;list-style: none;}
.__goods .__goods_list {padding: 8px;max-height: 500px;overflow-y: scroll;}
.__goods .__goods_list ul{overflow: hidden;width: 270px;}
.__goods .__goods_list ul li{width: 135px;float: left;margin-bottom: 10px;}
.__goods .__goods_list ul li label{display: block;width: 130px;margin: auto;padding: 2.5px;}
.__goods .__goods_list ul li label input {display: none;}
.__goods .__goods_list ul li label .__goods_item {}
.__goods .__goods_list ul li label input:checked + .__goods_item {background: yellow;box-shadow: 0 0 0 5px yellow}
.__goods .__goods_list ul li label .__goods_item img{display: block;width: 130px;height: 130px;}
.__goods .__goods_list ul li label .__goods_item h4{height: 40px;line-height: 20px;font-weight: normal;display: block;overflow: hidden;text-align: left;}
.__goods .__goods_list ul li label .__goods_item em{display: block;text-align: left;color:red;}
</style>

<?php }?>
</body>
</html>
