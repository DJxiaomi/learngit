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

$seller_id = IFilter::act(IReq::get('id'),'int');
$page = IFilter::act(IReq::get('page'),'int');
$page = max($page, 1);
$page_size = 10;
$sellerRow = Api::run('getSellerInfo',$seller_id);
$user_id = $this->user['user_id'];
$member_info = array();
$resultData = search_goods::get_special_seller_goods_list($seller_id, $page, $page_size);
$page_info = $resultData['page_info'];
$page_count = $resultData['page_count'];
$list = $resultData['list'];
if ( $user_id )
    $member_info = member_class::get_member_info($user_id);

if ( !$sellerRow['is_system_seller'] )
{
    header("location: " . IUrl::creatUrl('/school/home/id/' . $seller_id));
    exit();
}

if(!$sellerRow)
{
    IError::show(403,'信息不存在');
}

$this->title = $sellerRow['true_name'];
$time = time();

?>
<link href="<?php echo $this->getWebSkinPath()."css/mlmm.css";?>" rel="stylesheet" type="text/css" />
<script language="javascript">
var _page_count = <?php echo isset($page_count)?$page_count:"";?>;
var _curr_page = <?php echo isset($page)?$page:"";?>;
var _page_size = <?php echo isset($page_size)?$page_size:"";?>;
var _loading = false;
var _ajax_data_url = 'http://<?php echo get_host();?><?php echo IUrl::creatUrl("/school/get_special_seller_goods_list_ajax");?>';
</script>
<div class="free_class_content">
  <div class="free_class_hd">
    <img src="<?php echo $this->getWebSkinPath()."images/mlmm_img_1.jpg";?>" />
  </div>
  <div class="free_class_bd">
    <div class="free_class_search">
      <input type="text" name="key" placeholder="请输入选手的名称/编号" /><input type="button" name="btn" value="搜索">
    </div>
    <?php if($list){?>
    <ul class="mlmm_content">
      <?php foreach($list as $key => $item){?>
      <li>
        <div class="class_image">
          <a href="<?php echo IUrl::creatUrl("/site/products3/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" /></a>
        </div>
        <div class="class_action">
          <div class='t-left'>姓名：<?php echo isset($item['name'])?$item['name']:"";?></div>
          <div class='t-right'>排名：<?php echo discussion_class::get_vote_range($item['id']);?></div>
        </div>
        <div class="class_action">
          <div class='t-left'>编号：<?php echo isset($item['sort'])?$item['sort']:"";?></div>
          <div class='t-right'>票数：<?php echo discussion_class::get_vote_count($item['id']);?></div>
        </div>
      </li>
      <?php }?>
    </ul>
    <div id="cc"></div>
    <?php }?>
  </div>
</div>

<script language="javascript">
$(document).ready(function(){
  $('.mui-title').html('<?php echo $this->title;?>');

  $('.free_class_search input[name=btn]').click(function(){
    var key = $("input[name=key]").val();
    if ( key == '请输入选手的名称/编号' || key == '')
    {
      layer.alert('请输入选手的名称/编号');
    } else {
      window.location.href =  'http://<?php echo get_host();?>/school/search_mlmm/id/<?php echo isset($seller_id)?$seller_id:"";?>/search_mlmm?key=' + key;
    }
  })
})

var loadi;
$(window).scroll(function(){
	var a = $(window).scrollTop();
	var load_position = $('#cc').offset().top;
	if( a + $(window).height() > load_position -10 && _loading == false && _curr_page < _page_count )
	{
		_loading = true;
		_curr_page = _curr_page + 1;
		$.get( _ajax_data_url, {page: _curr_page,id:<?php echo isset($seller_id)?$seller_id:"";?>}, function( result ){
			$('.mlmm_content').append( result );
			$('#cc').html('');
			_loading = false;
		});
	}
});
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
