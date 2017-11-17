<?php 

/**
 * check mail server is working...
 */
class Mail extends IController
{
    function index()
    {
        $site_config                 = array();
        $site_config['email_type']   = 1;
        //$site_config['mail_address'] = 'service@zzhrg.com';
        //$site_config['smtp_user']    = 'service@zzhrg.com';
        $site_config['mail_address'] = 'admin@lex365.net';
        $site_config['smtp_user']    = 'admin@lex365.net';
        $site_config['smtp']         = 'smtp.qq.com';
        $site_config['smtp_pwd']     = 'qmntghshdeuycadc';
        $site_config['smtp_port']    = '465';
        $site_config['email_safe']   = 'ssl';
        $test_address                = '474890177@qq.com';
        
        $smtp = new SendMail($site_config);
        if($error = $smtp->getError())
        {
            $result = array('isError'=>true,'message' => $error);
        }
        else
        {
            $title    = 'email test';
            $content  = '您好，这是来自hnlxsh系统的测试邮件，如果您能收到此邮件那么恭喜您，系统邮件服务正常。';
            if($smtp->send($test_address,$title,$content))
            {
                $result = array('isError'=>false,'message' => '恭喜你！测试通过');
            }
            else
            {
                $result = array('isError'=>true,'message' => $smtp->getError());
            }
        }
        
        dump( $result );
    }
}

?>