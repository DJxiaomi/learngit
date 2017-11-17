<?php 

class Seller2 extends IController implements sellerAuthorization
{
    public $layout = 'site';
    
    function init()
    {

    }
    
    function cart2()
    {
        $tutor_id = IFilter::act(IReq::get('id'),'int');
        if ( !$tutor_id )
        {
            IError::show('参数不正确',403);
        }
    
        // 判断该家教状态是否可以被商户下单
        if ( !tutor_class::can_order_by_seller($tutor_id))
        {
            IError::show('操作失败，该家教暂时不能进行试讲',403);
        }
         
        $tutor_info = tutor_class::get_tutor_info($tutor_id);
        if ( $tutor_info )
        {
            $tutor_info['teaching_time'] = ($tutor_info['teaching_time']) ? unserialize($tutor_info['teaching_time']) : array();
        }
        if ( $tutor_info['test_reward'] )
        {
            $tutor_info['test_reward'] = unserialize($tutor_info['test_reward']);
        }
        
        $this->setRenderData(array(
            'tutor_info'   =>  $tutor_info,
            'order_amount'  =>  tutor_class::get_tutor_price($tutor_id),
            'teaching_time_arr'    =>  tutor_class::get_teaching_time2(),
        ));

        $this->redirect('cart2');
    }
    
    function cart3()
    {
        $tutor_id = IFilter::act(IReq::get('tutor_id'),'int');
        if ( !$tutor_id )
        {
            IError::show('参数不正确',403);
        }
         
        // 判断该家教状态是否可以被商户下单
        if ( !tutor_class::can_order_by_seller($tutor_id))
        {
            IError::show('操作失败，该家教暂时不能进行试讲',403);
        }
         
        $tutor_info = tutor_class::get_tutor_info($tutor_id);
        $member_info = member_class::get_member_info($tutor_info['user_id']);
        $seller_id = $this->seller['seller_id'];
        $seller_info = seller_class::get_seller_info($seller_id);
        $order_db = new IModel('order');
        $order_goods_db = new IModel('order_goods');
        
         
        //生成的订单数据
    
        $order = array(
    
        				'order_no'            => Order_Class::createOrderNum(),
    
        				'user_id'             => $tutor_info['user_id'],
    
        				'accept_name'         => $member_info['true_name'],
    
        				'pay_type'            => 1,
    
        				'distribution'        => 1,
    
        				'postcode'            => '000000',
    
        				'telphone'            => '',
    
        				'province'            => '111111',
    
        				'city'                => '111111',
    
        				'area'                => '111111',
    
        				'address'             => '默认地址',
    
        				'mobile'              => $member_info['mobile'],
    
        				'create_time'         => ITime::getDateTime(),
    
        				'postscript'          => '',
    
        				'accept_time'         => '任意',
    
        				'exp'                 => 0,
    
        				'point'               => 0,
    
        				'type'                => 0,
    
    
    
        				//商品价格
    
        				'payable_amount'      => tutor_class::get_tutor_price($tutor_id),
    
        				'real_amount'         => tutor_class::get_tutor_price($tutor_id),
    
    
    
        				//运费价格
    
        				'payable_freight'     => 0,
    
        				'real_freight'        => 0,
    
    
    
        				//手续费
    
        				'pay_fee'             => 0,
    
    
    
        				//税金
    
        				'invoice'             => $tax_title ? 1 : 0,
    
        				'invoice_title'       => $tax_title,
    
        				//'taxes'               => $goodsResult['taxPrice'],
    
        				'taxes'               => 0,
    
    
    
        				//优惠价格
    
        				//'promotions'          => $goodsResult['proReduce'] + $goodsResult['reduce'],
    
        				'promotions'	    	=> 0,
    
             
    
        				//订单应付总额
    
        				//'order_amount'        => $goodsResult['orderAmountPrice'],
    
        				'order_amount'		    => tutor_class::get_tutor_price($tutor_id),
    
    
    
        				//订单保价
    
        				//'insured'             => $goodsResult['insuredPrice'],
    
        				'insured'		        => 0,
    
             
    
        				//自提点ID
    
        				'takeself'            => $takeself,
    
    
    
        				//促销活动ID
    
        				'active_id'           => $active_id,
    
    
    
        				//商家ID
    
        				'seller_id'           => $seller_id,
    
    
    
        				//备注信息
    
        				'note'                => '',
    
                        'statement'           => 4,
            	
                        'order_role'          => 2,
            
                        'user_tutor_id'       => $tutor_id,
            	
        );
         
         
        $order_db->setData($order);
        $order_id = $order_db->add();
        if ( !$order_id )
        {
            IError::show('下单失败',403);
        }
         
        $order_goods_data = array(
            'img'        =>  $seller_info['logo'],
            'order_id'   =>  $order_id,
            'goods_id'   =>  946,
            'product_id' =>  5280,
            'goods_price'    =>  $order['order_amount'],
            'real_price'     =>  $order['order_amount'],
            'goods_nums' =>  1,
            'seller_id'  =>  $seller_id,
            'verification_code'  =>  Order_goods_class::get_verification_code(),
        );
        $specArray = array('name' => $seller_info['true_name'],'goodsno' => '','value' => category_class::get_category_title($tutor_info['grade_level']) . category_class::get_category_title($tutor_info['grade']));
        $order_goods_data['goods_array'] = IFilter::addSlash(JSON::encode($specArray));
         
        $order_goods_db->setData($order_goods_data);
        $order_goods_db->add();
         
        $this->redirect('/site/success/message/'.urlencode("订单成功").'/is_seller/1/?callback=/seller/order_tutor_list');
         
        exit;
    }
}


?>