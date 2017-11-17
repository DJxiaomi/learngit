<!doctype html>

<html>

<head>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<title><?php echo $siteConfig->name;?></title>

	<link type="image/x-icon" href="favicon.ico" rel="icon">

	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>

	<link href="<?php echo $this->getWebSkinPath()."school/css/bootstrap.min.css";?>" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."school/css/lightbox.css";?>" type="text/css" media="all" />

	<link href="<?php echo $this->getWebSkinPath()."school/css/style.css";?>" rel="stylesheet" type="text/css"/>

	<script src="<?php echo $this->getWebSkinPath()."school/js/bootstrap.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/easing.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/TouchSlide.1.1.js";?>"></script>

	<script type="text/javascript">mui.init();var SITE_URL = 'http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>';</script>

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

	<?php

$host = get_host();
$seller_id = IFilter::act(IReq::get('id'),'int');
$sellerRow = Api::run('getSellerInfo',$seller_id);
$user_id = $this->user['user_id'];
$_GET['order'] = 'sort';
$member_info = array();
$goodsObj = search_goods::find(array('go.seller_id' => $seller_id));
$resultData = $goodsObj->find();
if ( $user_id )
    $member_info = member_class::get_member_info($user_id);

if ( !$sellerRow['is_system_seller'] )
{
    header("location: " . IUrl::creatUrl('/school/home/id/' . $seller_id));
    exit();
}

if(!$sellerRow)
{
    IError::show(403,'商户信息不存在');
}

$this->title = $sellerRow['true_name'];

if ( $resultData )
{
  foreach( $resultData as $kk => $vv )
  {
    $resultData[$kk]['products_list'] = products_class::get_product_list($vv['id']);
    if ( $vv['relative_goods_id'] > 0 )
    {
      $goods_info = goods_class::get_goods_info($vv['relative_goods_id'] );
      $resultData[$kk]['relative_seller_id'] = $goods_info['seller_id'];
    }
  }
}
?>
<link href="<?php echo $this->getWebSkinPath()."css/free_class.css";?>" rel="stylesheet" type="text/css" />
<div class="free_class_content">
  <div class="free_class_hd">
    <img src="<?php echo $this->getWebSkinPath()."images/free_class_img_1.jpg";?>" />
  </div>
  <div class="free_class_bd">
    <?php if($resultData){?>
    <ul>
      <?php foreach($resultData as $key => $item){?>
      <?php  $id = ($item['products_list'][0]) ? $item['products_list'][0]['id'] : $item['id']?>
      <li>
        <div class="class_image">
          <a href="http://<?php echo isset($host)?$host:"";?><?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" /></a>
        </div>
        <div class="class_action">
          <?php if($item['relative_seller_id'] > 0){?>
          <a class="class_info" href="http://<?php echo isset($host)?$host:"";?><?php echo IUrl::creatUrl("/school/home/id/".$item['relative_seller_id']."");?>"><img src="<?php echo $this->getWebSkinPath()."images/class_info_btn.png";?>" /></a>
          <?php }else{?>
          <a class="class_info" href="http://<?php echo isset($host)?$host:"";?><?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo $this->getWebSkinPath()."images/class_info_btn.png";?>" /></a>
          <?php }?>
          <a class="class_register" href="<?php if($item['products_list'][0]){?>http://<?php echo isset($host)?$host:"";?><?php echo IUrl::creatUrl("/simple/cart2/id/".$id."/num/1/type/product");?><?php }else{?><?php echo IUrl::creatUrl("/simple/cart2/id/".$id."/num/1/type/goods");?><?php }?>"><img src="<?php echo $this->getWebSkinPath()."images/class_register_btn.png";?>" /></a>
        </div>
        <?php if($item['recommend'] == 2){?>
        <span class="boutique"></span>
        <?php }?>
      </li>
      <?php }?>
    </ul>
    <?php }?>
  </div>
</div>

<script language="javascript">
$(document).ready(function(){
  $('.mui-title').html('<?php echo $this->title;?>');
})
</script>


	</div>

	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_discount'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_props'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/366");?>">
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

<!-- mui('body').on('tap', 'a', function(){ -->

    <!-- if(this.href != '#' && this.href != ''){ -->

        <!-- mui.openWindow({ -->

            <!-- url: this.href -->

        <!-- }); -->

    <!-- } -->

    <!-- this.click(); -->

<!-- }); -->

(function($) {

	$(document).imageLazyload({

		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'

	});

})(mui);

</script>
