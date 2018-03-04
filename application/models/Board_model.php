<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    function get_porpula_list() {
        $query = "select board.b_index,board.b_title,board.b_writer,board.b_code,board.b_board_type,boardfile.f_name,boardfile.f_rename,boardfile.list_img,boardfile.f_index,boardfile.file_path

                    from board 
                    left join  boardfile on board.b_index = boardfile.b_index
                    where board.b_index in(select popular_log.board_idx from popular_log where popular_log.show_flag =1) 
                    and LEFT(f_type, 5) = 'image' 
                    and boardfile.list_img = 'Y'
                    order by f_show desc, f_index asc";
        return $this->db->query($query)->result();
    }

    function get_permission_check($params){
        $b_index  = $params['b_index'];
        $sql = "SELECT b_locked FROM board WHERE b_index = ?";
        return $this->db->query($sql, array($b_index))->row();
    }


    function get_gallery_list($params){

        $list_rows  = $params['list_rows'];
        $page_start = $params['page_start'];
        $page 		= $params['page'];
        $page_no 	= $params['page_no'];
        $search_type = $params['search_type'];
        $search_value= $params['search_value'];
        $board_type = $params['board_type'];

        $start_row = (($page-1)*$list_rows);
        $end_row = $page*$list_rows;

        $where="";
        if(!empty($search_value)){ //게시물 검색어
            $like_word = " and ".$search_type." REGEXP '".$search_value."' ";
        }else{
            $like_word = "";
        }

        $query = "SELECT board.b_title,board.b_board_type,board.b_code,board.b_index,board.b_hit,board.b_locked,
                    DATE_FORMAT(board.b_regdate,'%Y-%m-%d') b_regdate,board.b_writer,board.b_board_type,tmp_boardfile.f_name,tmp_boardfile.f_rename,tmp_boardfile.file_path,
                    tmp_boardfile.list_img,tmp_boardfile.f_index,(select count(*) from board tmp where tmp.b_parentindex = board.b_index) as reply
                    FROM board as board 
                    left join  (select f_name,f_rename,list_img,f_index,b_index,file_path from boardfile where boardfile.list_img='Y') as tmp_boardfile on board.b_index = tmp_boardfile.b_index
                    where 
                      board.b_code = ? AND
                      board.b_parentindex = 0 and
                      board.b_sequence =1 
                      ".$like_word."
                    ORDER BY board.b_index desc limit ".$start_row.",".$list_rows;

        return $this->db->query($query,array($board_type))->result();
    }

    function get_list_tot($params){ //리스트 페이징을 위한 토탈 카운트

        $table_name = $params['table_name'];
        $board_type = $params['board_type'];
        $search_type = $params['search_type'];
        $search_value	= $params['search_value'];
        $where="";


        if(!empty($search_value)){ //게시물 검색어
            $like_word = " and ".$search_type." REGEXP '".$search_value."' ";

        }else{
            $like_word = "";
        }
        if($board_type == "CEPILOGUE0"){
            $where = " and B_Sequence = '1' and B_Depth = '0'";
        }

        $main_query ="select b_index from ".$table_name. " where  b_code = '".$board_type."' ".$where.$like_word;
        $tot_rows = $this->db->query($main_query)->num_rows();

        return $tot_rows;

    }

    function get_last_group_no(){
        $query = "select MAX(b_group)+1 AS max_group from board";
        return $this->db->query($query)->row();
    }

    function get_password_check($params){
        $b_index = $params['b_index'];
        $passwd = $params['b_password'];

        $query = "select count(b_index) AS cnt from board where b_index = ? and b_password = ?";
        return  $this->db->query($query,array($b_index,$passwd))->row();
    }

    function get_view($params){
        $mode = $params['mode'];
        $id = $params['id'];
        $where ="";
        if($mode == "P") {
            $query = "update board set b_hit = b_hit + 1 where b_index = ?";
            $result = $this->db->query($query, array($id));
            $where = "b_index =?";

        }else{
            $where = "b_parentindex = ? and b_sequence = '2' and b_depth = '1'";

        }

        $query = "select b_title,b_board_type,b_code,b_index,b_hit,b_content,b_email,
                    DATE_FORMAT(b_regdate,'%Y-%m-%d') b_regdate,b_writer,b_board_type,(select count(*) from board tmp where tmp.b_parentindex = b_index) as reply
                  from board where ".$where;

        $result =  $this->db->query($query,array($id))->row();
        return $result;
    }

    function get_file($id,$type){
        if($type == "image"){
            $query = "select f_index,b_code,b_index,f_name ,f_type,f_position,f_width ,f_show ,f_size,f_rename,list_img ,file_path,reg_date
                  from boardfile where b_index =? and left(f_type, 5) = 'image' order by f_index asc";
        }else if($type == "movie"){
            $query = "select f_index,b_code,b_index,f_name ,f_type,f_position,f_width ,f_show ,f_size,f_rename,list_img ,file_path,reg_date
                  from boardfile where b_index =? and right(f_name, 3) IN('mp4', 'wma', 'wmv', 'asf', 'avi', 'wav', 'mid', 'swf','flv') order by f_index asc";
        }else if($type == "file"){
            $query = "select f_index,b_code,b_index,f_name ,f_type,f_position,f_width ,f_show ,f_size,f_rename,list_img ,file_path,reg_date
                  from boardfile where b_index =? and left(f_type, 5) <> 'image' and right(f_name, 3) not in('mp4', 'wma', 'wmv', 'asf', 'avi', 'wav', 'mid', 'swf') order by f_index asc";

        }else if($type == "all"){
            $query = "select f_index,b_code,b_index,f_name ,f_type,f_position,f_width ,f_show ,f_size,f_rename,list_img ,file_path,reg_date
                  from boardfile where b_index =?  order by f_index asc";
        }
        $result =  $this->db->query($query,array($id))->result();
        return $result;
    }

   function get_file_check($id){    // 게시글에 첨부된 파일 총갯수
       $query = "select f_index
                  from boardfile where b_index =? ";
       $result =  $this->db->query($query,array($id))->num_rows();
       return $result;
   }

    function set_bbs_save($params){

        $this->db->trans_begin();
        $b_index = $params['b_index'];
//        $send_data = array(
//            'b_code'        =>   $b_code,
//            'proc_type'     =>   $proc_type,
//            'b_depth'       =>   $b_depth,
//            'b_parentindex' =>   $b_parentindex,
//            'b_board_type'  =>   $b_board_type,
//            'b_index'       =>   $b_index,
//            'select_img'    =>   $select_img,
//            'b_writer'      =>   $b_writer,
//            'b_password'    =>   $b_password,
//            'b_title'       =>   $b_title,
//            'b_email'       =>   $b_email ,
//            'b_content'     =>   $b_content,
//            'b_locked'      =>   $b_locked,
//            'attach_image'  =>   $attach_image,
//            'select_img'    =>   $select_img,
//            'b_group'       =>$max_group_no
//        );
        $data = array(
            'b_group'		=> $params['b_group'],
            'b_code'		=> $params['b_code'],
            'b_title'		=> $params['b_title'],
            'b_writer'      => $params['b_writer'],
            'b_content'		=> $params['b_content'],
            'b_password'	=> $params['b_password'],
            'b_email'		=> $params['b_email'],
            'b_locked'		=> $params['b_locked'],
            'b_ip'		    => $_SERVER['REMOTE_ADDR'],
            'b_board_type'	=> $params['b_board_type'],
            'b_regdate'		=> date('Y-m-d H:i:s',time()),

        );

        if(!empty($b_index)){
            $result = $this->db->update('board', $data,array('b_index'=>$b_index));
            $id = $b_index;
        }else{
            $result = $this->db->insert('board', $data);
            $id = $this->db->insert_id();
        }



        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{

            if(!empty($params["attach_image"])) {
                foreach ($params["attach_image"] as $key => $value) {
                    $temp_image = explode('|', $params["attach_image"][$key]);
                    if ($key == intval($params['select_img'])) {
                        $list_img = 'Y';
                    } else {
                        $list_img = 'N';
                    }
                    $data = array(
                        'b_code' => $params['b_code'],
                        'b_index' => $id,
                        'f_name' => $temp_image[1],
                        'f_type' => $temp_image[2],
                        'f_width' => $temp_image[3],
                        'f_size' => $temp_image[4],
                        'f_rename' => $temp_image[0],
                        'list_img' => $list_img,
                        'file_path' => $params['file_path'],
                        'reg_date' => 'now()'
                    );

                    $img_result = $this->db->insert('boardfile', $data);
                    if ($img_result === false) {
                        $this->db->trans_rollback();
                        return false;
                    }
                }
            }else{

                if(!empty($b_index) && isset($params['select_img'])){
                    $result = $this->get_file($b_index,"image");

                    foreach ($result as $key => $value) {
                        if($key == intval($params['select_img'])) {
                            $data = array(
                                'list_img' => 'Y',
                            );
                            $result = $this->db->update('boardfile', $data,array('f_index'=>$value->f_index));
                        }else{
                            $data = array(
                                'list_img' => 'N',
                            );
                            $result = $this->db->update('boardfile', $data,array('f_index'=>$value->f_index));
                        }
                    }

                }
            }
                $this->db->trans_commit();
                $this->db->trans_complete();
                return $id;
            }


    }

    public function set_bbs_delete($params){

        $result = $this->delete_query('board', array('b_index' => $params['b_index']));
        return $result;
    }
    public function set_file_delete($params){

        $result = $this->delete_query('boardfile', array('b_index' => $params['b_index']));
        return $result;
    }

    public function set_file_delete_one($id){

        $result = $this->delete_query('boardfile', array('f_index' => $id));
        return $result;
    }


    public function movie_img(){
        $query = "select f_Index,b_index,f_name ,f_rename,file_path,reg_date from boardfile ";

        return $this->db->query($query)->result();
    }

    function insert_query($table,$data) {
        $this->db->trans_begin();
        $this->db->insert($table,$data);
        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    /*
     * where_in은 반드시 array
     */
    function update_query($table, $data, $where, $field=false, $where_in=false) {
        $this->db->trans_begin();
        $this->db->where($where);
        if($where_in) {
            $this->db->where_in($field,$where_in);
        }
        $this->db->update($table,$data);
        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function delete_query($table, $where) {
        $this->db->trans_begin();
        $this->db->delete($table, $where);
        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


}