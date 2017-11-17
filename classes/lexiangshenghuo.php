<?php
/**
 * @copyright (c) 2011 jooyea
 * @file sonline.php
 * @brief 在线客服插件,此插件是基于jquery的
 * @author chendeshan
 * @date 2013/7/15 0:29:17
 * @version 1.0.0
 */

class Lexiangshenghuo{

public static $http = 'http://api.sms.cn/mt/';		//短信接口
public static $uid = 'lelele999';							//用户账号
public static $pwd = 'hnlxshmm';							//密码
public $mobile	 = '18874764973';	//号码
public $mobileids	 = '';	//号码唯一编号
public $content = '您的验证码是565853。请在页面中提交验证码完成验证。【优安鲜品】';		//内容

public static function sendSMS($mobile,$content,$mobileids='',$time='',$mid='')
	{
	$http=self::$http;
	$uid=self::$uid;
	$pwd=self::$pwd;
	$data = array
	(
	'uid'=>$uid, //用户账号
	'pwd'=>md5($pwd.$uid), //MD5位32密码,密码和用户名拼接字符
	'mobile'=>$mobile, //号码
	'content'=>$content, //内容
	'mobileids'=>$mobileids,
	'time'=>$time, //定时发送
	'encode'=>'utf8', //定时发送
	);
	$re= self::postSMS($http,$data); //POST方式提交
	return $re;
	}

public static function postSMS($url,$data='')
	{
	$port="";
	$post="";
	$row = parse_url($url);
	$host = $row['host'];
	$port = isset($row['port']) ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data))
	{
	$post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
	return "$errstr ($errno)\n";
	} else {
	$receive = '';
	$out = "POST $file HTTP/1.1\r\n";
	$out .= "Host: $host\r\n";
	$out .= "Content-type: application/x-www-form-urlencoded\r\n";
	$out .= "Connection: Close\r\n";
	$out .= "Content-Length: $len\r\n\r\n";
	$out .= $post;
	fwrite($fp, $out);
	while (!feof($fp)) {
	$receive .= fgets($fp, 128);
	}
	fclose($fp);
	$receive = explode("\r\n\r\n",$receive);
	unset($receive[0]);
	return implode("",$receive);
	}
	}

public static function count_edu($user_id){//计算实际信用额度
		$time= strtotime(date("Y-m-d",time()));
		
		$memberObj = new IModel('member','balance');
		$where     = 'user_id = '.$user_id;
		$memberRow = $memberObj->getObj($where);
		$all_edu=$memberRow['user_edu'];//用户总信用额度
		
		
		
		$canshuObj = new IModel('fenqicanshu');
		$where     = 'canshu_id = 1 ';
		$canshuRow = $canshuObj->getObj($where);
		$faxi_lilv=$canshuRow['faxi_lilv'];
		$moren_yuqi=$canshuRow['moren_yuqi'];
		
		
		
		$jiekuanObj = new IQuery('jiekuan');
		$jiekuanObj->where='jiekuan_status = 0 and user_id = '.$user_id;
		$jiekuanObj->fields='jiekuan_num,jiekuan_time,shiji_lilv';
		$weihuankuanInfo=$jiekuanObj->find();
		$weihuan_edu=0;
		foreach($weihuankuanInfo as $k=>$v){//未还款的借款单直接将所有的金额和利息全部计算在里面
			$overday=floor(($time-strtotime(date("Y-m-d",$v['jiekuan_time'])))/86400);
			if($overday<=$moren_yuqi){
				$weihuan_edu+=$v['jiekuan_num'];
			}else{
				$weihuan_edu+=$v['jiekuan_num']*($overday*$v['shiji_lilv']+1.2+($overday-$moren_yuqi)*$faxi_lilv);
			}
		}
		$jiekuanObj = new IQuery('jiekuan ');
		$jiekuanObj->where=' jiekuan_status = 1 and user_id = '.$user_id;
		$jiekuanObj->fields='jiekuan_id,shiji_lilv';
		$weihuankuanInfo=$jiekuanObj->find();
		$huankuan = new IQuery('huankuan');
		foreach($weihuankuanInfo as $k=>$v){//还款中借款单需要按照每一个单的实际情况进行分析
			$jiekuan_id=$v['jiekuan_id'];
			$huankuan->where=' jiekuan_id='.$v['jiekuan_id'].' and user_id='.$user_id.' and huankuan_result=1';
			$huankuan->order=' huankuan_time desc ';
			$huankuan->group=' jiekuan_id ';
			$huankuan->fields=' max(huankuan_time) maxhuankuan_time,min(huankuan_yue) minhuankuan_yue ';
			$huankuaninfo=$huankuan->find();
			$huankuaninfo=$huankuaninfo[0];
			$overday=floor(($time-strtotime(date("Y-m-d",$huankuaninfo['maxhuankuan_time'])))/86400);
			if($overday<=$moren_yuqi){
				$weihuan_edu+=$huankuaninfo['minhuankuan_yue'];
			}else{
				$weihuan_edu+=$huankuaninfo['minhuankuan_yue']*($overday*$v['shiji_lilv']+1.2+($overday-$moren_yuqi)*$faxi_lilv);
			}
		}
		$array=array();
		$array['all_edu']=$all_edu;
		$array['weihuan_edu']= number_format($weihuan_edu, 2, '.', '');
		$array['real_edu']=number_format($all_edu-$weihuan_edu, 2, '.', '');;
		return $array;
}

