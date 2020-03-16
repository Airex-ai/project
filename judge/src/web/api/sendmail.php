<?php
session_start();

require_once("../include/setting_oj.inc.php");
require_once("../include/common_functions.inc.php");
require_once('../include/safe_func.inc.php');
require_once('../include/user_check_functions.php');
require_once("../include/PHPMailer.php");
require_once("../include/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
} else {
    exit("error");
}
if (get_magic_quotes_gpc()) {
    $email = stripslashes($email);
}

$sql = $pdo->prepare("SELECT user_id,nick,getpasstime,password FROM `users` WHERE email=?");
$sql->execute(array($email));
$row = $sql->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $getpasstime = time();
    $uid = $row['user_id'];
    $token = md5($uid . $row['nick'] . $row['password']);
    $url = "http://witacm.com/reset.php?email=" . $email . "&token=" . $token;
    $time = date('Y-m-d H:i');
    $result = sendmail($time, $email, $url, $uid);
    if ($result) {//邮件发送成功
        $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
        //更新数据发送时间
        $sql = $pdo->prepare("UPDATE `users` SET getpasstime=? WHERE user_id=?");
        $sql->execute(array($time, $uid));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    } else {
        $msg = $result;
    }
    echo $msg;
} else {
    echo 'noreg';
}

function sendmail($time, $email, $url, $uid)
{
    $mail = new PHPMailer();
// 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
//    $mail->SMTPDebug = 1;
// 使用smtp鉴权方式发送邮件
    $mail->isSMTP();
// smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = true;
// 链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.exmail.qq.com';
// 设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';
// 设置ssl连接smtp服务器的远程服务器端口号
    $mail->Port = 465;
// 设置发送的邮件的编码
    $mail->CharSet = 'UTF-8';
// 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = 'WITACM';
// smtp登录的账号 QQ邮箱即可
    $mail->Username = 'acm@witacm.com';
// smtp登录的密码 使用生成的授权码
    $mail->Password = 'Wit@2018';
// 设置发件人邮箱地址 同登录账号
    $mail->From = 'acm@witacm.com';
// 邮件正文是否为html编码 注意此处是一个方法
    $mail->isHTML(true);
// 设置收件人邮箱地址
    $mail->addAddress($email);
    $mail->addAddress('acm@witacm.com');
// 添加该邮件的主题
    $mail->Subject = 'witacm.com - 找回密码';
// 添加邮件正文
    $mail->Body = "亲爱的" . $uid . "：<br/>您在" . $time . "提交了找回密码请求。请点击下面的链接重置密码（链接24小时内有效）。<br/><a href='" . $url . "' target='_blank'>" . $url . "</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果您没有提交找回密码请求，请忽略此邮件。";
// 发送邮件 返回状态
    $status = $mail->send();
    return $status;
}
