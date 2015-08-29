<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }



    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -  
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->show_order_list();
    }


    /**
     * 显示订单列表
     */
    public function show_orders_list( $order_type ){

        // 需要登陆
        if ( $this->session->userdata('admin_user') == false ) {
            redirect('adminlogin');
        } 

        $data['order_type'] = $order_type;

        // 非空校验
        if ( empty($order_type)) {
            show_error('缺少参数!',500,'请求错误');
        }

        $this->load->model('Adminmodel');

        $result = $this->Adminmodel->get_order_list_from_api( $order_type ) ;

        if ( is_array($result) ) {
            $data['order_list'] = $result;
        } else {
            $data['order_list'] = array();
        }
        // 渲染生成页面
        $this->load->view('header_admin',$data);
        $this->load->view('orders',$data);
        $this->load->view('footer');
    }

    /** 
     * 查询订单详情
     */
    public function get_order_detail( $order_id ){
        // 需要登陆
        if ( $this->session->userdata('admin_user') == false ) {
            redirect('adminlogin');
        }
        // 非空校验
        if ( empty($order_id)) {
            $this->returnJson(1,array(),'缺少参数');
        }

        $this->load->model('Adminmodel');
        $result = $this->Adminmodel->get_order_detail_from_api( $order_id ) ;

        if ( $result !== false ) {
            $this->returnJson(0,$result,'ok');
        } else {
            $this->returnJson(1,array(),'查询订单详情错误');
        }
    }


    /** 
     * 更新订单状态
     */
    public function update_order_status(){
        $order_id = $this->input->get('order_id');
        $status_id = $this->input->get('status_id');
        $remark = $this->input->get('remark');

        // 非空校验
        if ( empty($order_id) || empty($status_id) ) {
            $this->returnJson(1,array(),'缺少参数');
        }
        $this->load->model('Adminmodel');

        $data = $this->Adminmodel->update_order_status( $order_id ,$status_id, $remark);

        if ( $data['code'] === 0 ) {
            $this->returnJson($data['code'],array(),'修改成功');
        } else {
            $this->returnJson($data['code'],array(),$data['message']);
        }

        $this->returnJson(0,array(),'ok');
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