public static function add_jiekuan($count_money,$user_id){//新增借款记录
		$jiekuanObj = new IQuery('jiekuan ');
		$jiekuanObj->where=' jiekuan_style = 0 and jiekuan_status = 0 and user_id = '.$user_id;
		$jiekuanObj->fields='jiekuan_num,jiekuan_time,shiji_lilv,jiekuan_id';
		$weihuankuanInfo=$jiekuanObj->find();
		
		$canshuObj = new IModel('fenqicanshu');
		$where     = 'canshu_id = 1 ';
		$this->canshuRow = $canshuObj->getObj($where);
		$faxi_lilv=$this->canshuRow['faxi_lilv'];
		$moren_yuqi=$this->canshuRow['moren_yuqi'];
		$jichu_lilv=$this->canshuRow['jichu_lilv'];
		
		$time= strtotime(date("Y-m-d",time()));
		
		if($weihuankuanInfo){
		$weihuankuanInfo=$weihuankuanInfo[0];
		
		
		$overday=floor(($time-strtotime(date("Y-m-d",$weihuankuanInfo['jiekuan_time'])))/86400);
		$new_money=$count_money;
		if($overday<=$moren_yuqi){
			$weihuankuan_money=$weihuankuanInfo['jiekuan_num']*($overday*$weihuankuanInfo['shiji_lilv']+1);
		}else{
			$weihuankuan_money=$weihuankuanInfo['jiekuan_num']*($overday*$weihuankuanInfo['shiji_lilv']+1.2+($overday-$moren_yuqi)*$faxi_lilv);
		}
		$weihuankuan_money=number_format($weihuankuan_money, 2, '.', '');
		$count_money+=$weihuankuan_money;
		$newjiekuan = new IModel('jiekuan');
		$dataArray=array();
		$dataArray['jiekuan_num']=$count_money;
		$dataArray['jiekuan_time']=time();
		$newjiekuan->setData($dataArray);
		$newjiekuan->update('jiekuan_id = "'.$weihuankuanInfo['jiekuan_id'].'"');
		
		$fenqilog = new IModel("fenqilog");

		$insertData = array(

			'user_id'   => $user_id,
			'num'		=> $new_money,
			'time'      => ITime::getDateTime(),
			'note'		=>'系统自动将未分期借款订单整合，用户【'.$user_id.'】，原本金'.$weihuankuanInfo['jiekuan_num'].'元，借款时间'.date("Y-m-d",$weihuankuanInfo['jiekuan_time']).'，'.$overday.'天未还款,本息合计'.$weihuankuan_money.'元，本次新增金额'.$new_money.'元，合计总金额'.$count_money.'元',

		);

		$fenqilog->setData($insertData);
		$fenqilog->add();
		}else{
		$newjiekuan = new IModel('jiekuan');
		$dataArray=array();
		$dataArray['user_id']=$user_id;
		$dataArray['jiekuan_no']=Order_Class::createOrderNum();
		$dataArray['jiekuan_style']=0;
		$dataArray['jiekuan_status']=0;
		$dataArray['jiekuan_num']=$count_money;
		$dataArray['shiji_lilv']=$jichu_lilv;
		$dataArray['jiekuan_time']=time();
		$newjiekuan->setData($dataArray);
		$newjiekuan->add();
		
		$fenqilog = new IModel("fenqilog");

		$insertData = array(

			'user_id'   => $user_id,
			'num'		=> $count_money,
			'time'      => ITime::getDateTime(),
			'note'		=>'用户【'.$user_id.'】使用了预分期方法预支金额'.$count_money.'元',

		);

		$fenqilog->setData($insertData);
		$fenqilog->add();
		}
	}
public static function add_huankuan($jiekuan_id,$type){//新增还款记录
		
		$return=array();
		
		$jiekuanObj = new IQuery('jiekuan ');
		$jiekuanObj->where=' jiekuan_id='.$jiekuan_id.' and  jiekuan_status != 2';
		$jiekuanObj->fields='*';
		$weihuankuanInfo=$jiekuanObj->find();
		if($weihuankuanInfo){
			$weihuankuanInfo=$weihuankuanInfo[0];
			if($type==0){//分期还款
			$huankuan_num=0.01;
			$shengyu=0.01;			
			}else if($type==1){//全款还款
			$huankuan_num=0.01;	
			$shengyu=0.02;
			}else if($type==2){//结清
			$huankuan_num=0.01;	
			$shengyu=0;
			}else{
				IError::show(403,'支付参数错误');
			}
			$fenqilog = new IQuery("huankuan");
			$fenqilog->where=' jiekuan_id='.$jiekuan_id.' and  huankuan_num = "'.$huankuan_num.'" and huankuan_style= '.$type.' and huankuan_result = 0  and huankuan_yue='.$shengyu;
			$fenqilog->fields='*';
			$fenqiinfo=$fenqilog->find();
			if($fenqiinfo){
			$new_id=$fenqiinfo[0]['huankuan_id'];
			}else{
			$fenqilog = new IModel("huankuan");
			$insertData = array(

				'user_id'   => $weihuankuanInfo['user_id'],
				'jiekuan_id'   => $weihuankuanInfo['jiekuan_id'],
				'huankuan_num'		=> $huankuan_num,
				'huankuan_no'		=> Order_Class::createOrderNum(),
				'huankuan_time'      => time(),
				'huankuan_style'      => $type,
				'huankuan_result'	=> 0,
				'huankuan_yue'	=> $shengyu,
			);

			$fenqilog->setData($insertData);
			$new_id=$fenqilog->add();
			}
		
		}else{
				IError::show(403,'还款订单不存在');
		}
		$return['huankuan_num']=$huankuan_num;
		$return['huankuan_id']=$new_id;
		$return['type']=$type;
		$return['qishu']=$weihuankuanInfo['jiekuan_qishu'];
		$return['shengyu']=$shengyu;
		return $return;
}

