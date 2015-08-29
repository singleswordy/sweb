<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Mailer {
 
    var $mail;
 
    public function __construct()
    {
        require_once('PHPMailer/class.phpmailer.php');
        require_once('PHPMailer/class.smtp.php');
 
        // the true param means it will throw exceptions on errors, which we need to catch
        $this->mail = new PHPMailer(true);
 
        $this->mail->IsSMTP(); // telling the class to use SMTP
        $this->mail->Ishtml(true); // 发送html
 
        $this->mail->CharSet = "utf-8";                  // 一定要設定 CharSet 才能正確處理中文
        $this->mail->SMTPDebug  = 0;                     // enables SMTP debug information
        $this->mail->SMTPAuth   = true;                  // enable SMTP authentication
        $this->mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $this->mail->Host       = "smtp.exmail.qq.com";      // sets GMAIL as the SMTP server
        $this->mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $this->mail->Username   = "reg@leskymob.com";// GMAIL username
        $this->mail->Password   = "4fv9rkiP3y2";       // GMAIL password
        $this->mail->AddReplyTo('reg@leskymob.com', '乐天互动');
        $this->mail->SetFrom('reg@leskymob.com', '乐天互动');
    }
 
    public function sendmail($to, $to_name, $subject, $body){
        try{
            $this->mail->AddAddress($to, $to_name);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
 
            $this->mail->Send();
            return true;
 
        } catch (phpmailerException $e) {
            log_message('error',$e->errorMessage());
        } catch (Exception $e) {
            log_message('error',$e->getMessage());
        }
    }
}
 
/* End of file mailer.php */
 