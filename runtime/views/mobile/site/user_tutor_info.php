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
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."css/product.css";?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>">
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/payfor.js";?>"></script>
<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '/';</script>
<style>
.shop-nav-bot a {width: 100%;}
.auth_error {width: 100%;text-align: center;font-size:90%;background-color: #ff5500;color:#fff;}
.border_table td {text-align: center;}
</style>

<div class="mui-content person">
    <div class="shop-nav-bot">
        <a href="<?php echo IUrl::creatUrl("/seller2/cart2/id/".$id."");?>;" class="buy-btn" id="buyNowButton">我要试讲</a>
    </div>

    <div class="mui-content-padded">
        <div class="person_head"><img src="<?php echo IUrl::creatUrl("")."".$tutor_info['head_icon']."";?>" alt=""></div>
        <div class="person_info">
            <h3><?php echo isset($tutor_info['true_name'])?$tutor_info['true_name']:"";?> <span><?php echo get_gender_title($tutor_info['gender']);?></span></h3>
            <p>需补课课程：<?php echo category_class::get_category_title($tutor_info['grade']);?></p>
        </div>
        <div class="cf"></div>
    </div>

    <div class="mui-content-padded person_zl">
        <h3>基本资料</h3>
        <p class="h_con">性别：<?php echo get_gender_title($tutor_info['gender']);?></p>
        <p class="h_con">年龄：<?php echo $tutor_info['age'];?>岁</p>
        <p class="h_con">补课类目：<?php echo category_class::get_category_title($tutor_info['grade_level']);?> <?php echo category_class::get_category_title($tutor_info['grade']);?></p>
        <?php if($tutor_info['lastest_scores'] > 0){?><p class="h_con">最近一次考分：<?php echo $tutor_info['lastest_scores'];?>分</p><?php }?>
        <?php if($tutor_info['expected_scores'] > 0){?><p class="h_con">期望的考分：<?php echo $tutor_info['expected_scores'];?>分</p><?php }?>
        <?php if($tutor_info['lowest_reward'] > 0){?><p class="h_con">最低的报酬：<?php echo $tutor_info['lowest_reward'];?>元/时</p><?php }?>
        <?php if($tutor_info['highest_reward'] > 0){?><p class="h_con">最高的报酬：<?php echo $tutor_info['highest_reward'];?>元/时</p><?php }?>
        <?php if($tutor_info['expected_hours'] > 0){?><p class="h_con">预计补课的课时：<?php echo $tutor_info['expected_hours'];?>时</p><?php }?>
        <?php if($tutor_info['teaching_time']){?><p class="h_con">预计补课的时间：每<?php foreach($tutor_info['teaching_time'] as $key => $item){?><?php if(!$key){?><?php echo isset($teaching_time_arr[$item['time1']])?$teaching_time_arr[$item['time1']]:"";?><?php }else{?>、<?php echo isset($teaching_time_arr[$item['time1']])?$teaching_time_arr[$item['time1']]:"";?><?php }?><?php }?></p><?php }?>
        <?php if($tutor_info['is_provide_transportation_fee']){?><p class="h_con">是否提供交通费用：<?php if($tutor_info['is_provide_transportation_fee']){?>是<?php }else{?>否<?php }?></p><?php }?>
        <?php if($tutor_info['is_provide_repast']){?><p class="h_con">是否提供就餐：<?php if($tutor_info['is_provide_repast']){?>是<?php }else{?>否<?php }?></p><?php }?>
        <p class="h_con">地址：<?php echo area::getName($tutor_info['region_id']);?> <?php echo isset($tutor_info['address'])?$tutor_info['address']:"";?> <?php echo isset($tutor_info['address2'])?$tutor_info['address2']:"";?></p>

        <?php if($tutor_info['test_reward']){?>
        <p class="h_con"><b style="color:red;">奖励机制</b>：
                <table width="94%" class="border_table" style="font-size:12px;color:#8f8f94;margin:0px auto;" cellspacing="2">
                  <tr>
                    <td>考试时间</td>
                    <td>考试类型</td>
                    <td>考试的分数</td>
                    <td>考试的奖励金额</td>
                  </tr>

                  <?php foreach($tutor_info['test_reward'] as $key => $item){?>
                  <tr>
                    <td><?php echo isset($item['test_time'])?$item['test_time']:"";?></td>
                    <td><?php echo isset($item['test_type'])?$item['test_type']:"";?></td>
                    <td><?php echo isset($item['test_condition'])?$item['test_condition']:"";?>分</td>
                    <td><?php echo isset($item['test_money'])?$item['test_money']:"";?></td>
                  </tr>
                  <?php $i++?>
                  <?php }?>
                </table>
        </p>
        <?php }?>
    </p>

    <script type="text/javascript">
        $(function(){
            $('.comment_head').children('li').on('click',function(){
                $(this).addClass('on').siblings('li').removeClass('on');
//                alert($(this).index());
                $('.comment').children('ul').eq($(this).index()).show().siblings('ul').hide();
            })
        })

        var swiper = new Swiper('.swiper-container', {
            loop : true,
            autoHeight: true
        });

        function sele_spec(obj)
        {
          $(obj).parent().find('a').removeClass('current');
          $(obj).addClass('current');
          $('input[name=id]').val($(obj).attr('value'));
          $('.price strong').html($(obj).attr('price'));
        }

        function buy_now()
        {
          var _id = $('input[name=id]').val();
          if ( _id == '')
          {
            mui.alert('请选择科目', '提示信息');
          } else {
            location.href = '/simple/cart2/num/1/statement/4/seller_tutor_id/' + _id;
          }
        }
    </script>


</div>

<script type="text/javascript">


    (function($) {
        $(document).imageLazyload({
            placeholder: '/views/mobile/skin/blue/images/lazyload.jpg'
        });
    })(mui);
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
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

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
