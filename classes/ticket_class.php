<?php 





class ticket_class

{

    // 添加代金券ticket

    public static function create_ticket($name = '', $value = 0, $seller_id = 0 )

    {

        $ticket_db = new IModel('ticket');

        $arr = array(

            'name'  =>  $name,

            'value' =>  $value,

            'start_time'    =>  ITime::getDateTime(),

            'end_time'      =>  ITime::getDateTime('', strtotime("+1 years")),

            'seller_id' =>  $seller_id,

        );

        $ticket_db->setData( $arr );

        return $ticket_db->add();

    }

}



?>