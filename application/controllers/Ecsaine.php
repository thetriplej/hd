<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Ecsaine extends Common {

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

        $this->material();

    }
    public function material()
    {
        if($this->lang_type == 'en') {
            $this->load->view('ecsaine/e_material.phtml');
        }else{
            $this->load->view('ecsaine/material.phtml');
        }
    }
    public function strongpoint()
    {
        if($this->lang_type == 'en') {
            $this->load->view('ecsaine/e_strongpoint.phtml');
        }else{
            $this->load->view('ecsaine/strongpoint.phtml');
        }
    }
    public function maintain()
    {
        if($this->lang_type == 'en') {
            $this->load->view('ecsaine/e_maintain.phtml');
        }else{
            $this->load->view('ecsaine/maintain.phtml');
        }
    }
}
