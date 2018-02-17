<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {


    public function  __construct() {
        parent::__construct();
        $this->load->helper('url'); //Loading url helper
        $this->load->library('utilcommon');

        if($this->utilcommon->get_mobile_check() === true){
            //  echo "<script>alert('mobile')</script>";
        }else{
            //   echo "<script>alert('PC')</script>";
        }
        $this->load->library('user_agent');
        //var_dump($this->agent->referrer());
        $this->lang_type = get_cookie('tj_lang_type');
        $this->load->model(array('board_model'));
        $this->load->library('pagination');

    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();

    }

    public function get_porpula_list(){

        $list =  $this->board_model->get_porpula_list();
        foreach ( $list as $key => $value){
            if($value->B_Board_Type == 0){
                $path = '/public_html/upload/upload/';
            }else{
                $path = '/public_html/upload/upload2/';
            }
            $value->F_Name = $path.$value->F_Name;
        }

        echo json_encode($list);

    }
    public function get_gallery_list(){

        $post = $this->input->post(null, true);

        $p_data = array(
            'table_name' 	=> 'board',
            'search_type'	=> $post['search_type'],
            'search_value'   => $post['search_value'],
            'page'			=> $post['page'],
            'board_type'    => 'CEPILOGUE0',
            'list_rows'		=> 12,
            'page_no'		=> 10,

        );
        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'   => $post['search_value'],
            'board_type'    => 'CEPILOGUE0',
        );

        $list =  $this->board_model->get_gallery_list($list_data);


        foreach ( $list as $key => $value){
            if($value->B_Board_Type == 0){
                $path = '/public_html/upload/upload/';
            }else{
                $path = '/public_html/upload/upload2/';
            }
            $temp_fname = explode ('.',$value->F_Name);
            $value->F_Name = $path.$temp_fname[0]."_145x90.".$temp_fname[1];
        }
//        $result = array(
//            'list_rows' 	=> $list_rows,
//            'page_start' 	=> $page_start,
//            'total_rows' 	=> $total_rows,
//            'page' 			=> $page,
//            'prev_page' 	=> $prev_page,
//            'next_page' 	=> $next_page,
//            'tot_page' 		=>$tot_page,
//            'now_page_group' =>$now_page_group,
//            'page_no' 		=>$page_no,
//
//        );
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

    public function page_navi($params){
        $table_name = 'board';
        $page = $params['page'];
        $search_type = $params['search_type'];
        $search_value = $params['search_value'];
        $board_type = $params['board_type'];
        $list_rows = $params['list_rows'];
        $page_no = $params['page_no'];


        if(!$page) $page = 1;

        $data1 = array(
            'table_name'	=> $table_name,
            'board_type'	=> $board_type,
            'search_type'	=> $search_type,
            'search_value'   => $search_value,
        );


        $total_rows = $this->board_model->get_list_tot($data1);
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

        );

        return $result;

    }

    public function gallery_file_upload(){

        $post = $this->input->post(null, true);
        var_dump($post);exit;
// default redirection
        $url = 'callback.html?callback_func='.$_REQUEST["callback_func"];

        $upload_file    = $_FILES['attachFile']['name'];
        $upload_tmp        = $_FILES['attachFile']['tmp_name'];
        $upload_type    = $_FILES['attachFile']['type'];

        $fCnt = count($upload_file);

        for($i=0;$i<$fCnt;$i++)
        {
            $bSuccessUpload = is_uploaded_file($_FILES['attachFile']['tmp_name']);
            $today = date('Y-m');
// SUCCESSFUL
            if(bSuccessUpload) {
                $tmp_name = $_FILES['attachFile']['tmp_name'];
                $name = $_FILES['attachFile']['name'];

                $filename_ext = strtolower(array_pop(explode('.',$name)));
                $allow_file = array("jpg", "png", "bmp", "gif");

                if(!in_array($filename_ext, $allow_file)) {
                    $url .= '&errstr='.$name;
                } else {
                    $uploadDir = '/public_html/upload/upload2/'.$today;
                    if(!is_dir($uploadDir)){
                        mkdir($uploadDir, 0777);
                    }

                    $newPath = $uploadDir.urlencode($_FILES['attachFile']['name']);

                    @move_uploaded_file($tmp_name, $newPath);

                    $url .= "&bNewLine=true";
                    $url .= "&sFileName=".urlencode(urlencode($name));
                    $url .= "&sFileURL=/public_html/upload/upload2/".$today."/".urlencode(urlencode($name));
                }
            }
// FAILED
            else {
                $url .= '&errstr=error';
            }
        }

        header('Location: '. $url);
    }



}
