<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }


    function _remap($method) {

        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()) exit;
        $this->{$method}();
    }





}