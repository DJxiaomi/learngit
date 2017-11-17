<?php
/**
 * @brief 自主扩展模块
 * @class Zesheng
 * @author mlm
 * @datetime 2016/3/1
 */
class Zesheng extends IController
{	
	public $layout='';
	
	public function wxpay_success(){
		$order_no=IReq::get('order_no');
		$type=IReq::get('type');
		if($type=='order'){
			//订单批量结算缓存机制
				$moreOrder = Order_Class::getBatch($order_no);
				foreach($moreOrder as $key => $item)
				{
					$order_id = Order_Class::updateOrderStatus($item);

				}
		}elseif($type='recharge'){
			payment::updateRecharge($order_no);
		}elseif($type='fanli'){
			Lexiangshenghuo::updateFanli_chongzhi($order_no);
		}elseif($type='sale'){
			Lexiangshenghuo::updateSale_chongzhi($order_no);
		}
		echo 'success';
	}
	
	
	
	
	
	public function daily_rebate()
	{
	    Lexiangshenghuo::rebate_daily();
	}
	
	public function test_rebate()
	{
	    /**
        $rebate_log_list = Fanli_log_class::get_rebate_log_list( array( 61 ));
        //dump( $rebate_log_list );

        $close_log_arr = array();
        $rebate_statisc = array();
        foreach( $rebate_log_list as $kk => $vv )
        {
            $distance_day = get_distance_day( date('Y-m-d') . ' 00:00:00', date('Y-m-d', $vv['time'] ) . ' 00:00:00' );
            $rebate_info = Lexiangshenghuo::get_rebate_info( $vv['rebate_rule'], $distance_day, $vv['num'] );
            
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
        
        //dump( $rebate_statisc );
        dump( $rebate_log_list );
        **/
        Lexiangshenghuo::rebate_daily();
	}
	
	
	public function meiri_fanli(){
		
		Lexiangshenghuo::gengxinfanli();
		exit;
	}
	
	// public function gengxin_key(){
			// $fenqilog = new IQuery("goods as g,seller as s");
			// $fenqilog->where='g.seller_id = s.id ';
			// $fenqilog->fields='g.id,g.search_words,s.seller_name';
			// $fenqiinfo=$fenqilog->find();
			// $goodsObj = new IModel('goods');
			// foreach($fenqiinfo as $v){
				
				
				
				// $dataArray = array(
				// 'search_words' => $v['search_words'].','.$v['seller_name']
				// );
				// $goodsObj->setData($dataArray);
				// $goodsObj->update('id='.$v['id']);
				
			// }
			
			// print_r($fenqiinfo);exit;
	// }
	
	
	public function sendmass(){
		
	}
	
	public function wxPay(){
		//获得相关参数
		$order_id   = IReq::get('order_id');
		$payment_id = 13;
		$final_sum = IReq::get('final_sum');
 
		ini_set('date.timezone','Asia/Shanghai');
		//error_reporting(E_ERROR);
		require_once "plugins/payments/pay_wx/lib/WxPay.Api.php";
		require_once "plugins/payments/pay_wx/example/WxPay.JsApiPay.php";
		require_once 'plugins/payments/pay_wx/example/log.php';

		//初始化日志
		$logHandler= new CLogFileHandler("plugins/payments/pay_wx/logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);

		//打印输出数组信息
		function printf_info($data)
		{
			foreach($data as $key=>$value){
				echo "<font color='#00ff55;'>$key</font> : $value <br/>";
			}
		}

		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();

		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($final_sum*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://dsanke.com/plugins/payments/pay_wx/example/notify.php");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		printf_info($order);
		$jsApiParameters = $tools->GetJsApiParameters($order);

		//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();




		$this->redirect('wxPay');
		exit;
	}
	
	
	
	
	
}