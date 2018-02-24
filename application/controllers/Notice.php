<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/common.php';
class Notice extends Common {

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
        $this->customer();
    }

    public function customer()
    {
        $this->load->view('index.phtml');
    }
}
