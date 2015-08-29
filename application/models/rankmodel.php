<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rankmodel extends CI_Model {
                    
    // var $cat_type_map = array(
    //     array('id' => 1,    'key' => 'news',      'desc' => '新闻'),
    //     array('id' => 2,    'key' => 'ent',       'desc' => '娱乐'),
    //     array('id' => 3,    'key' => 'fun',       'desc' => '搞笑'),
    //     array('id' => 4,    'key' => 'tour',      'desc' => '旅游'),
    //     array('id' => 5,    'key' => 'foods',     'desc' => '美食'),
    //     array('id' => 6,    'key' => 'finance',   'desc' => '财经'),
    //     array('id' => 7,    'key' => 'health',    'desc' => '健康'),
    //     array('id' => 8,    'key' => 'manage',    'desc' => '管理'),
    //     array('id' => 9,    'key' => 'emotion',   'desc' => '情感'),
    //     array('id' => 10,   'key' => 'gov',       'desc' => '政务'),
    //     array('id' => 11,   'key' => 'beauty',    'desc' => '丽人'),
    //     array('id' => 12,   'key' => 'car',       'desc' => '汽车'),
    //     array('id' => 13,   'key' => 'building',  'desc' => '楼市'),
    //     array('id' => 14,   'key' => 'fashion',   'desc' => '时尚'),
    //     array('id' => 15,   'key' => 'tech',      'desc' => '科技'),
    //     array('id' => 16,   'key' => 'games',     'desc' => '游戏'),
    //     array('id' => 17,   'key' => 'history',   'desc' => '文史'),
    //     array('id' => 18,   'key' => 'famous',    'desc' => '名人'),
    //     array('id' => 19,   'key' => 'film',      'desc' => '影音'),
    //     array('id' => 20,   'key' => 'carton',    'desc' => '动漫'),
    //     array('id' => 21,   'key' => 'company',   'desc' => '企业'),
    //     array('id' => 22,   'key' => 'local',     'desc' => '本地'),
    //     array('id' => 23,   'key' => 'photo',     'desc' => '摄影'),
    //     array('id' => 24,   'key' => 'parent',    'desc' => '亲子'),
    //     array('id' => 25,   'key' => 'life',      'desc' => '生活'),
    //     array('id' => 26,   'key' => 'sex',       'desc' => '两性'),
    //     array('id' => 27,   'key' => 'hot',       'desc' => '热门'),
    //     array('id' => 28,   'key' => 'wemedia',   'desc' => '自媒体'),
    //     array('id' => 29,   'key' => 'keephealth', 'desc' => '养生')
    // );


    var $cat_type_map = array(
        array('id' => 1,    'key' => 'news',      'desc' => '新闻'),
        array('id' => 2,    'key' => 'ent',       'desc' => '娱乐'),
        array('id' => 3,    'key' => 'fun',       'desc' => '搞笑'),
        array('id' => 4,    'key' => 'tour',      'desc' => '旅游'),
        array('id' => 5,    'key' => 'foods',     'desc' => '美食'),
        array('id' => 6,    'key' => 'finance',   'desc' => '财经'),
        array('id' => 7,    'key' => 'health',    'desc' => '健康'),
        array('id' => 8,    'key' => 'manage',    'desc' => '管理'),
        array('id' => 9,    'key' => 'emotion',   'desc' => '情感'),
        // array('id' => 10,   'key' => 'gov',       'desc' => '政务'),
        // array('id' => 11,   'key' => 'beauty',    'desc' => '丽人'),
        // array('id' => 12,   'key' => 'car',       'desc' => '汽车'),
        // array('id' => 13,   'key' => 'building',  'desc' => '楼市'),
        // array('id' => 14,   'key' => 'tech',      'desc' => '科技'),
        // array('id' => 15,   'key' => 'games',     'desc' => '游戏'),
        // array('id' => 16,   'key' => 'history',   'desc' => '文史'),
        // array('id' => 17,   'key' => 'film',      'desc' => '影音'),
        // array('id' => 18,   'key' => 'local',     'desc' => '本地')
    );

    function __construct()
    {
        parent::__construct();
    }
    

    /**
     *  目录列表
     */
    public function get_rank_catgory_list( $current_cat_id )
    {
        $rank_catgory_list = array();
        foreach ($this->cat_type_map as $key => $value) {
            $cat_item = $value;
            if ( !empty( $current_cat_id ) && $current_cat_id == $cat_item['id'] && $current_cat_id <= count($this->cat_type_map) ) {
                $cat_item['is_current'] = true;
            } else {
                $cat_item['is_current'] = false;
            }
            $rank_catgory_list[] = $cat_item;
        }
        return $rank_catgory_list;
    }

    /**
     * 获取列表总行数（用于分页）
     */
    public function get_rank_total($current_cat_id,$search_key){

        $this->load->database();

        $sql = 'select count(*) as total_count ' ;
        $sql .= 'from tb_biz_base t1 left join tb_biz_hot_data t2 on t1.biz_id=t2.biz_id where 1 = 1 ';
        // 类别
        if ( !empty( $current_cat_id ) ) {
            $sql .= ' and classify=' . $current_cat_id;
        } 
        // 微信名搜索
        if ( !empty( $search_key ) ) {
            $sql .= ' and nickname like \'%' . $search_key . '%\'';
        }
        return $this->db->query($sql)->row()->total_count;
    }


    /**
     *  排名详情列表
     */
    public function get_rank_list( $current_cat_id,$search_key,$rows_per_page = 30,$cur_page = 1 ){
        
        $this->load->database();

        $sql = 'select t1.biz_id,nickname,head_img,fans_cnt,near_art_cnt,near_read_cnt,near_like_cnt,update_time  ' ;
        $sql .= 'from tb_biz_base t1 left join tb_biz_hot_data t2 on t1.biz_id=t2.biz_id where 1 = 1 ';
        // 类别
        if ( !empty( $current_cat_id ) ) {
            $sql .= ' and classify=' . $current_cat_id;
        } 
        // 微信名搜索
        if ( !empty( $search_key ) ) {
            $sql .= ' and nickname like \'%' . $search_key . '%\'';
        }
        // 按阅读数倒序
        $sql .= ' order by near_read_cnt desc ';
        // 分页
        if ( !empty( $rows_per_page ) && !empty( $cur_page ) ) {
            $sql .= ' limit ' . ($rows_per_page * ($cur_page - 1)) . ',' . $rows_per_page ;
        }
        $res = $this->db->query($sql);

        $rank_list = array();
        foreach ( $res->result_array() as $key => $row ) {
            
            $rank_item = array(
                'rank_no' => $key + 1,
                'pn_id' => $row['biz_id'],
                'pn_img_link' => $row['head_img'],
                'pn_cn_name' => $row['nickname'],
                'pn_fans' => $row['fans_cnt'],
                'pn_week_publish' => $row['near_art_cnt'],
                'pn_week_read' => $row['near_read_cnt'],
                'pn_week_praise' => $row['near_like_cnt']
            );
            // 点赞比率
            if ($row['near_read_cnt'] <= 0) {
                $rank_item['pn_week_praise_rate'] = '0.00%';
            } else {
                $cent = number_format( ($row['near_like_cnt'] / $row['near_read_cnt']), 4, '.', '');
                $rank_item['pn_week_praise_rate'] = strval( $cent * 100) . '%';
            }
            
            // 隐藏粉丝数
            if ( intval($rank_item['pn_fans'] / 10000) > 0) {
                $rank_item['pn_fans'] =  intval($rank_item['pn_fans'] / 10000) * 10000;
            } else {
                $rank_item['pn_fans'] =  intval($rank_item['pn_fans'] / 100) * 100;
            }
            $rank_list[] = $rank_item;
        }

        return $rank_list;
    }


    /**
     *  排名详情列表
     */
    public function get_rank_list_fromapi( $current_cat_id,$search_key,$rows_per_page = 20,$cur_page = 1 ){

        $this->load->library('http');
        $this->config->load('rank_config');

        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'GetADBizList2',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'uin' => $this->session->userdata('uin'),
            'type' => $current_cat_id,
            'page' => $cur_page
            // 'pagecnt' => $rows_per_page
        );
        // 强制数字使用整形
        $input = json_encode( $input, JSON_NUMERIC_CHECK);
        $output = $this->http->post($url,$input);
        if ( empty($output) ) {
            return false;
        } else {

            $output = json_decode( $output );

                // echo '<pre>';
                // var_dump($output);
                // exit();

            if ( isset($output->datas) && !empty($output->datas) && !empty($output->datas->ls_biz)) {
                $result['count'] = $output->datas->all_cnt;
                $result['list'] = array();
                foreach ( $output->datas->ls_biz as $key => $rank_item ) {
                    $result_item['rank_no']         = $key + 1;
                    $result_item['pn_id']           = $rank_item->biz_id;
                    $result_item['pn_img_link']     = $rank_item->head_img;
                    $result_item['pn_cn_name']      = $rank_item->nickname;
                    $result_item['pn_fans']         = $rank_item->fans_cnt;
                    $result_item['pn_week_publish'] = $rank_item->art_cnt;
                    $result_item['pn_week_read']    = $rank_item->read_cnt;
                    $result_item['pn_week_praise']  = $rank_item->like_cnt;
                    // $cent = number_format( $rank_item->like_rate, 4, '.', '');
                    // $result_item['pn_week_praise_rate'] = strval( $cent * 100) . '%';
                    $result_item['hard_multi_1_price']  = $this->get_price_text($rank_item->hard_multi_1_price);
                    $result_item['hard_multi_2_price']  = $this->get_price_text($rank_item->hard_multi_2_price);
                    $result_item['soft_multi_1_price']  = $this->get_price_text($rank_item->soft_multi_1_price);
                    $result_item['soft_multi_2_price']  = $this->get_price_text($rank_item->soft_multi_2_price);
                    
                    $result['list'][] = $result_item;
                }


                // echo '<pre>';
                // var_dump($output);
                // exit();


                return $result;
            }
        }
        return false;
    }


    /**
     *  获取价格的中文说明
     */
    private function get_price_text( $pirce ){
        if( $pirce < 0) {
            return '不接';
        } else if( $pirce == 0){
            return '待定';
        } else {
            return $pirce . '元';
        }
    }
     

    /**
     *  查询公众号详情
     */
    public function get_pn_detail_fromapi( $biz_id){

        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');
        
        $input = array(
            'func_name' => 'GetADBizInfo',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'uin' => $this->session->userdata('uin'),
            'biz_id' => $biz_id
        );
        // 强制数字使用整形
        $input = json_encode( $input, JSON_NUMERIC_CHECK);
        $output = $this->http->post($url,$input);
        if ( empty($output) ) {
            return false;
        } else {

            $output = json_decode( $output );

            if ( isset($output->datas) && !empty($output->datas)) {
                $result['pn_id'] = $output->datas->biz_id;
                $result['pn_cn_name'] = $output->datas->nickname;
                $result['head_img'] = $output->datas->head_img;
                //$result['pn_qr_code'] = $output->datas->;
                //$result['pn_rank_no'] = $output->datas->;
                $result['pn_description'] = $output->datas->signature;
                $result['pn_trend_num'] = array(
                    'week_avg_read' => $output->datas->read_cnt,
                    'week_avg_praise' => $output->datas->like_cnt,
                    'week_avg_publish' => $output->datas->art_cnt,
                    'valid_fans_count' => $output->datas->fans_cnt,
                    'single_adv_value' => $output->datas->ad_price
                );
                // 文章列表
                foreach ($output->datas->list as $key => $item ) {
                    $article['article_img'] = $item->pic_url;
                    $article['article_title'] = $item->title;
                    $article['article_url'] = $item->art_url;
                    $article['article_content'] = $item->abstract;
                    $article['article_publish_time'] = date('Y-m-d h:i:s',strtotime($item->pub_time));
                    $article['article_read_num'] = $item->read_cnt;
                    $article['article_praise_num'] = $item->like_cnt;
                    $result['pn_article_list'][] = $article;
                }
                // 图表
                $trend_points = array();
                foreach ($output->datas->curve as $key => $point) {
                    $trend_points[] = array(strtotime($point->date) * 1000, $point->cnt);
                }
                $result['pn_trend_data'] = json_encode($trend_points);
                return $result;
            }
        }
        return false;
    }


    /**
     * 新增广告
     */
    public function add_adv_fromapi($pn_id,$ad_type,$ad_classify,$ad_pos,$ad_title,$fans_cnt,$company,$person ,$phone ,$ad_date = '',$remark=''){

        $this->load->library('http');
        $this->config->load('rank_config');
        $url = $this->config->item('api_url');

        // 整型
        $ad_date = preg_replace('/-/','',$ad_date );
        
        $input = array(
            'func_name' => 'PostAdTask',
            'svr_name' => 'from_tools',
            'user_ip' => $this->input->ip_address(),
            'uin' => $this->session->userdata('uin'),
            'ad_type' => intval($ad_type),
            'ad_classify' => 1,
            'ad_pos' => intval($ad_pos),
            'ad_title' => $ad_title,
            'fans_cnt' => intval($fans_cnt),
            'company' => $company,
            'person' => $person,
            'phone' => $phone,
            'ad_date' => intval($ad_date),
            // 'ad_date' => 20150824,
            'remark' => $remark,
            'biz_id' => $pn_id
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
     *  获取分页信息,返回数组，在页面拼成html
     */
    public function get_pager_cfg_data( $base_link,$total_row,$rows_per_page = 10,$cur_page = 1){
        
        // 分页条最多显示的分页个数，超过时，中间部分显示为 。。。
        $page_link_max = 10;

        // 计算总页数
        $total_page = ceil( $total_row / $rows_per_page );
        // 当前
        $cur_page = $cur_page < 1 ? 1 : $cur_page;
        $cur_page = $cur_page > $total_page ? $total_page : $cur_page;
        // 前一页
        $priv_page = ($cur_page - 1) < 1 ? 1 : ($cur_page - 1);
        // 下一页
        $next_page = ($cur_page + 1) > $total_page ? $total_page : $cur_page + 1;

        // 记录结果
        $pager_data = array();
        
        // “前一页”
        $join_char = strstr($base_link,'?') === false ? '?' : '&';
        $pager_data['priv'] = array('text' => '上一页','link' => $base_link . $join_char .'p=' . $priv_page,'class' => 'priv' );// class:priv,current,text,next
        
        // 中间的多页
        // ==分页数没超==
        if ( $total_page <= $page_link_max) {
            for ($i=1; $i <= $total_page; $i++) { 
                $pager_data[$i] = array('text' => $i,'link' => $base_link . $join_char .'p=' . $i,'class' => ( $i == $cur_page ) ? 'current' : 'link' );// class:priv,current,text,next
            }
        } else {
            for ($i=1; $i <= $total_page; $i++) { 
                if ( ($i < $cur_page - intval( $page_link_max / 2 ) && $i < ($total_page - $page_link_max) ) ||  ( $i > $cur_page + intval( $page_link_max / 2 ) && $i > $page_link_max ) ) {
                    continue;
                } else if( $i > $cur_page - intval( $page_link_max / 2 )  &&  $i <  $cur_page + intval( $page_link_max / 2 ) ){
                    $pager_data[$i] = array('text' => $i,'link' => $base_link . $join_char .'p=' . $i,'class' => ( $i == $cur_page ) ? 'current' : 'link' );// class:priv,current,text,next
                } else {
                    if ( ($i >=  $cur_page + intval( $page_link_max / 2 ) && $i < $page_link_max)  || ($i <= $cur_page - intval( $page_link_max / 2 ) && $i > ($total_page - $page_link_max) )  ) {
                        $pager_data[$i] = array('text' => $i,'link' => $base_link . $join_char .'p=' . $i,'class' => ( $i == $cur_page ) ? 'current' : 'link' );// class:priv,current,text,next
                    } else {
                        $pager_data[$i] = array('text' => '...','link' => '','class' => 'text' );// class:priv,current,text,next
                    }
                    
                }
            }
        }
        
        // “后一页”
        $pager_data['next'] = array('text' => '下一页','link' => $base_link . $join_char .'p=' . $next_page,'class' => 'next' );

        return $pager_data;
    }


    // private function get_cfg_data($){
    // } 

}