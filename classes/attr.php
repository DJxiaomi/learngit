<?php 

class attr
{
    public static function get_attr_info( $attr_id )
    {
        if ( !$attr_id )
            return false;
        
        $attr_db = new IQuery('attribute');
        $attr_db->where = 'id = ' . $attr_id;
        $info = $attr_db->find();
        if ( $info[0] )
        {
            $info = current( $info );
            $info['value'] = explode( ',', $info['value'] );
            return $info;
        }
        return array();
    }
}

?>