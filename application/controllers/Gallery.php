<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

    public function  __construct() {
        parent::__construct();
        $this->load->helper('url'); //Loading url helper
        $this->load->helper(array('form', 'url'));
        $this->load->library('utilcommon');
        if($this->utilcommon->get_mobile_check() === true){
            //  echo "<script>alert('mobile')</script>";
        }else{
            //   echo "<script>alert('PC')</script>";
        }
        $this->load->library('user_agent');
        //var_dump($this->agent->referrer());
        $this->lang_type = get_cookie('tj_lang_type');
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

        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer.phtml',array('b_code'=>'CEPILOGUE0'));
        }else{
            $this->load->view('gallery/customer.phtml',array('b_code'=>'CEPILOGUE0'));
        }

    }

    public function customer_write()
    {
        $page = $_GET['page'];
        $b_code = $_GET['b_code'];
        $search_type = $_GET['search_type'];
        $search_value = $_GET['search_value'];

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


    public function customer_store(){
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);
        var_dump(1);
        $post = $this->input->post(null, true);
        var_dump($post);exit;
        $send_data = array();
        //echo json_encode($send_data);
    }

    public function customer_view(){
        //SQL = "UPDATE Board SET B_Hit = B_Hit + 1 WHERE B_Index = '"&B_Index&"'"
    }


}