public static function zhuanfenqi($jiekuan_id,$qishu){//非分期订单转分期订单
		$jiekuanObj = new IQuery('jiekuan ');
		$jiekuanObj->where=' jiekuan_id='.$jiekuan_id.' and  jiekuan_status = 0 and jiekuan_style = 0 ';
		$jiekuanObj->fields='*';
		$weihuankuanInfo=$jiekuanObj->find();
		if($weihuankuanInfo){
			$weihuankuanInfo=$weihuankuanInfo[0];
			//非分期转分期的方法
			
			
			
			$fenqilog = new IModel("fenqilog");

			$insertData = array(

				'user_id'   => $weihuankuanInfo['user_id'],
				'num'		=> 0,
				'time'      => ITime::getDateTime(),
				'note'		=>'用户【'.$weihuankuanInfo['user_id'].'】将单号为'.$weihuankuanInfo['jiekuan_no'].'的借款单转化为分期还款',

			);

			$fenqilog->setData($insertData);
			$fenqilog->add();	
		}else{
			Error::show(403,'此借款单不满足转分期条件');
		}
}

public static function updateHuankuan($huankuan_no){
		$huankuanObj = new IQuery('huankuan ');
		$huankuanObj->where=' huankuan_no='.$huankuan_no.' and huankuan_result=0 ';
		$huankuanObj->fields='*';
		$huankuanInfo=$huankuanObj->find();
		if($huankuanInfo){
			$huankuanInfo=$huankuanInfo[0];
			//更新还款单状态
			$rechargeObj = new IModel('huankuan');//还款订单状态更改
			$dataArray = array(
				'huankuan_result' => 1
			);
			$rechargeObj->setData($dataArray);
			$result = $rechargeObj->update('huankuan_no = "'.$huankuan_no.'"  and huankuan_result=0 ');
			
			$rechargeObj = new IModel('jiekuan');//借款单状态更改
			if($huankuanInfo['huankuan_yue']>0){
				$dataArray = array(
				'jiekuan_status' => 1
			);
			}
			if($huankuanInfo['huankuan_yue']==0){
				$dataArray = array(
				'jiekuan_status' => 2
			);
			}
			
			$rechargeObj->setData($dataArray);
			$result = $rechargeObj->update('jiekuan_id = "'.$huankuanInfo['jiekuan_id'].'"');
			
			
			$fenqilog = new IModel("fenqilog");//记录日志

			$insertData = array(

				'user_id'   => $huankuanInfo['user_id'],
				'num'		=> 0,
				'time'      => ITime::getDateTime(),
				'note'		=>'用户【'.$huankuanInfo['user_id'].'】支付了一笔还款，还款金额为：'.$huankuanInfo['huankuan_num'].',剩余还款金额为'.$huankuanInfo['huankuan_yue'],

			);

			$fenqilog->setData($insertData);
			$fenqilog->add();
			
			
			
		}else{
			return false;
		}
	
}


/**
 *
 * 以上为以前写的分期相关函数，如不需要可以删除
 * 
 */
 
/**
 * 获取用户信息
 * @param int user_id
 * @return array 
 */
public static function getFanlilist($user_id){
		$fanliObj = new IQuery('member');
		$fanliObj->where=' user_id ='.$user_id;
		$fanliObj->fields='*';
		$fanliInfo=$fanliObj->find();
		if($fanliInfo){
			$fanliInfo=$fanliInfo[0];
			return $fanliInfo;
		}else{
			return false;
		}
}

/**
 * 获取商户信息
 * @param int seller_id
 * @return array
 */
public static function getsellerFanli($seller_id){
		$fanliObj = new IQuery('seller');
		$fanliObj->where=' id ='.$seller_id;
		$fanliObj->fields='*';
		$fanliInfo=$fanliObj->find();
		if($fanliInfo){
			$fanliInfo=$fanliInfo[0];
			return $fanliInfo;
		}else{
			return false;
		}
}

/**
 * 获取商品信息
 * @param int goods_id
 * @return array
 */
public static function getGoodsInfo($goods_id){
		$fanliObj = new IQuery('goods');
		$fanliObj->where=' id ='.$goods_id;
		$fanliObj->fields='*';
		$fanliInfo=$fanliObj->find();
		if($fanliInfo){
			$fanliInfo=$fanliInfo[0];
			return $fanliInfo;
		}else{
			return false;
		}
}


/**
 * 返利点购物((已废除,已废除,已废除))
 * @param int user_id
 * @param float money
 * @param int seller_id
 * @return array
 */
public static function shopByfanli($user_id,$money,$seller_id){
		$array=array();
		$userInfo=self::getFanlilist($user_id);
		
		if($userInfo['user_real_fanli']<$money){
		 	$array['status']=0;
		 	$array['message']='用户可用返利账户余额不足';
			return $array;
			exit;
		}
		
		if($money<5.00){
			$array['status']=1;
		 	$array['message']='消费金额低于10.00不予返利';
			return $array;
			exit;	
		}
		$sellerInfo=self::getsellerFanli($seller_id);
		if(2*$sellerInfo['real_fanli']<$money){
		 	$array['status']=2;
		 	$array['message']='商户可用返利余额不足';
			return $array;
			exit;
		}
		$array['status']=3;
		return $array;
}

