<?php 

/**
 * 专门处理ajax内容的controller
 */
class Ajax extends IController 
{
    /**
     * 获取最新课程
     */
    function get_latest_goods()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1 );
        $page_size = 10;
        $latest_goods = goods_class::get_lastest_goods( $page, $page_size );
        
        ajax_class::response( 200,'', $latest_goods['result'] );
    }
}

?>