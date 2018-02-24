<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Product extends Common {


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
        if($this->lang_type == 'en') {
            $this->load->view('product/e_becky.phtml');
        }else{
            $this->load->view('product/becky.phtml');
        }
    }
    public function detail_view()
    {
        if($this->lang_type == 'en') {
            $lang_type = 'e_';
        }else{
            $lang_type='';
        }
        $type = $this->input->get('code');
        switch ($type) {
            case 'becky' :
                $this->load->view('product/'.$lang_type.'becky.phtml');
                break;
            case 'arriba' :
                $this->load->view('product/'.$lang_type.'arriba.phtml');
                break;
            case 'calix' :
                $this->load->view('product/'.$lang_type.'calix.phtml');
                break;
            case 'ailish' :
                $this->load->view('product/'.$lang_type.'ailish.phtml');
                break;
            case 'whistle' :
                $this->load->view('product/'.$lang_type.'whistle.phtml');
                break;
            case 'besso' :
                $this->load->view('product/'.$lang_type.'besso.phtml');
                break;
            case 'floria' :
                $this->load->view('product/'.$lang_type.'floria.phtml');
                break;
            case 'francis' :
                $this->load->view('product/'.$lang_type.'francis.phtml');
                break;
            case 'bambi' :
                $this->load->view('product/'.$lang_type.'bambi.phtml');
                break;
            case 'adela' :
                $this->load->view('product/'.$lang_type.'adela.phtml');
                break;
            case 'esther' :
                $this->load->view('product/'.$lang_type.'esther.phtml');
                break;
            case 'provence' :
                $this->load->view('product/'.$lang_type.'provence.phtml');
                break;
            case 'crane' :
                $this->load->view('product/'.$lang_type.'crane.phtml');
                break;
            case 'amore' :
                $this->load->view('product/'.$lang_type.'amore.phtml');
                break;
            case 'twinsofa' :
                $this->load->view('product/'.$lang_type.'twinsofa.phtml');
                break;
            case 'swingchair' :
                $this->load->view('product/'.$lang_type.'swingchair.phtml');
            break;

        }
    }
}
