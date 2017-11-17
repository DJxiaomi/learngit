<?php 

class products_class
{
    public static function get_product_info($id = 0, $goods_id = 0)
    {
        if ( !$id )
            return false;        
        $products_db = new IQuery('products');
        $where = 'id = ' . $id;
        if ( $goods_id )
            $where .= ' and goods_id = ' . $goods_id;
        $products_db->where = $where;
        return $products_db->getOne();
    }        
	
	public static function get_product_list($goods_id = 0)    
	{        
		if ( !$goods_id )            
			return false;                
		$products_db = new IQuery('products');        
		$products_db->where = 'goods_id = ' . $goods_id;        
		return $products_db->find();    
	} 
}

?>