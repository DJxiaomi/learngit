<?php 

/**
 * 阿里会员授权，获取用户信息
 * @author Administrator
 *
 */
class Alipay extends IController
{
    private $app_id;
    private $gatewayUrl;
    private $debug = 1;
    //private $rsaPrivateKeyFilePath;
    //private $alipayPublicKey;
    private $sdk_path;
    
    function init()
    {
        $this->sdk_path = 'alipay_sdk';
        $this->app_id = ( $this->debug ) ? '2016102800773317' : '2016111902994748';
        $this->gatewayUrl = ( $this->debug ) ? 'https://openapi.alipaydev.com/gateway.do' : 'https://openapi.alipay.com/gateway.do';
    }
    
    
    // 调用用户授权
    function index()
    {
        $type = IFilter::act(IReq::get('type'),'int');
        $user_id = IFilter::act(IReq::get('user_id'),'int');
        $back = IFilter::act(IReq::get('back'),'int');
        $callback = 'http://' . $_SERVER['HTTP_HOST'] . '/alipay/check_auth/type/' . $type . '/user_id/' . $user_id . '/back/' . $back;
        $callback = urlencode( $callback );
        if ( $this->debug )
        {
            $url = 'https://openauth.alipaydev.com/oauth2/publicAppAuthorize.htm?app_id=' .$this->app_id . '&scope=auth_userinfo&redirect_uri=' . $callback;
        }
        else
        {
            $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=' . $this->app_id . '&scope=auth_userinfo&redirect_uri=' . $callback;
        }
        
        header("location: $url;");
    }
        
    function get_aop()
    {
        include( IWEB_ROOT . DIRECTORY_SEPARATOR . $this->sdk_path . DIRECTORY_SEPARATOR . 'AopSdk.php');
        $aop = new AopClient ();
        $aop->gatewayUrl = $this->gatewayUrl;
        $aop->appId = $this->app_id;
        $aop->rsaPrivateKey = 'MIIEpQIBAAKCAQEAt7h5bAL14ANuT7u2JX2JYo7kIRfWdQWFyHsH+KqEakGus2C3dZY3bNcaS2lv3fJbGVjir7Rbnw3lLeqR1Y2il9fSK0p+b8SxZrvES6EGIcR4h1w9tx7wg62Cv4WJarmFIg7LyLSfROCGsXl/aB50uTL1lBiG04MNm0EQhgjXDjmaZEEVqin3jT/syfbo6pRx8K2KTF+Bf5eQxGe82/gr15U8OBownJ83yD8Fn9ECJUX/PomGKQspkGCRGzltCTSL97iaCwVvTcdz+xVlkt+Cv62sVOlFB02E+YZ0arbFS6WxIcod5tx/eD2WJn6AeTVTNkQJ4dOkSio/G9zPjGRGmQIDAQABAoIBAQCFKmqgdtjfYb1Af+/75q2BSc9jiVLCCZm6Ait5+6b1GdzWWkFAMvzDoHqHtMoIFxYfHkVZVCKg/EJk8MR6BSqYYzAMfvd8bhakP2993h6CtVUj0CFPrVZqK4c86T78o7IzSIQ/W2SiWRhoZYeK4aB7aMuGZ+y6PSDMqvGeJaQzwyKdP8+k9asAd8ZX0DDBjqAA2sNLiiKCtEtRmb8XKs7C85z3jdBJklIFZZC9TriWDuODXafbPXSIVEtmUeEOJx+BEEBUBdMVCkgNrhJo5ah64gcQ8QHrA/UkK/FSywecw6jLCFqzNG8YhpYQktfzzNP1GwWFIjvHqR4ZzJMRZ1gdAoGBAPKfZVkZJRYJHwSAAbRd44/ePaMuqJ76ik+NbLOQRnQLVqpm+H/gQE5Btg3xGGjDoZ7/zC8rL0zMZq8p4tpulQeZP/eCkpmrkrQTuh4v2CSA7O9SWoqUkXfkBOnicA96OC514AN5l2gFBlj3FpqjTX1TGgF6yQkWPOAsbkE1nawLAoGBAMHZrf6DuO6cacZd1IA9xpvrSUy0en0R9mY49qVVRtHKeYm19JQr3P5A78UXCpyOirL0xHfreCznMez3MHQMJO1J/82TFJw+1tlO7fybfYickG4u7QXSCsTzI5m5yMZXnwGx8FAdokomt/+WJnGl1JC1GRYFH0jqrx9LouP+dNprAoGBAMNVFwhLmTMLduBtmnG3IU2jtGYbW4Ba312606ghYMdulYCtVCXHyp32g3boAyndTtKuyJm1H+ipq4Ycp9oKK4upkvlXM2Xq3zqBo1dIV7DT522qFOD7Sb6HYnlWZ7feQzsMhaTmkMIbQYgArj8jeHCMpiRI0W+yaqJkwwNXAjEPAoGAdQdCiK3jHoJlRTFuUcF5vrWr+dfXPtxyQcJP/P5fk9XFzAKCVlWoxAJV/klryZowV9t3JOKOGaW1uVZ99QFD5dFP0j7iKXWyZVzGRkNk5O2IMEy6IVJt1/rlWjAT6tIJF4/iAavyRwva9z0hlmjDzFzYeTe8bFvqP119SGFdEGMCgYEA7rWhEUOqQd6kTqNeP5kMYVupNS2GZf0t5JWKXLL7BHp/jEJoywt08dspE8ct/aqe589Os7DsDnDDIJ7ONjs9O087nhK8ZbiKBlMTsaqpZ2pO8hkDtUlhJevrhAnFrmXAplxP2xsXGeXHZG0EYunNn4u+GJ4hTxWDMvuZboyRDco=';
        $aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvNIem1GstekEnTUFdmTk6gmIu99uD5AV/jT7dVOc2tjgp8N/Sp7LrHpuCWWi92a+x7wK/LgqtJs7eW6+tnanptVfzLHUm1juVO/NnvK5sicmjjmy/XJNGZ9PViRLpyhIMZvteG8MX82QG9zjldHTdH3Nwp75HsUp1z3gbTVhdWwTZsKuYJJCgnILSEmmL3SFoSdpHN7UReDf7htgjwnoBH5G/QcP98UsI2hl9xSBPeNXmLodeZyw/GkpexM2sQLW3Ywkggk6l6LLR63/GCQnQKHVzVvYi2q9P2tYe6Sr/9uv/5CbE36Uuh4IXeCNeY9UvnjLk3OyN0gEpc+KSX9riQIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        return $aop;
    }
    
