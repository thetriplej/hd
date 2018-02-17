<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    function get_porpula_list() {
        $query = "select board.B_Index,board.B_Title,board.B_writer,board.B_Code,board.B_Board_Type,boardfile.F_Name,boardfile.list_img,boardfile.f_index
                    from board 
                    left join  boardfile on board.B_Index = boardfile.B_Index
                    where board.B_Index in(select popular_log.board_idx from popular_log where popular_log.show_flag =1) 
                    and LEFT(F_Type, 5) = 'image' 
                    and boardfile.list_img = 'Y'
                    order by F_Show desc, F_Index asc";
        return $this->db->query($query)->result();
    }


    function get_gallery_list($params){

        $list_rows  = $params['list_rows'];
        $page_start = $params['page_start'];
        $page 		= $params['page'];
        $page_no 	= $params['page_no'];
        $search_type = $params['search_type'];
        $search_value= $params['search_value'];
        $board_type = $params['board_type'];

        $start_row = (($page-1)*$list_rows)+1;
        $end_row = $page*$list_rows;

        $where="";
        if(!empty($search_value)){ //게시물 검색어
            $like_word = " and ".$search_type." like '%".$search_value."%' ";
        }else{
            $like_word = "";
        }

        $query = "SELECT board.B_Title,board.B_Board_Type,board.B_Code,board.B_Index,board.B_Hit,
                    DATE_FORMAT(board.B_RegDate,'%Y-%m-%d') B_RegDate,board.B_Writer,board.B_Board_Type,tmp_boardfile.F_Name,
                    tmp_boardfile.list_img,tmp_boardfile.f_index,(select count(*) from board tmp where tmp.b_parentindex = board.b_index) as reply
                    FROM Board as board 
                    left join  (select F_Name,list_img,f_index,B_Index from boardfile where boardfile.list_img='Y') as tmp_boardfile on board.B_Index = tmp_boardfile.B_Index
                    where 
                      board.b_code = ? AND
                      board.b_parentindex = 0 and
                      board.B_Sequence =1 
                      ".$like_word."
                    ORDER BY board.B_index desc limit ".$start_row.",".$list_rows;
        return $this->db->query($query,array($board_type))->result();
    }

    function get_list_tot($params){ //리스트 페이징을 위한 토탈 카운트

        $table_name = $params['table_name'];
        $board_type = $params['board_type'];
        $search_type = $params['search_type'];
        $search_value	= $params['search_value'];
        $where="";


        if(!empty($search_value)){ //게시물 검색어
            $like_word = " and ".$search_type." like '%".$search_value."%' ";

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

}