<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

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
            $this->load->view('gallery/e_customer.phtml');
        }else{
            $this->load->view('gallery/customer.phtml');
        }

    }

    public function customerwWrite()
    {
        if($this->lang_type == 'en') {
            $this->load->view('gallery/e_customer_write.phtml');
        }else{
            $this->load->view('gallery/customer_write.phtml');
        }

    }
}
