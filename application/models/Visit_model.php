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
        }else if($mode =="referer"){
            $select = "cast(create_at as date)as created_at";
            $where = "create_at >= '".$start_date."' AND create_at <= '".$end_date."'";
            $groupby = " group by created_at ";
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
        }else if($mode =="referer"){
            $select = "count(idx) as cnt ,sum(case when agent_type='1' then 1 else 0 end) pc, sum(case when agent_type='2' then 1 else 0 end) mobile,cast(create_at as date)as created_at";
            $where = "domain is not null and create_at >= '".$start_date."' and create_at <= '".$end_date."'";
            $groupby = " group by created_at";
            $orderby = " order by created_at desc";
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

    function get_visit_referer_view($params){
        $view_date  = $params['view_date'];

        $query = "select cnt,pc,mobile,created_at,domain from (
                    select count(domain) as cnt ,sum(case when agent_type='1' then 1 else 0 end) pc, 
                    sum(case when agent_type='2' then 1 else 0 end) mobile,cast(create_at as date) as created_at,domain
                    from referer where cast(create_at as date) ='".$view_date."' 
                    group by cast(create_at as date),domain) k
                  order by cnt desc ";

        return $this->db->query($query)->result();
    }

    function get_log_check($params){
        $agent_mode = $params['agent_mode'];
        $url = $params['url'];
        $today = date("Y-m-d");

        $query = "select l_hit from pagelog where l_url='".$url."' and mode ='".$agent_mode."' and l_date ='".$today."'";
        return $this->db->query($query)->result();
    }

    function set_log($params){
        $this->db->trans_begin();
        $type = $params['type'];
        $agent_mode = $params['agent_mode'];
        $url = $params['url'];
        $today = date("Y-m-d");


        if($type == "update"){
            $query = "update pagelog set l_hit = l_hit + 1 where mode=? and l_date = ? and l_url = ?";
            $result = $this->db->query($query, array('mode'=>$agent_mode,'l_date'=>$today,'l_url'=>$url));

        }else{
            $data = array(
                'l_date'    =>$today,
                'l_url'		=> $url,
                'l_title'	=> $params['l_title'],
                'l_hit'     => 1,
                'mode'      => $agent_mode,
            );
            $result = $this->db->insert('pagelog', $data);

        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            $this->db->trans_complete();
            return true;
        }
    }

    function set_visit_log($params){
        $this->db->trans_begin();
        $user_ip = $params['user_ip'];
        $agent_mode = $params['agent_mode'];
        $today = date("Y-m-d");

        $query ="select cnt from visit_log where ip =? and visit_date = ? and agent_type =?";
        $result = $this->db->query($query, array('ip'=>$user_ip,'visit_date'=>$today,'agent_type'=>$agent_mode));
//var_dump($query);
        if($result){
            $query = "update visit_log set cnt = cnt + 1 where ip=? and visit_date = ? and agent_type = ?";
            $result = $this->db->query($query, array('ip'=>$user_ip,'visit_date'=>$today,'agent_type'=>$agent_mode));

        }else{
            $data = array(
                'cnt'           => 1,
                'ip'		    => $user_ip,
                'visit_date'	=> $today,
                'agent_type'    => $agent_mode,
            );
            $result = $this->db->insert('visit_log', $data);

        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            $this->db->trans_complete();
            return true;
        }
    }

    function set_referrer($params){
        $domain = $params['domain'];
        $agent_mode = $params['agent_type'];
        $url = $params['url'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $file_data = array(
            'domain'		    => $domain,
            'http_referer_url'	=> $url,
            'user_ip'		    => $user_ip,
            'user_agent'		=> $user_agent,
            'create_at'		    => date('Y-m-d H:i:s',time()),
            'agent_type'	    => $agent_mode,
        );
        $result = $this->insert_query('referer',$file_data);

        return $result;

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