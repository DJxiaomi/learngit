<?php 

class Rebate_rules_class
{
    public static function get_rebate_rule_list( $rule_id )
    {
        if ( !$rule_id )
            return array();
        
        $rule_list_db = new IQuery('rebate_rules');
        $rule_list_db->where = 'rule_id = ' . $rule_id;
        return $rule_list_db->find();
    }
}

?>