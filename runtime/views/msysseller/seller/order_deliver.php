<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="/resource/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/resource/scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="/resource/scripts/common.js"></script>
	<script type="text/javascript">mui.init();var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }else{?>
		<a href="" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php $this->title = '订单发货'; ?>

<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/artTemplate/area_select.js";?>'></script>
<script type="text/javascript" src="/resource/scripts/layer_mobile/layer.js" ></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<style>
.module {
	width: 98%;
	margin: 0px auto;
	margin-top: 12px;
	background-color: #fff;
	font-size: 80%;
	padding-left: 2%;
	padding-right: 2%;
	padding-top: 2%;
	padding: 10px;
}
.gridtable, .gridtable2 {
	margin-bottom: 20px;
	border: 1px solid #ccc;
	width: 98%;
	margin: 0px auto;
	margin-bottom: 12px;
}
.gridtable th, .gridtable2 th {
	height: 30px;
	line-height: 30px;
	text-align: center;
	font-weight: 400;
}
.gridtable td, .gridtable2 td {
	text-align: center;
	padding: 4px 0;
}
.gridtable2 td {
	text-align: left;
}
p {
	line-height: 25px;
}
p input {
	height: 25px;
}
footer input { width: 20%; padding: 5px 0; color: #fff; background-color: #ff5500; border: 0px; border-radius: 3px; }
.submit_link {text-align:center;}
</style>
<article class="module width_full">

	<form action="<?php echo IUrl::creatUrl("/seller/order_delivery_doc");?>" method="post" id="deliver_form">

		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>

		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>

		<input type="hidden" name="weight_total" id="weight_total" value="<?php echo isset($goods_weight)?$goods_weight:"";?>"/>

		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>

		<input type="hidden" name="freight" value="<?php echo isset($real_freight)?$real_freight:"";?>" />


			<table class="gridtable clear" cellpadding="0" cellspacing="0">

				<thead>

					<tr style="background-color: #a0bbed;">

						<th width="45%">课程</th>

						<th width="15%">学费</th>

						<th width="16%">数量</th>

						<th width="25%" onclick="selectAll('sendgoods[]')">确认课程</th>

					</tr>

				</thead>



				<tbody>

					<?php $seller_id = $this->seller['seller_id']?>

					<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id and seller_id = $seller_id";$items = $query->find(); foreach($items as $key => $item){?>

					<tr>

						<td>

							<?php $goodsRow = JSON::decode($item['goods_array'])?>

							<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>

						</td>

						<td><?php echo isset($item['real_price'])?$item['real_price']:"";?></td>

						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>

						<td>

							<?php if($item['is_send'] == 0){?>

							<input type="checkbox" name="sendgoods[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" />

							<?php }else{?>

							<?php echo Order_class::goodsSendStatus($item['is_send']);?>

							<?php }?>

						</td>

					</tr>

					<?php }?>

				</tbody>

			</table>


			<table class="gridtable2 clear">

				<tbody>

					<tr>
                    	<td width="30%;">&nbsp; 订单号：</td>
                        <td><?php echo isset($order_no)?$order_no:"";?></td>
                    </tr>

					<tr>
                    	<td>&nbsp; 下单时间：</td>
                        <td><?php echo isset($create_time)?$create_time:"";?></td>
                    </tr>

					<tr style="display:none;">
                    	<td>配送方式：</td>
                        <td>
                        	<?php $query = new IQuery("delivery");$query->where = "is_delete = 0";$items = $query->find(); foreach($items as $key => $item){?>

							<?php if($distribution == $item['id']){?>

							<input type='hidden' value='<?php echo isset($item['id'])?$item['id']:"";?>' name='delivery_type' />

							<?php echo isset($item['name'])?$item['name']:"";?>

							<?php }?>

							<?php }?>
                        </td>
                    </tr>

					<tr style="display:none;">
                    	<td>配送费用：</td>
                        <td>&yen;<?php echo isset($real_freight)?$real_freight:"";?></td>
                    </tr>

					<tr style="display:none;">
                    	<td>消费保证费用：</td>
                        <td>&yen;<?php echo isset($insured)?$insured:"";?></td>
                    </tr>

					<tr>
                    	<td>&nbsp; 买家姓名：</td>
                        <td><input type="text" style="height:22px;width:60%;" class="small" name="name" value="<?php echo isset($accept_name)?$accept_name:"";?>" pattern="required"/></td>
                    </tr>

					<tr>
                    	<td>&nbsp; 电话：</td>
                        <td><input type="text" class="small" style="height:22px;width:60%;"name="telphone" value="<?php echo isset($telphone)?$telphone:"";?>" pattern="phone" empty /></td>
                    </tr>

					<tr>
                    	<td>&nbsp; 手机：</td>
                        <td><input type="text" class="small"style="height:22px;width:60%;" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" pattern="mobi"/></td>
                    </tr>

					<tr style="display: none;">
                    	<td>邮政编码：</td>
                        <td><input type="text"style="height:25px;width:60%;" name="postcode" class="small" value="<?php echo isset($postcode)?$postcode:"";?>" pattern="zip" empty /></td>
                    </tr>

					<tr style="display: none;">
                    	<td></td>
                        <td>

                            <p>物流公司:

                                <select name="freight_id" pattern="required" style="height:25px;width:48%;"alt='<br/>选择物流公司' class="auto">

                                <option value="">选择物流公司</option>

                                        <?php $query = new IQuery("freight_company");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>

                                <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['freight_name'])?$item['freight_name']:"";?></option>

                                        <?php }?>

                                </select><br/>

                                    <label class="tip"(选择物流公司)</label>

                            </p>

                            <p>配送单号:<input type="text" style="height:25px;width:50%;"class="normal" name="delivery_code" pattern="required"/></p>

                            <p>地区:

                                    <select name="province" style="height:25px;width:25%;"child="city,area" onchange="areaChangeCallback(this);" class="auto"></select>

                                    <select name="city" style="height:25px;width:25%;"child="area" parent="province" onchange="areaChangeCallback(this);" class="auto"></select>

                                    <select name="area"style="height:25px;width:25%;"parent="city" pattern="required" class="auto"></select>

                            </p>

                            <p>地址:<input type="text" style="height:25px;width:60%;"class="normal" name="address" value="<?php echo isset($address)?$address:"";?>"  pattern="required"/></p>

                            <p>发货单备注:<p></p><textarea style="height:80px;width:70%;"name="note" class="normal"></textarea>

                            </p>


                        </td>
                    </tr>

				</tbody>

			</table>

		<footer>

			<div class="submit_link">

				<input type="submit" class="alt_btn" value="确 定" onclick="return checkForm()" />

			</div>

		</footer>

	</form>

