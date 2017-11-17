<?php 

class prom_rules_class
{
    public static function get_prom_rules_list()
    {
        $prom_rules_db = new IQuery('prom_rules');
        $prom_rules_db->order = 'level asc';
        return $prom_rules_db->find();
    }
    
    public static function get_prom_rules_info($id)
    {
        if (!$id)
            return false;
        
        $prom_rules_db = new IQuery('prom_rules');
        $prom_rules_db->where = 'id = ' . $id;
        return $prom_rules_db->getOne();
    }
    
    public static function is_has_prom_rules_by_type($level = 1, $id = 0 )
    {
        if ( !$level )
        {
            return false;
        }
        
        $prom_rules_db = new IQuery('prom_rules');
        if ( $id )
            $prom_rules_db->where = 'level = ' . $level . ' and id != ' . $id;
        else 
            $prom_rules_db->where = 'level = ' . $level;
        $prom_rules_list = $prom_rules_db->find();
        return ($prom_rules_list) ? true : false;
    }
    
    public static function get_prom_info_title($promo_type = 1, $value = 0)
    {
        $title = '';
        switch($promo_type)
        {
            case 1:
                $title = '按利润比例提成' . $value . '%';
                break;
            case 2:
                $title = '按固定值提成' . $value . '元';
                break;
        }
        return $title;
    }
}

?>