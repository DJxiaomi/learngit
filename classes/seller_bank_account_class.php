<?php 

class seller_bank_account_class
{
    public static function get_seller_statement_account( $seller_id = 0 )
    {
        if ( !$seller_id )
            return false;
        
        $seller_bank_account_db = new IQuery('seller_bank_account');
        $seller_bank_account_db->where = 'seller_id = ' . $seller_id;
        return $seller_bank_account_db->getOne();
    }
}

?>