/**
 * 
 * 购物返利
 * 
 * @param int user_id 用户ID
 * @param float money 返利金额
 * @param int seller_id 商户ID
 * @param int payment_id 支付ID
 * @param int orderNo 订单号
 * @return null
 */
public static function updateFanli($user_id,$money,$seller_id,$payment_id,$orderNo){
		if($payment_id != 18)
		{
    		$sellerObj  = new IModel('seller');
    		$sellerRow  = $sellerObj->getObj('id = "'.$seller_id.'"');
    		if($sellerRow)
    		{
        		if($sellerRow['real_fanli']+$sellerRow['zengsong_fanli']>$money)
        		{
        			$real_num=$money;
        			$num1=$sellerRow['real_fanli']-number_format($money*$sellerRow['bili_fanli'], 2, '.', '');
        			$num2=$sellerRow['zengsong_fanli']-$money+number_format($money*$sellerRow['bili_fanli'], 2, '.', '');
        			if($num1>=0&&$num2>=0)
        			{
        			     $real_fanli_down=$num1;
        			     $zengsong_fanli_down=$num2;
        			}elseif($num1>=0&&$num2<0){
        			     $real_fanli_down=$sellerRow['real_fanli']-$real_num+$sellerRow['zengsong_fanli'];
        			     $zengsong_fanli_down=0;			
        			}elseif($num1<0&&$num2>=0){
        			     $real_fanli_down=0;
        			     $zengsong_fanli_down=$sellerRow['zengsong_fanli']-$real_num+$sellerRow['real_fanli'];
        			}
        			     
        			$sale_balance = $sellerRow['sale_balance'];
        			$sale_num = $real_num;
        		}else{
        			$real_num=$money;
        			$real_fanli_down=0;
        			$zengsong_fanli_down=0;
        			
        			$sale_balance = $sellerRow['sale_balance']-($money-($sellerRow['real_fanli']+$sellerRow['zengsong_fanli']));
        			
        			$mlm_balance = $money-($sellerRow['real_fanli']+$sellerRow['zengsong_fanli']);
        			
        			$salelogObj = new IModel('salelog');
        			$dataArray = array(
        				'note' =>'商户返利账户余额不足，从销售额账户中扣款'.$mlm_balance.'元',
        				'time' =>time(),
        				'num' =>(0-$mlm_balance),
        				'seller_id' =>$seller_id,
        				'sale_balance' =>$sale_balance,
        			);
        
        			$salelogObj->setData($dataArray);
        			$salelogObj->add();
        			
        			$sale_num = $real_num-$mlm_balance;
        			
        		}
        		
    			$dataArray = array(
    				'real_fanli'     => $real_fanli_down,
    				'zengsong_fanli'   => $zengsong_fanli_down,
    				'sale_balance'   => $sale_balance,
    			);
    
    			$sellerObj->setData($dataArray);
    			$sellerObj->update('id = "'.$seller_id.'"');
    			
    			$fanli_mlm=$real_fanli_down+$zengsong_fanli_down; 
    			if($fanli_mlm<100){
    				self::sendSMS($sellerRow['mobile'],'您的商家('.$sellerRow['seller_name'].')的返利账户余额仅剩'.$fanli_mlm.'元，请及时充值。【乐享生活】');
    			}
    			//
    			$memberObj = new IModel('member');
    			$memberRow = $memberObj->getObj('user_id = "'.$user_id.'"');
    			if($memberRow){
    			
    			$order1Obj = new IQuery('order');
    			$order1Obj->fields='sum(real_amount)';
    			$order1Obj->where=' id>0 ';
    			$real_amount=$order1Obj->find();
    			$real_amount=$real_amount[0]['sum(real_amount)'];
    			
    			
    			if(self::check_first($orderNo)){
    				$real_num_mlm=($real_num-(1000-$real_amount))+(20/3)*(1000-$real_num);
    			}else{
    				$real_num_mlm=$real_num;
    			}
    			$real_num_mlm=number_format($real_num_mlm, 2, '.', '');
    			
    			$dataArray1 = array(
    				'user_all_fanli'    => $memberRow['user_all_fanli']+$real_num,
    				'user_max_fanli'   => $memberRow['user_max_fanli']+$real_num_mlm,
    			);
    
    			$memberObj->setData($dataArray1);
    			$memberObj->update('user_id = "'.$user_id.'"');
    			}
    			
    			$user_db = new IQuery('user');
    			$user_db->where = 'id = ' . $user_id;
    			$user_info = $user_db->getOne();
    			
    			$logObj  = new IModel('fanlilog');
    			$dataArray2 = array(
    				//'note' =>'用户【'.$user_info['username'].'】在商家【'.$sellerRow['true_name'].'】购物消费，应获取返利额度'.$money.'，实际获取额度'.$real_num,
    				'note'  =>  '订单号: ' . $orderNo . '，获取返利' . $real_num . '元',
    				'time' =>time(),
    				'num'  =>$real_num,
    				'sale_num'  =>$sale_num,
    				'real_fanli'  =>$memberRow['user_all_fanli']+$real_num+$memberRow['user_real_fanli'],
    				'seller_fanli'=>$real_fanli_down+$zengsong_fanli_down,
    				'user_id' =>$user_id,
    				'seller_id' =>$seller_id,
    				'order_no'=>$orderNo,
    				'tuikuan_num'=>$real_num,
    				'max_tuikuan_num'=>$real_num_mlm,
    				'status' =>0,
    			    'log_type' => 1,
    			    'rebate_rule' => Order_Class::is_first_order( $user_id, $orderNo) ? 2 : 1,
    			);
    			$logObj->setData($dataArray2);
    			$logObj->add();
    		}
		}
}

