<?php
	
Class UserModel extends CI_Model{
	
    public function __construct() {
        $this->load->database();
    }
    
    public function login($username,$password){
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $query = $this->db->get("users");
        return $query->row_array();
    }
    
    public function getUsers($limit=100,$offset=0){
        $query = $this->db->get('user',$limit,$offset);
        return $query->result();
    }
    
    public function getUser($userId){
        $this->db->where("id", $userId);
        $query = $this->db->get("user");
        return $query->row_array();
    }
}

?>

