<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Board_file extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('board_model'));
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();
    }

    public function file_down()
    {
        $this->load->helper('download');
        $post = $this->input->post(null, true);

        $filepath = $post['path'];
        $mode = $post['mode'];
        $filepath = $_SERVER['DOCUMENT_ROOT'].'/public_html'.$filepath;
        $filesize = filesize($filepath);
        $tmp = explode('/',$filepath);
        $filename = end($tmp);

        if(file_exists($filepath)){

            force_download($filename, $filepath);
            echo '<meta http-equiv="Content-Type" content="file/unknown; charset=utf-8">';
//            //IE인가 HTTP_USER_AGENT로 확인
//            $ie = isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false;
//
//            //IE인경우 한글파일명이 깨지는 경우를 방지하기 위한 코드
//            if( $ie ){
//                $filename = iconv('utf-8', 'euc-kr', $filename);
//            }
//
//            //기본 헤더 적용
//            header('Content-Disposition: attachment; filename="'.$filename.'"');
//            var_dump($filename);exit;
//            header("Pragma: public");
//            header("Expires: 0");
//            header("Content-Description: File Transfer");
//            header("Content-Description: ".$_SERVER['HTTP_HOST']." Generated Data");
//            header('Content-Type: file/unknown');
//            header('Content-Transfer-Encoding: binary');
//            header('Content-Length: '.sprintf('%d', $filesize));
//            header('Expires: 0');
//
//            // IE를 위한 헤더 적용
//            if( $ie ){
//                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//                header('Pragma: public');
//            } else {
//                header('Pragma: no-cache');
//            }
//
//            //해당 파일을 binary로 읽어와 출력
//            $handle = fopen($filepath, 'rb');
//            fpassthru($handle);
//            fclose($handle);
            $result = array('downstate'  =>  'success');
        }else{
            $result = array('downstate'  =>  'notfile');

        }
        echo json_encode($result);
    }

    private function utf2euc($str)
    {
        return iconv("UTF-8", "cp949//IGNORE", $str);
    }

    private function is_ie()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) return false;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11
        return false;
    }








}
