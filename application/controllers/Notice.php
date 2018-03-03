<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Notice extends Common {

    public function  __construct() {
        parent::__construct();
        $this->load->model(array('board_model'));
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

    public function notice()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'FREEBOARD0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
        );

        if($this->lang_type == 'en') {
            $this->load->view('notice/e_notice.phtml',$send_data);
        }else{
            $this->load->view('notice/notice.phtml',$send_data);
        }

    }

    public function notice_view()
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
            $this->load->view('notice/e_notice_view.phtml',$view_array);
        }else{
            $this->load->view('notice/notice_view.phtml',$view_array);
        }

    }

    public function qna()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'QANDA0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
        );

        if($this->lang_type == 'en') {
            $this->load->view('notice/e_qna.phtml',$send_data);
        }else{
            $this->load->view('notice/qna.phtml',$send_data);
        }

    }

    public function faq()
    {
        if($this->lang_type == 'en') {
            $this->load->view('notice/e_faq.phtml');
        }else{
            $this->load->view('notice/faq.phtml');
        }
    }
}
