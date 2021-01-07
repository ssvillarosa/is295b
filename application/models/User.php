<?php
	
Class User extends CI_Model{
	
    public function __construct() {
        $this->load->database();
    }
    
    public function login($username,$password){
		$this->db->where("username", $username);
		$this->db->where("password", $password);
        $query = $this->db->get("users");
		return $query->row_array();
    }
    
}

?>

