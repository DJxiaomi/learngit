<?php 

class institution_class
{
    /**
     * 获取线下采集机构列表
     */
    public static function get_institution_list()
    {
        $institution_db = new IQuery('institution');
        $institution_db->where = '1=1';
        return $institution_db->find();
    }
    
    /**
     * 获取线下机构信息
     */
    public static function get_institution_info($id = 0)
    {
        if ( !$id )
            return false;
        
        $institution_db = new IQuery('institution');
        $institution_db->where = 'id = ' . $id;
        return $institution_db->getOne();
    }
    
    /**
     * 获取线下机构信息
     */
    public static function get_institution_info_by_code($code = '')
    {
        if ( !$code )
            return false;
        
        $institution_db = new IQuery('institution');
        $institution_db->where = "code = '$code'";
        return $institution_db->getOne();
    }
}


?>