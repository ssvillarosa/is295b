<?php
	
Class UserModel extends CI_Model{
	
    public function __construct() {
        $this->load->database();
    }
    
    public function getUserByCred($username,$password){
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $query = $this->db->get("user");
        return $query->row();
    }
    
    public function getUserByUsername($username){
        $this->db->where("username", $username);
        $query = $this->db->get("user");
        return $query->row();
    }
    
    public function getUsers($limit=100,$offset=0){
        $query = $this->db->get('user',$limit,$offset);
        return $query->result();
    }
    
    public function getUser($userId){
        $this->db->where("id", $userId);
        $query = $this->db->get("user");
        return $query->row();
    }
}

?>