    function check_auth()
    {
        $type = IFilter::act(IReq::get('type'),'int');
        $user_id = IFilter::act(IReq::get('user_id'),'int');
        $back = IFilter::act(IReq::get('back'),'int');

        if ( $type == 1)
        {
            $user_info = member_class::get_member_info($user_id);
            $cert_no = $user_info['id_card'];
            $name = $user_info['true_name'];
            $content = "{" .
            "    \"product_code\":\"w1010100000000002859\"," .
            "    \"transaction_id\":\"20151127233347987676212309253\"," .
            "    \"cert_no\":\"$cert_no\"," .
            "    \"cert_type\":\"IDENTITY_CARD\"," .
            "    \"name\":\"$name\"," .
//             "    \"mobile\":\"17707413901\"," .
            //         "    \"email\":\"jnlxhy@alitest.com\"," .
        //         "    \"bank_card\":\"20110602436748024138\"," .
        //         "    \"address\":\"北京 北京市 朝阳区 呼家楼街道北京市朝阳区东三环中路1号环球金融中心 东塔9层\"," .
        //         "    \"ip\":\"101.247.161.1\"," .
        //         "    \"mac\":\"AA-34-4D-59-61-28\"," .
        //         "    \"wifimac\":\"22-35-4A-5F-07-88\"," .
        //         "    \"imei\":\"868331011992179\"" .
            "  }";
        } else {
            $seller_info = seller_class::get_seller_info($user_id);
            $cert_no = $seller_info['cardsn'];
            $name = $seller_info['true_name'];
            $bank_card = $seller_info['account'];
            $content = "{" .
                "    \"product_code\":\"w1010100000000002859\"," .
                "    \"transaction_id\":\"20151127233347987676212309253\"," .
                "    \"cert_no\":\"$cert_no\"," .
                "    \"cert_type\":\"IDENTITY_CARD\"," .
                "    \"name\":\"$name\"," .
                //             "    \"mobile\":\"17707413901\"," .
            //         "    \"email\":\"jnlxhy@alitest.com\"," .
                "    \"bank_card\":\"$bank_card\"," .
            //         "    \"address\":\"北京 北京市 朝阳区 呼家楼街道北京市朝阳区东三环中路1号环球金融中心 东塔9层\"," .
            //         "    \"ip\":\"101.247.161.1\"," .
            //         "    \"mac\":\"AA-34-4D-59-61-28\"," .
            //         "    \"wifimac\":\"22-35-4A-5F-07-88\"," .
            //         "    \"imei\":\"868331011992179\"" .
            "  }";
        }
        
        $aop = $this->get_aop();
        $request = new ZhimaCreditAntifraudVerifyRequest ();
        $request->setBizContent($content);
        $result = $aop->execute ( $request);
         
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        
        if(!empty($resultCode)&&$resultCode == 10000){
            if ( $type == 1)
            {
                $member_db = new IModel('member');
                $member_db->setData(array(
                    'is_auth' => 1,
                ));
                $member_db->update('user_id = ' . $user_id);
                
                $tutor_db = new IModel('tutor');
                $tutor_db->setData(array('is_publish' => 1));
                $tutor_db->update('user_id = ' . $user_id);
                
                if ( $back )
                    header("location: " . IUrl::creatUrl('/ucenter/tutor_list'));
                else
                    header("location: " . IUrl::creatUrl('/ucenter/authentication'));
            } else {
                $seller_db = new IModel('seller');
                $seller_db->setData(array(
                    'is_authentication' => 1,
                ));
                $seller_db->update('id = ' . $user_id);
                
                $seller_tutor_db = new IModel('seller_tutor');
                $seller_tutor_db->setData(array('is_publish' => 1));
                $seller_tutor_db->update('seller_id = ' . $user_id);
                header("location: " . IUrl::creatUrl('/seller/seller_edit3'));
            }
        } else {
            echo "失败";
            dump($resultCode);
        }
        
        // 获取auth_code
        /**
        $source = $_GET['source'];
        $alipay_wallet = $_GET['alipay_wallet'];
        $scope = $_GET['scope'];
        $userOutputs = $_GET['userOutputs'];
        $auth_code = $_GET['auth_code'];
        
        $aop = $this->get_aop();
        $request = new AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($auth_code);
        $result = $aop->execute ( $request);
        $alipay_system_oauth_token_response = $result->alipay_system_oauth_token_response;
        
        $access_token = $alipay_system_oauth_token_response->access_token;
        $alipay_user_id = $alipay_system_oauth_token_response->alipay_user_id;
        $refresh_token = $alipay_system_oauth_token_response->refresh_token;
        $user_id = $alipay_system_oauth_token_response->user_id;
        
        // 获取用户信息
        $request = new AlipayUserUserinfoShareRequest ();
        $result = $aop->execute ($request, $access_token);
        
        $alipay_user_userinfo_share_response = $result->alipay_user_userinfo_share_response;
        $user_type_value = $alipay_user_userinfo_share_response->user_type_value;
        $is_balance_frozen = $alipay_user_userinfo_share_response->is_balance_frozen;
        $is_mobile_auth = $alipay_user_userinfo_share_response->is_mobile_auth;
        $user_id = $alipay_user_userinfo_share_response->user_id;
        $gender = $alipay_user_userinfo_share_response->gender;
        $is_licence_auth = $alipay_user_userinfo_share_response->is_licence_auth;
        $is_certified = $alipay_user_userinfo_share_response->is_certified;
        $is_certify_grade_a = $alipay_user_userinfo_share_response->is_certify_grade_a;
        $avatar = $alipay_user_userinfo_share_response->avatar;
        $is_student_certified = $alipay_user_userinfo_share_response->is_student_certified;
        $is_bank_auth = $alipay_user_userinfo_share_response->is_bank_auth;
        $alipay_user_id = $alipay_user_userinfo_share_response->alipay_user_id;
        $user_status = $alipay_user_userinfo_share_response->user_status;
        $is_id_auth = $alipay_user_userinfo_share_response->is_id_auth;
        $sign = $result->sign;
        
        dump( $result );
        **/
        
       
    }
}

?>