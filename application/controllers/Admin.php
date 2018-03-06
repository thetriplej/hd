<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Admin extends Common {

    public function  __construct() {
        parent::__construct();
        $this->load->model(array('member_model'));
    }

    function _remap($method) {

        $send_data = array(
            'user_id'   => $this->session->userdata('userid'),
            'level'     => $this->session->userdata('level'),
            'user_name' => $this->session->userdata('username'),
        );
        if($method != "index") {
            $this->load->view('admin_top.phtml',$send_data);
            $this->{$method}();
            $this->load->view('admin_bottom.phtml');
        }else{
            $this->{$method}();
        }

    }

    public function index()
    {
        $this->load->view('admin/index.phtml');
    }
    public function login()
    {
        $post = $this->input->post(null, true);
        $id = $post['id'];
        $password = $post['password'];

    }
    public function notice_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'FREEBOARD0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special
        );
        $this->load->view('admin/notice.phtml',$send_data);
    }

    public function notice_write()
    {
        $this->load->view('admin/notice_write.phtml');
    }
    public function customer_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page' => $page,
            'b_code' => $b_code,
            'search_type' => $search_type,
            'search_value' => $search_value,
            'b_special'     => $b_special
        );
        $this->load->view('admin/customer.phtml',$send_data);
    }

    public function customer_write()
    {
        $this->load->view('admin/customer_write.phtml');
    }
    public function magajine_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'CEPILOGUE0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'b_special'     => $b_special
        );

        $this->load->view('admin/magajine.phtml',$send_data);
    }

    public function magajine_write()
    {
        $this->load->view('admin/magajine_write.phtml');
    }
    public function qna_list()
    {
        $page = $this->input->get('page');
        if(empty($page)) $page = 1;
        $b_special = $this->input->get('b_special');
        if(empty($b_special)) $b_special = 0;
        $b_code = $this->input->get('b_code');
        if(empty($b_code)) $b_code = 'QANDA0';
        $search_type = $this->input->get('search_type');
        $search_value = $this->input->get('search_value');

        $send_data = array(
            'page'          => $page,
            'b_code'        => $b_code,
            'search_type'   => $search_type,
            'search_value'  => $search_value,
            'view_uri'      => $this->view_uri,
            'b_special'     => $b_special
        );
        $this->load->view('admin/qna.phtml',$send_data);
    }

    public function qna_write()
    {
        $this->load->view('admin/qna_write.phtml');
    }
}
