<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    function id_check($params){
        $id  = $params['id'];
        $password  = $params['password'];
        $sql = "SELECT m_id,m_pw FROM manager WHERE m_id = ?";
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }

    function login($params){
        $id  = $params['id'];
        $password  = $params['password'];
        $sql = "SELECT m_id,m_level,m_name FROM manager WHERE m_id = ? and m_pw = ?";
        $result = $this->db->query($sql, array($id,$password))->row();
        return $result;
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