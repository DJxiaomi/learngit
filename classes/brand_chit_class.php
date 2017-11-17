<?php 

class brand_chit_class
{
    public static function get_chit_info($id)
    {
    	$brand_db = new IModel('brand');
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'id = ' . $id;
        $chit = $brand_chit_db->getOne();
        //$brand = $brand_db->getObj("id = '$chit[brand_id]'", 'shortname');
        //$chit['shortname'] = $brand['shortname'];
        $chit['limitdate'] = date('Y-m-d', $chit['limittime']);
        return $chit;
    }
    
    public static function get_chit_list_db($swhere = '')
    {
        $where = "1 = 1";
        if($swhere)
        {
            $where .= $swhere; 
        }
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = $where;
        return $brand_chit_db;
    }

    public static function check_chit_by_id($id, $user_id)
    {
        $chit = self::get_chit_info($id);
        $order_db = new IModel('order');
        $order = $order_db->getObj("chit_id = '$id' and user_id = '$user_id'", 'count(*) as num');
        $nowtime = time();

        if(!empty($chit['limittime']) && $chit['limittime'] < $nowtime)
        {
            return -1;
        }
        elseif(!empty($chit['limitnum']) && $order['num'] >= $chit['limitnum'])
        {
            return -2;
        }
        else
        {
            return 1;
        }
    }

    public static function get_chit_list_by_seller_id($seller_id = 0)
    {
        $time = time();
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = "seller_id = '$seller_id' AND limittime >= '$time'";
        $chits = $brand_chit_db->find();

        return $chits;
    }
    
    public static function get_chit_list_by_brand_id($brand_id = 0)
    
    {
    
        $time = time();
    
        $brand_chit_db = new IQuery('brand_chit');
    
        $brand_chit_db->where = "brand_id = '$brand_id' AND limittime >= '$time'";
    
        $chits = $brand_chit_db->find();
    
    
    
        return $chits;
    
    }
    
    public static function get_seller_chit_list($seller_id = 0)
    {
        $product_db = new IQuery('products as p');
        $product_db->join = 'left join goods as g on p.goods_id = g.id left join seller as s on g.seller_id = s.id';
        $product_db->fields = 'g.seller_id,g.id,p.id as pid,p.dprice,p.rprice,p.chit,p.market_price,p.cost_price,s.true_name,s.shortname';
        if ( !$seller_id )
            $product_db->where = 'g.statement = 2 and p.chit > 0 and p.dprice > 0 and g.is_del = 0 and s.is_del = 0';
        else
            $product_db->where = 'g.seller_id = ' . $seller_id . ' and g.statement = 2 and p.chit > 0 and p.dprice > 0 and g.is_del = 0 and s.is_del = 0';
        $product_db->order = 'p.chit desc';
        $product_db->group = 'seller_id';
        $list = $product_db->find();
    
        if ( $list )
        {
            foreach( $list as $kk => $vv )
            {
                $cprice = number_format( order_class::get_cprice($vv['dprice'], $vv['rprice']), 2, '.', '');
                $list[$kk]['type'] = 1;
                $list[$kk]['limittime'] = strtotime("+1 years");
                $list[$kk]['max_price'] = order_class::get_max_input_cprice($cprice);
                $list[$kk]['max_order_chit'] = number_format( order_class::get_real_order_chit( $vv['market_price'], $vv['cost_price'], $list[$kk]['max_price'] ), 2, '.','');
                if ( $list[$kk]['max_price'] <= 10 || $list[$kk]['max_order_chit'] <= 20 || $list[$kk]['max_price'] == $list[$kk]['max_order_chit'] )
                    unset( $list[$kk] );
            }
        }
    
        return $list;
    }
    
    /**
     * 根据参数返回手工代金券的名称, 比如：500抵800元
     * @param unknown $max_price 价格
     * @param unknown $max_order_chit 抵扣
     */
    public static function get_chit_name($max_price, $max_order_chit)
    {
        return '购券' . $max_price . '抵' . $max_order_chit;
    }
    
    
    public static function add_chit($info)
    {
        $brand_chit_db = new IModel('brand_chit');
        $brand_chit_db->setData($info);
        return $brand_chit_db->add();
    }
    
    // 获取课程的代金券列表
    public static function get_chit_list_by_goods_id($goods_id = 0)
    {
        if ( !$goods_id )
            return false;
        
        $goods_info = goods_class::get_goods_info($goods_id);
        if ( !$goods_info || $goods_info['is_del'] != 0)
            return false;
        
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'seller_id = ' . $goods_info['seller_id'] . ' and goods_id = ' . $goods_id . ' and category = 1';
        $brand_chit_db->order = 'max_price asc';
        $brand_chit_list = $brand_chit_db->find();
        return $brand_chit_list;
    }
    
