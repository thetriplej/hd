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
            'b_special'     => $b_special
        );
        $this->load->view('admin/notice.phtml',$send_data);
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
        }else if($b_code == "CEPILOGUE0"){
            $sub_title = "고객후기";
        }else if($b_code == "SEPILOGUE0"){
            $sub_title = "H_매거진";
        }else if($b_code == "QANDA0"){
            $sub_title = "Q&A";
        }else if($b_code == "NEWS0"){
            $sub_title = "영상자료";
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
            'view_uri'              => $this->view_uri,
            'sub_title'             => $sub_title,
        );


        $this->load->view('admin/bbs_view.phtml',$view_array);


    }

    public function notice_write()
    {
        $this->load->view('admin/notice_write.phtml');
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
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
            'b_special'     => $b_special,
            'porpula_list'     => $list
        );

        $this->load->view('admin/customer.phtml',$send_data);
    }

    public function customer_write()
    {
        $this->load->view('admin/customer_write.phtml');
    }
    public function magajine_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special
        );

        $this->load->view('admin/magajine.phtml',$send_data);
    }

    public function magajine_write()
    {
        $this->load->view('admin/magajine_write.phtml');
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
            'b_special'     => $b_special
        );
        $this->load->view('admin/qna.phtml',$send_data);
    }

    public function qna_write()
    {
        $this->load->view('admin/qna_write.phtml');
    }
}