/**
 * 检查用户是不是第一天购物
 * @param int orderNo
 * @return int
 */
public static function check_first($orderNo){
	$orderObj = new IModel('order');
	$orderRow1 = $orderObj->getObj('order_no ="'.$orderNo.'"');
	$mobile= $orderRow1['mobile'];
	$orderRow = $orderObj->getObj('mobile = "'.$mobile.'" and create_time <"'.date("Y-m-d",time()).'"' );
	
	$order1Obj = new IQuery('order');
	$order1Obj->fields='sum(real_amount)';
	$order1Obj->where=' id>0 ';
	$real_amount=$order1Obj->find();
	
	
	
	
	if(empty($orderRow)&&$real_amount[0]['sum(real_amount)']<1000){
		$return=1;
	}else{
		$return=0;
	}
	
	return $return;
	
	
}

/**
 * 返利点购物
 * @param int user_id
 * @param int num
 * @param int seller_id
 * @param int orderNo
 * @return array
 */
public static function fanliBuy($user_id,$num,$seller_id,$orderNo){
		
		
		$memberObj = new IModel('member');
		$memberRow = $memberObj->getObj('user_id = "'.$user_id.'"');
		if($memberRow){
		$dataArray1 = array(
			'user_real_fanli'    => $memberRow['user_real_fanli']-$num,
		);

		$memberObj->setData($dataArray1);
		$memberObj->update('user_id = "'.$user_id.'"');
		
		$user_db = new IQuery('user');
		$user_db->where = 'id = ' . $user_id;
		$user_info = $user_db->getOne();
		
		$seller_info = Seller_class::get_seller_info( $seller_id );
		
		$logObj  = new IModel('fanlilog');
		$dataArray2 = array(
			//'note' =>'用户【'.$user_info['username'].'】在商家【'.$seller_info['true_name'].'】用返利点购物消费，消耗返利额度'.$num,
			'note'   =>  '向' . $seller_info['true_name'] . '支付' . $num . '返利点进行消费(订单号：' . $orderNo . ')',
			'time' =>time(),
			'num'  =>'-'.$num,
			'sale_num'  =>'-'.$num,
			'real_fanli'  =>$memberRow['user_all_fanli']+$memberRow['user_real_fanli']-$num,
			'seller_fanli'=>0,
			'user_id' =>$user_id,
			'seller_id' =>0,
			'status' =>0,
		    'log_type' => 2,
		    'order_no'    =>  $orderNo,
		);
		$logObj->setData($dataArray2);
		$return=$logObj->add();
		
		// $sellerObj  = new IModel('seller');
		// $sellerRow  = $sellerObj->getObj('id = "'.$seller_id.'"');
		// $change_num=$sellerRow['real_fanli']>=number_format($num/10, 2, '.', '')?number_format($num/10, 2, '.', ''):$sellerRow['real_fanli'];
		
		// $dataArray = array(
				// 'real_fanli'     => $sellerRow['real_fanli']-$change_num,
			// );

		// $sellerObj->setData($dataArray);
		// $sellerObj->update('id = "'.$seller_id.'"');
		// $dataArray3 = array(
			// 'note' =>'用户【'.$user_id.'】在商家【'.$seller_id.'】用返利点购物消费，消耗返利额度'.$num.',平台扣点百分之10，扣点'.$change_num.'元',
			// 'time' =>time(),
			// 'num'  =>$change_num,
			// 'real_fanli'  =>0,
			// 'seller_fanli'=>$sellerRow['real_fanli']-$change_num,
			// 'user_id' =>0,
			// 'seller_id' =>$seller_id,
			// 'order_no'=>$orderNo,
			// 'tuikuan_num'=>$change_num,
			// 'status' =>0,
		// );
		// $logObj->setData($dataArray3);
		// $logObj->add();
		
		}
		return $return;
}

/**
 * 每日返利最新版 added by jack 20160706
 */
