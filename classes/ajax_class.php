<?php 

class ajax_class {
    public static function response( $code = 200, $message = '', $data )
    {
        $arr = array(
            'code'      =>  $code,
            'message'   =>  $message,
            'data'      =>  $data,
        );
        
        die( JSON::encode( $arr ));
    }
}

?>