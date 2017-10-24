<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Crud extends CI_Model{
    public function Get($table){
        $res = $this->db->get($table); 
        return $res->result_array();
    }
 
    public function Insert($table,$data){
        $res = $this->db->insert($table, $data);
        return $res;
    }
 
    public function Update($table, $data, $where){
        $res = $this->db->update($table, $data, $where); 
        return $res;
    }
 
    public function Delete($table, $where){
        $res = $this->db->delete($table, $where);
        return $res;
    }

    public function GetWhere($table, $data){
        $res=$this->db->get_where($table, $data);
        return $res->result_array();
    }

    public function GetLastRecord($table){
        $res = $this->db->get($table); 
        return $res->result_array();
    }

    public function CheckLogin($table,$where){      
        return $this->db->get_where($table,$where);
    }

    public function CheckEmail($key)
    {
        $query = $this->db->get_where('users', array('email' => $key));
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function CheckUsername($key)
    {
        $query = $this->db->get_where('users', array('username' => $key));
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function specialQuery($string){
        $data = $this->db->query($string)->result_array();
        if(count($data) > 0){
            return $data;
        }
    }   

}
?>