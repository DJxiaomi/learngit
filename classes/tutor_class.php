<?php

class tutor_class
{
    public static function get_tutor_list_db($user_id = 0, $is_publish = true, $page = 1, $page_size = 10)
    {
        $tutor_db = new IQuery('tutor');
        $where = ( $user_id > 0 ) ? 'user_id = ' . $user_id : '1=1';
        $where .= ( $is_publish ) ? ' and is_publish = 1' : '';
        $tutor_db->where = $where;
        $tutor_db->page = page;
        $tutor_db->pagsize = $page_size;
        $tutor_db->order = 'create_time desc';
        return $tutor_db;
    }
    
    public static function get_tutor_info($id = 0)
    {
        if ( !$id )
            return false;
        
        $tutor_db = new IQuery('tutor');
        $tutor_db->where = 'id = ' . $id;
        return $tutor_db->getOne();
    }
    
    public static function get_tutor_info_by_order_id($order_id = 0)
    {
        if ( !$order_id )
            return false;
        
        $tutor_db = new IQuery('tutor');
        $tutor_db->where = 'order_id = ' . $order_id;
        return $tutor_db->getOne();
    }
    
    public static function get_tutor_status_title($status = 0,$is_publish = 0)
    {
        return ($is_publish) ? '已发布' : '未发布';
    }
    
    public static function get_grade_level_arr()
    {
        return array(
            1 => '小学','初中','高中/中专','大学/大专'
        );
    }
    
    public static function get_grade_arr()
    {
        return array(
            1 => 1,2,3,4,5,6
        );
    }
    
    public static function teaching_type_arr()
    {
        return array(
            1 => '学生家','老师家','其它地点'
        );
    }
    
    public static function get_teaching_time()
    {
        return array(
            1 => '1个月以内','3个月以内','6个月以内','1年以内','1年以上',
        );
    }
    
    public static function get_teaching_type($teaching_type_str = '')
    {
        if (!$teaching_type_str)
            return '';
        
        $teaching_type_arr = self::teaching_type_arr();
        $arr = explode(',', $teaching_type_str);
        if ( $arr )
        {
            foreach( $arr as $kk => $vv )
            {
                if (isset($teaching_type_arr[$vv]))
                {
                    $arr[$kk] = $teaching_type_arr[$vv];
                } else {
                    unset($arr[$kk]);
                }
            }
        }
        
        if ( $arr )
            return implode(',', $arr);
    }
    
    public static function get_grade_title($grade_level = 0, $grade)
    {
        $grade_level_arr = self::get_grade_level_arr();
        return $grade_level_arr[$grade_level] . $grade . '年级';
    }
    
    public static function get_grade_level_title($grade_level = 0)
    {
        $grade_level_arr = self::get_grade_level_arr();
        return $grade_level_arr[$grade_level];
    }
    
    public static function is_show_tutor_detail($user_id = 0, $statement = 1)
    {
        if ( !$user_id || $statement != 4)
            return false;
        
        return true;
    }
    
    public static function get_teaching_time2()
    {
        return array(
            0 => '请选择', '周一','周二','周三','周四','周五','周六','周日'
        );
    }
    
    public static function get_teaching_time2_title($teaching_time = array())
    {
        $str = '';
        $teaching_time_arr = self::get_teaching_time2();
        $teaching_time3 = self::get_teaching_time3();
        if ( $teaching_time )
        {
            foreach( $teaching_time as $kk => $vv )
            {
                if ( $vv['time1'] > 0 )
                {
                    $str .= '每' . $teaching_time_arr[$vv['time1']] . $teaching_time3[$vv['time2']] . '点-' . $teaching_time3[$vv['time3']] . '点&nbsp;&nbsp;';
                } else {
                    $str .= $teaching_time3[$vv['time2']] . '点-' . $teaching_time3[$vv['time3']] . '点&nbsp;&nbsp;';
                }
            }
        }
        return $str;
    }
    
    public static function week_day_chi2en($i)
    {
        $arr = array(
           1 => 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
        );
        
        return (isset($arr[$i])) ? $arr[$i] : '';
    }
    
    public static function get_teaching_time3()
    {
        return array(
            0 => '请选择时间','8','9','10','11', '12','13','14','15','16','17','18','19','20','21','22'
        );
    }
    
