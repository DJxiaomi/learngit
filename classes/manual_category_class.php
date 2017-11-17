<?php 

class manual_category_class
{
    public function get_category_list()
    {
        $manual_category_db = new IQuery('manual_category');
        $manual_category_db->where = 'parent_id = 0';
        return $manual_category_db->find();
    }
}

?>