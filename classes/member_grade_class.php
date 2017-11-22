<?php 

class member_grade_class
{
    /**
     * 获取代理商等级信息
     */
    public static function get_member_grade_info($grade_id = 0)
    {
        if ( !$grade_id )
        {
            return false;
        }
        
        $member_grade_db = new IQuery('member_grade');
        $member_grade_db->where = 'id = ' . $grade_id;
        return $member_grade_db->getOne();
    }
    
    /**
     * 获取代理商等级列表
     */
    public staitc function get_member_grade_list()
    {
        $member_grade_db = new IQuery('member_grade');
        $member_grade_db->where = '1=1';
        return $member_grade_db->find();
    }
    
    /**
     * 根据充值金额统计需要增加的积分
     */
    public static function statistics_points_by_recharge($recharge_price = 0, $grade_id = 0)
    {
        
    }
}

?>