    /**
     * 生成合同
     * @param unknown $id
     */
    public static function create_contract($id)
    {
        if ( !$id )
            return false;
    
        $tutor_info = tutor_class::get_tutor_info($id);
        $member_info = member_class::get_member_info($tutor_info['user_id']);
        if ( !$tutor_info['contract_addr'] )
        {
            $contract_file = './default_contract.png';
            //header('Content-Type: image/png');
    
            // Create the image
            $im = imagecreatefrompng($contract_file);
    
            // Create some colors
            $black = imagecolorallocate($im, 0, 0, 0);
    
            // The text to draw
            //$name1 = '蔡家杰';
            $name1 = $member_info['true_name'];
            $name2 = '易霈江';
            $year = date('Y');
            $month = date('m');
            $date = date('d');
            // Replace path by your own font path
            $font = 'msyh.ttf';
    
            // Add some shadow to the text
            //imagettftext($im, 20, 0, 416, 1651, $grey, $font, $text);
    
            // Add the text
            imagettftext($im, 20, 0, 486, 1756, $black, $font, $name1);
            imagettftext($im, 20, 0, 1086, 1756, $black, $font, $name2);
    
            imagettftext($im, 20, 0, 326, 1842, $black, $font, $year);
            imagettftext($im, 20, 0, 450, 1842, $black, $font, $month);
            imagettftext($im, 20, 0, 535, 1842, $black, $font, $date);
    
            imagettftext($im, 20, 0, 940, 1842, $black, $font, $year);
            imagettftext($im, 20, 0, 1090, 1842, $black, $font, $month);
            imagettftext($im, 20, 0, 1170, 1842, $black, $font, $date);
    
            $path = 'upload/contract/';
            $file = ITime::getDateTime('Ymdhis').mt_rand(100,999).'.png';
    
            imagePng($im,$path . $file);
            imagedestroy($im);
    
            // 保存到数据库
            $tutor_db = new IModel('tutor');
            $tutor_db->setData(array(
                'contract_addr' =>  $path . $file,
            ));
            $tutor_db->update('id = ' . $id);
        }
    }
    
    /**
     * 计算出家教开始的日期
     * @param unknown $class_rule
     */
    public static function get_start_date($class_rule = array())
    {
        if ( !$class_rule )
            return time();
        
        $start_caculate_time = time();
        $start_time = 0;
        if ( $class_rule )
        {
            foreach($class_rule as $kk => $vv )
            {
                $time = strtotime("next " . self::week_day_chi2en($vv['week']), $start_caculate_time );
                if ( !$start_time )
                    $start_time = $time;
                else {
                    if ( $time < $start_time )
                        $start_time = $time;
                }
            }
        }
        
        return ( !$start_time ) ? $start_caculate_time : $start_time;
    }
    
    /**
     * 根据上课时间表、第一天上课的时间、课时，计算出最后一天上课的时间
     * @param unknown $start_date
     * @param unknown $class_rule
     * @param unknown $num
     */
    public static function get_end_date($start_date, $class_rule = array(), $num)
    {
        $week_arr = array();
        if ( $class_rule )
        {
            foreach($class_rule as $kk => $vv )
            {
                if ( $vv['week'] < 7 )
                    $week_arr[] = $vv['week'];
                else
                  $week_arr[] = 0;
            }
        }
        
        if ( !$week_arr )
            return time();
        
        $i = 0;
        $num = $num - 1;
        while ( $i < $num )
        {
            $j++;
            $date = strtotime("+$j days", $start_date);
            if ( in_array(date('w', $date), $week_arr) )
            {
                $i++;
                $end_date = $date;
            }
        }
        
        return ($end_date) ? $end_date : time();
    }
    
    public static function get_class_date_list($start_date, $class_rule = array(), $num )
    {
        $week_arr = array();
        if ( $class_rule )
        {
            foreach($class_rule as $kk => $vv )
            {
                if ( $vv['week'] < 7 )
                    $week_arr[] = $vv['week'];
                else
                    $week_arr[] = 0;
            }
        }
        
        if ( !$week_arr )
            return time();
        
        $i = 0;
        $num = $num - 1;
        $list = array($start_date);
        while ( $i < $num )
        {
            $j++;
            $date = strtotime("+$j days", $start_date);
            if ( in_array(date('w', $date), $week_arr) )
            {
                $i++;
                $list[] = $date;
            }
        }
        
        return $list;
    }
    
    public static function can_order_by_seller($tutor_id = 0 )
    {
        $tutor_info = self::get_tutor_info($tutor_id);
        return ($tutor_info) ? true : false;
    }
    
    public static function get_tutor_price($id = 0)
    {
        if ( !$id )
            return 0;
        
        $tutor_info = self::get_tutor_info($id);
        if ( !$tutor_info )
            return 0;
        
        return $tutor_info['lowest_reward'];
        
//         if ($tutor_info['lowest_reward'] >= 200)
//         {
//             return $tutor_info['lowest_reward'];
//         }
        
//         return ($tutor_info['lowest_reward'] >= 200) ? $tutor_info['price'] : 200;
    }
    
    public static function get_tutor_category_title($item = array(), $filter = '/')
    {
        return category_class::get_category_title($item['grade']) . $filter . category_class::get_category_title($item['category_id']) . $filter . category_class::get_category_title($item['category_id2']);
    }
}

?>