public static function rebate_daily()
{
    die('该活动已停止');
    set_time_limit(0);
    
    // 获取上一次操作的时间，为了保持兼容性，保留旧的验证流程, 如果上一次操作的日期小于当天，则执行操作
    $last_rebate_time = self::get_rebate_action();
    if ( $last_rebate_time > 0 )
    {
        $last_rebate_date = date('Ymd', $last_rebate_time );
        $today = date('Ymd');
        $action = ( $today > $last_rebate_date ) ? true : false;
    } else {
        $action = true;
    }
        
    if ( $action )
    {
        // 获取所有需要返利的用户 user_all_fanli > 0
        $rebate_member_list = member_class::get_rebate_member_list();
    
        if ( $rebate_member_list )
        {
            $user_arr = array();
            foreach( $rebate_member_list as $kk => $vv )
            {
                if ( !in_array( $vv['user_id'], $user_arr ))
                    $user_arr[] = $vv['user_id'];
            }
             
            // 获取用户未完成返利的的信息,并计算每一个订单需要返利的金额
            $rebate_log_list = Fanli_log_class::get_rebate_log_list( $user_arr );
    
            // 如果没有需要返利的订单log信息，则更新返利操作时间，然后退出
            if ( !$rebate_log_list )
            {
                self::update_rebate_action( time() );
                die('ok!');
            }
    
            $close_log_arr = array();
            $rebate_statisc = array();
            foreach( $rebate_log_list as $kk => $vv )
            {
                $distance_day = get_distance_day( date('Y-m-d') . ' 00:00:00', date('Y-m-d', $vv['time'] ) . ' 00:00:00' );
                $rebate_info = self::get_rebate_info( $vv['rebate_rule'], $distance_day, $vv['num'] );
    
                if ( $rebate_info['is_last_day'] )
                    $close_log_arr[] = $vv;
                
                if ( $rebate_info['rebate_num'] > 0 )
                {
                    $rebate_log_list[$kk] = array_merge( $vv, $rebate_info);
                    $rebate_statisc[$vv['user_id']] += $rebate_info['rebate_num'];
                }
                else 
                 unset( $rebate_log_list[$kk] );
            }
            
            // 执行返利操作，首先判断用户冻结的返利金额是否大于要返利的数字
            $member_db = new IModel('member');
            foreach( $rebate_member_list as $kk => $vv )
            {
                if ( isset( $rebate_statisc[$vv['user_id']]) )
                {
                    $rebate_num = ( $vv['user_all_fanli'] >= $rebate_statisc[$vv['user_id']] ) ? $rebate_statisc[$vv['user_id']] : $vv['user_all_fanli'];
                    $update_data = array(
                        'user_real_fanli'   =>  $vv['user_real_fanli'] + $rebate_num,
                        'user_all_fanli'    =>  $vv['user_all_fanli'] - $rebate_num,
                    );
                    $member_db->setData( $update_data );
                    $member_db->update('user_id = ' . $vv['user_id']);
                }
            }
            
            // 记录到返利日志rebate_log
            $rebate_log_db = new IModel('rebate_log');
            foreach( $rebate_log_list as $kk => $vv )
            {
                $add_data = array(
                    'user_id'       =>  $vv['user_id'],
                    'add_time'      =>  time(),
                    'order_no'      =>  $vv['order_no'],
                    'rebate_num'    =>  $vv['rebate_num'],
                    'distance_day'  =>  $vv['distance_day'],
                );
                
                $rebate_log_db->setData( $add_data );
                $rebate_log_db->add();
            }
            
             
            // 批量将最后一天的返利订单关闭
            $fanlilog_db = new IModel('fanlilog');
            if ( $close_log_arr )
            {
                foreach( $close_log_arr as $kk => $vv )
                {
                    $update_data = array(
                        'status'    =>  1,
                    );
                    $fanlilog_db->setData( $update_data );
                    $fanlilog_db->update('id = ' . $vv['id'] );
                }
            }
        }
        
        self::update_rebate_action(time());
    }
    
    echo 'ok!';
}

/**
 * 根据返利规则计算出某个订单需要返利的金额
 * @param int 返利规则
 * @param int 相隔天数
 * @param float 返利的总金额
 * @return array
 */
public static function get_rebate_info( $rebate_rule_id, $distance_day, $num )
{
    // 如果当前返利规则已删除，则不再进行返利
    $rebate_rule_list = Rebate_rules_class::get_rebate_rule_list( $rebate_rule_id );
    if ( !$rebate_rule_list )
    {
        return array(
            'num' => 0,
            'is_close' => true,
            'distance_day'  => $distance_day,
            'type'  =>  '-1',
       );
    }
    
    if ( $rebate_rule_list )
    {
        foreach( $rebate_rule_list as $kk => $vv )
        {
            if ( $distance_day >= $vv['start_day'] && $distance_day <= $vv['end_day'] )
            {
                $rebate_rate = $vv['rate'];
                $rebate_num = number_format( $rebate_rate * $num, 2, '.', '');
                $is_close = ( $distance_day == $rebate_rul_info['list'][sizeof( $rebate_rul_info['list'] ) - 1]['end_day'] ) ? true : false;
                return array(
                    'rebate_num'    =>  $rebate_num,
                    'is_close'      =>  $is_close,
                    'distance_day'  => $distance_day,
                );
            }
        }
    }
    
    return array(
        'rebate_num'    => 0,
        'is_close'      => true,
        'distance_day'  => $distance_day,
        'type'          =>  '-2'
    );
}

/**
 * 
 * 获取上一次返利操作执行的时间，保留以前的操作流程
 * @return string
 */
public static function get_rebate_action()
{
    $rebate_action_db = new IQuery('rebate_action');
    $rebate_action_db->where = '1 = 1';
    $rebate_action_db->order = 'id desc';
    $rebate_action_db->limit = 1;
    $rebate_action_info = $rebate_action_db->getOne();
    return ( $rebate_action_info ) ? $rebate_action_info['action_time'] : 0;
}

/**
 * 
 * 更新返利执行的时间
 * @param int 当前时间
 */
public static function update_rebate_action( $content )
{
    $rebate_action_db = new IModel('rebate_action');
    $data = array(
        'action_time'   =>  $content
    );
    $rebate_action_db->setData( $data );
    $rebate_action_db->add();
}

/**
 * 每日更新返利
 */
