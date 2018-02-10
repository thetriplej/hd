<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    function get_porpula_list() {
        $query = "select board.B_Index,board.B_Title,board.B_Code,board.B_Password,board.B_Board_Type,boardfile.F_Name
                    from board 
                    left join  boardfile on board.B_Index = boardfile.B_Index
                    where board.B_Index in(select popular_log.board_idx from popular_log where popular_log.show_flag =1)";
        return $this->db->query($query)->result();
    }

}