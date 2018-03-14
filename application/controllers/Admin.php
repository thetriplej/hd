<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Admin extends Common {

    public function  __construct() {
        parent::__construct();
        $this->load->model(array('member_model','board_model'));
    }

    function _remap($method) {

        $send_data = array(
            'user_id'   => $this->session->userdata('userid'),
            'level'     => $this->session->userdata('level'),
            'user_name' => $this->session->userdata('username'),
        );
        if($method != "index") {
            $this->load->view('admin_top.phtml',$send_data);
            $this->{$method}();
            $this->load->view('admin_bottom.phtml');
        }else{
            $this->{$method}();
        }

    }

    public function index()
    {
        $this->load->view('admin/index.phtml');
    }
    public function login()
    {
        $post = $this->input->post(null, true);
        $id = $post['id'];
        $password = $post['password'];

    }
    public function notice_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'FREEBOARD0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');


        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'menu_title'    => "헷세드공지",
            'menu_ajax_url' => 'get_notice_list',
            'bbs_write'     => 'notice_write',
            'list_uri'      => '/admin/notice_list'
        );
        $this->load->view('admin/bbs_list.phtml',$send_data);
    }

    public function notice_write()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'FREEBOARD0';
        $b_index = $this->input->get('b_index');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        if(!empty($b_index)){
            $result = $this->bbs_file($b_index);
            $file_data = $result['file_data'];
            $b_board_type = $result['b_board_type'];
        }else{
            $file_data ="";
            $b_board_type = "";
        }

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'b_index'       => $b_index,
            'menu_title'    => "헷세드공지",
            'menu_ajax_url' => 'get_notice_list',
            'bbs_write'     => 'notice_write',
            'file_data'     => $file_data,
            'b_board_type'   => $b_board_type,
        );
        if(!empty($b_index)){
            $this->load->view('admin/bbs_modify.phtml', $send_data);
        }else {
            $this->load->view('admin/bbs_write.phtml', $send_data);
        }
    }

    public function bbs_view()
    {
        $b_index = $this->input->get('b_index');
        $page = $this->input->get('page');
        $b_code = $this->input->get('b_code');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        if($b_code == "FREEBOARD0"){
            $sub_title = "헷세드공지";
            $list_uri = 'notice_list';
            $edit_uri = 'notice_write';
        }else if($b_code == "CEPILOGUE0"){
            $sub_title = "고객후기";
            $list_uri = 'customer_list';
            $edit_uri = 'customer_write';
        }else if($b_code == "SEPILOGUE0"){
            $sub_title = "H_매거진";
            $list_uri = 'magajine_list';
            $edit_uri = 'magajine_write';
        }else if($b_code == "QANDA0"){
            $sub_title = "Q&A";
            $list_uri = 'qna_list';
            $edit_uri = 'qna_write';
        }else if($b_code == "NEWS0"){
            $sub_title = "영상자료";
            $list_uri = 'news_list';
            $edit_uri = 'news_write';
        }

        $send_data = array(
            'b_index'       => $b_index,
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
        );
        $view_send = array(
            'id'  => $b_index,
        );

        $view_data = $this->board_model->get_admin_view($view_send);

        if(!empty($b_code)){
            $b_code = $view_data->b_code;
        }
        if($view_data->b_board_type == '0') {
            $image_data = $this->board_model->get_file($b_index,'all');

            foreach($image_data as $key => $value){
                $value->file_path = $value->file_path.$value->f_rename;
                if(intval($value->f_width) > 780){
                    $value->f_width = 780;
                }
            }
        }else if($view_data->b_board_type == '1') {
            $image_data = $this->board_model->get_file($b_index,'notall');

            foreach($image_data as $key => $value){
                $value->file_path = $value->file_path.$value->f_rename;
                if(intval($value->f_width) > 780){
                    $value->f_width = 780;
                }
            }
        }else{
            $image_data = "";
        }
        $movie_data = $this->board_model->get_file($b_index,'movie');
        if(!empty($movie_data)) {
            foreach ($movie_data as $key => $value) {
                $value->file_path = "http://".$_SERVER["HTTP_HOST"]."/public_html".$value->file_path . $value->f_rename;
            }
        }

        $file_data = $this->board_model->get_file($b_index,'file');

        $view_send = array(
            'mode'   => 'C',
            'id'  => $b_index,
        );
        $reply_file_data = $this->board_model->get_file($b_index,'file');
        if (!empty($reply_file_data)) {
            foreach ($reply_file_data as $key => $value) {
                $value->file_path = $value->file_path.$value->f_rename;
            }
        }
        if(!empty($reply_view_data)) {
            $reply_id = $reply_view_data->b_index;
            if ($view_data->b_board_type == '0') {
                $reply_image_data = $this->board_model->get_file($reply_id,'image');

                foreach ($reply_image_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                    if (intval($value->f_width) > 780) {
                        $value->f_width = 780;
                    }
                }
            } else {
                $reply_image_data = "";
            }
            $reply_movie_data = $this->board_model->get_file($reply_id,'movie');
            if (!empty($reply_movie_data)) {
                foreach ($reply_movie_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                }
            }

            $reply_file_data = $this->board_model->get_file($reply_id,'file');
            if (!empty($reply_file_data)) {
                foreach ($reply_file_data as $key => $value) {
                    $value->file_path = $value->file_path.$value->f_rename;
                }
            }
        }else{
            $reply_image_data ="";
            $reply_movie_data ="";
            $reply_file_data ="";
            $reply_view_data ="";
        }
        $view_array = array(
            'view_data'             => $view_data,
            'image_data'            => $image_data,
            'movie_data'            => $movie_data,
            'file_data'             => $file_data,
            'reply_view_data'       => $reply_view_data,
            'reply_image_data'      => $reply_image_data,
            'reply_movie_data'      => $reply_movie_data,
            'reply_file_data'       => $reply_file_data,
            'b_code'                => $b_code,
            'search_type'           => $search_type,
            'search_value'          => $search_value,
            'page'                  => $page,
            'b_index'               => $b_index,
            'view_uri'              => $this->view_uri,
            'sub_title'             => $sub_title,
            'list_uri'              => $list_uri,
            'edit_uri'              => $edit_uri
        );
        $this->load->view('admin/bbs_view.phtml',$view_array);
    }

    public function bbs_store(){

        $b_code         =   $this->input->post("b_code");
        $page           =   $this->input->post("page");
        $search_type    =   $this->input->post("search_type ");
        $search_value   =   $this->input->post("search_value");
        $proc_type      =   $this->input->post("proc_type");
        $b_depth        =   $this->input->post("b_depth");
        $b_parentindex  =   $this->input->post("b_parentindex");
        $b_board_type   =   $this->input->post("b_board_type");
        $b_index        =   $this->input->post("b_index");
        $select_img     =   $this->input->post("select_img");
        if(empty($select_img)) $select_img = 0;
        $b_writer       =   $this->input->post("b_writer");
        $b_password     =   $this->input->post("b_password");
        $b_title        =   $this->input->post("b_title");
        if(empty($b_title)) $b_title = ".";
        $b_email        = $this->input->post("b_email1")."@".$this->input->post("b_email2");
        $b_content      =   $this->input->post("b_content");
        $b_locked       =   $this->input->post("b_locked");

        if(empty($b_locked)) $b_locked = "N";
        $attach_image   =   $this->input->post("attach_image[]",false);

        $today = date('Y-m');

        $new_attach_image = array();
        if($proc_type == "NW"){ // 신규등록
            if(!empty($attach_image)) {
                foreach ($attach_image as $key => $value) {
                    $new_attach_image[$key] = $this->input->post("attach_image[" . $key . "]", true);
                }
                $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/board/'.$today;
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir, 0777);
                }
                $attach_image = $new_attach_image;
            }
            if(!empty($files)){

            }
            If(empty($b_title)) $b_title = '.';
            if($b_board_type != '0'){
                $b_content = htmlspecialchars($b_content);  //에디터 사용
            }else{
                $b_content = $b_content;
            }
            $b_writer = "HASSED";
			$b_password = "1234567890";
        }else if($proc_type == "M"){    // 수정
            $b_writer = "HASSED";
            $b_password = "1234567890";
            $old_image = array();
            $new_image = array();
            $image_data = $this->board_model->get_file($b_index,'image');
            $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html';
            foreach($image_data as $key => $value){
                $old_image[$key] = $value->f_rename;
            }
            if(!empty($attach_image)) {
                foreach ($attach_image as $key => $value) { //수정시 기존이미지 이미지 추가배열에서 삭제
                    $temp_image = explode('|', $attach_image[$key]);
                    $re_filename = $temp_image[0];
                    $new_image[$key] = $re_filename;
                    if (in_array($re_filename, $old_image)) unset($attach_image[$key]);
                }

                foreach ($image_data as $key => $value) {

                    if (!in_array($value->f_rename, $new_image)) {
                        var_dump($value->f_rename);
                        @unlink($upload_dir . $value->file_path . $value->f_rename);
                        $temp_fname = explode('.', $value->f_rename);
                        $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                        if (in_array($temp_fname[1], $allow_file)) {
                            @unlink($upload_dir . $value->file_path . $temp_fname[0] . "_145x90." . $temp_fname[1]);
                        }
                        $del_result = $this->board_model->set_file_delete_one($value->f_index);
                    }
                }
            }

        }

        $old_path = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/temp/';
        $path = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/board/'.$today.'/';
        $file_result = true;
        if(!empty($attach_image)) {
            foreach ($attach_image as $key => $value) {
                $temp_image = explode('|', $attach_image[$key]);
                $re_filename = $temp_image[0];

                if (rename($old_path . $re_filename, $path . $re_filename)) {

                } else {
                    $file_result = false;
                }
                $temp_fname = explode('.', $re_filename);
                $thum_file = $temp_fname[0] . "_145x90." . $temp_fname[1];

                if (rename($old_path . $thum_file, $path . $thum_file)) {

                } else {
                    $file_result = false;
                }

            }
        }

        $b_content = str_replace ("/temp","/board/".$today,$b_content);
        $max_group_no = $this->board_model->get_last_group_no();

        $send_data = array(
            'b_code'        =>   $b_code,
            'proc_type'     =>   $proc_type,
            'b_depth'       =>   $b_depth,
            'b_parentindex' =>   $b_parentindex,
            'b_board_type'  =>   $b_board_type,
            'b_index'       =>   $b_index,
            'select_img'    =>   $select_img,
            'b_writer'      =>   $b_writer,
            'b_password'    =>   $b_password,
            'b_title'       =>   $b_title,
            'b_email'       =>   $b_email ,
            'b_content'     =>   $b_content,
            'b_locked'      =>   $b_locked,
            'attach_image'  =>   $attach_image,
            'select_img'    =>   $select_img,
            'file_path'     =>   '/upload/board/'.$today.'/',
            'b_group'       =>   $max_group_no->max_group
        );

        $result = $this->board_model->set_bbs_save($send_data);

        if($result && $file_result){
            ini_set("memory_limit", "-1");

            //$url = '/public_html/d_editor/pages/trex/image.php?callback_func='.$_REQUEST["callback_func"];
            $upload_file    = $_FILES['files']['name'];
            $upload_tmp     = $_FILES['files']['tmp_name'];
            $upload_type    = $_FILES['files']['type'];

            $send_data = array();
            $fCnt = count($upload_file);
            $today = date('Y-m');

            for($i=0;$i<$fCnt;$i++){
                $bSuccessUpload = is_uploaded_file($_FILES['files']['tmp_name'][$i]);
                $img_info = array();
                if($bSuccessUpload) {
                    $tmp_name = $_FILES['files']['tmp_name'][$i];
                    $name = $_FILES['files']['name'][$i];
                    $size = $_FILES['files']['size'][$i];
                    $upload_type = $_FILES['files']['type'][$i];

                    $filename_ext = strtolower(substr(strrchr($name,"."),1));	//확장자앞 .을 제거하기 위하여 substr()함수를 이용

                    $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/board/'.$today.'/';
                    if(!is_dir($upload_dir)){
                        mkdir($upload_dir, 0777);
                    }
                    $file_rename = date("Ymd")."_".time().rand(0,100000);
                    $setPath = $upload_dir.$file_rename;

                    if(move_uploaded_file($tmp_name, $setPath.'.'.$filename_ext)){
                        $send_data = array(
                            'b_code'    => $b_code,
                            'b_index'   => $b_index,
                            'f_name'    => $name,
                            'f_type'    => $upload_type,
                            'f_width'   => '-1',
                            'f_size'    => $size,
                            'f_rename'  => $file_rename.'.'.$filename_ext,
                            'list_img'  => '',
                            'file_path' => '/upload/board/'.$today.'/',
                        );
                        $file_result2 = $this->board_model->set_files($send_data);
                    }
                }
            }

            redirect("/admin/bbs_view?b_index=".$result."&page=".$page."&b_code=".$b_code."&search_type=".$search_type."&search_value=".$search_value);
            exit;
        }else{
            echo "<script>alert('관리자에게 문의해주세요.');location.href='/gallery/';</script>";
            exit;
        }
    }

    public function customer_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $list =  $this->board_model->get_admin_porpula_list();

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'menu_title'    => "고객후기",
            'menu_ajax_url' => 'get_gallery_list',
            'porpula_list'  => $list,
            'bbs_write'     => 'customer_write',
            'list_uri'      => '/admin/customer_list'
        );

        $this->load->view('admin/bbs_list.phtml',$send_data);
    }

    public function customer_write()
    {

        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');
        $b_index = $this->input->get('b_index');

        $list =  $this->board_model->get_admin_porpula_list();
        if(!empty($b_index)){
            $result = $this->bbs_file($b_index);
            $file_data = $result['file_data'];
            $b_board_type = $result['b_board_type'];
        }else{
            $file_data ="";
            $b_board_type = "";
        }

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'menu_title'    => "고객후기",
            'menu_ajax_url' => 'get_gallery_list',
            'porpula_list'  => $list,
            'bbs_write'     => 'customer_write',
            'b_index'       => $b_index,
            'file_data'     => $file_data,
            'b_board_type'   => $b_board_type,
        );

        if(!empty($b_index)){
            $this->load->view('admin/bbs_modify.phtml', $send_data);
        }else {
            $this->load->view('admin/bbs_write.phtml', $send_data);
        }
    }

    public function magajine_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'SEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'menu_title'    => "H_매거진",
            'menu_ajax_url' => 'get_magajine_list',
            'bbs_write'     => 'magajine_write',
            'list_uri'      => '/admin/magajine_list'
        );

        $this->load->view('admin/bbs_list.phtml',$send_data);
    }

    public function magajine_write()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'SEPILOGUE0';
        $b_index = $this->input->get('b_index');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');
        if(!empty($b_index)){
            $result = $this->bbs_file($b_index);
            $file_data = $result['file_data'];
            $b_board_type = $result['b_board_type'];
        }else{
            $file_data ="";
            $b_board_type = "";
        }
        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special,
            'menu_title'    => "H_매거진",
            'menu_ajax_url' => 'get_magajine_list',
            'bbs_write'     => 'magajine_write',
            'b_index'       => $b_index,
            'file_data'     => $file_data,
            'b_board_type'   => $b_board_type,
        );

        if(!empty($b_index)){
            $this->load->view('admin/bbs_modify.phtml', $send_data);
        }else {
            $this->load->view('admin/bbs_write.phtml', $send_data);
        }

    }
    public function qna_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'QANDA0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'view_uri'      => $this->view_uri,
            'b_special'     => $b_special,
            'menu_title'    => "Q&A",
            'menu_ajax_url' => 'get_qna_list',
            'bbs_write'     => 'qna_write',
            'list_uri'      => '/admin/qna_list'
        );
        $this->load->view('admin/bbs_list.phtml',$send_data);
    }

    public function qna_write()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'QANDA0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');
        $b_index = $this->input->get('b_index');
        if(!empty($b_index)){
            $result = $this->bbs_file($b_index);
            $file_data = $result['file_data'];
            $b_board_type = $result['b_board_type'];
        }else{
            $file_data ="";
            $b_board_type = "";
        }
        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'view_uri'      => $this->view_uri,
            'b_special'     => $b_special,
            'menu_title'    => "Q&A",
            'menu_ajax_url' => 'get_qna_list',
            'bbs_write'     => 'qna_write',
            'b_index'       => $b_index,
            'file_data'     => $file_data,
            'b_board_type'   => $b_board_type,
        );
        if(!empty($b_index)){
            $this->load->view('admin/bbs_modify.phtml', $send_data);
        }else {
            $this->load->view('admin/bbs_write.phtml', $send_data);
        }
    }

    public function bbs_file($b_index){
        $view_send = array(
            'mode'   => 'P',
            'id'  => $b_index,
        );
        $bbs_view = $this->board_model->get_view($view_send);

        if($bbs_view->b_board_type == 0) {
            $file_data = $this->board_model->get_file($b_index, 'all');
        }else{
            $file_data = $this->board_model->get_file($b_index, 'notall');
        }

        foreach($file_data as $key => $value){

            $mType = explode("/",$value->f_type);
            if($mType[0] != 'image') {
                $value->file_path = $value->file_path . $value->f_rename;
            }else {
                if (intval($value->f_width) > 780) {
                    $value->f_width = 780;
                }
                $temp_fname = explode('.', $value->f_rename);
                $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                if (in_array($temp_fname[1], $allow_file)) {
                    $value->file_path = '/public_html' . $value->file_path . $temp_fname[0];
                }
            }
        }
        $send_data = array(
            'file_data' => $file_data,
            'b_board_type'  =>$bbs_view->b_board_type,
        );

        return $send_data;

    }
}
