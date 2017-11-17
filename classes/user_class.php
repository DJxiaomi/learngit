<?php 

class user_class
{
    public static function get_user_info($user_id)
    {
        if ( !$user_id )
            return false;
        
        $user_db = new IQuery('user');
        $user_db->where = 'id = ' . $user_id;
        return $user_db->getOne();
    }
}

?>