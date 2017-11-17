<?php 

class navigation_class
{
    public static function get_navigation_info( $id = 0 )
    {
        if ( !$id )
            return false;
        
        $navigation_db = new IQuery('navigation');
        $navigation_db->where = 'id = ' . $id;
        return $navigation_db->getOne();
    }
    
    public static function get_navigation_list( $module_id = 0, $parent_id = 0)
    {
        if ( !$module_id )
            return false;
        
        $navigation_db = new IQuery('navigation');
        $navigation_db->where = 'module_id = ' . $module_id . ' and parent_id = ' . $parent_id;
        $navigation_db->order = 'parent_id asc,sort asc,id asc';
        $navigation_list = $navigation_db->find();
        
        if ( $navigation_list )
        {
            foreach( $navigation_list as $kk => $vv )
            {
                $navigation_list[$kk]['child'] = self::get_navigation_list($module_id, $vv['id'] );
            }
        }
        
        return $navigation_list;
    }
    
    // 添加导航
    public static function navigation_add( $data = array() )
    {
        if ( !$data )
            return false;
        
        $data = self::check_navigation_fields( $data );
        if ( $data === false )
            return false;
        
        $navigation_db = new IModel('navigation');
        $navigation_db->setData($data);
        return $navigation_db->add();
    }
    
    // 修改导航
    public static function navigation_update( $id = 0, $data = array())
    {
        if ( !$id || !$data )
            return false;
        
        $data = self::check_navigation_fields( $data );
        if ( $data === false )
            return false;
        
        $navigation_db = new IModel('navigation');
        $navigation_db->setData($data);
        return $navigation_db->update('id = ' . $id );
    }
    
    public static function navigation_del( $id = 0 )
    {
        if ( !$id )
            return false;
        
        $navigation_db = new IModel('navigation');
        return $navigation_db->del('id = ' . $id );
    }
    
    // 检查字段
    public static function check_navigation_fields( $data = array())
    {
        if ( !$data )
            return array();
        
        $fields_arr = self::get_navigation_fields();
        if ( $data )
        {
            foreach( $data as $kk => $vv )
            {
                if ( !in_array( $kk, $fields_arr ))
                    unset( $data[$kk] );
            }
        }
        
        return $data;
    }
    
    // 获取导航表的有效字段
    public static function get_navigation_fields()
    {
        return array('module_id', 'name', 'type', 'link', 'parent_id', 'sort');
    }
}

?>