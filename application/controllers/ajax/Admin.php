<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Admin extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('member_model','board_model','visit_model'));
        $this->load->helper('cookie');
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();

    }
    public function admin_mode(){
        $post = $this->input->post(null, true);
        $mode = $post['mode'];
        $cookie = array(
            'name'   => 'admin_mode',
            'value'  => $mode,
            'expire' => '86500',
            'path'   => '/',
        );

        set_cookie($cookie);

        if(get_cookie('admin_mode', TRUE)){
            $result = 'success';
        }else{
            $result = 'fail';
        }
        echo json_encode($result);
    }
    public function popular_del(){
        $post = $this->input->post(null, true);
        $checkArray = explode(",",$post['checkArray']);

        unset($checkArray[0]);
        $checkArray = array_values($checkArray);



        foreach ( $checkArray as $key => $value){
            $send_data = array( 'idx' => $value);
            $list =  $this->board_model->set_porpula_del($send_data);

            if(empty($list)){
                $result = 'fail';
                break;
            }
            $result = 'success';
        }

        echo json_encode($result);
    }

    public function popular_set()
    {
        $post = $this->input->post(null, true);
        $send_date = array(
            'idx' => $post['idx']
        );

        $result = $this->board_model->set_popular($send_date);

        echo $result;
    }

    public  function file_delete(){
        $post = $this->input->post(null, true);

        $f_index = $post['idx'];

        $result =  $this->board_model->get_file_info_one($f_index);
        if(!$result){
            $send_result = 'fail';
        }
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html';
        $upload_dir = $upload_dir.$result->file_path.$result->f_rename;
        if(file_exists($upload_dir)){
            @unlink($upload_dir);
            $send_result = 'success';
        }else{
            $send_result = 'fail';
        }
        $result =  $this->board_model->set_file_delete_one($f_index);

        if($result){
            $send_result = 'success';
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);

    }
    public function check_pass(){
        $post = $this->input->post(null, true);

        $send_date = array(
            'b_index'   =>  $post['b_index'],
            'b_password'   =>  $post['pass'],
        );

        $result =  $this->board_model->get_password_check($send_date);
        if($result->cnt == '1'){
            $send_result = 'success';
            $ss_data = array(
                'b_index'      	=> $post['b_index'],
                'result'       	=> 1,
                'pass'       	=> $post['pass'],

            );
            $this->session->set_userdata($ss_data);
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }

    public function log_out(){
        $this->session->sess_destroy();
        $send_result = 'success';
        echo json_encode($send_result);
    }


    public function set_del(){
        $post = $this->input->post(null, true);
        if($post['mode'] == "admin"){
            $exec = '1';
        }else{
            $send_date = array(
                'b_index'   =>  $post['b_index'],
                'b_password'=>  $post['pass'],
                'mode'      =>  $post['mode'],
            );
            $result =  $this->board_model->get_password_check($send_date);
            $exec = $result->cnt;
        }

        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html';

        if($exec == '1'){
            $file_list =  $this->board_model->get_file($post['b_index'],'all');
            if(!empty($file_list)){
                foreach ($file_list as $key => $value){
                    @unlink($upload_dir.$value->file_path.$value->f_rename);
                    $temp_fname = explode('.', $value->f_rename);
                    $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                    if (in_array($temp_fname[1], $allow_file)) {
                        @unlink($upload_dir.$value->file_path . $temp_fname[0] . "_145x90." . $temp_fname[1]);
                    }
                }
            }
            $bbs_result =  $this->board_model->set_bbs_delete($send_date);
            $file_result =  $this->board_model->set_file_delete($send_date);

            $send_result = 'success';
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }

    public function referer(){
        $post = $this->input->post(null, true);
        $page = $post['page'];
        if(empty($post['page'])) $post['page'] = 1;

        $mode = $post['mode'];

        $table_name = 'referer';

        $p_data = array(
            'table_name' 	=> $table_name,
            'page'			=> $post['page'],
            'mode'          => $post['mode'],
            'start_date'    => $post['start_date'],
            'end_date'      => $post['end_date'],
            'list_rows'		=> 25,
            'page_no'		=> 10,
        );

        $result = $this->page_navi($p_data);

        $list_data = array(
            'table_name' 	=> $table_name,
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'start_date'    => $post['start_date'],
            'end_date'      => $post['end_date'],
            'mode'          => $post['mode'],
        );

        $list =  $this->visit_model->get_visit_list($list_data);


        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page' => $result['page'],
            'last_page' => $result['tot_page'],
            'per_page' => $result['list_rows'],
            'total' => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);
    }

    public function visit(){
        $post = $this->input->post(null, true);
        $page = $post['page'];
        if(empty($post['page'])) $post['page'] = 1;

        $mode = $post['mode'];
        if($mode == "new"){
            $table_name = 'visit_log';
        }else if($mode == "old2"){
            $table_name	= 'pagelog';
        }
        $p_data = array(
            'table_name' 	=> $table_name,
            'page'			=> $post['page'],
            'mode'          => $post['mode'],
            'start_date'    => $post['start_date'],
            'end_date'      => $post['end_date'],
            'list_rows'		=> 25,
            'page_no'		=> 10,
        );

        $result = $this->page_navi($p_data);

        $list_data = array(
            'table_name' 	=> $table_name,
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'start_date'    => $post['start_date'],
            'end_date'      => $post['end_date'],
            'mode'          => $post['mode'],
        );

        $list =  $this->visit_model->get_visit_list($list_data);


        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page' => $result['page'],
            'last_page' => $result['tot_page'],
            'per_page' => $result['list_rows'],
            'total' => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);
    }

    public function visit_view(){
        $post = $this->input->post(null, true);
        $view_type = $post['view_type'];

        $list_data = array(
            'view_date'    => $post['view_date'],
        );

        if($view_type == "ip"){
            $list = $this->visit_model->get_visit_ip_view($list_data);
        }else if($view_type == "page"){
            $list = $this->visit_model->get_visit_view($list_data);
        }
        $send_data = array (
            'list' => $list,
        );

        echo json_encode($send_data);
    }

    public function page_navi($params){
        $table_name = $params['table_name'];
        $page = $params['page'];
        $list_rows = $params['list_rows'];
        $page_no = $params['page_no'];
        $mode = $params['mode'];


        if(!$page) $page = 1;

        $data1 = array(
            'table_name'	=> $table_name,
            'mode'          => $params['mode'],
            'start_date'    => $params['start_date'],
            'end_date'      => $params['end_date'],
        );


        $total_rows = $this->visit_model->get_list_tot($data1);
        $page_start = ($page-1)*$list_rows;
        $tot_page = ceil($total_rows/$list_rows);
        $now_page_group = ceil($page/$page_no);
        $start_page	= ($now_page_group-1) * $page_no + 1;
        $end_page = ($now_page_group*$page_no);
        $tot_page_group = ceil($tot_page/$page_no);

        if($now_page_group > 1){
            $prev_page = $start_page - 1;
        }else{
            $prev_page =1;
        }

        if($now_page_group < $tot_page_group){
            $next_page = $end_page + 1;
        }else{
            $next_page='';
        }

        $result = array(
            'list_rows' 	=> $list_rows,
            'page_start' 	=> $page_start,
            'total_rows' 	=> $total_rows,
            'page' 			=> $page,
            'prev_page' 	=> $prev_page,
            'next_page' 	=> $next_page,
            'tot_page' 		=>$tot_page,
            'now_page_group' =>$now_page_group,
            'page_no' 		=>$page_no,
            'start_date'    => $params['start_date'],
            'end_date'      => $params['end_date'],

        );

        return $result;

    }








}
