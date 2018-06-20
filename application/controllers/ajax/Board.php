<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Board extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('board_model'));
        $this->load->helper('cookie');
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();
    }

    public function get_porpula_list(){
        $list =  $this->board_model->get_porpula_list();
        foreach ( $list as $key => $value){
            $path = '/public_html'.$value->file_path;
            $value->f_rename = $path.$value->f_rename;
        }
        echo json_encode($list);
    }

    public function get_qna_list(){
        $post = $this->input->post(null, true);

        $p_data = array(
            'table_name' 	=> 'board',
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'page'			=> $post['page'],
            'board_type'    => 'QANDA0',
            'list_rows'		=> 20,
            'page_no'		=> 10,
            'mode'          => $post['mode'],

        );
        if($post['mode'] == "admin"){
            $p_data['b_special'] = $post['b_special'];
        }
        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'board_type'    => 'QANDA0',
            'mode'          => $post['mode'],
        );
        if($post['mode'] == "admin"){
            $list_data['b_special'] = $post['b_special'];
        }
        $list =  $this->board_model->get_gallery_list($list_data);

        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page'  => $result['page'],
            'last_page'     => $result['tot_page'],
            'per_page'      => $result['list_rows'],
            'total'         => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);
    }

    public function get_notice_list(){
        $post = $this->input->post(null, true);

        $p_data = array(
            'table_name' 	=> 'board',
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'page'			=> $post['page'],
            'board_type'    => 'FREEBOARD0',
            'list_rows'		=> 20,
            'page_no'		=> 10,
            'mode'          => $post['mode'],

        );
        if($post['mode'] == "admin"){
            $p_data['b_special'] = $post['b_special'];
        }

        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'board_type'    => 'FREEBOARD0',
            'mode'          => $post['mode'],

        );
        if($post['mode'] == "admin"){
            $list_data['b_special'] = $post['b_special'];
        }
        $list =  $this->board_model->get_gallery_list($list_data);

        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page'  => $result['page'],
            'last_page'     => $result['tot_page'],
            'per_page'      => $result['list_rows'],
            'total'         => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);
    }

    public function get_gallery_list(){

        $post = $this->input->post(null, true);

        $p_data = array(
            'table_name' 	=> 'board',
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'page'			=> $post['page'],
            'board_type'    => 'CEPILOGUE0',
            'list_rows'		=> 12,
            'page_no'		=> 10,
            'mode'          => $post['mode'],

        );
        if($post['mode'] == "admin"){
            $p_data['b_special'] = $post['b_special'];
        }

        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'board_type'    => 'CEPILOGUE0',
            'mode'          => $post['mode'],
        );

        if($post['mode'] == "admin"){
            $list_data['b_special'] = $post['b_special'];
        }
        $list =  $this->board_model->get_gallery_list($list_data);


        foreach ( $list as $key => $value){

            if(!empty($value->file_path)) {
                $path = '/public_html'.$value->file_path;
                //$value->f_rename = iconv("utf-8","CP949",$value->f_rename);
                $temp_fname = explode('.', $value->f_rename);
                if(count($temp_fname) > 1) {
                    $temp_cnt = substr_count($value->f_rename, ".");
                    if($temp_cnt == 1) {
                        $value->f_rename = $path .$temp_fname[0] . "_145x90." . $temp_fname[1];
                    }else if($temp_cnt == 2){
                        $value->f_rename = $path .$temp_fname[0].".".$temp_fname[1]."_145x90." . $temp_fname[2];
                    }else if($temp_cnt == 3){
                        $value->f_rename = $path .$temp_fname[0].".".$temp_fname[1].".".$temp_fname[2]."_145x90." . $temp_fname[3];
                    }
                }else{
                    $value->f_rename = 'no_image';
                }
            }else{
                $value->f_rename = 'no_image';
            }
        }
