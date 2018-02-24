<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Common {

    function __construct()
    {
        parent::__construct();
    }


    function _remap($method) {
        $this->load->library('form_validation');
        $this->load->library('validation');
        $this->load->model(array('address_model','member_model'));
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()) exit;
        $this->{$method}();
    }

}