<?php 

class Seller_class
{
    public static function get_seller_info_by_mobile( $mobile )
    {
        if ( !$mobile )
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->where = "mobile = '$mobile'";
        return $seller_db->getOne();
    }
    
    public static function get_seller_info( $seller_id )
    {
        if ( !$seller_id )
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->where = 'id = ' . $seller_id;
        return $seller_db->getOne();
    }
    
    public static function get_seller_info_by_id_arr( $id_arr, $field = '*' )
    {
        if ( !is_array( $id_arr ))
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->where = db_create_in( $id_arr, 'id');
        $seller_db->fields = $field;
        return $seller_db->find();
    }
    
    public static function get_seller_list( $where = '', $fields = '*', $page = 1, $page_size = 12, $order = 'id asc' )
    {
        $where = ( $where ) ? $where . ' and is_del = 0 and is_lock = 0' : 'is_del = 0 and is_lock = 0';
        $seller_db = new IQuery('seller');
        $seller_db->where = $where;
        $seller_db->fields = $fields;
        if ( !$order )
            $order = 'id asc';
        $seller_db->order = $order;
        
        if ( !$page_size )
        {
            return $seller_db->find();
        } else {
            $seller_db->pagesize = $page_size;
            $seller_db->page = $page;
            $seller_list = $seller_db->find();
            $paging = $seller_db->paging;
            
            if ( $seller_list )
            {
                foreach($seller_list as $kk => $vv)
                {

                        $seller_tutor_db = seller_tutor_class::get_seller_tutor_list_db($vv['id'], 1, 50);
                        $seller_list[$kk]['seller_tutor_list'] = $seller_tutor_db->find();
                        $seller_list[$kk]['point'] = comment_class::get_tutor_seller_point($vv['id']);
                        
                        $teaching_info = Teacher_class::get_teacher_info_by_seller2($vv['id']);
                        if ( $teaching_info )
                            $seller_list[$kk]['sex'] = $teaching_info['sex'];
                        
                   
                }
            }
            
            return array(
                'result_count'  =>  $paging->rows,
                'seller_list'   =>  $seller_list,
                'page_info'     =>  $seller_db->getPageBar(),
                'page_count'    =>  ceil( $paging->rows / $page_size ),
            );
        }
    }
    
    public static function get_seller_list2( $where = '', $fields = 's.*', $page = 1, $page_size = 12, $order = 'id asc' )
    {
        $where = ( $where ) ? $where . ' and is_del = 0 and is_lock = 0' : 'is_del = 0 and is_lock = 0';
        $seller_db = new IQuery('seller as s');
        $seller_db->join = 'left join brand as b on s.brand_id = b.id';
        $seller_db->where = $where;
        $seller_db->fields = $fields;
        if ( !$order )
            $order = 's.id asc';
        $seller_db->order = $order;
    
        if ( !$page_size )
        {
            return $seller_db->find();
        } else {
            $seller_db->pagesize = $page_size;
            $seller_db->page = $page;
            $seller_list = $seller_db->find();
            $paging = $seller_db->paging;
    
            if ( $seller_list )
            {
                foreach($seller_list as $kk => $vv)
                {

                        $seller_tutor_db = seller_tutor_class::get_seller_tutor_list_db($vv['id'], 1, 50);
                        $seller_list[$kk]['seller_tutor_list'] = $seller_tutor_db->find();
                        $seller_list[$kk]['point'] = comment_class::get_tutor_seller_point($vv['id']);
    
                        $teaching_info = Teacher_class::get_teacher_info_by_seller2($vv['id']);
                        if ( $teaching_info )
                            $seller_list[$kk]['sex'] = $teaching_info['sex'];
    
                    
                }
            }
    
            return array(
                'result_count'  =>  $paging->rows,
                'seller_list'   =>  $seller_list,
                'page_info'     =>  $seller_db->getPageBar(),
                'page_count'    =>  ceil( $paging->rows / $page_size ),
            );
        }
    }
   
    // 验证商家账户信息 
    public static function check_seller( $sellername = '', $passwd = '')
    {
        if ( !$sellername || !$passwd )
            return false;
        
        $passwd = md5( $passwd );
        $seller_db = new IQuery('seller');
        $seller_db->where = 'seller_name = "'.$sellername.'" and password = "' . $passwd . '" and is_del = 0 and is_lock = 0';
        return ( $seller_db->getOne() ) ? true : false;
    }
    
    public static function get_seller_info_by_bid( $bid = 0 )
    {
        if ( !$bid )
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->where = 'brand_id = ' . $bid . ' and is_del = 0';
        return $seller_db->getOne();
    }

    public static function get_seller_shortname($seller_id)
    {
        $seller_db = new IModel('seller');
        $seller = $seller_db->getObj("id = '$seller_id'", 'true_name,shortname');

        return $seller['shortname'] ? $seller['shortname'] : $seller['true_name'];
    }
    
