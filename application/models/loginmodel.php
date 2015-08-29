<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginmodel extends CI_Model {
                    

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 注册
     */
    public function register_fromapi($email,$password,$entname,$entindustry,$phoneno,$smscode,$linkman){

        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'Register',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'nickname' => $email,
            'email' => $email,
            'phone' => $phoneno,
            'password' => md5($password),
            'company' => $entname,
            'trade' => $entindustry,
            'person' => $linkman
        );

        // 强制数字使用整形
        $input = json_encode( $input);
        $output = $this->http->post($url,$input);

        // 返回
        $data = array(
            'code' => 1,
            'message' => '服务器异常！' 
        );
        if ( !empty($output) ) {
            $output = json_decode( $output );
            // 注册成功
            if ( isset($output->result) && $output->result === 0) {
                $data = array(
                    'code' => 0,
                    'data' => $output->uin,
                    'message' => '注册成功！' 
                );
            } 
        }
        return $data;
    }


    /**
     * 校验email是否已经注册:
     *     1:已注册  
     *     0:未注册
     *     false: 异常
     */
    public function check_is_exist_fromapi( $email ){
        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'CheckExistEmail',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'email' => $email
        );

        $input = json_encode( $input);
        $output = $this->http->post($url,$input);

        if ( empty($output) ) {
            return false;
        } else {
            $output = json_decode( $output );
            if ( isset($output->result) ) {
                // result = 0;正常，未注册
                if ( intval($output->result) === 0 ) {
                    return 0;
                // result > 0;异常，已注册
                } else if( intval($output->result) > 0){
                    log_message('debug','email:' . $email . ' has been registered!');
                    return 1;
                // result < 0;异常，服务异常
                } else {
                    log_message('error','service error！result=' . $output->result);
                    return false;
                }
            }
        }
        return false;
    }


    /**
     * 激活
     */
    public function activate_fromapi( $email ){
        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'EnableEmail',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'email' => $email
        );

        $input = json_encode( $input);
        $output = $this->http->post($url,$input);

        if ( empty($output) ) {
            return false;
        } else {
            $output = json_decode( $output );

            if ( isset($output->result) ) {
                // result = 0;激活成功
                if ( intval($output->result) === 0 ) {
                    return 0;
                // result > 0;激活失败
                } else if( intval($output->result) > 0){
                    log_message('debug','activate failed:email:' . $email );
                    return 1;
                // result < 0;激活失败，服务异常
                } else {
                    log_message('error','service error！result=' . $output->result);
                    return false;
                }
            }
        }
        return false;
    }



    /**
     * 登陆
     */
    public function login_fromapi( $user_name,$password){
        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'Login',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'email' => $user_name,
            'password' => md5($password)
        );

        // 强制数字使用整形
        $input = json_encode( $input);
        $output = $this->http->post($url,$input);

        // 返回
        $data = array(
            'code' => 1,
            'message' => '服务器异常！' 
        );
        if ( !empty($output) ) {
            $output = json_decode( $output );
            // 注册成功
            if ( isset($output->result) && $output->result === 0) {
                $data = array(
                    'code' => 0,
                    'data' => array('uin' => $output->uin,'utype' => $output->type ),
                    'message' => '登陆成功！' 
                );
            } 
        }
        return $data;
    }


    

    /**
     * 登陆(管理员)
     */
    public function admin_login_fromapi( $user_name,$password){
        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'AdminLogin',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'admin_user' => $user_name,
            'password' => md5($password)
        );

        // 强制数字使用整形
        $input = json_encode( $input);
        $output = $this->http->post($url,$input);

        // 返回
        $data = array(
            'code' => 1,
            'message' => '服务器异常！' 
        );
        if ( !empty($output) ) {
            $output = json_decode( $output );
            // 注册成功
            if ( isset($output->result) && $output->result === 0) {
                $data = array(
                    'code' => 0,
                    'data' => array(),
                    'message' => '登陆成功！' 
                );
            } 
        }
        return $data;
    }



    /**
     * 获取短信验证码
     */
    // public function get_smscode_fromapi( $mobile_no ){}

    /**
     * 发送验证邮件
     */
    public function send_check_email( $to,$uid ){

        $this->load->library('email');
        $this->config->load('rank_config');
        $fromEmail = $this->config->item('reg_check_from_email_smtp_user');
        $fromName = $this->config->item('reg_check_email_from_name');
        $emailSubject = $this->config->item('reg_check_email_subject');
        $activateUrl = site_url('activate?uid='. $uid . '&eid=' . urlencode( $to ));
        // 设定邮件内容类型为html
        $config['mailtype'] = 'html';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $this->config->item('reg_check_from_email_smtp_host');
        $config['smtp_user'] = $this->config->item('reg_check_from_email_smtp_user');
        $config['smtp_pass'] = $this->config->item('reg_check_from_email_smtp_pass');
        $config['smtp_port'] = $this->config->item('reg_check_from_email_smtp_port');
        $config['smtp_timeout'] = '10';

        $this->email->initialize($config);
        // 邮件内容
        $emailContentHtml = '<html><head></head><body>';
        $emailContentHtml .= "<h1>Hi,{$to}</h1>";
        $emailContentHtml .= "<p>请点击链接激活账号：{$activateUrl}</p>";
        $emailContentHtml .= "<div>如果链接无法点击，请将链接复制到你的浏览器进行访问。</div>";
        $emailContentHtml .= "<div>感谢您对乐天广告平台的支持与信赖！</div>";
        $emailContentHtml .= "<p>－－乐天团队</p>";
        $emailContentHtml .= '</body></html>';

        $this->email->from( $fromEmail , $fromName);
        $this->email->to( $to ); 
        $this->email->subject( $emailSubject  );
        $this->email->message( $emailContentHtml ); 
        $res = $this->email->send();
        //echo $this->email->print_debugger();
        return $res;
    }


    /**
     * 发送验证邮件(Phpmailer)
     */
    public function send_check_email_byphpmailer( $to,$subject,$uid ){

        $this->load->library('mailer');
        $activateUrl = site_url('activate?uid='. $uid . '&eid=' . urlencode( $to ));
        // 邮件内容
        $emailContentHtml = '<!DOCTYPE  HTML><head></head><body>';
        $emailContentHtml .= "<h1>Hi,{$to}</h1>";
        $emailContentHtml .= "<p>请点击链接激活账号：{$activateUrl}</p>";
        $emailContentHtml .= "<div>如果链接无法点击，请将链接复制到你的浏览器进行访问。</div>";
        $emailContentHtml .= "<div>感谢您对乐天广告平台的支持与信赖！</div>";
        $emailContentHtml .= "<p>－－乐天团队</p>";
        $emailContentHtml .= '</body></html>';

        // 发邮件
        $res = $this->mailer->sendmail(
            $to,
            '收件人',
            $subject,
            $emailContentHtml
        );
        return $res === true ? true : false;
    }


}