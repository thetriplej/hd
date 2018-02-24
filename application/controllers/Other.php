<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/common.php';
class Other extends Common {


    public function  __construct() {
        parent::__construct();

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
        //echo phpinfo();

    }
    public function b2b()
    {

        if($this->lang_type == 'en') {
            $this->load->view('etc/e_b2b.phtml');
        }else{
            $this->load->view('etc/b2b.phtml');
        }
    }
    public function recruit()
    {
        if($this->lang_type == 'en') {
            $this->load->view('etc/e_recruit.phtml');
        }else{
            $this->load->view('etc/recruit.phtml');
        }
    }
    public function law()
    {
        if($this->lang_type == 'en') {
            $this->load->view('etc/e_law.phtml');
        }else{
            $this->load->view('etc/law.phtml');
        }
    }
    public function privacy()
    {
        if($this->lang_type == 'en') {
            $this->load->view('etc/e_privacy.phtml');
        }else{
            $this->load->view('etc/privacy.phtml');
        }
    }
    public function faq()
    {
        if($this->lang_type == 'en') {
            $this->load->view('etc/e_faq.phtml');
        }else{
            $this->load->view('etc/faq.phtml');
        }
    }
}
