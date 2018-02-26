<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Board extends Common {


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

    public function get_porpula_list(){

        $list =  $this->board_model->get_porpula_list();
        foreach ( $list as $key => $value){
            if($value->b_board_type == 0){
                $path = '/public_html/upload/upload/';
            }else{
                $path = '/public_html/upload/upload2/';
            }
            $value->f_name = $path.$value->f_name;
        }

        echo json_encode($list);

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

        );
        $result = $this->page_navi($p_data);

        $list_data = array(
            'list_rows' 	=> $result['list_rows'],
            'page_start' 	=> $result['page_start'],
            'page' 			=> $result['page'],
            'page_no' 		=> $result['page_no'],
            'search_type'	=> $post['search_type'],
            'search_value'  => $post['search_value'],
            'board_type'    => 'CEPILOGUE0',
        );

        $list =  $this->board_model->get_gallery_list($list_data);


        foreach ( $list as $key => $value){
            if($value->b_board_type == "0"){
                $path = '/public_html/upload/upload/';
            }else{
                $path = '/public_html/upload/upload2/';
            }
            $temp_fname = explode ('.',$value->f_name);
            $value->f_name = $path.$temp_fname[0]."_145x90.".$temp_fname[1];
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
        );


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

        $image_data = $this->board_model->get_bbs_image($b_index);
        foreach($image_data as $key => $value){
            $value->file_path = $value->file_path.$value->f_rename;
            if(intval($value->f_width) > 600){
                $value->f_width = 600;
            }
        }
        echo json_encode($image_data);
    }
    public function get_view(){
        $post = $this->input->post(null, true);
        $b_index = $post['b_index'];
        $session_pwd_checking = $this->session->b_index;
        var_dump($this->session->all_userdata());
        var_dump($session_pwd_checking);exit;
        $send_data = array();
        if(!empty($b_index) && $session_pwd_checking == $b_index) {
            $view_send = array(
                'mode' => 'P',
                'id' => $b_index,
            );
            $view_data = $this->board_model->get_view($view_send);
            $file_cnt = $this->board_model->get_file_check($b_index);
            if($file_cnt > 0){
                $file_result = get_file($b_index);
            }
            $send_data['b_index']       = $view_data->b_index;
            $send_data['b_writer']      = $view_data->b_writer;
            $send_data['b_title']       = $view_data->b_title;
            $send_data['b_email']       = $view_data->b_email;
            $send_data['b_content']     = $view_data->b_content;
            $send_data['b_board_type']  = $view_data->b_board_type;
            $send_data['file_cnt']  = $file_cnt;
            if($file_cnt>0) $send_data['file_result'] = $file_result;
            $send_data['result']  = 'success';
        }else{
            $send_data['result'] = "fail";
        }


//
//
//
//
//
//		if NOT IsNull(B_Index) then
//			SQL = "SELECT TOP 1 * FROM Board WHERE B_Index = '"  & B_Index &  "'  ORDER BY B_RegDate DESC"
//
//
//				Rs.Open SQL, DB, 1
//					If Not Rs.Eof Then
//						rows("B_Index") = Rs("B_Index")
//						rows("B_Writer") = Rs("B_Writer")
//						rows("B_Title") = Rs("B_Title")
//						rows("B_Email") = Rs("B_Email")
//						rows("B_Content") = htmlspecialchars_decode(Rs("B_Content"))
//						rows("B_Board_Type") = Rs("B_Board_Type")
//
//
//						SQL = "select F_Index, B_Code, B_Index, F_Name, F_Type, F_Position, F_Width, F_Show, F_Size, (case when F_ReName <> '' then F_ReName else F_Name end ) F_ReName  from BoardFile where B_Index = '"&B_Index&"' order by F_Index desc;"
//						Rs.Open SQL, DB, 1
//						If NOT Rs.Eof Then
//							rows("F_Cnt") = Rs.recordcount
//						End If
//
//
//		End If
//	'arr_email = Split(B_Email, "@")
//
//		rows("code") = 1000
//		rows("msg") = ""
//
//		Response.Write toJSON(rows)
//		Response.End
//
//End Function
//
//Function getFileList(B_Index)
//		Dim rows, originFilePath,num
//		Dim  files(50,11)
//		'Set rows = jsObject()
//		Set Rs = Server.CreateObject("ADODB.RecordSet")
//		SQL = "select F_Index, B_Code, B_Index, F_Name, F_Type, F_Position, F_Width, F_Show, F_Size, (case when F_ReName <> '' then F_ReName else F_Name end ) F_ReName from BoardFile where B_Index = '"&B_Index&"' order by F_Index desc;"
//		Rs.Open SQL, DB, 1
//'		Response.Write SQL
//		'tCnt = Rs.recordcount
//		originFilePath =  "D:\website\hassed.co.kr\upload2\"
//
//		If NOT Rs.Eof Then
//			i = 0
//			Do Until Rs.Eof
//				minetype = Split(Rs("F_Type"), "/")
//				If minetype(0) = "image" Then
//						extension = Right(Trim(Rs("F_ReName")), 4)
//						fileName = Replace(Trim(Rs("F_ReName")), extension, "")
//'						files= Rs
//						files(i,0) = Rs("F_Index")		' f_index
//						files(i,1) = Rs("B_Code")		' b_cod
//						files(i,2) = Rs("F_Name")		' f_name
//						files(i,3) = Rs("F_Type")		' f_type
//						files(i,4) = Rs("F_Position")
//						files(i,5) = Rs("F_Width")		'F_Width
//						files(i,6) = Rs("F_Show")		' fileSize
//
//						files(i,7) = "/upload2/" & fileName & extension		'imageurl
//						files(i,8) = fileName & extension			'filename
//						files(i,9) = "/upload2/" & fileName & extension		'originalurl
//						files(i,10) = "/upload2/" & fileName & "_145x90" & extension		'thumburl
//						files(i,11) = Rs("F_Size")	'filesize
//
//'				Response.Write Rs("F_Index")
//'				Response.End
//'					rows(0) = files
//					rows = files
//				Else
//						extension = Right(Trim(Rs("F_ReName")), 4)
//						fileName = Replace(Trim(Rs("F_ReName")), extension, "")
//'						files= Rs
//						files(i,0) = Rs("F_Index")		' f_index
//						files(i,1) = Rs("B_Code")		' b_cod
//						files(i,2) = Rs("F_Name")		' f_name
//						files(i,3) = "file"		' f_type
//						files(i,4) = Rs("F_Position")
//						files(i,5) = Rs("F_Width")		'F_Width
//						files(i,6) = Rs("F_Show")		' fileSize
//
//						files(i,7) = "/upload2/" & fileName & extension			'imageurl
//						files(i,8) = fileName & extension			'filename
//						files(i,9) = "/upload2/" & fileName & extension			'originalurl
//						files(i,10) = ""	'thumburl
//						files(i,11) = Rs("F_Size")	'filesize
//					rows = files
//
//
//        echo json_encode($send_data);
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
                    $set_width_array = array(300,600);


                    $return_thum = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,300);
                    $return = $this->image_resize($tmp_name,$img_rename,$filename_ext,$upload_dir,600);
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
        $send_temp_dir = '/public_html/upload/temp/';
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








}