</article>




<script type="text/javascript">

//DOM加载完毕

$(function(){

	//初始化地域联动

	template.compile("areaTemplate",areaTemplate);



	createAreaSelect('province',0,<?php echo isset($province)?$province:"";?>);

	createAreaSelect('city',<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>);

	createAreaSelect('area',<?php echo isset($city)?$city:"";?>,<?php echo isset($area)?$area:"";?>);

});



/**

 * 生成地域js联动下拉框

 * @param name

 * @param parent_id

 * @param select_id

 */

function createAreaSelect(name,parent_id,select_id)

{

	//生成地区

	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)

	{

		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));

	});

}



//表单提交前检测

function checkForm()

{

	var checkedNum = $('input[name="sendgoods[]"]:checked').length;

	if(checkedNum == 0)

	{

		//信息框
		layer.open({
			content: '请选择需要确认的课程'
			,btn: '好的'
		});

		return false;

	}

	return true;

}

</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">页面信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">基本信息</span>
	    </a>
	    <!-- <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a> -->
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
	        <i class="mui-icon-my icon-shopping-cart"></i>
	        <span class="mui-tab-label">学校订单</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/meau_index");?>" id="ltelBtn">
	        <i class="mui-icon-my icon-user"></i>
	        <span class="mui-tab-label">管理中心</span>
	    </a>
	</nav>
</body>
</html>
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
