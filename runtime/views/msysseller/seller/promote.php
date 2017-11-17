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
	<link href="/views/mobile/skin/blue/css/ucenter.css" rel="stylesheet" type="text/css" />
<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            我的推广码：<span class="ordbigbt-price"><?php echo isset($my_promote_code)?$my_promote_code:"";?></span>

            <table class="card-table info" width="100%">
                <tr>
                    <th width="30%">类型</th>
                    <th width="35%">总推广</th>
                    <th width="35%"><a href="<?php echo IUrl::creatUrl("/seller/promote_previous_month");?>">上月推广</a></th>
                </tr>
                <tr>
                    <td>个人用户</td>
                    <td><a href="<?php echo IUrl::creatUrl("/seller/promote_user_list");?>"><?php echo isset($promote_statics['user_count'])?$promote_statics['user_count']:"";?></a></td>
                    <td><?php echo isset($promote_statics['user_count_by_month'])?$promote_statics['user_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>个人返佣</td>
                    <td><?php echo isset($promote_statics['user_prommission_count'])?$promote_statics['user_prommission_count']:"";?></td>
                    <td><?php echo isset($promote_statics['user_prommission_count_by_month'])?$promote_statics['user_prommission_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>培训机构</td>
                    <td><a href="<?php echo IUrl::creatUrl("/seller/promote_seller_list");?>"><?php echo isset($promote_statics['seller_count'])?$promote_statics['seller_count']:"";?></a></td>
                    <td><?php echo isset($promote_statics['seller_count_by_month'])?$promote_statics['seller_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>机构返佣</td>
                    <td><?php echo isset($promote_statics['seller_prommission_count'])?$promote_statics['seller_prommission_count']:"";?></td>
                    <td><?php echo isset($promote_statics['seller_prommission_count_by_month'])?$promote_statics['seller_prommission_count_by_month']:"";?></td>
                </tr>
                <tr>
                    <td>下级推广</td>
                    <td><a href="<?php echo IUrl::creatUrl("/seller/promote_subordinate_user_list");?>"><?php echo isset($promote_statics['get_promote_list_by_account'])?$promote_statics['get_promote_list_by_account']:"";?></a></td>
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
            商家用户
        </a>
        <a class="mui-control-item" href="#item3">
            个人用户
        </a>
    </div>
</div>
<div class="mui-control-content mui-active" id="item1">
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <h5>最新成交</h5>
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <th width="20%">用户</th>
                      <th width="25%">课程</th>
                      <th width="20%">日期</th>
                      <th width="15%">预计提成</th>
                    </tr>
                    <?php foreach($promotelistorder as $key => $item){?>
                    <tr>
                        <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                        <td><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></td>
                        <td><?php echo date('Y-m-d',strtotime($item['create_time']));?></td>
                        <td><?php echo isset($item['commission'])?$item['commission']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
                <h5>最新推广</h5>
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th width="10%">编号</th>
                        <th width="25%">用户</th>
                        <th width="30%">日期</th>
                    </tr>
                    <?php foreach($promotelist as $key => $list){?>
                    <tr>
                        <td><?php echo isset($list['id'])?$list['id']:"";?></td>
                        <td><?php echo isset($list['username'])?$list['username']:"";?></td>
                        <td><?php if($item['create_time']){?><?php echo date('Y-m-d',strtotime($item['create_time']));?><?php }?></td>
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
                <h5>推广商户</h5>
                <table class="card-table" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <th>编号</th>
                        <th>用户</th>
                        <th>日期</th>
                    </tr>
                    <?php foreach($promotelistseller as $key => $seller){?>
                    <tr>
                        <td><?php echo isset($seller['id'])?$seller['id']:"";?></td>
                        <td><?php echo isset($seller['username'])?$seller['username']:"";?></td>
                        <td><?php echo isset($seller['create_time'])?$seller['create_time']:"";?></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
</div>

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
