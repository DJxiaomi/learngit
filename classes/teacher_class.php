<?php 



class Teacher_class

{

    /**

     * 获取教师列表

     */

    public static function get_teacher_list( $where = '', $page = 1, $page_size = 12, $limit = 4 )

    {

        $where = ( $where ) ? $where : '1 = 1';

        // $where .= ' and s.type = 1';

        $teacher_db = new IQuery('teacher as t');

        $teacher_db->join = 'left join seller as s on s.id = t.seller_id ';

        $teacher_db->fields = 't.*,s.true_name';

        $teacher_db->where = $where;

        if ( !$page_size )

        {

            return $teacher_db->find();

        } else {

            $result = $teacher_db->find();

            $result_count = ( $result ) ? sizeof( $result ) : 0;

            

            $teacher_db->$page_size = $page_size;

            $teacher_db->page = $page;

            // $teacher_db->limit = $limit;

            $result = $teacher_db->find();

            return array(

                'result_count'  =>  $result_count,

                'result'        =>  $result,

                'page_info'     =>  $teacher_db->getPageBar(),

                'page_count'    =>  ceil( $result_count / $page_size ),

            );

        }

    }

    public static function get_teacher_info( $t_id )

    {

        if ( !$t_id )

            return false;

        

        $teacher_db = new IQuery('teacher');

        $teacher_db->where = 'id = ' . $t_id;

        return $teacher_db->getOne();

    }

    

    public static function del_teacher( $id )

    {

        $teacher_db = new IModel('teacher');

        return $teacher_db->del('id = ' . $id );

    }

    

    public static function get_teacher_info_by_goods_id( $goods_id )

    {

        if ( !$goods_id )

            return false;

        

        $goods_info = goods_class::get_goods_info( $goods_id, 'id, seller_id, teacher_id' );

        if ( !$goods_info || !$goods_info['teacher_id'] )

            return array();

        

        return self::get_teacher_info( $goods_info['teacher_id'] );

    }



    public static function get_goods_list_by_seller_id( $seller_id = 0, $limit = 4 )

    {

        if ( !$seller_id )

            return false;

        

        $teacher_db = new IQuery('teacher');

        $teacher_db->where = 'seller_id = ' . $seller_id;

        $teacher_db->limit = $limit;

        $teacher_db->order = 'id asc';

        return $teacher_db->find();

    }

    

    // 获取个人入驻教师资料

    public static function get_teacher_info_by_seller2( $seller_id = 0 )

    {

        $teacher_db = new IQuery('teacher as t');

        $teacher_db->join = 'left join seller as s on t.seller_id = s.id';

        $teacher_db->fields = 't.*';

        $teacher_db->where = 't.seller_id = ' . $seller_id . ' and s.type = 2 ';

        return $teacher_db->getOne();

    }

}



?>