<?php $menuData=menu::init($this->admin['role_id']);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo $this->getWebSkinPath()."images/admin/logo.png";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="topMenu">
					<?php foreach(menu::getTopMenu($menuData) as $key => $item){?>
					<li>
						<a hidefocus="true" href="<?php echo IUrl::creatUrl("".$item."");?>"><?php echo isset($key)?$key:"";?></a>
					</li>
					<?php }?>
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/admin_repwd");?>">修改密码</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			
<div class="headbar">
	<div class="position"><span>学校</span><span>></span><span>学校管理</span><span>></span><span>学校配置</span></div>
</div>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/layui/css/layui.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layui/layui.js";?>"></script>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/brand_config.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/brand_config.js";?>"></script>
<div class="content_box">

  <form name="form" action="<?php echo IUrl::creatUrl("/brand/brand_config_save");?>" method="POST">
  <div class="layui-tab">
    <ul class="layui-tab-title">
      <li class="layui-this">基本权限设置</li>
      <li>功能权限设置</li>
      <li>交易权限设置</li>
    </ul>
      <div class="layui-tab-content layui-form layui-form-pane">
          <div class="layui-tab-item layui-show">

            <div class="layui-form-item">
              <label class="layui-form-label">是否开通</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if(!$seller_info['is_lock']){?>checked=""<?php }?> value="1" name="is_lock" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux">关闭后账号无法登陆</div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否VIP</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if($seller_info['is_vip']){?>checked=""<?php }?> value="1" name="is_vip" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux">非VIP商品上传需要审核</div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否认证</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if($seller_info['is_authentication']){?>checked=""<?php }?> value="1" name="is_authentication" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux">未认证商家无法进行交易</div>
            </div>

            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label">上级推广人</label>
                <div class="layui-input-inline">
                  <input type="text" name="promo_code" min="0" autocomplete="off" class="layui-input" value="<?php echo isset($seller_info['promo_code'])?$seller_info['promo_code']:"";?>">
                </div>
								<div class="layui-form-mid layui-word-aux">请输入上级推广码</div>
              </div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否支持通用代金券</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if($seller_info['is_support_props']){?>checked=""<?php }?> value="1" name="is_support_props" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

          </div>

          <div class="layui-tab-item">

            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                  <input type="number" name="sort" min="0" autocomplete="off" class="layui-input" value="<?php echo isset($seller_info['sort'])?$seller_info['sort']:"";?>">
                </div>
              </div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否特定商户</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if($seller_info['is_system_seller']){?>checked=""<?php }?> value="1" name="is_system_seller" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label">特定商户列表模板</label>
                <div class="layui-input-inline">
                  <input type="text" name="template" autocomplete="off" class="layui-input" value="<?php echo isset($seller_info['template'])?$seller_info['template']:"";?>">
                </div>
              </div>
            </div>

            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label">特定商户详情模板</label>
                <div class="layui-input-inline">
                  <input type="text" name="product_template" autocomplete="off" class="layui-input" value="<?php echo isset($seller_info['product_template'])?$seller_info['product_template']:"";?>">
                </div>
              </div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否支持在线课堂</label>
              <div class="layui-input-block">
                <input type="checkbox" value="1" name="is_support_zxkt" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否支持订票</label>
              <div class="layui-input-block">
                <input type="checkbox" value="1" name="is_support_dp" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

          </div>
          <div class="layui-tab-item">

            <div class="layui-form-item">
              <label class="layui-form-label">是否支付宝服务商</label>
              <div class="layui-input-block">
                <input type="checkbox" value="1" name="is_support_zfb" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否微信服务商</label>
              <div class="layui-input-block">
                <input type="checkbox" value="1" name="is_support_wechat" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否锁定</label>
              <div class="layui-input-block">
                <input type="checkbox" <?php if($seller_info['is_auth']){?>checked=""<?php }?> value="1" name="is_auth" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label">学校折扣</label>
                <div class="layui-input-inline">
                  <input type="number" name="discount" min="0" autocomplete="off" class="layui-input" value="<?php echo isset($seller_info['discount'])?$seller_info['discount']:"";?>">
                </div>
                <div class="layui-form-mid layui-word-aux">%，服务费比例</div>
              </div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">结算方式</label>
              <div class="layui-input-inline">
                <select name="settlement_method" lay-filter="aihao">
                  <option value="0" selected>方式一</option>
                  <option value="1">方式二</option>
                  <option value="2">方式三</option>
                </select>
              </div>
              <div class="layui-form-mid layui-word-aux">
                方式一：市场价-成本价，无折扣，实际价格成交正常结算方式<br />
                方式二：定金结算方式<br />
                方式三：代金券结算方式<br />
              </div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否推广人</label>
              <div class="layui-input-block">
                <input type="checkbox" name="is_promotor" value="1" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item">
              <label class="layui-form-label">是否支持股权</label>
              <div class="layui-input-block">
                <input type="checkbox" name="is_support_gq" value="1" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
              </div>
              <div class="layui-form-mid layui-word-aux"></div>
            </div>

          </div>

					<input type="hidden" name="id" value="<?php echo isset($seller_info['id'])?$seller_info['id']:"";?>" />
					<input type="hidden" name="page" value="<?php echo isset($page)?$page:"";?>" />
          <button class="layui-btn" lay-submit=""> 保 存 </button>
      </div>
  </div>
  </form>

</div>

		</div>
	</div>

	<script type='text/javascript'>
	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//按钮高亮
	var topItem  = "<?php echo key($leftMenu);?>";
	$("ul[name='topMenu']>li:contains('"+topItem+"')").addClass("selected");

	var leftItem = "<?php echo IUrl::getUri();?>";
	$("ul[name='leftMenu']>li a[href^='"+leftItem+"']").parent().addClass("selected");
	</script>
</body>
</html>