//        $result = array(
//            'list_rows' 	=> $list_rows,
//            'page_start' 	=> $page_start,
//            'total_rows' 	=> $total_rows,
//            'page' 			=> $page,
//            'prev_page' 	=> $prev_page,
//            'next_page' 	=> $next_page,
//            'tot_page' 		=>$tot_page,
//            'now_page_group' =>$now_page_group,
//            'page_no' 		=>$page_no,
//
//        );
        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page' => $result['page'],
            'last_page' => $result['tot_page'],
            'per_page' => $result['list_rows'],
            'total' => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);

    }

    public function get_magajine_list(){
        $post = $this->input->post(null, true);
        if(empty($post['page'])) $post['page'] = 1;
        if(empty($post['search_type'])) $post['search_type'] = 1;
        if(empty($post['search_value'])) $post['search_value'] = "";
        $p_data = array(
            'table_name' 	=> 'board',
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'page'			=> $post['page'],
            'board_type'    => 'SEPILOGUE0',
            'list_rows'		=> 20,
            'page_no'		=> 10,
            'mode'          => $post['mode'],

        );
        if($post['mode'] == "admin"){
            $p_data['b_special'] = $post['b_special'];
        }
        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'board_type'    => 'SEPILOGUE0',
            'mode'          => $post['mode'],
        );
        if($post['mode'] == "admin"){
            $list_data['b_special'] = $post['b_special'];
        }
        $list =  $this->board_model->get_gallery_list($list_data);


        foreach ( $list as $key => $value){

            if(!empty($value->file_path)) {
                $path = '/public_html'.$value->file_path;
                //$temp_fname = explode('.', $value->f_rename);
                //$value->f_rename = $path . $temp_fname[0] . "_145x90." . $temp_fname[1];
                $value->f_rename = $path . $value->f_rename;
            }else{
                $value->f_rename = 'no_image';
            }
        }

        /* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
        //pagination(result.current_page, result.last_page, result.per_page, result.total, 10);
        $page_navi = array(
            'current_page' => $result['page'],
            'last_page' => $result['tot_page'],
            'per_page' => $result['list_rows'],
            'total' => $result['total_rows'],
        );

        $send_data = array (
            'list' => $list,
            'page_navi' => $page_navi
        );

        echo json_encode($send_data);

    }

    public function page_navi($params){
        $table_name = 'board';
        $page = $params['page'];
        $search_type = $params['search_type'];
        $search_value = $params['search_value'];
        $board_type = $params['board_type'];
        $list_rows = $params['list_rows'];
        $page_no = $params['page_no'];


        if(!$page) $page = 1;

        $data1 = array(
            'table_name'	=> $table_name,
            'board_type'	=> $board_type,
            'search_type'	=> $search_type,
            'search_value'   => $search_value,
            'mode'          => $params['mode'],
        );
        if($params['mode'] == "admin"){
            $data1['b_special'] = $params['b_special'];
        }

        $total_rows = $this->board_model->get_list_tot($data1);
        $page_start = ($page-1)*$list_rows;
        $tot_page = ceil($total_rows/$list_rows);
        $now_page_group = ceil($page/$page_no);
        $start_page	= ($now_page_group-1) * $page_no + 1;
        $end_page = ($now_page_group*$page_no);
        $tot_page_group = ceil($tot_page/$page_no);

        if($now_page_group > 1){
            $prev_page = $start_page - 1;
        }else{
            $prev_page =1;
        }

        if($now_page_group < $tot_page_group){
            $next_page = $end_page + 1;
        }else{
            $next_page='';
        }

        $result = array(
            'list_rows' 	=> $list_rows,
            'page_start' 	=> $page_start,
            'total_rows' 	=> $total_rows,
            'page' 			=> $page,
            'prev_page' 	=> $prev_page,
            'next_page' 	=> $next_page,
            'tot_page' 		=>$tot_page,
            'now_page_group' =>$now_page_group,
            'page_no' 		=>$page_no,

        );

        return $result;

    }

    public function get_file($b_index){
        $image_data = $this->board_model->get_file($b_index,'image');
        foreach($image_data as $key => $value){
            $value->file_path = $value->file_path.$value->f_rename;
            if(intval($value->f_width) > 700){
                $value->f_width = 700;
            }
        }

        echo json_encode($image_data);
    }

    public function get_view(){
        $post = $this->input->post(null, true);
        $b_index = $post['b_index'];
        $mode = $post['mode'];
        if($mode == 'stie') {
            $session_pwd_checking = $this->session->b_index;
        }else{
            $session_pwd_checking = $b_index;
        }
        $view = array();
        $send_data = array();
        $file_cnt = "";
        if(!empty($b_index) && $session_pwd_checking == $b_index) {
            $view_send = array(
                'mode' => 'P',
                'id' => $b_index,
            );
            $view_data = $this->board_model->get_view($view_send);
            $file_cnt = $this->board_model->get_file_check($b_index);
            if($file_cnt > 0){
                $file_result = $this->board_model->get_file($b_index,'all');
                $files_array = array();
                if(!empty($file_result)) {
                    foreach ($file_result as $key => $value) {
                        $temp_fname ='';
                        $files_array[$key]['f_index'] = $value->f_index;
                        $files_array[$key]['b_code'] = $value->b_code;
                        $files_array[$key]['b_index'] = $value->b_index;
                        $files_array[$key]['f_name'] = $value->f_name;
                        $files_array[$key]['f_type'] = $value->f_type;
                        $files_array[$key]['f_position'] = $value->f_position;
                        $files_array[$key]['f_width'] = $value->f_width;
                        $files_array[$key]['f_show'] = $value->f_show;
                        $files_array[$key]['f_size'] = $value->f_size;
                        $files_array[$key]['f_rename'] = $value->f_rename;
                        $files_array[$key]['list_img'] = $value->list_img;
                        $files_array[$key]['file_path'] = "http://".$_SERVER["HTTP_HOST"].'/public_html' . $value->file_path . $value->f_rename;
                        $files_array[$key]['reg_date'] = $value->reg_date;


                        $temp_fname = explode('.', $value->f_rename);
                        $allow_file = array("jpg", "png", "bmp", "gif", "jpeg");
                        //var_dump(json_encode($temp_fname));exit;
                        if (in_array($temp_fname[1], $allow_file)) {
                            $files_array[$key]['thumburl'] = "http://".$_SERVER["HTTP_HOST"].'/public_html' . $value->file_path . $temp_fname[0] . "_145x90." . $temp_fname[1];
                            //$files_array[$key]['f_type'] = 'image';

                        } else {
                            //$files_array[$key]['f_type'] = 'file';
                        }

                    }
                }

            }
            $view['b_index']       = $view_data->b_index;
            $view['b_writer']      = (htmlspecialchars_decode($view_data->b_writer));
            $view['b_title']       = (htmlspecialchars_decode($view_data->b_title));
            $view['b_email']       = (htmlspecialchars_decode($view_data->b_email));
            $view['b_locked']      = $view_data->b_locked;
            $view['b_password']      = $view_data->b_password;
            $view['b_content']     = (htmlspecialchars_decode($view_data->b_content));
            //$view['b_content']     = $view_data->b_content;
            $view['b_board_type']  = $view_data->b_board_type;
            $view['file_cnt']  = $file_cnt;


            $send_data['result']  = 'success';
        }else{
            $send_data['result'] = "fail";
        }
        $send_data['view'] = $view;
        if($file_cnt>0) {
            $send_data['file'] = $files_array;
        }
        //var_dump(json_encode($files_array));exit;
        echo json_encode($send_data);
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

    public function gallery_file_upload(){
        ini_set("memory_limit", "-1");

        //$url = '/public_html/d_editor/pages/trex/image.php?callback_func='.$_REQUEST["callback_func"];

        $upload_file    = $_FILES['attachFile']['name'];
        $upload_tmp     = $_FILES['attachFile']['tmp_name'];
        $upload_type    = $_FILES['attachFile']['type'];

        $send_data = array();
        $fCnt = count($upload_file);
        $_mockdata = array();

        for($i=0;$i<$fCnt;$i++){
            $bSuccessUpload = is_uploaded_file($_FILES['attachFile']['tmp_name'][$i]);
            $img_info = array();
            if($bSuccessUpload) {
                $tmp_name = $_FILES['attachFile']['tmp_name'][$i];
                $name = $_FILES['attachFile']['name'][$i];
                $size = $_FILES['attachFile']['size'][$i];
                $upload_type = $_FILES['attachFile']['type'][$i];

                $filename_ext = strtolower(substr(strrchr($name,"."),1));	//확장자앞 .을 제거하기 위하여 substr()함수를 이용

                $allow_file = array("jpg", "png", "bmp", "gif","jpeg");

                if(!in_array($filename_ext, $allow_file)) {
                    $send_data['result'] = 'fail';
                    break;
                } else {
                    $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/public_html/upload/temp/';

                    if(!is_dir($upload_dir)){
                        mkdir($upload_dir, 0777);
                    }
                    $img_rename = date("Ymd")."_".time().rand(0,100000);
                    $setPath = $upload_dir.$img_rename;
                    $set_width_array = array(300,700);

                    $oldfile = $tmp_name;
                    $newfile = $upload_dir.$img_rename."_origin.".$filename_ext;
                    if(file_exists($oldfile)) {
                        if(!copy($oldfile, $newfile)) {
                            echo "파일 복사 실패";
                        } else if(file_exists($newfile)) {
                        }
                    }
                    $info = getimagesize($newfile);
                    $image_width = $info[0];
                    if($image_width > 700){
                        $return_thum = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,300);
                        $return = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,700);
                    }else{
                        $return_thum = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,300);
                        $return = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,$image_width);
                    }

                    (!empty($return_thum) && !empty($return))? $status = 'success' : $status = 'fail';

                    $img_600 = $upload_dir.$img_rename.'.'.$filename_ext;
                    list($width, $height) = getimagesize($img_600);

                    $img_info = array(
                        'f_rename'    =>  $img_rename.'.'.$filename_ext,
                        'filename'    => $name,
                        'filesize'    => $size,
                        'imagealign'  => 'C',
                        'originalurl' => $return['originalurl'],
                        'thumburl'    => $return_thum['thumburl'],
                        'mime_type'   => $upload_type,
                        'image_width' => intval($width),
                        'image_height' => intval($height),
                        'status'      => $status
                    );
                    //@move_uploaded_file($tmp_name, $setPath.'.'.$filename_ext);

                    $send_data['result'] = $status;
                    $send_data['_mockdata'][$i] = $img_info;

                }
            }else {
                $send_data['result'] = 'fail';
                break;
            }
        }

        echo json_encode($send_data);
    }

    private function get_image_resource_from_file($path_file){

        if (!is_file($path_file)) {//파일이 아니라면
            $GLOBALS['errormsg'] = $path_file . '은 파일이 아닙니다.';
            return Array();
        }

        $size = @getimagesize($path_file);
        if (empty($size[2])) {//이미지 타입이 없다면
            $GLOBALS['errormsg'] = $path_file . '은 이미지 파일이 아닙니다.';
            return Array();
        }

        if ($size[2] != 1 && $size[2] != 2 && $size[2] != 3) {//지원하는 이미지 타입이 아니라면
            $GLOBALS['errormsg'] = $path_file . '은 gif 나 jpg, png 파일이 아닙니다.';
            return Array();
        }

        switch($size[2]){

            case 1 : //gif
                $im = @imagecreatefromgif($path_file);
                break;

            case 2 : //jpg
                $im = @imagecreatefromjpeg($path_file);
                break;

            case 3 : //png
                $im = @imagecreatefrompng($path_file);
                break;
        }

        if ($im === false) {//이미지 리소스를 가져오기에 실패하였다면
            $GLOBALS['errormsg'] = $path_file . ' 에서 이미지 리소스를 가져오는 것에 실패하였습니다.';
            return Array();
        }
        else {//이미지 리소스를 가져오기에 성공하였다면

            $return = $size;
            $return[0] = $im;
            $return[1] = $size[0];//너비
            $return[2] = $size[1];//높이
            $return[3] = $size[2];//이미지타입
            $return[4] = $size[3];//이미지 attr

            return $return;
        }
    }

    private function save_image_from_resource ($im, $path_save_file){

        $path_save_dir = dirname($path_save_file);
        if (!is_dir($path_save_dir)) {
            $GLOBALS['errormsg'] = $path_save_dir . '은 디렉토리가 아닙니다.';
            return false;
        }

        if (!is_writable($path_save_dir)){
            $GLOBALS['errormsg'] = $path_save_dir . '에 이미지를 저장할 권한이 없습니다.';
            return false;
        }

        if (is_file($path_save_file) || is_dir($path_save_file)) {
            $GLOBALS['errormsg'] = $path_save_file . '은 이미 존재하는 파일이거나 디렉토리입니다.';
            return false;
        }

        $extension = strtolower(substr($path_save_file, strrpos($path_save_file, '.') + 1));

        switch($extension){
            case 'gif' :
                $result_save = @imagegif($im, $path_save_file);
                break;

            case 'jpg' :
            case 'jpeg' :
                $result_save = @imagejpeg($im, $path_save_file);
                break;

            default : //확장자 png 또는 확장자가 없는 경우, 정의되지 않는 확장자인 경우는 모두 png로 저장
                $result_save = @imagepng($im, $path_save_file);
        }

        if ($result_save === false) {//이미지 저장에 실패
            $GLOBALS['errormsg'] = $path_save_file . '의 저장에 실패하였습니다.';
            return false;
        }else {//이미지 저장에 성공
            return true;
        }
    }

    private function image_resize($originfile,$renamefile,$filename_ext,$upload_dir,$width){
        $dst_w = $width;//만들어질 이미지의 너비 지정, 픽셀단위의 0이상의 정수를 지정
        $setPath = $upload_dir.$renamefile;

        $path_file = $originfile;//원본파일
        $send_temp_dir = "http://".$_SERVER["HTTP_HOST"].'/public_html/upload/temp/';
        if($width == 300){
            $newPath = $setPath.'_145x90.'.$filename_ext;
            $sen_data = array(
                'thumburl' =>   $send_temp_dir.$renamefile.'_145x90.'.$filename_ext
            );
        }else{
            $newPath = $setPath.'.'.$filename_ext;
            $sen_data = array(
                'originalurl' =>   $send_temp_dir.$renamefile.'.'.$filename_ext
            );
        }

        $path_resizefile = $newPath;//리사이즈되어 저장될 파일 경로

        //이미지 리소스를 받아온다.
        list($src, $src_w, $src_h) = $this->get_image_resource_from_file($path_file);
        if (empty($src)) die($GLOBALS['errormsg'] . "<br />\n");
        //만들어질 이미지의 높이를 결정한다.
        $resize_rule = $dst_w / $src_w;

        $dst_h = ($width == 300)? 188 :ceil($resize_rule * $src_h);//소숫점이 나올것을 대비하여 무조건 올림을 한다.
        $dst = @imagecreatetruecolor($dst_w, $dst_h);//만드어질 $dst_w , $dst_h 크기의 이미지 리소스를 생성한다.
        if ($dst === false) die("$dst_w , $dst_h 크기의 썸네일 이미지의 리소스를 생성하지 못했습니다.<br />\n");
        $result_resize = imagecopyresampled($dst, $src, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        if ($result_resize === false) die("리사이즈에 실패하였습니다.<br />\n");

        $result_save = $this->save_image_from_resource($dst, $path_resizefile);//저장
        if ($result_save === false) die($GLOBALS['errormsg'] . "<br />\n");

        @imagedestroy($src);
        @imagedestroy($dst);



        return $sen_data;



    }

    public function set_del(){
        $post = $this->input->post(null, true);
        $send_data = array(
            'b_index'   =>  $post['b_index'],
            'mode'      =>  $post['mode'],
        );
        if($post['mode'] == "admin"){
            $exec = '1';
        }else{
            $send_data['b_password'] = $post['pass'];
            $result =  $this->board_model->get_password_check($send_data);
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
            $bbs_result =  $this->board_model->set_bbs_delete($send_data);
            $file_result =  $this->board_model->set_file_delete($send_data);

            $send_result = 'success';
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }


}
