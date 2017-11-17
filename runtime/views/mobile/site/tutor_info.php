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
</style>

<div class="mui-content teacher">
    <div class="pro-header goodstab teacher_head">
        <input type="hidden" name="id" value="" />
        <a href="#basic" class="current">基本资料</a>
        <a href="#comment">教学评价</a>
    </div>
    <div class="shop-nav-bot">
        <?php if($seller_info['is_authentication'] && $is_receive_booking){?>
        <a href="javascript: void(0);" onclick="buy_now();" class="buy-btn" id="buyNowButton">立即约课</a>
        <?php }else{?>
          <?php if(!$is_receive_booking){?>
            <div class="auth_error red">教师行程已满，暂不接受预定</div>
          <?php }else{?>
            <div class="auth_error red">该教师尚未通过实名认证</div>
          <?php }?>
        <?php }?>
    </div>
    <div class="swiper-container" style="display:none;">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img width="100%" src="images/001.jpg" />
            </div>
            <div class="swiper-slide">
                <img width="100%" src="images/001.jpg" />
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="mui-content-padded">
        <h5><?php echo isset($seller_info['true_name'])?$seller_info['true_name']:"";?></h5>
        <span><?php echo get_gender_title($seller_info['teacher_info']['sex']);?></span>
        <div class="score">综合评分：
          <?php
            for($i = 0; $i < $seller_info['point']; $i++)
            {
              echo '<i class="icon-star"></i> ';
            }
          ?>
        </div>
        <div class="price">
            ￥：<strong><?php echo isset($seller_info['price'])?$seller_info['price']:"";?></strong>元/小时
        </div>
        <ul class="prop">
            <li>
                <h6>讲课次数</h6>
                <p><?php echo isset($seller_info['lecture_nums'])?$seller_info['lecture_nums']:"";?><i>次</i></p>
            </li>
            <li>
                <h6>成功受聘</h6>
                <p><?php echo isset($seller_info['hired_nums'])?$seller_info['hired_nums']:"";?><i>次</i></p>
            </li>
            <li>
                <h6>续聘次数</h6>
                <p><?php echo isset($seller_info['rehired_nums'])?$seller_info['rehired_nums']:"";?><i>次</i></p>
            </li>
            <li>
                <h6>实际教龄</h6>
                <p><?php echo isset($seller_info['experience'])?$seller_info['experience']:"";?><i>年</i></p>
            </li>
        </ul>
    </div>

    <div class="mui-content-padded">
        <ul class="spec_list clearfix" id="spec_list_mao">
            <li name="specCols">
                <?php foreach($seller_info['seller_tutor_list'] as $key => $item){?>
                <a href="javascript:void(0);" onclick="sele_spec(this);" value='<?php echo isset($item['id'])?$item['id']:"";?>' price='<?php echo isset($item['price'])?$item['price']:"";?>'>
                    <?php echo tutor_class::get_tutor_category_title($item);?>
                </a>
                <?php }?>
            </li>
        </ul>
        <p class="numberbox clearfix" style="display:none;">
            <span>人数：</span>
            <a class="reduce" onclick="setAmount.reduce('#qty_item_1')" href="javascript:void(0)">
                -</a>
            <input type="text" name="qty_item_1" value="1" id="qty_item_1" onkeyup="setAmount.modify('#qty_item_1')" class="text">
            <a class="add" onclick="setAmount.add('#qty_item_1')" href="javascript:void(0)">
                +</a>
            人
        </p>
        <p class="selected_spec"><span></span></p>
    </div>
    <div class="mui-content-padded teacher_zl"><a name="basic"></a>
        <h3>基本资料</h3>
        <p class="h_con">教学科目：<?php foreach($seller_info['seller_tutor_list'] as $key => $item){?> <?php echo tutor_class::get_tutor_category_title($item);?><?php }?></p>
        <?php if($seller_info['teacher_info']['graduate']){?><p class="h_con">毕业院校：<?php echo isset($seller_info['teacher_info']['graduate'])?$seller_info['teacher_info']['graduate']:"";?></p><?php }?>
        <?php if($seller_info['teacher_info']['major']){?><p class="h_con">主修专业：  <?php echo isset($seller_info['teacher_info']['major'])?$seller_info['teacher_info']['major']:"";?></p><?php }?>
        <?php if($seller_info['teaching_time']){?><p class="h_con">授课时段：  <?php echo tutor_class::get_teaching_time2_title($seller_info['teaching_time']);?></p><?php }?>
        <?php if($seller_info['teaching_type']){?><p class="h_con">授课方式：  <?php foreach($seller_info['teaching_type'] as $key => $item){?><?php if(!$key){?><?php echo isset($teaching_type_arr[$item])?$teaching_type_arr[$item]:"";?><?php }else{?> <?php echo isset($teaching_type_arr[$item])?$teaching_type_arr[$item]:"";?><?php }?><?php }?></p><?php }?>
        <?php if($seller_info['teacher_info']['teaching_direction']){?><p class="h_con">教学特点：  <?php echo isset($seller_info['teacher_info']['teaching_direction'])?$seller_info['teacher_info']['teaching_direction']:"";?></p><?php }?>
        <p class="h_con">对学生要求：<?php if($seller_info['student_reqiures']){?>$seller_info['student_reqiures']}<?php }else{?>无<?php }?></p>

        <h3 class="pj">教学评价</h3><a name="comment"></a>
        <ul class="comment_head">
            <li class="on">全部（<?php echo sizeof($seller_info['comment_info']['comment_list']);?>）</li>
            <li>好评（<?php echo isset($seller_info['comment_info']['perfect'])?$seller_info['comment_info']['perfect']:"";?>）</li>
            <li>中评（<?php echo isset($seller_info['comment_info']['good'])?$seller_info['comment_info']['good']:"";?>）</li>
            <li>差评（<?php echo isset($seller_info['comment_info']['bad'])?$seller_info['comment_info']['bad']:"";?>）</li>
        </ul>
        <div class="comment">
            <ul>
                <?php foreach($seller_info['comment_info']['comment_list'] as $key => $item){?>
                <li>
                    <div class="pic"><img src="<?php if($item['user_info']['head_ico']){?><?php echo IUrl::creatUrl("")."".$item['user_info']['head_ico']."";?><?php }else{?>/views/default/skin/default/images/002.jpg<?php }?>" alt=""></div>
                    <div class="comment_con">
                        <p>补课课程：<?php echo tutor_class::get_grade_level_title($item['tutor_info']['grade_level']);?> / <?php echo isset($cates_arr[$item['tutor_info']['category_id']])?$cates_arr[$item['tutor_info']['category_id']]:"";?></p>
                        <p>评价内容：<?php if(!$item['contents']){?>无<?php }else{?><?php echo isset($item['contents'])?$item['contents']:"";?><?php }?></p>
                        <em><?php echo isset($item['comment_time'])?$item['comment_time']:"";?></em>
                    </div>
                    <div class="cf"></div>
                </li>
                <?php }?>
            </ul>
            <ul style="display:none;">
              <?php foreach($seller_info['comment_info']['perfect_list'] as $key => $item){?>
              <li>
                  <div class="pic"><img src="<?php if($item['user_info']['head_ico']){?><?php echo IUrl::creatUrl("")."".$item['user_info']['head_ico']."";?><?php }else{?>/views/default/skin/default/images/002.jpg<?php }?>" alt=""></div>
                  <div class="comment_con">
                      <p>补课课程：<?php echo tutor_class::get_grade_level_title($item['tutor_info']['grade_level']);?> / <?php echo isset($cates_arr[$item['tutor_info']['category_id']])?$cates_arr[$item['tutor_info']['category_id']]:"";?></p>
                      <p>评价内容：<?php if(!$item['contents']){?>无<?php }else{?><?php echo isset($item['contents'])?$item['contents']:"";?><?php }?></p>
                      <em><?php echo isset($item['comment_time'])?$item['comment_time']:"";?></em>
                  </div>
                  <div class="cf"></div>
              </li>
              <?php }?>
            </ul>
            <ul style="display:none;">
              <?php foreach($seller_info['comment_info']['good_list'] as $key => $item){?>
              <li>
                  <div class="pic"><img src="<?php if($item['user_info']['head_ico']){?><?php echo IUrl::creatUrl("")."".$item['user_info']['head_ico']."";?><?php }else{?>/views/default/skin/default/images/002.jpg<?php }?>" alt=""></div>
                  <div class="comment_con">
                      <p>补课课程：<?php echo tutor_class::get_grade_level_title($item['tutor_info']['grade_level']);?> / <?php echo isset($cates_arr[$item['tutor_info']['category_id']])?$cates_arr[$item['tutor_info']['category_id']]:"";?></p>
                      <p>评价内容：<?php if(!$item['contents']){?>无<?php }else{?><?php echo isset($item['contents'])?$item['contents']:"";?><?php }?></p>
                      <em><?php echo isset($item['comment_time'])?$item['comment_time']:"";?></em>
                  </div>
                  <div class="cf"></div>
              </li>
              <?php }?>
            </ul>
            <ul style="display:none;">
              <?php foreach($seller_info['comment_info']['bad_list'] as $key => $item){?>
              <li>
                  <div class="pic"><img src="<?php if($item['user_info']['head_ico']){?><?php echo IUrl::creatUrl("")."".$item['user_info']['head_ico']."";?><?php }else{?>/views/default/skin/default/images/002.jpg<?php }?>" alt=""></div>
                  <div class="comment_con">
                      <p>补课课程：<?php echo tutor_class::get_grade_level_title($item['tutor_info']['grade_level']);?> / <?php echo isset($cates_arr[$item['tutor_info']['category_id']])?$cates_arr[$item['tutor_info']['category_id']]:"";?></p>
                      <p>评价内容：<?php if(!$item['contents']){?>无<?php }else{?><?php echo isset($item['contents'])?$item['contents']:"";?><?php }?></p>
                      <em><?php echo isset($item['comment_time'])?$item['comment_time']:"";?></em>
                  </div>
                  <div class="cf"></div>
              </li>
              <?php }?>
            </ul>
        </div>

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
