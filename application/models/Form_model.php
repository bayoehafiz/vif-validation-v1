<?php
class Form_model extends CI_Model{

	public function getforms(){
	    $q = $this->db->query('SELECT F.*,B.branch_name FROM form as F,branch as B where F.branch=B.id');
 
	    if($q->num_rows() > 0){
	      foreach ($q->result() as $row){
	        $data[] = $row;
	      }
	      return $data;
	    }
	}
}
?>
