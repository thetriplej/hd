<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
        $this->load->view('frame_top.phtml');
        $this->{$method}();
        $this->load->view('frame_bottom.phtml');
    }

    public function index()
    {
        $this->load->view('product/becky.phtml');
    }
    public function detail_view()
    {
        $type = $this->input->get('code');
        switch ($type) {
            case 'becky' :
                $this->load->view('product/becky.phtml');
                break;
            case 'arriba' :
                $this->load->view('product/arriba.phtml');
                break;
            case 'calix' :
                $this->load->view('product/calix.phtml');
                break;
            case 'ailish' :
                $this->load->view('product/ailish.phtml');
                break;
            case 'whistle' :
                $this->load->view('product/whistle.phtml');
                break;
            case 'besso' :
                $this->load->view('product/besso.phtml');
                break;
            case 'floria' :
                $this->load->view('product/floria.phtml');
                break;
            case 'francis' :
                $this->load->view('product/francis.phtml');
                break;
            case 'bambi' :
                $this->load->view('product/bambi.phtml');
                break;
            case 'adela' :
                $this->load->view('product/adela.phtml');
                break;
            case 'esther' :
                $this->load->view('product/esther.phtml');
                break;
            case 'provence' :
                $this->load->view('product/provence.phtml');
                break;
            case 'crane' :
                $this->load->view('product/crane.phtml');
                break;
            case 'amore' :
                $this->load->view('product/amore.phtml');
                break;
            case 'twinsofa' :
                $this->load->view('product/twinsofa.phtml');
                break;
            case 'swingchair' :
                $this->load->view('product/swingchair.phtml');
            break;

        }
    }
}
