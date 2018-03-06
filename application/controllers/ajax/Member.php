<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Member extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('member_model'));
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();

    }

    public function login(){

        $post = $this->input->post(null, true);

        $send_date = array(
            'id'   =>  $post['id'],
            'password'   =>  $post['password'],
        );

        $result1 =  $this->member_model->id_check($send_date);

        if($result1){
            $result2 =  $this->member_model->login($send_date);
            if($result2){
                $newdata = array(
                    'userid'   => $result2->m_id,
                    'level'    => $result2->m_level,
                    'username' => $result2->m_name,
                );
                $this->session->set_userdata($newdata);

                echo "0";
            }else{
                echo "2";
            }
        }else{
            echo "1";
            return;
        }
    }


    public function get_permission_check(){
        $post = $this->input->post(null, true);
        $send_date = array(
            'b_index'   =>  $post['b_index']
        );

        $result =  $this->board_model->get_permission_check($send_date);
        $send_data = array();
        if($result->b_locked == 'Y'){
            $send_data['lock'] = 'Y';
        }else{
            $send_data['lock'] = 'N';
        }

        echo json_encode($send_data);
    }

    public function check_pass(){
        $post = $this->input->post(null, true);

        $send_date = array(
            'b_index'   =>  $post['b_index'],
            'b_password'   =>  $post['pass'],
        );

        $result =  $this->board_model->get_password_check($send_date);
        if($result->cnt == '1'){
            $send_result = 'success';
            $ss_data = array(
                'b_index'      	=> $post['b_index'],
                'result'       	=> 1,
                'pass'       	=> $post['pass'],

            );
            $this->session->set_userdata($ss_data);
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }









}