public static function gengxinfanli()
{
		$log_filename='upload/log_mlm/gengxinfanlitime.xml';
		$time=file_get_contents($log_filename);
		$theday=strtotime(date('Y-m-d',$time));
		$nowday=strtotime(date('Y-m-d',time()));
		
		//获取上次更新时间看是否是同一天，同一天就不执行，不是同一天就进行返利并更新时间
		if($theday<$nowday)
		{
			$log_filename='upload/log_mlm/fanlilog.xml';
			Lexiangshenghuo::logger($log_filename,"本次更新开始日期：".date('Y-m-d',time()));
			$overday=$nowday-500*24*60*60;
			$logObj  = new IModel('fanlilog');
			$memberObj = new IModel('member');
			
			$logObj2 = new IQuery('fanlilog');
			$logObj2->fields='sum(num) sumnum';
			
			$memberObj2 = new IQuery('member');
			$memberObj2->fields='*';
			$memberObj2->where=' user_id > 0 and user_max_fanli > 0';
			$memberRow2 = $memberObj2->find();
			foreach($memberRow2 as $k=>$v)
			{
    			$logObj2->where='user_id = '.$v['user_id'].' and num>0 and time<'.$overday.' and status=0';
    			$logRow2=$logObj2->find();
    			if($logRow2&&$logRow2[0]['sumnum']>0)
    			{//如果有过期的记录就从总返利中去除
    				Lexiangshenghuo::logger($log_filename,"更新过期记录，用户".$v['user_id']."共有".$logRow2[0]['sumnum']."元额度过期");
    				$dataArray = array(
    				'user_max_fanli'=>$v['user_max_fanli']-$logRow2[0]['sumnum'],
    				);
    				$memberObj->setData($dataArray);
    				$memberObj->update('user_id = "'.$v['user_id'].'"');//更改用户的返利基数
    				$dataArray2 = array(
    				'status'=>1,
    				);
    				$logObj->setData($dataArray2);
    				$logObj->update('user_id = '.$v['user_id'].' and num>0 and time<'.$overday.' and status=0');//更新日志记录防止重复操作
    			}
			}
			
			//现在的返利基数已经去除了过期的数据，因此直接按照千分之2进行返利即可
			$memberObj2->fields='*';
			$memberObj2->where=' user_id > 0 and user_max_fanli > 0';
			$memberRow3 = $memberObj2->find();
			foreach($memberRow3 as $k=>$v)
			{
				$fanli_num=number_format($v['user_max_fanli']*0.002, 2, '.', '');
				$real_num=$v['user_all_fanli']-$fanli_num>0?$fanli_num:$v['user_all_fanli'];
				Lexiangshenghuo::logger($log_filename,"进行返利，用户".$v['user_id']."有".$real_num."元从冻结账户转入可用账户");
				$dataArray = array(
				'user_real_fanli'=>$v['user_real_fanli']+$real_num,
				'user_all_fanli'=>$v['user_all_fanli']-$real_num,
				);
				$memberObj->setData($dataArray);
				$memberObj->update('user_id = "'.$v['user_id'].'"');//更新用户的返利数据
			}
			$log_filename='upload/log_mlm/gengxinfanlitime.xml';
			unlink($log_filename);
			file_put_contents($log_filename, time());	//更新时间
		}
}

/**
 * 返利充值
 * @param int fanli_no
 * @return boolen
 */
public static function updateFanli_chongzhi($fanli_no){
	$fanliObj = new IModel('fanli_chongzhi');
	$fanliRow = $fanliObj->getObj('fanli_no = "'.$fanli_no.'"');
	if(empty($fanliRow))
	{
		return false;
	}

	if($fanliRow['status'] == 1)
	{
		return true;
	}

	$dataArray = array(
		'status' => 1
	);

	$fanliObj->setData($dataArray);
	$result = $fanliObj->update('fanli_no = "'.$fanli_no.'"');

	if($result == '')
	{
		return false;
	}

	$money   = $fanliRow['account'];
	$seller_id = $fanliRow['seller_id'];
	$sellerRow =Lexiangshenghuo::getsellerFanli($seller_id);
	$zengsong_money=$money*(1-$sellerRow['bili_fanli'])/$sellerRow['bili_fanli'];
	$zengsong_money=number_format($zengsong_money, 2, '.', '');
	
	$sellerObj  = new IModel('seller');
	$dataArray1 = array(
			'real_fanli'     => $sellerRow['real_fanli']+$money,
			'zengsong_fanli'     => $sellerRow['zengsong_fanli']+$zengsong_money,
		);

	$sellerObj->setData($dataArray1);
	$sellerObj->update('id = "'.$seller_id.'"');
	
	
	
	
	$logObj  = new IModel('fanlilog');
	$dataArray2 = array(
		'note' =>'商户【'.$seller_id.'】通过'.$fanliRow['payment_name'].'方式进行返利账户充值，充值金额'.$money .'元,赠送金额'.$zengsong_money.'元，账户余额'.($dataArray1['zengsong_fanli']+$dataArray1['real_fanli']).'元',
		'time' =>time(),
		'num'  =>'-'.($money+$zengsong_money),
		'sale_num'  =>'-'.($money+$zengsong_money),
		'real_fanli'  =>0,
		'seller_fanli'=>$dataArray1['zengsong_fanli']+$dataArray1['real_fanli'],
		'user_id' =>0,
		'seller_id' =>$seller_id,
		'status' =>0,
	);
	$logObj->setData($dataArray2);
	$return=$logObj->add();
	return $return;
}

