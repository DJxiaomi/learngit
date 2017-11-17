<?php 
class equity_class
{

    public function equity_allocation($orderNo)
    {
        //订单信息
        $order_db = new IQuery('order');
        $order_db->where = 'order_no = '.$orderNo;
        $order = $order_db->getOne();

        //商户信息
        $seller = seller_class::get_seller_info($order['seller_id']);

        //判断商户状态
        if($seller['is_equity'] != 1){
            return false;
        }

        //判断商户是否有推广人
        if($seller['promo_code'] != '')
        {
            $parent = self::get_promotor_info($seller['promo_code']);

            //判断父级是商家还是用户
            if($parent['is_seller']){
                $promo_code = self::get_promo_code($parent['id']);
            }else{
                $promo_code = $parent['id'];
            }

            //判断父级是否为股权分配商家 是否开启股权分配
            if($parent['is_equity'] == 1 && $parent['equity_status'] == 1)
            {
                $parent_equity = $this->equity_handle($promo_code,1);
                if(!$parent_equity)
                {
                    $this->equity_handle($promo_code,2);
                    $parent_equity = $this->equity_handle($promo_code,1);
                }

                //是否达到股权分配最高值
                if($parent_equity['equity_num'] < 1)
                {
                    //添加推广数据 
                    $this->equity_update($parent_equity,$order,1,self::get_promo_code($seller['id']));
                } 
            }           
        }

        //判断商户是否为股权分配商户
        if($seller['equity_status'] == 1)
        {
            $promo_code = self::get_promo_code($seller['id']);

            //查询商家股权信息
            $seller_equity = $this->equity_handle($promo_code,1);
            if(!$seller_equity)
            {
                $this->equity_handle($promo_code,2);
                $seller_equity = $this->equity_handle($promo_code,1);
            }

            //是否达到股权分配最高值
            if($seller_equity['equity_num'] < 1)
            {
                //添加推广数据 
                $this->equity_update($seller_equity,$order,1);
            }
        }
    }
    
    private function equity_rule($promo_code,$order_id)
    {           
        $total_equity = self::get_total_equity();
        $equity_info = $this->equity_handle($promo_code,1);
        $stall = self::get_current_stall($total_equity); 
        
        if($equity_info['surplus_price'] >= $stall['stall_price'] && $equity_info['surplus_num'] >= $stall['stall_num'])
        {
            $data = array(
                'surplus_price' => $equity_info['surplus_price'] - $stall['stall_price'],
                'surplus_num' => $equity_info['surplus_num'] - $stall['stall_num'],
                'equity_num' => $equity_info['equity_num'] + 0.01
            );
           
            $equity_info_db = new IModel('equity_info');
            $equity_info_db->setData($data);
            $equity_info_db->update('promo_code = "'.$promo_code.'"');

            //更新股权剩余数量
            $equity_data = array('total'=>$total_equity - 0.01);
            $equity_w_db =  new IModel('equity');
            $equity_w_db->setData($equity_data);
            $equity_w_db->update('id = 1');

            //记录股权变更信息
            $change_db = new IModel('equity_change_info');

            $change_db->setData(array(
                'promo_code' => $promo_code,
                'order_id' => $order_id,
                'point' => $total_equity - 0.01,
                'create_time' => time()
            ));
            
            $change_db->add();
        }        
    }


    public function equity_handle($promo_code,$flag = 1)
    {
        if(!$promo_code || !$flag)
        {
            return false;
        }        
        
        $equity_db = new IQuery('equity_info');
        $equity_db->where = 'promo_code = "'.$promo_code.'"';
        $info = $equity_db->getOne();        

        if($flag == 2 && !$info){
            $equity_db = new IModel('equity_info');
            $equity_db->setData(array('promo_code' => $promo_code,'create_time'=>time()));
            $equity_db->add();
        }else{
            return $info;
        }
        
       
    }


    //数据更新
    private function equity_update($equity,$order,$is_seller,$branch_code = null)
    {
        if(!$equity)
        {
            return false;
        }

        $data = array(
            'total_price' => $equity['total_price'] + $order['order_amount'],
            'surplus_price' =>  $equity['surplus_price'] + $order['order_amount'],
        );

        //判断用户是否第一次记录
        $equity_order_db = new IQuery('equity_order');
        $equity_order_db->where = 'deal_user_id = ' . $order['user_id'] . ' and order_id != ' . $order['id'];
        $result = $equity_order_db->getOne();

        if(!$result){
            $data['total_num'] = $equity['total_num'] + 1;
            $data['surplus_num'] = $equity['surplus_num'] + 1;
        }      
  
        $equity_db = new IModel('equity_info');
        $equity_db->setData($data);
        $equity_db->update('promo_code = "' . $equity['promo_code'] . '"');

        //记录订单
        $equity_order_w_db = new IModel('equity_order');
        $recode_data = array(
            'promo_code' => $equity['promo_code'],
            'order_id' => $order['id'],
            'deal_user_id' => $order['user_id'],
            'create_time' => time()
        );

        if($branch_code)
        {
            $recode_data['branch_code'] = $branch_code;
        }        

        $equity_order_w_db->setData($recode_data);         
        $equity_order_w_db->add();

        $this->equity_rule($equity['promo_code'],$order['id']);        
    }


