<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Admin extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('member_model','board_model'));
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();

    }

    public function popular_del(){
        $post = $this->input->post(null, true);
        $checkArray = explode(",",$post['checkArray']);

        unset($checkArray[0]);
        $checkArray = array_values($checkArray);



        foreach ( $checkArray as $key => $value){
            $send_data = array( 'idx' => $value);
            $list =  $this->board_model->set_porpula_del($send_data);

            if(empty($list)){
                $result = 'fail';
                break;
            }
            $result = 'success';
        }

        echo json_encode($result);
    }


    public function popular_set()
    {
        $post = $this->input->post(null, true);
        $send_date = array(
            'idx' => $post['idx']
        );

        $result = $this->board_model->set_popular($send_date);

        echo $result;
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


    public function set_del(){
        $post = $this->input->post(null, true);
        if($post['mode'] == "admin"){
            $exec = '1';
        }else{
            $send_date = array(
                'b_index'   =>  $post['b_index'],
                'b_password'=>  $post['pass'],
                'mode'      =>  $post['mode'],
            );
            $result =  $this->board_model->get_password_check($send_date);
            $exec = $result->cnt;
        }

        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html';

        if($exec == '1'){
            $file_list =  $this->board_model->get_file($post['b_index'],'all');
            if(!empty($file_list)){
                foreach ($file_list as $key => $value){
                    @unlink($upload_dir.$value->file_path.$value->f_rename);
                    $temp_fname = explode('.', $value->f_rename);
                    $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                    if (in_array($temp_fname[1], $allow_file)) {
                        @unlink($upload_dir.$value->file_path . $temp_fname[0] . "_145x90." . $temp_fname[1]);
                    }
                }
            }
            $bbs_result =  $this->board_model->set_bbs_delete($send_date);
            $file_result =  $this->board_model->set_file_delete($send_date);

            $send_result = 'success';
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }








}
