<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other extends CI_Controller {

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
        //echo phpinfo();

    }
    public function b2b()
    {
        $this->load->view('etc/b2b.phtml');
    }
    public function recruit()
    {
        $this->load->view('etc/recruit.phtml');
    }
    public function law()
    {
        $this->load->view('etc/law.phtml');
    }
    public function privacy()
    {
        $this->load->view('etc/privacy.phtml');
    }
}
