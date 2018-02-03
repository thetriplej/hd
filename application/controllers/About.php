<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

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
        $this->load->view('frame_top.html');
        $this->{$method}();
        $this->load->view('frame_bottom.html');
    }

    public function index()
    {
        //echo phpinfo();

        $this->company();

    }
    public function company()
    {
        $this->load->view('aboutus/company.html');
    }
    public function brand()
    {
        $this->load->view('aboutus/brand.html');
    }
    public function ceo()
    {
        $this->load->view('aboutus/ceo.html');
    }
    public function shop_info()
    {
        $this->load->view('aboutus/shop_info.html');
    }
}