/**
 * 检查商户返利
 * @param int seller_id
 * @param float money
 * @return boolen
 */
public static function checkSelleFanli($seller_id,$money){
	$sellerRow=Lexiangshenghuo::getsellerFanli($seller_id);
	if($sellerRow['real_fanli']+$sellerRow['zengsong_fanli']>=$money/2){
		return false;
	}else{
		return true;
	}
}

/**
 * 结算函数
 * @param int seller_id
 * @param int num
 * @return null
 */
public static function add_sale($seller_id,$num){
	$sellerRow =self::getsellerFanli($seller_id);
	$sellerObj  = new IModel('seller');
	$dataArray1 = array(
			'sale_balance'     => $sellerRow['sale_balance']+$num,
		);

	$sellerObj->setData($dataArray1);
	$sellerObj->update('id = "'.$seller_id.'"');
	
	$salelogObj = new IModel('salelog');
	$dataArray = array(
			'note' =>'商户申请了结算，为自己的销售额账户增加了'.$num.'元',
			'time' =>time(),
			'num' =>$num,
			'seller_id' =>$seller_id,
			'sale_balance' =>$sellerRow['sale_balance']+$num,
		);

	$salelogObj->setData($dataArray);
	$salelogObj->add();
}


/**
 * 
 */
public static function updateSale_chongzhi($sale_no){
	$saleObj = new IModel('sale_chongzhi');
	$fanliRow = $saleObj->getObj('sale_no = "'.$sale_no.'"');
	if(empty($fanliRow))
	{
		return false;
	}

	if($fanliRow['status'] == 1)
	{
		return true;
	}

	$dataArray = array(
		'status' => 1
	);

	$saleObj->setData($dataArray);
	$result = $saleObj->update('sale_no = "'.$sale_no.'"');

	if($result == '')
	{
		return false;
	}

	$num   = $fanliRow['account'];
	$seller_id = $fanliRow['seller_id'];
	$sellerRow =Lexiangshenghuo::getsellerFanli($seller_id);
	
	$sale_balance = $sellerRow['sale_balance']+$num;
	
	$sellerObj  = new IModel('seller');
	$dataArray1 = array(
			'sale_balance' =>$sale_balance,
		);

	$sellerObj->setData($dataArray1);
	$sellerObj->update('id = "'.$seller_id.'"');
	
	
	
	
	$logObj  = new IModel('salelog');
	$dataArray2 = array(
		'note' =>'商户【'.$seller_id.'】用'.$fanliRow['payment_name'].'方式进行了充值，充值金额'.$num.'元',
		'time' =>time(),
		'num'  =>$num,
		'seller_id'=>$seller_id,
		'sale_balance'=>$sale_balance,
	);
	$logObj->setData($dataArray2);
	$return=$logObj->add();
	return $return;
}

/**
 * 模拟POST提交
 * @param string url
 * @param array post
 * @return string
 */
public static function post_send($url, $post){
	//模拟post提交。例如$data = post_send("http://www.a.com/post/post.php", array('name'=>'caiknife', 'email'=>'caiknife@gmail.com')); 
	
	$options = array(  
        CURLOPT_RETURNTRANSFER => true,  
        CURLOPT_HEADER         => false,  
        CURLOPT_POST           => true,  
        CURLOPT_POSTFIELDS     => $post,  
    );  
  
    $ch = curl_init($url);  
    curl_setopt_array($ch, $options);  
    $result = curl_exec($ch);  
    curl_close($ch);  
    return $result;  
}



/**
 * 日志记录
 * @param string 
 * @param string 
 */
public static function logger($log_filename,$log_content)
{
    $max_size = 100000;
    if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
    file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
}


/**
 * 
 */
public static function check_saletixian($seller_id){
	$saleObj = new IModel('sale_tixian');
	$saleRow = $saleObj->getObj('seller_id = "'.$seller_id.'" and status = 0 ');
	if(empty($saleRow)){
		$return=1;
	}else{
		$return=0;
	}
	return $return;
}

public static function check_fanlitixian($seller_id){
	$saleObj = new IModel('fanli_tixian');
	$saleRow = $saleObj->getObj('seller_id = "'.$seller_id.'" and status = 0 ');
	if(empty($saleRow)){
		$return=1;
	}else{
		$return=0;
	}
	return $return;
}


public static function getFanliNum($goodsList){
	if(!is_array($goodsList)||!isset($goodsList)){
		return 0;
		exit;
	}
	$fanli_num=0;
	foreach($goodsList as $k=>$v){
		$GoodsInfo=self::getGoodsInfo($v['goods_id']);
		$SellerInfo=self::getsellerFanli($v['seller_id']);
		$fanli_bili=$GoodsInfo['fanli_bili'];
		$seller_fanli=$SellerInfo['bili_fanli'];
		$fanli_num+=($fanli_bili*$v['sum'])/$seller_fanli;
	}
	
	return $fanli_num;
	exit;
	}
	
public static function getTuiGuangNum($seller_id){
	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
	$orderObj = new IQuery('order');
	$orderObj->where='seller_id='.$seller_id.' and unix_timestamp(create_time)>"'.$beginThismonth.'" and unix_timestamp(create_time)<"'.$endThismonth.'"';
	$orderObj->fields='sum(real_amount) real_amount';
	$orderRow=$orderObj->find();
	if(empty($orderRow)){
		$return=0;
	}else{
		$return=$orderRow[0]['real_amount'];
	}
	return $return;
}



}