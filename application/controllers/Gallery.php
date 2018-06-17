<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Gallery extends Common {

    public function  __construct() {
        parent::__construct();
        $this->load->model(array('board_model'));
        $this->load->helper('cookie');
    }

    function _remap($method) {

        if($this->agent_mode == "1") {
            $this->type ="";
            if ($this->lang_type == 'en') {
                $this->load->view('e_frame_top.phtml');
                $this->{$method}();
                $this->load->view('e_frame_bottom.phtml');
            } else {
                $this->load->view('frame_top.phtml');
                $this->{$method}();
                $this->load->view('frame_bottom.phtml');
            }

        }else{
            $this->type ="m/";
            $this->load->view('m_frame_top.phtml');
            $this->{$method}();
            $this->load->view('m_frame_bottom.phtml');

        }
    }

    public function index()
    {
        $this->customer();
    }
    public function customer()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer.phtml',$send_data);
        }else{
            $this->load->view($this->type.'gallery/customer.phtml',$send_data);
        }

    }

    public function customer_write()
    {
        $b_index = $this->input->get('b_index');
        $page = $this->input->get('page');
        $b_code = $this->input->get('b_code');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $session_b_index = $this->session->userdata('b_index');
        $session_b_pass = $this->session->userdata('pass');
        $session_pwd_checking = $this->session->userdata('b_index');
        if(!empty($b_index) && $b_index == $session_b_index && $session_pwd_checking =='1') {
            $view_send = array(
                'mode' => 'P',
                'id' => $b_index,
            );
            $view_data = $this->board_model->get_view($view_send);
            if($session_b_pass == $view_data->b_password) {

            }else{
                echo "<script type='text/javascript'>
                            alert('비밀번호가 일치하지 않습니다.');
					        history.back();
				        </script>";
                return;
            }
        }else{
            $view_data="";
        }
        $send_data = array(
            'b_index'       => $b_index,
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'view_data'     => $view_data,
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer_write.phtml',$send_data);
        }else{
            $this->load->view($this->type.'gallery/customer_write.phtml',$send_data);
        }

    }

    public function customer_view()
    {
        $b_index = $this->input->get('b_index');
        $page = $this->input->get('page');
        $b_code = $this->input->get('b_code');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'b_index'       => $b_index,
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
        );
        $view_send = array(
            'mode'   => 'P',
            'id'  => $b_index,
        );

        $view_data = $this->board_model->get_view($view_send);
        if(!empty($b_code)){
            $b_code = $view_data->b_code;
        }
        if($view_data->b_board_type == '0') {
            $image_data = $this->board_model->get_file($b_index,'image');

            foreach($image_data as $key => $value){
                $value->file_path = $value->file_path.$value->f_rename;
                if(intval($value->f_width) > 600){
                    $value->f_width = 600;
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
        $reply_view_data = $this->board_model->get_view($view_send);
        if(!empty($reply_view_data)) {
            $reply_id = $reply_view_data->b_index;
            if ($view_data->b_board_type == '0') {
                $reply_image_data = $this->board_model->get_file($reply_id,'image');

                foreach ($reply_image_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                    if (intval($value->f_width) > 600) {
                        $value->f_width = 600;
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
            'view_uri'              => $this->view_uri
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer_view.phtml',$view_array);
        }else{
            $this->load->view($this->type.'gallery/customer_view.phtml',$view_array);
        }

    }


    public function customer_store(){

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
        $b_content      =   $this->input->post("b_content",false);
        $b_locked       =   $this->input->post("b_locked");
        if(empty($b_locked)) $b_locked = "N";
        $attach_image   =   $this->input->post("attach_image[]",false);

        $today = date('Y-m');
        If(empty($b_title)) $b_title = '.';
        if($b_board_type != '0'){
            $b_title = htmlspecialchars($b_title);  //에디터 사용
            $b_writer = htmlspecialchars($b_writer);  //에디터 사용
            $b_email = htmlspecialchars($b_email);  //에디터 사용
            $b_content = htmlspecialchars($b_content);  //에디터 사용
        }else{
            $b_content = $b_content;
        }

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

        }else if($proc_type == "M"){    // 수정
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
                    var_dump($new_image);

                    if (!in_array($value->f_rename, $new_image)) {
                        var_dump($value->f_rename);
                        @unlink($upload_dir . $value->file_path . $value->f_rename);
                        $temp_fname = explode('.', $value->f_rename);
                        $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                        if (in_array($temp_fname[1], $allow_file)) {
                            @unlink($upload_dir . $value->file_path . $temp_fname[0] . "_145x90." . $temp_fname[1]);
                            @unlink($upload_dir . $value->file_path . $temp_fname[0] . "_origin." . $temp_fname[1]);
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
                    $file_result = true;
                } else {
                    $file_result = false;
                }
                $temp_fname = explode('.', $re_filename);
                $thum_file = $temp_fname[0] . "_145x90." . $temp_fname[1];

                if (rename($old_path . $thum_file, $path . $thum_file)) {
                    $file_result = true;
                } else {
                    $file_result = false;
                }
                $origin_file = $temp_fname[0] . "_origin." . $temp_fname[1];
                if (rename($old_path . $origin_file, $path . $origin_file)) {
                    $file_result = true;
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
            $ss_data = array(
                'b_index'      	=> '',
                'result'       	=> '',
            );
            //$this->session->unset_userdata($ss_data);
            redirect("/gallery/customer/?page=".$page."&b_code=".$b_code."&search_type=".$search_type."&search_value=".$search_value);
            exit;
        }else{
            echo "<script>alert('관리자에게 문의해주세요.');location.href='/gallery/customer/';</script>";
            exit;
        }

    }



    public function set_img2(){   //파일이동
        // boardfile 테이블에 날짜생성
        // update boardfile set boardfile.reg_date = (select board.b_regdate from board where board.b_index = boardfile.b_index) where reg_date is null

        // boardfile 테이블에 path생성
        //update boardfile set file_path = CONCAT('/upload/board/',left(reg_date,7),'/')

        // content img url 변경
//        update board set b_content = REPLACE(b_content, 'http://www.hassed.kr/upload/',  CONCAT('http://www.hassed.kr/public_html/upload/board/',left(b_regdate,7),'/'))
//update board set b_content = REPLACE(b_content, 'http://www.hassed.kr/upload2/',  CONCAT('http://www.hassed.kr/public_html/upload/board/',left(b_regdate,7),'/'))
//update board set b_content = REPLACE(b_content, 'http://www.hassed.co.kr/upload/',  CONCAT('http://www.hassed.co.kr/public_html/upload/board/',left(b_regdate,7),'/'))
//update board set b_content = REPLACE(b_content, 'http://www.hassed.co.kr/upload2/',  CONCAT('http://www.hassed.co.kr/public_html/upload/board/',left(b_regdate,7),'/'))

//        update board set b_content = REPLACE(b_content, '/upload/',  CONCAT('/public_html/upload/board/',left(b_regdate,7),'/'))
//        update board set b_content = REPLACE(b_content, '/upload2/',  CONCAT('/public_html/upload/board/',left(b_regdate,7),'/'))

//// 업데이트 안해도 됩 다음에디터에서 오류 풀url사용해야함
        //update board set b_content = REPLACE(b_content, 'http://www.hassed.kr/',  '/')
        //update board set b_content = REPLACE(b_content, 'http://www.hassed.co.kr/',  '/')
//update boardfile set f_rename = f_name where f_rename is null


        $result = $this->board_model->movie_img();
        //$old_path = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/upload/';

        $old_path = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/upload2/';
        $path = $_SERVER['DOCUMENT_ROOT'].'/public_html';
        foreach ($result as $key=>$value){
            $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html'.$value->file_path;
            if(!is_dir($upload_dir)){
                var_dump($upload_dir);
                mkdir($upload_dir, 0777);
            }
            if(file_exists($old_path.$value->f_name)) {
                var_dump($old_path.$value->f_name);
                if (rename($old_path . $value->f_name, $path.$value->file_path.$value->f_name)) {

                } else {
                    var_dump($old_path . $value->f_name);
                    var_dump($path.$value->file_path . $value->f_name);
                }
                $temp_fname = explode('.', $value->f_name);
                $thum_file = $temp_fname[0] . "_145x90." . $temp_fname[1];

                if (rename($old_path.$thum_file, $path.$value->file_path.$thum_file)) {

                } else {
                    $file_result = false;
                }
            }

        }
    }

    public function hmagajine(){
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_hmagajine.phtml',$send_data);
        }else{
            $this->load->view($this->type.'gallery/hmagajine.phtml',$send_data);
        }
    }

    public function hmagajine_view(){
        $b_index = $this->input->get('b_index');
        $page = $this->input->get('page');
        $b_code = $this->input->get('b_code');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'b_index'       => $b_index,
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
        );
        $view_send = array(
            'mode'   => 'P',
            'id'  => $b_index,
        );

        $view_data = $this->board_model->get_view($view_send);
        if(!empty($b_code)){
            $b_code = $view_data->b_code;
        }
        if($view_data->b_board_type == '0') {
            $image_data = $this->board_model->get_file($b_index,'image');

            foreach($image_data as $key => $value){
                $value->file_path = $value->file_path.$value->f_rename;
                if(intval($value->f_width) > 600){
                    $value->f_width = 600;
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
        $reply_view_data = $this->board_model->get_view($view_send);
        if(!empty($reply_view_data)) {
            $reply_id = $reply_view_data->b_index;
            if ($view_data->b_board_type == '0') {
                $reply_image_data = $this->board_model->get_file($reply_id,'image');

                foreach ($reply_image_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                    if (intval($value->f_width) > 600) {
                        $value->f_width = 600;
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
            'view_uri'              => $this->view_uri
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_hmagajine_view.phtml',$view_array);
        }else{
            $this->load->view($this->type.'gallery/hmagajine_view.phtml',$view_array);
        }
    }

}
