<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rank extends CI_Controller {


	function __construct()
 	{
  		parent::__construct();
  		$this->load->helper('url');
 	}



	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		// phpinfo();
		// 加载model和分页类
		$this->load->model('Rankmodel');
		$this->show_list();
		// $this->load->model('Loginmodel');
		// $this->Rankmodel->send_check_email_byphpmailer( '277850636@qq.com','乐天互动账号激活','123487');
		// $this->Rankmodel->send_check_email_byphpmailer( '287217977@qq.com','乐天互动账号激活','123487');
	}

	/**
	 * 
	 * 查看微信大号列表
	 * @$cat_type  参见 ../models/rankmodel.php
	 *
	 */
	public function show_list($cat_type = 0)
	{
		// 加载model和分页类
		$this->load->model('Rankmodel');

		// 请求参数
		$cat_type = empty($cat_type) ? 0 : intval($cat_type);
		$cur_page = $this->input->get('p', TRUE);
		$cur_page = $cur_page === false ? 1 : intval($cur_page);
		$search_key = $this->input->get('k',TRUE);

		// 访客只能看第一页
		if ( $cur_page > 1 && $this->session->userdata('uin') == false ) {
			redirect('login');
		} 

		// 每页的行数
		$rows_per_page = 20;

		// 更新时间，暂时hardcode
		$data['update_time'] = date('Y年m月d日');
		$data['keywords'] = empty($search_key) ? '' : $search_key;
		// 查询目录列表
		$data['rank_cat_list'] = $this->Rankmodel->get_rank_catgory_list( $cat_type );
		
		// 查询大号信息列表
		// $data['rank_total'] = $this->Rankmodel->get_rank_total( $cat_type,$search_key);
		// $data['rank_list'] = $this->Rankmodel->get_rank_list( $cat_type,$search_key,$rows_per_page,$cur_page );
		
		$rank_list = $this->Rankmodel->get_rank_list_fromapi($cat_type,$search_key,$rows_per_page,$cur_page);
		if ( !empty($rank_list) ) {
			$data['rank_total'] = $rank_list['count'];
			$data['rank_list'] = $rank_list['list'];
		} else {
			$data['rank_total'] = 0;
			$data['rank_list'] = array();
		}

		// 生成分页信息
		$data['cur_page'] = $cur_page;
		$pager_link_base = site_url('list/'. $cat_type . '/');
		$data['pager_data'] = $this->Rankmodel->get_pager_cfg_data( $pager_link_base ,$data['rank_total'],$rows_per_page,$cur_page);

		// 导航
		$data['cur_nav'] = 'list';
		// 渲染生成页面
		$this->load->view('header',$data);
		$this->load->view('list',$data);
		$this->load->view('footer');
	}


	/** 
	 * 查看微信大号详情
	 */
	public function show_detail($pn_id = '')
	{

		// 需要登陆
		if ( $this->session->userdata('uin') == false ) {
			redirect('login');
		} else if( $this->session->userdata('utype') == 1 ){
			redirect('register');
		}

		// 加载model和分页类
		$this->load->model('Rankmodel');
		$data = array();

		if ( empty($pn_id)) {
			show_error('缺少参数!',500,'请求错误');
		}

		$data = $this->Rankmodel->get_pn_detail_fromapi( $pn_id);

		// 导航
		$data['cur_nav'] = 'list';
		// 渲染生成页面
		$this->load->view('header',$data);
		$this->load->view('detail',$data);
		$this->load->view('footer');
	}


	/** 
	 * 添加广告页面
	 */
	public function show_add_adv( $pn_id )
	{

		// 需要登陆
		if ( $this->session->userdata('uin') == false ) {
			redirect('login');
		} else if( $this->session->userdata('utype') == 1 ){
			redirect('register');
		}

		$this->load->model('Rankmodel');

		if ( empty($pn_id)) {
			$data = array();
		} else {
			$data = $this->Rankmodel->get_pn_detail_fromapi( $pn_id);
		}

		// 导航
		$data['cur_nav'] = 'add';
		// 渲染生成页面
		$this->load->view('header',$data);
		$this->load->view('add',$data);
		$this->load->view('footer');
	}

	/** 
	 * 提交广告
	 */
	public function do_add(){

		// 需要登陆
		if ( $this->session->userdata('uin') == false ) {
			$this->returnJson(99,array(),'您的请求已过期，请重新登录！');
		} 

		$pn_id = $this->input->get('pn_id');
		$ad_type = $this->input->get('adv_type');
		$ad_classify = $this->input->get('adv_classify');
		$ad_pos = $this->input->get('adv_pos');
		$fans_cnt = $this->input->get('fans_count');
		$ad_title = $this->input->get('title');
		$company = $this->input->get('ent_name');
		$person = $this->input->get('link_man');
		$phone = $this->input->get('link_info');
		$ad_date = $this->input->get('expect_time');
		$remark = $this->input->get('remark');

		// 非空校验
		if ( empty($pn_id) || empty($ad_type) /*|| empty($ad_classify) */|| empty($ad_pos) || empty($fans_cnt) || empty($ad_title) || empty($company) || empty($person) || empty($phone)) {
			$this->returnJson(1,array(),'缺少参数');
		}
		$this->load->model('Rankmodel');

		$data = $this->Rankmodel->add_adv_fromapi( $pn_id,$ad_type,$ad_classify,$ad_pos,$ad_title,$fans_cnt,$company,$person ,$phone ,$ad_date ,$remark);

		if ( $data['code'] === 0 ) {
            $this->returnJson($data['code'],array(),'提交成功');
        } else {
            $this->returnJson($data['code'],array(),$data['message']);
        }
	}


	public function test(){
		phpinfo();
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