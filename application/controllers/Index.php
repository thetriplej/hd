<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Index extends Common {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function  __construct() {
        parent::__construct();
        $this->load->helper('url'); //Loading url helper

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

        if ($this->lang_type == 'en') {
            $this->load->view('e_index.phtml');
        } else {
            $this->load->view($this->type.'index.phtml');
        }


    }
}
