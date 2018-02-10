<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {


    public function  __construct() {
        parent::__construct();
        $this->load->helper('url'); //Loading url helper
        $this->load->library('utilcommon');
        if($this->utilcommon->get_mobile_check() === true){
            //  echo "<script>alert('mobile')</script>";
        }else{
            //   echo "<script>alert('PC')</script>";
        }
        $this->load->library('user_agent');
        //var_dump($this->agent->referrer());
        $this->lang_type = get_cookie('tj_lang_type');
        $this->load->model(array('board_model'));

    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()) exit;
        $this->{$method}();
    }

    public function get_porpula_list(){

        $result =  $this->board_model->get_porpula_list();

    }
    public function get_image_board()
    {


    }

}
