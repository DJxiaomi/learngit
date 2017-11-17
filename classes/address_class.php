<?php 

class address_class
{
    public static function get_my_address_list( $user_id = 0 )
    {
        if ( !$user_id )
            return false;
        
        $address_db = new IQuery('address');
        $address_db->where = 'user_id = ' . $user_id;
        return $address_db->find();
    }
}

?>