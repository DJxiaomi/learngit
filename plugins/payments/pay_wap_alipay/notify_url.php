<?php
/* *
 * ���ܣ�֧�����������첽֪ͨҳ��
 * �汾��3.3
 * ���ڣ�2012-07-23
 * ˵����
 * ���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 * �ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���


 *************************ҳ�湦��˵��*************************
 * ������ҳ���ļ�ʱ�������ĸ�ҳ���ļ������κ�HTML���뼰�ո�
 * ��ҳ�治���ڱ������Բ��ԣ��뵽�������������ԡ���ȷ���ⲿ���Է��ʸ�ҳ�档
 * ��ҳ����Թ�����ʹ��д�ı�����logResult���ú����ѱ�Ĭ�Ϲرգ���alipay_notify_class.php�еĺ���verifyNotify
 * ���û���յ���ҳ�淵�ص� success ��Ϣ��֧��������24Сʱ�ڰ�һ����ʱ������ط�֪ͨ
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
require_once("lib/alipay_submit.class.php");

//����ó�֪ͨ��֤���
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//��֤�ɹ�
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//������������̻���ҵ���߼������

	
	//�������������ҵ���߼�����д�������´�������ο�������
	
    //��ȡ֧������֪ͨ���ز������ɲο������ĵ��з������첽֪ͨ�����б�
	
	//�̻�������

	$out_trade_no = $_POST['out_trade_no'];

	//֧�������׺�

	$trade_no = $_POST['trade_no'];

	//����״̬
	$trade_status = $_POST['trade_status'];
	if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
		//���жϱ�ʾ�������֧�������׹����в����˽��׼�¼�Ҹ���ɹ���������û�з�
		$parameter = array(
				"service" => "send_goods_confirm_by_platform",
				"partner" => trim($alipay_config['partner']),
				"trade_no"	=> $trade_no,
				"logistics_name"	=> "EXPRESS",
				"invoice_no"	=> $out_trade_no,
				"transport_type"	=> "EXPRESS",
				"_input_charset"	=> "utf-8"
		);
		
		//��������
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($parameter);
		//����XML
		//ע�⣺�ù���PHP5����������֧�֣��迪ͨcurl��SSL��PHP���û��������鱾�ص���ʱʹ��PHP�������
		$doc = new DOMDocument();
		$doc->loadXML($html_text);
	}

    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//�жϸñʶ����Ƿ����̻���վ���Ѿ���������
			//���û�������������ݶ����ţ�out_trade_no�����̻���վ�Ķ���ϵͳ�в鵽�ñʶ�������ϸ����ִ���̻���ҵ�����
			//���������������ִ���̻���ҵ�����
				
		//ע�⣺
		//�˿����ڳ������˿����޺��������¿��˿��֧����ϵͳ���͸ý���״̬֪ͨ

        //�����ã�д�ı�������¼������������Ƿ�����
        //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		//�жϸñʶ����Ƿ����̻���վ���Ѿ���������
			//���û�������������ݶ����ţ�out_trade_no�����̻���վ�Ķ���ϵͳ�в鵽�ñʶ�������ϸ����ִ���̻���ҵ�����
			//���������������ִ���̻���ҵ�����
				
		//ע�⣺
		//������ɺ�֧����ϵͳ���͸ý���״̬֪ͨ

        //�����ã�д�ı�������¼������������Ƿ�����
        //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
    }

	//�������������ҵ���߼�����д�������ϴ�������ο�������
        
	//echo "success";		//�벻Ҫ�޸Ļ�ɾ��
	echo file_get_contents($alipay_config['siteurl']."plugin.php?id=it618_credits:ajax&ac=alipay_success&ac1=notify&out_trade_no=".$_POST['out_trade_no']."&trade_no=".$_POST['trade_no']."&trade_status=".$_POST['trade_status']);
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //��֤ʧ��
    //echo "fail";
	echo file_get_contents($alipay_config['siteurl']."plugin.php?id=it618_credits:ajax&ac=alipay_fail&ac1=notify&out_trade_no=".$_POST['out_trade_no']."&trade_no=".$_POST['trade_no']);

    //�����ã�д�ı�������¼������������Ƿ�����
    //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
}
?>