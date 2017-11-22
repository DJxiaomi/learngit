<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>康卓商城 我要提现</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.picker.js";?>"></script>
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/weui/weui.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/mui.min.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/icons-extra.css";?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/app.css";?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/common.css";?>"/>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
</head>

<body>
    <nav class="mui-bar mui-bar-tab">
    	<a class="mui-tab-item" href="/">
    		<span class="mui-icon mui-icon-home"></span>
    		<span class="mui-tab-label">首页</span>
    	</a>
    	<a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/simple/cart");?>">
    		<span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
    		<span class="mui-tab-label">购物车</span>
    	</a>
    	<a class="mui-tab-item mui-active" href="<?php echo IUrl::creatUrl("/ucenter");?>">
    		<span class="mui-icon mui-icon-contact"></span>
    		<span class="mui-tab-label">个人中心</span>
    	</a>
    </nav>

    <div class="mui-content">
    	<div id="tabbar-with-contact" class="mui-control-content mui-active">
    		<header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
                <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    			<h1 class="mui-title" style="color:#fff"><?php echo $this->title;?></h1>
    		</header>

            <?php $callback = IUrl::creatUrl('/ucenter/account_log');?>
            <link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
            <div class="mui-card" style="margin-top:55px">

                <!--ul class="mui-table-view mui-table-view-chevron">
					<li class="mui-table-view-cell">
						<a class="mui-navigate">总成长币： <i class="mui-pull-right update"><span class="ordbigbt-price">￥<?php echo isset($balance_count)?$balance_count:"";?></span></i></a>
					</li>
					<li class="mui-table-view-cell">
						<a class="mui-navigate">可提现： <i class="mui-pull-right update"><span class="ordbigbt-price">￥<?php echo isset($balance_1)?$balance_1:"";?></span></i></a>
					</li>
					<li class="mui-table-view-cell">
						<a class="mui-navigate">不可提现： <i class="mui-pull-right update"><span class="ordbigbt-price">￥<?php echo isset($balance_2)?$balance_2:"";?></span></i></a>
					</li>
                </ul-->


            </div>
            <h5 class="mui-content-padded">我要提现</h5>
            <form action='<?php echo IUrl::creatUrl("/ucenter/withdraw_act");?>' method='post' id='withdrawForm'>
            <div class="mui-card">
                <div class="mui-input-group">
                    <div class="mui-input-row">
                        <label>收款人姓名</label>
                        <input type="text" class="mui-input-clear" name="name" id="name" value="" placeholder="请填写真实的收款人姓名" />
                    </div>
                    <div class="mui-input-row">
                        <label>银行卡号</label>
                        <input type="text" class="mui-input-clear" name="cart_no" id="cart_no" value="" placeholder="请填写开户银行的卡号" />
                    </div>
                    <div class="mui-input-row">
                        <label>银行名称</label>
                        <input type="text" class="mui-input-clear" name="bank_name" id="bank_name" value="" placeholder="如：中国建设银行" />
                    </div>
										<div class="mui-input-row">
												<label>支行名称</label>
												<input type="text" class="mui-input-clear" name="bank_branch" id="bank_branch" value="" placeholder="如：中国建设银行某某支行" />
										</div>
                    <div class="mui-input-row">
                        <label>提现金额</label>
                        <!--input type="text" name="amount" id="amount" value="" placeholder="填写提现金额" /-->
                        <div class="mui-numbox" data-numbox-min="0" data-numbox-max="<?php echo isset($this->memberRow['balance'])?$this->memberRow['balance']:"";?>" style="width:60%">
							<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
							<input class="mui-input-numbox" type="number" name="amount" id="amount" value="<?php echo isset($this->memberRow['balance'])?$this->memberRow['balance']:"";?>">
							<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
						</div>
                    </div>
                </div>
            </div>
            <div class="mui-content-padded" style="margin-top:30px">
                <center>
                    <button type="button" class="mui-btn mui-btn-primary mui-btn-block" id="withdraw"
                    style="width: 80%;margin:10px 10px 10px;padding: 10px 15px;border: 1px solid #5cc2d0;background-color: #5cc2d0;">提交提现申请</button>
                </center>
            </div>
            </form>
            <script language="javascript">
            <?php if($message){?>
            mui.toast('<?php echo isset($message)?$message:"";?>');
            <?php }?>
            $(function(){
                document.getElementById('withdraw').addEventListener('tap', function(){
                    var name = $('#name').val();
                    var cart_no = $('#cart_no').val();
                    var bank_name = $('#bank_name').val();
										var bank_branch = $('#bank_branch').val();
                    var amount = $('#amount').val();

                    if ( name == '' ) {
                        mui.toast('收款人姓名不能为空');
                        return false;
                    } else if ( cart_no == '' ) {
                        mui.toast('开户银行的卡号不能为空');
                        return false;
                    }else if ( bank_name == '' ) {
                        mui.toast('银行名称不能为空');
                        return false;
                    }else if ( bank_branch == '' ) {
                        mui.toast('银行支行名称不能为空');
                        return false;
                    }else if ( amount == '' ) {
                        mui.toast('提现金额不能为空');
                        return false;
                    }else {
                        $('#withdrawForm').submit();
                        return false;
                    }
                });
            });
            </script>

    	</div>

    </div>

<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
<script>
	mui.init({swipeBack:true});
	mui('nav').on('tap','a',function(){document.location.href = this.href;});
</script>
</body>
</html>