<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 查询订单列表（后台）
     */
    public function get_order_list_from_api( $task_state){
        $this->load->library('http');
        $this->config->load('rank_config');

        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'GetAdTaskList',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'admin_user' => $this->session->userdata('admin_user'),
            'admin_user' => 'jaxon',
            'task_state' => $task_state
        );
        // 强制数字使用整形
        $input = json_encode( $input, JSON_NUMERIC_CHECK);
        $output = $this->http->post($url,$input);
        if ( empty($output) ) {
            return false;
        } else {

            $output = json_decode( $output );
            if ( isset($output->datas) && !empty($output->datas) && !empty($output->datas->ls_tasks)) {
                foreach ( $output->datas->ls_tasks as $key => $order_item ) {
                    $result_item['order_id']            = $order_item->task_id;
                    $result_item['order_time']          = date('Ymd',$order_item->pub_date);
                    $result_item['order_status']        = $this->get_state_by_id($order_item->task_state);
                    $result_item['order_company']       = $order_item->company;
                    $result_item['order_pn_name']       = empty($order_item->biz_id) ? '无' : $order_item->biz_id;
                    $result_item['order_exp_fanscnt']   = $order_item->fans_cnt;
                    $result_item['order_exp_time']      = $order_item->ad_date;
                    $result_item['order_last_owner']    = empty($order_item->deal_user) ? '--' : $order_item->deal_user;

                    $result[] = $result_item;
                }
                return $result;
            }
        }
        return false;
    }


    public function get_order_detail_from_api( $task_id){
        $this->load->library('http');
        $this->config->load('rank_config');

        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'GetAdTaskDetail',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'admin_user' => $this->session->userdata('admin_user'),
            'task_id' => $task_id
        );
        // 强制数字使用整形
        $input = json_encode( $input, JSON_NUMERIC_CHECK);
        $output = $this->http->post($url,$input);
        if ( empty($output) ) {
            return false;
        } else {

            $output = json_decode( $output );
            if ( isset($output->datas) && !empty($output->datas)) {
                    $result['adv_pos']           = $output->datas->ad_pos;
                    $result['adv_type']          = $output->datas->ad_type == 1 ? '软广' : '硬广';
                    $result['adv_contact_man']   = $output->datas->person;
                    $result['adv_contact_link']  = $output->datas->phone;
                    $result['adv_title']         = $output->datas->ad_title;
                    $result['adv_remark']        = $output->datas->remark;
                    $result['status']            = $output->datas->task_state;
                    $result['remark']            = $output->datas->deal_remark;
                return $result;
            }
        }
        return false;
    } 


    public function update_order_status( $task_id,$task_state,$task_remark){
        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'UpdateAdTask',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'admin_user' => $this->session->userdata('admin_user'),
            'deal_remark' => $task_remark,
            'task_state' => $task_state,
            'task_id' => $task_id
        );

        // 强制数字使用整形
        $input = json_encode( $input, JSON_NUMERIC_CHECK);
        $output = $this->http->post($url,$input);

        // 返回
        $data = array(
            'code' => 1,
            'message' => '服务器异常！' 
        );
        if ( !empty($output) ) {
            $output = json_decode( $output );

            // 修改成功
            if ( isset($output->result) && $output->result === 0) {
                $data['code'] = 0;
                $data['message'] = $output->err_info;
            } else {
                $data['code'] = 1;
                $data['message'] = $output->err_info;
            }
        }
        return $data;
    }



    /**
     * 获取状态描述
     */
    private function get_state_by_id( $state_id){
        $state = '';
        switch ( $state_id) {
            case 1:$state = '未联系';break;
            case 2:$state = '沟通中';break;
            case 3:$state = '合作中';break;
            case 4:$state = '完成';break;
            default: $state = '未知状态';break;
        }
        return $state;
    }


}