    // 获取学校的代金券列表
    public static function get_chit_list2_by_seller_id($seller_id = 0)
    {
        if ( !$seller_id )
            return false;
        
        $seller_info = seller_class::get_seller_info($seller_id);
        if ( !$seller_info || !$seller_info['is_authentication'] )
            return false;
        
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'seller_id = ' . $seller_id . ' and goods_id > 0 and category = 1';
        $brand_chit_db->order = 'max_price asc';
        $brand_chit_list = $brand_chit_db->find();
        return $brand_chit_list;
    }
    
    // 获取学校的代金券列表
    public static function get_chit_list2_by_brand_id($brand_id = 0)
    {
        if ( !$brand_id )
            return false;
    
        $brand_info = brand_class::get_brand_info($brand_id);
        if ( !$brand_info )
            return false;
    
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'brand_id = ' . $brand_id . ' and goods_id > 0 and category = 1';
        $brand_chit_db->order = 'max_price asc';
        $brand_chit_list = $brand_chit_db->find();
        return $brand_chit_list;
    }
    
    // 获取短期课信息
    public static function get_dqk_info($id = 0)
    {
        if ( !$id )
        {
            return false;
        }
        
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'id = ' . $id . ' and category = 2';
        $brand_chit_info = $brand_chit_db->getOne();
        return $brand_chit_info;
    }
    
    // 获取课程的短期课
    public static function get_dqk_info_by_goods_id($goods_id = 0)
    {
        if ( !$goods_id )
            return false;
        
        $goods_info = goods_class::get_goods_info($goods_id);
        if ( !$goods_info || $goods_info['is_del'] != 0)
            return false;
        
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'seller_id = ' . $goods_info['seller_id'] . ' and goods_id = ' . $goods_id . ' and category = 2 and is_del = 0';
        $brand_chit_db->order = 'id desc';
        $brand_chit_info = $brand_chit_db->getOne();
        return $brand_chit_info;
    }
    
    // 获取短期课列表
    public static function get_dqk_list_by_seller_id($seller_id = 0 )
    {
        if ( !$seller_id )
            return false;
        
        $brand_chit_db = new IQuery('brand_chit as bc');
        $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id';
        $brand_chit_db->where = 'g.is_del = 0 and bc.seller_id = ' . $seller_id . ' and bc.category = 2 and bc.is_del = 0';
        $brand_chit_db->order = 'bc.id desc';
        $brand_chit_db->fields = 'bc.*';
        $brand_chit_info = $brand_chit_db->find();
        return $brand_chit_info;
    }
    
    // 获取学习通优惠
    public static function get_manual_discount_list_by_seller_id($seller_id = 0 )
    {
        if ( !$seller_id )
            return false;
    
        $brand_chit_db = new IQuery('brand_chit as bc');
        $brand_chit_db->where = 'bc.seller_id = ' . $seller_id . ' and bc.category = 3 and bc.is_del = 0';
        $brand_chit_db->order = 'bc.id desc';
        $brand_chit_db->fields = 'bc.*';
        $brand_chit_info = $brand_chit_db->find();
        return $brand_chit_info;
    }
    
    // 获取短期课列表
    public static function get_dqk_list_by_brand_id($brand_id = 0 )
    {
        if ( !$brand_id )
            return false;
    
        $brand_chit_db = new IQuery('brand_chit');
        $brand_chit_db->where = 'brand_id = ' . $brand_id . ' and category = 2 and is_del = 0';
        $brand_chit_db->order = 'id desc';
        $brand_chit_info = $brand_chit_db->find();
        return $brand_chit_info;
    }
    
    // 将短期课加入到短期课购物车
    public static function join_dqk($id = 0 , $user_id = 0)
    {
        if ( !$id || !$user_id )
            return false;
        
        $dqk_info = brand_chit_class::get_dqk_info($id);
        if ( !$dqk_info )
            return false;
        
        $brand_chit_db = new IQuery('dqk_cart');
        $brand_chit_db->where = 'brand_chit_id = ' . $id . ' and user_id = ' . $user_id;
        $result = $brand_chit_db->getOne();
        
        if ( $result )
            return false;
        
        $brand_chit_db = new IModel('dqk_cart');
        $brand_chit_db->setData(array(
            'brand_chit_id' =>  $id,
            'user_id'       =>  $user_id,
        ));
        $brand_chit_db->add();
        return true;
    }
    
    // 获取短期课推荐
    public static function get_intro_dqk_list_by_category_id($category_id = 0, $limit = 10)
    {
        $where = '';
        if ( $category_id )
        {
            $where .= ' and manual_category_id = ' . $category_id;
        }
        
        $brand_chit_db = new IQuery('brand_chit as bc');
        $brand_chit_db->where = 'bc.is_intro = 1 and g.is_del = 0 and bc.category = 2 and bc.is_del = 0' . $where;
        $brand_chit_db->order = 'bc.is_top desc,bc.sale desc';
        $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id';
        $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,bc.*,s.shortname as seller_name,s.address,s.area';
        if ( $limit )
        {
            $brand_chit_db->limit = $limit;
        }
        $brand_chit_db->group = 'bc.seller_id';
        $dqk_list = $brand_chit_db->find();
        return $dqk_list;
    }
}

?>