    //股权数据转移
    function move_promo_data($promo_code,$old_promo_code,$new_promo_code,$type)
    {
        //新推广人信息
        $new_promotor_info = promotor_class::get_promotor_info($new_promo_code);
        
        //新推广人是否为股权分配商户
        if($new_promotor_info['equity_status'] != 1)
        {
            $flag = -1;
            return $flag;
        }

        $equity = $this->equity_handle($promo_code,1);//当前用户/商户股权信息
        $new_equity = $this->equity_handle($new_promo_code,1);//新推广人股权信息
        $old_equity = $this->equity_handle($old_promo_code,1);//原推广人股权信息    

        $plus_data = array(
            'total_price' => $new_equity['total_price'] + $equity['total_price'],
            'total_num' => $new_equity['total_num'] + $equity['total_num'],
            'surplus_price' => $new_equity['surplus_price'] + $equity['surplus_price'],
            'surplus_num' => $new_equity['surplus_num'] + $equity['surplus_num'],
            'equity_num' => $new_equity['equity_num'] + $equity['equity_num']
        );

        $minus_data = array(
            'total_price' => $old_equity['total_price'] - $equity['total_price'],
            'total_num' => $old_equity['total_num'] - $equity['total_num'],
            'surplus_price' => $old_equity['surplus_price'] - $equity['surplus_price'],
            'surplus_num' => $old_equity['surplus_num'] - $equity['surplus_num'],
            'equity_num' => $old_equity['equity_num'] - $equity['equity_num']
        );

        $equity_db = new IModel('equity_info');
        $equity_db->setData($plus_data);
        $equity_db->update( 'promo_code = "' . $new_promo_code . '"');

        $equity_db->setData($minus_data);
        $equity_db->update( 'promo_code = "' . $old_promo_code . '"');
  
        //修改股权订单记录
        $e_order_db = new IQuery('equity_order');
        $e_order_db->where = 'promo_code = "' . $old_promo_code . '" and branch_code = "' . $promo_code . '"';
        $order_list = $e_order_db->find();

        $e_order_w_db = new IModel('equity_order');
        if($order_list)
        {
            foreach($order_list as $v)
            {
                $e_order_w_db->setData(array('promo_code'=>$new_promo_code));
                $e_order_w_db->update('id = ' . $v['id']);
            }
        }        
    }


    public static function get_promo_code($id)
    {
        return 's'.$id;
    }

    public static function get_total_equity()
    {
        $DB = new IQuery('equity');
        $DB->where = 'id = 1';
        $equity = $DB->getOne();
        return $equity['total'];
    }

    public static function get_promotor_info($prom_code = '')
    {
        $user_ere = '/^[0-9]+$/';
        preg_match_all($user_ere, $prom_code, $result);

        if ( $result[0] )
        {
            $id = $result[0][0];
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $id;
            $user_info = $user_db->getOne();
            $user_info['is_seller'] = 0;
            return ($user_info) ? $user_info : false;
        }

        $seller_ere = '/^[sS]([0-9]+)$/';
        preg_match_all($seller_ere, $prom_code, $result);

        if ( $result[1] )
        {
            $id = $result[1][0];
            $seller_db = new IQuery('seller');
            $seller_db->where = 'id = ' . $id;
            $seller_info = $seller_db->getOne();
            $seller_info['is_seller'] = 1;
            return ($seller_info) ? $seller_info : false;
        }

        return false;
    }


    public static function get_current_stall($total)
    {
        if($total >= 15.01){
            $stall_price = 10000;
            $stall_num = 2;
        }else if($total >= 12.01){
            $stall_price = 12000;
            $stall_num = 2.4;
        }else if($total >= 9.01){
            $stall_price = 15000;
            $stall_num = 3;
        }else if($total >= 6.01){
            $stall_price = 20000;
            $stall_num = 4;
        }else if($total >= 3.01){
            $stall_price = 30000;
            $stall_num = 6;
        }else if($total >= 0.01){
            $stall_price = 40000;
            $stall_num = 8;
        }

        return array('stall_price'=>$stall_price,'stall_num'=>$stall_num);
    }

    public static function get_equity_info($promo_code)
    {
        $equityDB = new IQuery('equity_info');
        $equityDB->where = 'promo_code = "'.$promo_code.'"';
        return $equityDB->getOne();
    }

    //股权分配明细
    public static function get_detail_list($promo_code)
    { 
        $DB = new IQuery('equity_change_info');
        $DB->where = 'promo_code = "'.$promo_code.'"';
        $DB->order = 'id DESC';
        return $DB->find();
    }

}



?>