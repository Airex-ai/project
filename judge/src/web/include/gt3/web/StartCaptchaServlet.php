<?php 
/**
 * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
 * @author Tanxu
 */
//error_reporting(0);
session_start();
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/config/config.php';
require_once ("../../common_functions.inc.php");
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);

$data = array(
		"ip_address" => get_client_ip() # 请在此处传输用户请求验证时所携带的IP
	);

$status = $GtSdk->pre_process($data, 1);
$_SESSION['gtserver'] = $status;
echo $GtSdk->get_response_str();
 ?>