    public static function is_tutor_seller($seller_id = 0)
    {
        if (!$seller_id)
            return false;
        
        $seller_info = self::get_seller_info($seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
       return ($brand_info['category_ids'] != 16) ? false : true;
    }
    
    // 更新试讲次数
    public static function update_seller_lecture_nums($seller_id = 0)
    {
        if ( !$seller_id )
            return false;
         
        $seller_info = seller_class::get_seller_info($seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
        if ( !$seller_info || $brand_info['category_ids'] != 16 )
            return false;
         
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'lecture_nums' =>  $seller_info['lecture_nums'] + 1,
        ));
        $seller_db->update('id = ' . $seller_id);
    }
    
    // 更新成功受聘的次数
    public static function update_seller_hired_nums($seller_id = 0)
    {
        if ( !$seller_id )
            return false;
    
        $seller_info = seller_class::get_seller_info($seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
        if ( !$seller_info || $brand_info['category_ids'] != 16 )
            return false;
    
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'hired_nums' =>  $seller_info['hired_nums'] + 1,
        ));
        $seller_db->update('id = ' . $seller_id);
    }
    
    // 更新到期后再聘的次数
    public static function update_seller_rehired_nums($seller_id = 0)
    {
        if ( !$seller_id )
            return false;
         
        $seller_info = seller_class::get_seller_info($seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
        if ( !$seller_info || $brand_info['category_ids'] != 16 )
            return false;
         
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'rehired_nums' =>  $seller_info['rehired_nums'] + 1,
        ));
        $seller_db->update('id = ' . $seller_id);
    }
    
    // 判断是否聘用过
    public static function check_seller_hired($seller_id = 0, $user_id = 0)
    {
        if ( !$seller_id || !$user_id )
            return false;
         
        $rehired = false;
        $order_db = new IQuery('order');
        $order_db->where = 'user_id = ' . $user_id . ' and seller_id = ' . $seller_id . ' and pay_status = 1 and statement = 4';
        $order_list = $order_db->find();
        return ($order_list) ? true : false;
    }
    
    public static function check_seller_rehired($seller_id = 0, $user_id = 0 )
    {
        if ( !$seller_id || !$user_id )
            return false;
         
        $rehired = false;
        $order_db = new IQuery('order');
        $order_db->where = 'user_id = ' . $user_id . ' and seller_id = ' . $seller_id . ' and pay_status = 1 and statement = 4';
        $order_list = $order_db->find();
        return ($order_list && sizeof($order_list) > 1) ? true : false;
    }
        
    // 获取HOT家教老师排行榜
    public static function get_hotest_tutor_seller_list($page_size = 5)
    {
        $tutor_seller_list = seller_tutor_class::get_tutor_seller_list();
        $where = ($tutor_seller_list) ? 'b.category_ids = 16 and s.is_authentication = 1 and ' . db_create_in($tutor_seller_list, 's.id') : 'b.category_ids = 16 and s.is_authentication = 1';
        $seller_list = self::get_seller_list2($where, 's.*', 1, 5, 'sale desc');
        return $seller_list;
    }
    
    // 获取最新入驻老师
    public static function get_latest_tutor_seller_list($page_size = 5)
    {
        $tutor_seller_list = seller_tutor_class::get_tutor_seller_list();
        $where = ($tutor_seller_list) ? 'b.category_ids = 16 and s.is_authentication = 1 and ' . db_create_in($tutor_seller_list, 's.id') : 'b.category_ids = 16 and s.is_authentication = 1';
        $seller_list = self::get_seller_list2($where, 's.*', 1, 5, 'create_time desc');
        return $seller_list;
    }
    
    // 获取推荐的家教老师
    public static function get_intro_tutor_seller_list($page_size = 5)
    {
        $tutor_seller_list = seller_tutor_class::get_tutor_seller_list();
        $where = ($tutor_seller_list) ? 'b.category_ids = 16 and s.is_authentication = 1 and s.is_vip = 1 and ' . db_create_in($tutor_seller_list, 's.id') : 'b.category_ids = 16 and s.is_authentication = 1 and s.is_vip = 1 ';
        $seller_list = self::get_seller_list2($where, 's.*', 1, 5, 'create_time desc');
        return $seller_list;
    }
  
    public static function update_seller_views($seller_id = 0)
    {
        if ( !$seller_id )
            return false;
        
        $seller_info = self::get_seller_info($seller_id);
        if ( !$seller_info )
            return false;
        
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'views' => $seller_info['views'] + 1,
        ));
        $seller_db->update('id = ' . $seller_id);
    }
    
    public static function is_tutor_seller_receive_booking($seller_id = 0 )
    {
        if ( !$seller_id )
            return false;
        
        $seller_info = seller_class::get_seller_info($seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
        
        if ( !$seller_info || $brand_info['category_ids'] != 16)
            return false;
        
        $teacher_info = teacher_class::get_teacher_info_by_seller2($seller_id);
        return ($teacher_info['is_receive_booking'] == 1) ? true : false;
    }
    
    public static function get_intro_shop_list_by_area_id($city_id = 0, $area_id = 0, $limit = 10)
    {
        $seller_condition = " and s.city = $city_id";
        $goods_db = new IQuery('goods');
        $goods_db->where = 'is_del = 0';
        $goods_db->fields = 'distinct(seller_id) as seller_id';
        $seller_list = $goods_db->find();
        $seller_arr = array();
        if ( $seller_list )
        {
            foreach( $seller_list as $kk => $vv )
            {
                if ( !in_array($vv['seller_id'], $seller_arr))
                    $seller_arr[] = $vv['seller_id'];
            }
        }
        if ( $seller_arr )
        {
            $seller_condition .= ' and ' . db_create_in($seller_arr, 's.id');
        }
        
        $shop_db = new IQuery('seller s');
        $shop_db->join = " left join brand AS b on b.id = s.brand_id";
        if ( $area_id )
            $shop_db->where = "s.is_authentication = 1 and s.area = $area_id and s.is_del = 0 and s.is_lock = 0 and s.type = 1 and b.logo != '' and b.description != '' and s.shortname != '' and b.category_ids != '16' and s.id != 255 $seller_condition";
        else
            $shop_db->where = "s.is_authentication = 1 and s.is_del = 0 and s.is_lock = 0 and s.type = 1 and b.logo != '' and b.description != '' and s.shortname != '' and b.category_ids != '16' and s.id != 255 $seller_condition";
        $shop_db->fields = 's.sale,b.brief,b.id, b.shortname,b.name, s.seller_name, s.address, s.area, b.logo, s.brand_id,b.description';
        $shop_db->order = 's.sale desc';
        $shop_db->limit = $limit;
        
        $shop_db->find();
        return $shop_db->find();
    }
    
    public static function get_intro_shop_list_by_area_id2($area_id = 0, $limit = 10, $page = 1)
    {
        $goods_db = new IQuery('goods');
        $goods_db->where = 'is_del = 0';
        $goods_db->fields = 'distinct(seller_id) as seller_id';
        $seller_list = $goods_db->find();
        $seller_arr = array();
        if ( $seller_list )
        {
            foreach( $seller_list as $kk => $vv )
            {
                if ( !in_array($vv['seller_id'], $seller_arr))
                    $seller_arr[] = $vv['seller_id'];
            }
        }
        if ( $seller_arr )
        {
            $seller_condition = ' and ' . db_create_in($seller_arr, 's.id');
        }
    
        $shop_db = new IQuery('seller s');
        $shop_db->join = " left join brand AS b on b.id = s.brand_id";
        if ( $area_id )
            $shop_db->where = "s.is_authentication = 1 and s.area = $area_id and s.is_del = 0 and s.is_lock = 0 and s.type = 1 and s.logo != '' and b.description != '' and s.shortname != '' and b.category_ids != '16' and s.id != 255 $seller_condition";
        else
            $shop_db->where = "s.is_authentication = 1 and s.is_del = 0 and s.is_lock = 0 and s.type = 1 and s.logo != '' and b.description != '' and s.shortname != '' and b.category_ids != '16' and s.id != 255 $seller_condition";
        $shop_db->fields = 's.id, s.true_name, s.seller_name, s.address, s.area, s.logo, s.brand_id, s.shortname,b.description';
        $shop_db->order = 's.id desc';
        $shop_db->page = $page;
        $shop_db->pagesize = $limit;
        return $shop_db->find();
    }
    
    public static function get_seller_info_by_url($host_name = '')
    {
        if ( !$host_name )
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->where = "home_url = '$host_name'";
        return $seller_db->getOne();
    }

    public static function get_brand_info_by_seller_id($seller_id = '')
    {      
        
        $seller_db = new IModel('seller');
        $seller_info = $seller_db->getObj('id='.$seller_id);
        $brand_db = new IModel('brand');
        $brand_info = $brand_db->getObj('id='.$seller_info['brand_id']);
        $brand_info['img'] = ($brand_info['img'] != '')?explode(',',$brand_info['img']):'';
        $brand_info['class_desc_img'] = ($brand_info['class_desc_img'] != '')?explode(',',$brand_info['class_desc_img']):'';
        $brand_info['shop_desc_img'] = ($brand_info['shop_desc_img'] != '')?explode(',',$brand_info['shop_desc_img']):'';
        return $brand_info;
    }

    public static function get_goods_list_by_seller_id($seller_id = '')
    {
        $where = "go.seller_id='$seller_id' ";
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;
        $goodHandle = new IQuery('goods as go');
        $goodHandle->order  = "go.id desc";
        $goodHandle->fields = "distinct go.id,go.name,go.sell_price,go.market_price,go.store_nums,go.img,go.is_del,go.seller_id,go.is_share,go.sort";
        $goodHandle->where  = $where;
        $goodHandle->page   = $page;

        return $goodHandle->find();

    }

    public static function get_catname_by_goods_id($goods_id = '')
    {

        $tb = new IQuery('category_extend as ce');
        $tb->join  = "left join category as c on c.id = ce.category_id";
        $tb->where  = 'ce.goods_id='.$goods_id;
        $tb->fields  = 'c.name';
        $list = $tb->find();
        if($list){
            $tmp = '';
            foreach($list as $v){
                $tmp[] = $v['name'];
            }
            return implode(',',$tmp);
        }
        
        return;
    }
}

?>