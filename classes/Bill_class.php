<?php 

class Bill_class 
{
    // 商户订单自动结算 added by jack 2016-09-25
    public static function _bill_auto( $seller_id, $order_id )
    {
        if ( !$seller_id || !$order_id )
        {
            $this->show_warning('参数不正确');
            exit();
        }
        
        //获取未结算的订单
        $queryObject = CountSum::getAutoSellerGoodsFeeQuery($seller_id, $order_id);
        $countData   = CountSum::countSellerOrderFee($queryObject->find());
        
        if ( $countData['order_ids'][0] )
        {
            $order_id_temp = $countData['order_ids'][0];
            $order_info_temp = Order_Class::get_order_info($order_id_temp);
            $start_time = date('Y-m-d', strtotime( $order_info_temp['create_time'] ) );
            $end_time = $start_time;
        }
        
        if ( $countData['settled'] > 0 || $countData['not_settled'] > 0 )
        {
            $countData['countFee'] = $countData['settled'];
            $order_id = $countData['order_ids'][0];
            
            // 生成结算账单、商户账户增加交易额
            if($countData['countFee'] > 0)
            {
                $billDB = new IModel('bill');
                $countData['start_time'] = $start_time;
                $countData['end_time']   = $end_time;
                $billString = AccountLog::sellerBillTemplate($countData);
                $data = array(
                    'seller_id'  => $seller_id,
                    'apply_time' => date('Y-m-d H:i:s'),
                    'apply_content' => IFilter::act(IReq::get('apply_content')),
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'log' => $billString,
                    'order_ids' => join(",",$countData['order_ids']),
                );
            
                $billDB->setData($data);
                $id = $billDB->add();
                $is_pay = 1;
                $data = array(
                    'admin_id' => 0,
                    'pay_content' => '',
                    'is_pay' => $is_pay,
                );
            
                $billDB = new IModel('bill');
                $data['pay_time'] = ($is_pay == 1) ? date('Y-m-d H:i:s') : "";
                $billRow= $billDB->getObj('id = '.$id);            
                $billDB->setData($data);
                $billDB->update('id = '.$id);
                self::add_sale( $seller_id, $countData['countFee'] );
            }
            
            // 修改交易结算状态
            $data = array('settled' => $countData['settled'], 'not_settled' => $countData['not_settled'] );
            if ( $countData['settled'] > 0 )
            {
                $data['is_checkout'] = ( $countData['not_settled'] > 0 ) ? 2 : 1;
            } else {
                $data['is_checkout'] = 0;
            }
            $order_db = new IModel('order');
            $order_db->setData($data);
            $order_db->update('id = ' . $order_id );
        }
    
        /**
        if($countData['countFee'] > 0)
        {
            $billDB = new IModel('bill');
            $countData['start_time'] = $start_time;
            $countData['end_time']   = $end_time;
            $billString = AccountLog::sellerBillTemplate($countData);
            $data = array(
                'seller_id'  => $seller_id,
                'apply_time' => date('Y-m-d H:i:s'),
                'apply_content' => IFilter::act(IReq::get('apply_content')),
                'start_time' => $start_time,
                'end_time' => $end_time,
                'log' => $billString,
                'order_ids' => join(",",$countData['order_ids']),
            );
    
            $billDB->setData($data);
            $id = $billDB->add();
            $is_pay = 1;
            $data = array(
                'admin_id' => 0,
                'pay_content' => '',
                'is_pay' => $is_pay,
            );
    
            $billDB = new IModel('bill');
            $data['pay_time'] = ($is_pay == 1) ? date('Y-m-d H:i:s') : "";
            $billRow= $billDB->getObj('id = '.$id);
            if(isset($billRow['order_ids']) && $billRow['order_ids'])
            {
                //更新订单商品关系表中的结算字段
                $orderDB = new IModel('order');
                $orderIdArray = explode(',',$billRow['order_ids']);
    
                foreach($orderIdArray as $key => $val)
                {
                    $orderDB->setData(array('is_checkout' => $is_pay));
                    $orderDB->update('id = '.$val);
                }
            }
    
            $billDB->setData($data);
            $billDB->update('id = '.$id);
            self::add_sale( $seller_id, $countData['countFee'] );
        }
        **/
    }
    
    // 商户结算
    public static function add_sale($seller_id,$num)
    {
        $sellerRow = seller_class::get_seller_info( $seller_id );
        
        $sellerObj  = new IModel('seller');
        $dataArray1 = array(
            'sale_balance'     => $sellerRow['sale_balance']+$num,
        );
    
        $sellerObj->setData($dataArray1);
        $sellerObj->update('id = "'.$seller_id.'"');
    }
}

?>