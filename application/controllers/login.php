<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }


    /** 
     * 注册页面
     */
    public function show_register( ){
        $this->load->helper('form');
        
        if ( $this->session->userdata('utype') == false ) {
            $data['reg_status'] = 0;
        } else {
            $data['reg_status'] = $this->session->userdata('utype');
        }
        $this->load->view('register',$data);
        $this->output->_display();
        die();
    }


    /** 
     * 登陆页面
     */
    public function show_login($msg = '',$username = ''){
        $this->load->helper('form');
        if (empty($username) && !empty( $_COOKIE['username'])) {
            $username = $_COOKIE['username'];
        }
        $this->load->view('login',array('login_msg' => $msg,'username' => $username));
        $this->output->_display();
        die();
    }



    /** 
     * 登陆页面(管理员)
     */
    public function show_admin_login($msg = '',$username = ''){
        $this->load->helper('form');
        if (empty($username) && !empty( $_COOKIE['admin_user'])) {
            $username = $_COOKIE['admin_user'];
        }
        $this->load->view('admin_login',array('login_msg' => $msg,'username' => $username));
        $this->output->_display();
        die();
    }

    


    /**     
     * 生成验证码
     */
    public function show_captcha_img(){
        $this->load->helper('captcha');
        $this->load->helper('path');
        $this->config->load('rank_config');

        // 生成字符
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $word = '';
        for ($i = 0; $i < 4; $i++){
            $word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
        }

        $cfg = array(
            'word'=> $word,
            'img_path'=> set_realpath('static/image/captcha'),
            'img_url'=> base_url()."static/image/captcha/",
            'img_width'=>'120',
            'img_height'=>'38',
            'expiration'=>120//2分钟
        );
        $cap = create_captcha($cfg);
        // 存入sesstion
        $this->session->set_userdata('captcha_word', $cap['word']);  
        $this->session->set_userdata('captcha_time', $cap['time']);  
        echo $cap['image'];
    }


    /**     
     * 检验email是否已经注册
     */
    public function check_is_exist( ){
        $this->load->model('Loginmodel');
        $email = $this->input->get('e');
        $data = $this->Loginmodel->check_is_exist_fromapi($email);
        if( $data === false ) {
            $this->returnJson(1,array(),'服务异常');
        } else {
            // 0 不存在    1 已存在
            $this->returnJson( $data ,array(),'');
        }
    }



    /** 
     * 注册
     */
    public function do_register(){

        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
        $this->load->model('Loginmodel');

        // 表单校验
        $this->form_validation->set_rules('email', '邮箱账号', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[30]|xss_clean');
        $this->form_validation->set_rules('entname', '企业名称', 'trim|required|max_length[60]|xss_clean');
        // $this->form_validation->set_rules('entindustry', '企业所在行业', 'trim|required|max_length[60]|xss_clean');
        $this->form_validation->set_rules('phoneno', '联系手机号', 'trim|required|numeric|min_length[11]|max_length[11]|xss_clean');
        // $this->form_validation->set_rules('smscode', '短信验证码', 'trim|required|xss_clean');
        $this->form_validation->set_rules('linkman', '联系人', 'trim|required|max_length[30]|xss_clean');
        
        // 校验成功则注册
        if( $this->form_validation->run() == FALSE ) {
            show_error(validation_errors(),500,'注册信息填写错误');
        } else {
            $email          = $this->input->post('email');
            $password       = $this->input->post('password');
            $entname        = $this->input->post('entname');
            $entindustry    = $this->input->post('entindustry');
            $phoneno        = $this->input->post('phoneno');
            // $smscode         = $this->input->post('smscode');
            $linkman        = $this->input->post('linkman');

            // 调用注册接口
            $data = $this->Loginmodel->register_fromapi( $email,$password,$entname,$entindustry,$phoneno,'test',$linkman );
            
            if ( $data['code'] === 0 ) {
                // 发送确认邮件
                $emailRes = $this->Loginmodel->send_check_email_byphpmailer( $email,'乐天互动账号激活',$data['data']);
                if ($emailRes) {
                    // 返回到注册第二步
                    $data['reg_status'] = 1;
                    $data['to_email'] = $email;
                    $this->load->view('register',$data);
                } else {
                    show_error('注册邮件发送失败，您可能填写了无效的email地址！如需修改，请联系管理员!',500,'请求错误');
                }
            } else {
                show_error('服务器返回错误，请联系管理员!',500,'请求错误');
            }
        }

        
            
    }

    /** 
     * 激活邮箱
     */
    public function do_activate(){
        $this->load->model('Loginmodel');
        $email = $this->input->get('eid');
        if (empty( $email )) {
            show_error('缺少参数!',500,'无效请求');
        } else {
            // 调用激活接口
            $dataRet = $this->Loginmodel->activate_fromapi( $email );         
            if ( $dataRet === 0 ) {               
                // 返回到注册第二步
                $data['reg_status'] = 2;
                $this->session->set_userdata('utype', 2);  
                $this->load->view('register',$data);
            } else {
                show_error('服务器返回错误，请联系管理员!',500,'请求错误');
            }
        }
    }



    /** 
     * 登陆
     */
    public function do_login(){
        // 检查是否已经登陆
        if ( $this->session->userdata('uin') != false ) {  
            redirect('list');
        }

        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
        $this->load->model('Loginmodel');

        // 表单校验
        $this->form_validation->set_rules('username', '用户名', 'trim|required|max_length[30]|xss_clean');
        $this->form_validation->set_rules('password', '密码', 'trim|required|max_length[30]|xss_clean');
        $this->form_validation->set_rules('captcha', '验证码', 'trim|required|min_length[4]|max_length[4]|xss_clean');
        
        // 校验成功则登陆
        if( $this->form_validation->run() == FALSE ) {
            return $this->show_login(validation_errors(),$this->input->post('username'));
        } else {
            $username       = $this->input->post('username');
            $password       = $this->input->post('password');
            $captcha        = $this->input->post('captcha');

            $issave         = $this->input->post('issave');
            if ( !empty( $issave )) {
                setcookie("username",$username,time()+3600*24*365); 
            } else {
                setcookie('username','',time()-3600);
            }

            // 验证校验码
            if ( $this->session->userdata('captcha_word') == false || $this->session->userdata('captcha_time') == false // session 异常
                OR intval(microtime(true) - $this->session->userdata('captcha_time') ) > 60  // 过期
                OR strcasecmp($this->session->userdata('captcha_word'), $captcha) != 0       // 输入错误
            ) {
                $this->show_login('验证码错误',$this->input->post('username'));
            } 
            
            // 调用注册接口
            $data = $dataRet = $this->Loginmodel->login_fromapi( $username,$password );   
            // 登陆成功
            if ( $data['code'] === 0 ) {
                $this->session->set_userdata('username', $this->input->post('username'));  
                $this->session->set_userdata('uin', $data['data']['uin']);  
                $this->session->set_userdata('utype', $data['data']['utype']);  
                redirect('list');
            } else if($data['code'] > 0){
                return $this->show_login('用户名或密码错误！',$this->input->post('username'));
            }
        }
        return $this->show_login('系统异常，请联系管理员',$this->input->post('username'));
    }

    /** 
     * 登陆(管理员)
     */
    public function do_admin_login(){
        // 检查是否已经登陆
        if ( $this->session->userdata('admin_user') != false ) {  
            redirect('orders/1');
        }

        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
        $this->load->model('Loginmodel');

        // 表单校验
        $this->form_validation->set_rules('username', '用户名', 'trim|required|max_length[30]|xss_clean');
        $this->form_validation->set_rules('password', '密码', 'trim|required|max_length[30]|xss_clean');
        $this->form_validation->set_rules('captcha', '验证码', 'trim|required|min_length[4]|max_length[4]|xss_clean');
        
        // 校验成功则登陆
        if( $this->form_validation->run() == FALSE ) {
            return $this->show_admin_login(validation_errors(),$this->input->post('username'));
        } else {
            $username       = $this->input->post('username');
            $password       = $this->input->post('password');
            $captcha        = $this->input->post('captcha');

            $issave         = $this->input->post('issave');
            if ( !empty( $issave )) {
                setcookie("adminusername",$username,time()+3600*24*365); 
            } else {
                setcookie('adminusername','',time()-3600);
            }

            // 验证校验码
            if ( $this->session->userdata('captcha_word') == false || $this->session->userdata('captcha_time') == false // session 异常
                OR intval(microtime(true) - $this->session->userdata('captcha_time') ) > 60  // 过期
                OR strcasecmp($this->session->userdata('captcha_word'), $captcha) != 0       // 输入错误
            ) {
                $this->show_admin_login('验证码错误',$this->input->post('username'));
            } 
            
            // 调用注册接口
            $data = $dataRet = $this->Loginmodel->admin_login_fromapi( $username,$password );   
            // 登陆成功
            if ( $data['code'] === 0 ) {
                $this->session->set_userdata('admin_user', $this->input->post('username'));  
                redirect('orders/1');
            } else if($data['code'] > 0){
                return $this->show_admin_login('用户名或密码错误！',$this->input->post('username'));
            }
        }
        return $this->show_admin_login('系统异常，请联系管理员',$this->input->post('username'));
    }


    /** 
     *  登出
     */
    public function do_logout(){  
        $this->session->sess_destroy();
        return $this->show_login(); 
    }

    /** 
     *  登出(管理员)
     */
    public function do_admin_logout(){  
        $this->session->sess_destroy();
        return $this->show_admin_login(); 
    }

    /** 
     * 输出json
     */
    private function returnJson( $code,$data = array(),$message = '' ){
        $return = array(
            'code' => $code,
            'data' => $data,
            'message' => $message
        );
        $this->output->set_content_type('application/json')->set_output( json_encode( $return ) ) ;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */