<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Admin extends Common {

    public function  __construct() {
        parent::__construct();

    }

    function _remap($method) {

        if($method != "index") {
            $this->load->view('frame_top.phtml');
            $this->{$method}();
            $this->load->view('frame_bottom.phtml');
        }else{
            $this->{$method}();
        }

    }

    public function index()
    {
        $this->load->view('admin/index.phtml');
    }
    public function company()
    {
        if($this->lang_type == 'en') {
            $this->load->view('aboutus/e_company.phtml');
        }else{
            $this->load->view('aboutus/company.phtml');
        }
    }
    public function brand()
    {
        if($this->lang_type == 'en') {
            $this->load->view('aboutus/e_brand.phtml');
        }else{
            $this->load->view('aboutus/brand.phtml');
        }
    }
    public function ceo()
    {
        if($this->lang_type == 'en') {
            $this->load->view('aboutus/e_ceo.phtml');
        }else{
            $this->load->view('aboutus/ceo.phtml');
        }
    }
    public function shop_info()
    {
        $type = $this->input->get('location');
        $send_data = array(
            'type' => $type
        );
        if($this->lang_type == 'en') {
            $this->load->view('aboutus/e_shop_info.phtml',$send_data);
        }else{
            $this->load->view('aboutus/shop_info.phtml',$send_data);
        }
    }
}
