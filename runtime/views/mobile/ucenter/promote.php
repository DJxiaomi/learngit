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
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("".$this->back_url."");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            我的推广码：<span class="ordbigbt-price"><?php echo isset($this->user['user_id'])?$this->user['user_id']:"";?></span>
            <table class="card-table info" width="100%">
                <tr>
                    <th width="30%">类型</th>
                    <th width="35%">总推广</th>
                    <th width="35%"><a href="<?php echo IUrl::creatUrl("/ucenter/promote_previous_month");?>">上月推广</a></th>
                </tr>
                <tr>
                    <td>个人用户</td>
                    <td><a href="<?php echo IUrl::creatUrl("/ucenter/promote_user_list");?>"><?php echo isset($promote_statics['user_count'])?$promote_statics['user_count']:"";?></a></td>
                    <td><?php echo isset($promote_statics['user_count_by_month'])?$promote_statics['user_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>个人返佣</td>
                    <td><?php echo isset($promote_statics['user_prommission_count'])?$promote_statics['user_prommission_count']:"";?></td>
                    <td><?php echo isset($promote_statics['user_prommission_count_by_month'])?$promote_statics['user_prommission_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>培训机构</td>
                    <td><a href="<?php echo IUrl::creatUrl("/ucenter/promote_seller_list");?>"><?php echo isset($promote_statics['seller_count'])?$promote_statics['seller_count']:"";?></a></td>
                    <td><?php echo isset($promote_statics['seller_count_by_month'])?$promote_statics['seller_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>机构返佣</td>
                    <td><?php echo isset($promote_statics['seller_prommission_count'])?$promote_statics['seller_prommission_count']:"";?></td>
                    <td><?php echo isset($promote_statics['seller_prommission_count_by_month'])?$promote_statics['seller_prommission_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>下级推广</td>
                    <td><a href="<?php echo IUrl::creatUrl("/ucenter/promote_subordinate_user_list");?>"><?php echo isset($promote_statics['get_promote_list_by_account'])?$promote_statics['get_promote_list_by_account']:"";?></a></td>
                    <td><?php echo isset($promote_statics['get_promote_list_by_account_by_month'])?$promote_statics['get_promote_list_by_account_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>下级返佣</td>
                    <td><?php echo isset($promote_statics['other_commision_count'])?$promote_statics['other_commision_count']:"";?></td>
                    <td><?php echo isset($promote_statics['other_commision_count_by_month'])?$promote_statics['other_commision_count_by_month']:"";?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="mui-content-padded">
    <div class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-primary">
        <a class="mui-control-item mui-active" href="#item1">
            我的推广
        </a>
        <a class="mui-control-item" href="#item2">
            商家列表
        </a>
        <a class="mui-control-item" href="#item3">
            用户列表
        </a>
    </div>
</div>
<div class="mui-control-content mui-active" id="item1">
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <h5>最新推广订单</h5>
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th width="20%">用户</th>
                        <th width="20%">课程</th>
                        <th width="20%">日期</th>
                        <th width="25%">预计提成</th>
                    </tr>
                    <?php foreach($promotelistorder as $key => $item){?>
                    <tr>
                        <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                        <td><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></td>
                        <td><?php echo date('m-d',strtotime($item['create_time']));?></td>
                        <td><?php echo isset($item['commission'])?$item['commission']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
                <h5>最新推广用户/商户</h5>
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th width="25%">用户</th>
                        <th width="30%">日期</th>
                        <th width="30%">交易次数</th>
                    </tr>
                    <?php foreach($promotelist as $key => $list){?>
                    <tr>
                        <td><?php echo isset($list['username'])?$list['username']:"";?></td>
                        <td><?php echo date('m-d',strtotime($list['create_time']));?></td>
                        <td><?php echo isset($list['times'])?$list['times']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mui-control-content" id="item2">
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th>商户名称</th>
                        <th>日期</th>
                        <th>交易次数</th>
                    </tr>
                    <?php foreach($promotelistseller as $key => $seller){?>
                    <tr>
                        <td><?php echo isset($seller['username'])?$seller['username']:"";?></td>
                        <td><?php echo date('m-d',strtotime($seller['create_time']));?></td>
                        <td><?php echo isset($seller['times'])?$seller['times']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mui-control-content" id="item3">
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th>用户名称</th>
                        <th>日期</th>
                        <th>交易次数</th>
                    </tr>
                    <?php foreach($promotelistperson as $key => $user){?>
                    <tr>
                        <td><?php echo isset($user['username'])?$user['username']:"";?></td>
                        <td><?php echo date('m-d',strtotime($user['create_time']));?></td>
                        <td><?php echo isset($user['times'])?$user['times']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<!-- <a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">教育手册</span>
			</a> -->
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

</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
