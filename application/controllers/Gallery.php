<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Gallery extends Common {

    public function  __construct() {
        parent::__construct();
        $this->load->model(array('board_model'));
        $this->output->enable_profiler(true);
    }

    function _remap($method) {

        if($this->lang_type == 'en' ){
            $this->load->view('e_frame_top.phtml');
            $this->{$method}();
            $this->load->view('e_frame_bottom.phtml');
        }else {
            $this->load->view('frame_top.phtml');
            $this->{$method}();
            $this->load->view('frame_bottom.phtml');
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
            $this->load->view('gallery/customer.phtml',$send_data);
        }

    }

    public function customer_write()
    {
        $page = $this->input->get('page');
        $b_code = $this->input->get('b_code');
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
        );

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer_write.phtml',$send_data);
        }else{
            $this->load->view('gallery/customer_write.phtml',$send_data);
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

        if($view_data->b_board_type == '0') {
            $image_data = $this->board_model->get_bbs_image($b_index);

            foreach($image_data as $key => $value){
                $value->file_path = $value->file_path.$value->f_rename;
                if(intval($value->f_width) > 600){
                    $value->f_width = 600;
                }
            }
        }else{
            $image_data = "";
        }
        $movie_data = $this->board_model->get_bbs_movie($b_index);
        if(!empty($movie_data)) {
            foreach ($movie_data as $key => $value) {
                $value->file_path = $value->file_path . $value->f_rename;
            }
        }

        $file_data = $this->board_model->get_bbs_file($b_index);

        $view_send = array(
            'mode'   => 'C',
            'id'  => $b_index,
        );
        $reply_view_data = $this->board_model->get_view($view_send);
        if(!empty($reply_view_data)) {
            $reply_id = $reply_view_data->b_index;
            if ($view_data->b_board_type == '0') {
                $reply_image_data = $this->board_model->get_bbs_image($reply_id);

                foreach ($reply_image_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                    if (intval($value->f_width) > 600) {
                        $value->f_width = 600;
                    }
                }
            } else {
                $reply_image_data = "";
            }
            $reply_movie_data = $this->board_model->get_bbs_movie($reply_id);
            if (!empty($reply_movie_data)) {
                foreach ($reply_movie_data as $key => $value) {
                    $value->file_path = $value->file_path . $value->f_rename;
                }
            }

            $reply_file_data = $this->board_model->get_bbs_file($reply_id);
        }else{
            $reply_image_data ="";
            $reply_movie_data ="";
            $reply_file_data ="";
        }
        $view_array = array(
            'view_data'     => $view_data,
            'image_data'    => $image_data,
            'movie_data'    => $movie_data,
            'file_data'     => $file_data,
            'reply_view_data'    => $reply_view_data,
            'reply_image_data'    => $reply_image_data,
            'reply_movie_data'    => $reply_movie_data,
            'reply_file_data'     => $reply_file_data,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'page'          => $page,
            'b_index'       => $b_index,
        );
        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer_view.phtml',$view_array);
        }else{
            $this->load->view('gallery/customer_view.phtml',$view_array);
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
        $b_writer       =   $this->input->post("b_writer");
        $b_password     =   $this->input->post("b_password");
        $b_title        =   $this->input->post("b_title");
        if(empty($b_title)) $b_title = ".";
        $b_email        = $this->input->post("b_email1")."@".$this->input->post("b_email2");
        $b_content      =   $this->input->post("b_content");
        $b_locked       =   $this->input->post("b_locked");
        if(empty($b_locked)) $b_locked = "N";
        $attach_image   =   $this->input->post("attach_image[]",false);
        $new_attach_image = array();
        $today = date('Y-m');
        if(!empty($attach_image)) {
            foreach ($attach_image as $key => $value) {
                $new_attach_image[$key] = $this->input->post("attach_image[" . $key . "]", true);
            }
            $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/board/'.$today;
            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777);
            }
        }
        $attach_image = $new_attach_image;
        $select_img     =   $this->input->post("select_img");

        if($proc_type == "NW"){
            If(empty($b_title)) $b_title = '.';
            if($b_board_type != '0'){
                $b_content = htmlspecialchars($b_content);  //에디터 사용
            }else{
                $b_content = $b_content;
            }
        }
        $b_content = str_replace ("/temp","/".$today,$b_content);
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
            'file_path'     =>   'upload/board/'.$today.'/',
            'b_group'       =>   $max_group_no->max_group
        );
        $result = $this->board_model->set_bbs_save($send_data);

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

        if($result && $file_result){
            redirect("/gallery/?page=".$page."&b_code=".$b_code."&search_type=".$search_type."&search_value=".$search_value);
            exit;
        }else{
            echo "<script>alert('관리자에게 문의해주세요.');location.href='/gallery/';</script>";
            exit;
        }

    }



    public function set_img(){
        $result = $this->board_model->set_img();
    }

}
