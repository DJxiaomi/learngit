<?php 
class seat_class
{

    public static function get_seat_info($goods_id){
        $seatDB = new IQuery('seat as s');
        $seatDB->join = " left join seat_goods as g on s.goods_id = g.goods_id";
        $seatDB->fields = 's.id,s.goods_id,s.name,s.time,s.row,s.col,s.buy,s.give,s.give_grade,s.publish,g.table_name';
        $seatDB->where = 's.goods_id='.$goods_id;
        return $seatDB->getOne();
    }

    public static function get_seat_table_name($name){        
        return substr($name,strpos($name,'seat'));
    }

    public static function get_free_seats($goods_id,$seats){ 
  
        $seatInfo = self::get_seat_info($goods_id);
        $row = $seatInfo['row'];
        $col = $seatInfo['col'];
        $table_name = self::get_seat_table_name($seatInfo['table_name']);

        //查询是否有买送规则
        if($seatInfo['buy'] > 0 && $seatInfo['give'] > 0 && $seatInfo['give_grade'] > 0){

            $seatInfoDB = new IQuery($table_name);

            $sent_seat = explode('-',$seats);
               
            //判断是否达到买送条件
            if(count($sent_seat) >= $seatInfo['buy']){
                foreach($sent_seat as $val){
                    $tmp_seat = explode('_',$val);
                    $seatArr[] = $tmp_seat;
                    $is_flag = 0;
                    foreach($seatArr as $v){
                        if($is_flag){
                            break;
                        }

                        if($v[1] == $col){
                            $current_row = $v[0] + 1;
                            $current_col = 1;
                        }else{
                            $current_row = $v[0];
                            $current_col = $v[1];
                        }

                        for( $i=$current_col; $i<=$col; $i++){
                            
                            $seatInfoDB->where = 'rows='.$current_row.' and cols='.$i;
                            $query_data = $seatInfoDB->getOne();

                            if($query_data['status'] != 1 && $query_data['flag'] != 'gd' && $query_data['flag'] == $seatInfo['give_grade']){
                                $re_tmp = $current_row.'_'.$i;
                                if(in_array($re_tmp,$sent_seat)){                                                               
                                    continue;
                                }else{
                                    $re_seat = $re_tmp;
                                    $is_flag = 1;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            return $re_seat;

        }

    }

    //2_5
    //2_5-3_5
    public static function get_nearby_seat($goods_id,$seats){

        $seatInfo = self::get_seat_info($goods_id);
        $row = $seatInfo['row'];
        $col = $seatInfo['col'];
        $table_name = self::get_seat_table_name($seatInfo['table_name']);

        //查询是否有买送规则
        if($seatInfo['buy'] > 0 && $seatInfo['give'] > 0 && $seatInfo['give_grade'] > 0){

            $seatInfoDB = new IQuery($table_name);

            $seat_arr = explode('-',$seats);

            sort($seat_arr);

            //判断是否达到买送条件
            if(count($seat_arr) >= $seatInfo['buy']){

                $col_arr = '';
                foreach($seat_arr as $val){
                    $tmp_seat = explode('_',$val);
                    $col_arr[] = array($tmp_seat[0],$tmp_seat[1]-1);
                    $col_arr[] = array($tmp_seat[0],$tmp_seat[1]+1);

                }

                $flag = 0;
                //过滤数组
                foreach($col_arr as $val){
                    if(!in_array($val[0].'_'.$val[1],$seat_arr)){
                        // $new_seat[] = $val;

                        $seatInfoDB->where = 'rows='.$val[0].' and cols='.$val[1];
                        $query_data = $seatInfoDB->getOne();

                        if($query_data['status'] != 1 && $query_data['flag'] != 'gd' && $query_data['flag'] == $seatInfo['give_grade']){
                            
                            $re_seat = $val[0].'_'.$val[1];
                            $flag = 1;
                            break;                    
                        }else{
                            continue;
                        }
                    }
                }

                if(!$flag){           

                    foreach($seat_arr as $val){
                        $tmp_seat = explode('_',$val);
                        $seatArr[] = $tmp_seat;

                        foreach($seatArr as $v){
                            if($is_flag){
                                break;
                            }

                            if($v[1] == $col){
                                $current_row = $v[0] + 1;
                                $current_col = 1;
                            }else{
                                $current_row = $v[0];
                                $current_col = $v[1];
                            }

                            for( $i=$current_col; $i<=$col; $i++){
                                
                                $seatInfoDB->where = 'rows='.$current_row.' and cols='.$i;
                                $query_data = $seatInfoDB->getOne();

                                if($query_data['status'] != 1 && $query_data['flag'] != 'gd' && $query_data['flag'] == $seatInfo['give_grade']){
                                    $re_tmp = $current_row.'_'.$i;
                                    if(in_array($re_tmp,$seat_arr)){                                                               
                                        continue;
                                    }else{
                                        $re_seat = $re_tmp;
                                        $flag = 1;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $re_seat;
        
    }


    public static function get_seat_order_list($user_id){
        $order_db = new IQuery('order as o');
        $order_db->join = 'left join order_goods as g on o.id=g.order_id';
        $order_db->where = "o.user_id=".$user_id." and o.seats != ''";
        $order_db->fields = 'o.id,o.order_no,o.user_id,o.create_time,o.real_amount,o.seller_id,o.seats,g.goods_id,g.img';
        $order_db->order = 'o.id DESC';
        $list = $order_db->find();
        
        return $list;
    }

    //根据订单ID获取座位及票价信息
    public static function get_seat_info_by_order_id($order_id){
        $order_db = new IQuery('order');
        $order_db->where = 'id = '.$order_id;
        $order_db->fields = 'seats,give_seats';
        $data = $order_db->getOne();

        $table_name = self::get_table_by_order_id($order_id);

        if($data['seats']){
            $split_str = explode(',',$data['seats']);
            foreach($split_str as $v){
                $list[] = self::get_seat_id_by_seats($v,$table_name);
            }
        }

        return $list;
    }

    //根据座位获取座位id
    public static function get_seat_id_by_seats($_seats,$_table_name){
        $seats_arr = explode('_',$_seats);
        $seat_db = new IQuery($_table_name);
        if($seats_arr){            
            $seat_db->where = 'rows = ' . $seats_arr[0] . ' and cols = ' . $seats_arr[1];
            $info = $seat_db->getOne();
        }
        return $info;
    }

    //订单id获取表名
    public static function get_table_by_order_id($order_id){
        $order_goods_db = new IQuery('order_goods as o');
        $order_goods_db->join = 'left join seat_goods as s on o.goods_id = s.goods_id';
        $order_goods_db->fields = 's.table_name';
        $order_goods_db->where = 'o.order_id='.$order_id;
        $data = $order_goods_db->getOne();

        if($data['table_name']){
            $table_name = self::get_seat_table_name($data['table_name']);
        }

        return $table_name;

    }

    //获取主体信息
    public static function get_main_info($order_id){
        $order_goods_db = new IQuery('order_goods as o');
        $order_goods_db->join = 'left join seat as s on o.goods_id = s.goods_id';
        $order_goods_db->fields = 's.id,s.name,s.time,s.buy,s.give,s.give_grade';
        $order_goods_db->where = 'o.order_id='.$order_id;
        $data = $order_goods_db->getOne();

        return $data;
    }

    //获取商品信息
    public static function get_goods_info($order_id){
        $order_goods_db = new IQuery('order_goods as o');
        $order_goods_db->join = 'left join goods as g on o.goods_id = g.id';
        $order_goods_db->where = 'o.order_id='.$order_id;
        $data = $order_goods_db->getOne();

        return $data;
    }

    
    //订单完成时操作状态
    public static function finish_modify_status($order_info){        
        //获取表名
        $table_name = self::get_table_by_order_id($order_info['id']);

        $seat_info_db = new IModel($table_name);
        $seat_info_read_db = new IQuery($table_name);

        if($order_info['seats']){
            $seatArr = explode(',',$order_info['seats']);
            foreach( $seatArr as $v ){
                $subArr = explode('_',$v);
                $seat_info_read_db->where = 'rows='.$subArr[0].' and cols='.$subArr[1];
                $tmp_res = $seat_info_read_db->getOne();

                $seat_info_db->setData(array('status'=>1));
                $seat_info_db->update('id='.$tmp_res['id']);
            }
        }


        //更新订单信息
        $order_db = new IModel('order');
        $order_db->setData(array(
            'status' => 5,
            'distribution_status' => 1,
            'is_confirm' => 1,
            'is_checkout' => 1,
            'completion_time' => date('Y-m-d H:i:s'),
        ));
        $order_db->update('id='.$order_info['id']);

        //付款给商家
        $seller_info = seller_class::get_seller_info($order_info['seller_id']);
    
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'sale_balance' => $seller_info['sale_balance'] + $order_info['real_amount']
        ));
        $seller_db->update('id='.$order_info['seller_id']);

    }

}



?>