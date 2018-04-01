<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Other extends Common {


    public function  __construct() {
        parent::__construct();

    }

    function _remap($method) {

        if($this->agent_mode == "1") {
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
            $this->load->view('m_frame_top.phtml');
            $this->{$method}();
            $this->load->view('m_frame_bottom.phtml');
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

    public function file_down()
    {
        $this->load->helper('download');
        $path = $this->input->get('path');

        $filepath = $path;

        $filepath = $_SERVER['DOCUMENT_ROOT'].'/public_html'.$filepath;
        $filesize = filesize($filepath);
        $tmp = explode('/',$filepath);
        $filename = end($tmp);

        if(file_exists($filepath)){

            force_download($filepath, NULL);

        }else{
            $result = array('downstate'  =>  'notfile');

        }
        echo json_encode($result);
    }

}
