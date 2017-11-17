<?php 

class Commend_goods_class
{
    public static function get_commend_goods_str( $commend_id )
    {
        switch( $commend_id )
        {
            case 1:
                return '首页最新课程';
            case 2:
                return '试听课程';
            case 3:
                return '首页热门课程';
            default:
                return '推荐课程';
        }
    }
    
    
    // 获取推荐课程
    public static function get_commend_goods_list( $commend_id, $limit = 12 )
    {
        $goods_db = new IQuery('goods as g');
        $goods_db->join = 'left join commend_goods as cg on g.id = cg.goods_id left join seller as s on g.seller_id = s.id';
        $goods_db->where = 'cg.commend_id = ' . $commend_id . ' and g.is_del = 0';
        $goods_db->fields = 'g.id, g.name, g.goods_brief, g.spec_array,g.content,g.is_refer,g.sell_price,g.market_price, g.img, g.sale, g.seller_id, s.true_name';
        if ( $limit > 0 )
            $goods_db->limit = $limit;
        $goods_list = $goods_db->find();
        
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {                
                $seller_info = seller_class::get_seller_info($vv['seller_id']);
                $goods_list[$kk]['is_authentication'] = $seller_info['is_authentication'];
                
                $arr = array(
                    'goods_id'  => $vv['id'],
                    'seller_id' => $vv['seller_id'],
                    'sum'       => $vv['sell_price'],
                );
                
                $val = '';
                $specs = json_decode($vv['spec_array'], true);
                if($specs)
                {
                    foreach($specs AS $spec)
                    {
                        if ( $spec['name'] == '课时' || $spec['id'] == 15)
                        {
                            $val = explode(',', $spec['value']);
                            $val = $val[0];
                        }
                    }
                }
                $goods_list[$kk]['ks'] = $val;
                $goods_list[$kk]['content'] = strip_tags( $vv['content'] );
            }
        }
        
        return $goods_list;
    }
}

?>