<?php 


class rebate_log_class
{
    public static function get_rebate_list( $where = '', $page = 1, $page_size = 10)
    {
        $rebate_log_db = new IQuery('rebate_log');
        $rebate_log_db->where = ( $where ) ? $where : '1 = 1';
        $rebate_log_db->fields = 'add_time,sum(rebate_num) as count';
        $rebate_log_db->page = $page;
        $rebate_log_db->group = 'add_time';
        $rebate_log_db->pagesize = $page_size;
        $rebate_log_db->order = 'id desc';
        $rebate_list = $rebate_log_db->find();
                
        if ( $rebate_list )
        {
            foreach( $rebate_list as $kk => $vv )
            {
                $rebate_list[$kk]['time'] = date('Y-m-d H:i:s', $vv['add_time'] );
            }
        }
        
        return array(
            'result'    =>  $rebate_list,
            'page_info' =>  $rebate_log_db->getPageBar(),
        );
    }
}

?>