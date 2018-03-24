<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visit_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function get_list_tot($params){ //리스트 페이징을 위한 토탈 카운트

        $table_name = $params['table_name'];
        $mode       = $params['mode'];
        $start_date = $params['start_date'];
        $end_date   = $params['end_date'];
        if($mode == "old2"){
            $select = "l_index";
            $where = "l_date >= '".$start_date."' AND l_date <= '".$end_date."'";
            $groupby = " group by l_date";
        }else if($mode == "new"){
            $select = "idx";
            $where = "visit_date >= '".$start_date."' AND visit_date <= '".$end_date."'";
            $groupby = " group by visit_date";
        }

        $main_query ="select ".$select." from ".$table_name. " where  ".$where.$groupby;

        $tot_rows = $this->db->query($main_query)->num_rows();
        return $tot_rows;

    }


    function get_visit_list($params){

        $list_rows  = $params['list_rows'];
        $page_start = $params['page_start'];
        $page 		= $params['page'];
        $page_no 	= $params['page_no'];
        $start_date = $params['start_date'];
        $end_date   = $params['end_date'];
        $table_name   = $params['table_name'];
        $mode = $params['mode'];

        $start_row = (($page-1)*$list_rows);
        $end_row = $page*$list_rows;

//        영문페이지 스트립트 적용및 테스트
//        파일업로드 용량체크 한번에 50M까지
//        접속자
//        유입경로
        if($mode == "old2"){

            $select = "l_date,count(l_hit) as l_hit";
            $where = "l_date >= '".$start_date."' and l_date <= '".$end_date."'";
            $groupby = " group by l_date";
            $orderby = " order by l_index desc";
        }else if($mode == "new"){

            $select = "count(idx) as cnt ,sum(case when agent_type='1' then 1 else 0 end) pc, sum(case when agent_type='2' then 1 else 0 end) mobile,visit_date";
            $where = "visit_date >= '".$start_date."' and visit_date <= '".$end_date."'";
            $groupby = " group by visit_date";
            $orderby = " order by visit_date desc";
        }


        $query = "select ".$select." from $table_name where ".$where.$groupby.$orderby." limit ".$start_row.",".$list_rows;


        return $this->db->query($query)->result();
    }

    function get_visit_view($params){
        $view_date  = $params['view_date'];

        $query = "select l_index,l_date,l_url,l_title,l_hit,mode 
                  from pagelog 
                  where l_date ='".$view_date."' and l_index is not null 
                  order by l_hit desc, mode desc ";

        return $this->db->query($query)->result();
    }

    function get_visit_ip_view($params){
        $view_date  = $params['view_date'];

        $query = "select idx,cnt,ip,visit_date,agent_type 
                  from visit_log 
                  where visit_date ='".$view_date."' 
                  order by cnt desc";

        return $this->db->query($query)->result();
    }


    function insert_query($table,$data) {
        $this->db->trans_begin();
        $this->db->insert($table,$data);
        if($this->db->trans_status() === false) {
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
        if($this->db->trans_status() === false) {
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
        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


}