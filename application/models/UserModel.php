<?php
/**
 * UserModel
 *
 * Model class for user entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class UserModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns user object if username and password exist in the database.
    *
    * @param    string  $username   Username string
    * @param    string  $password   Password string
    * @return   user object
    */
    public function getUserByCred($username,$password){
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $query = $this->db->get("user");
        return $query->row();
    }
    
    /**
    * Returns user object if username exist in the database.
    *
    * @param    string  $username   Username string
    * @return   user object
    */
    public function getUserByUsername($username){
        $this->db->where("username", $username);
        $query = $this->db->get("user");
        return $query->row();
    }

    /**
    * Returns user objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of user objects
    */
    public function getUsers($limit=100,$offset=0){
        $query = $this->db->get('user',$limit,$offset);
        return $query->result();
    }
    
    /**
    * Returns user object if userId exist in the database.
    *
    * @param    int     $userId
    * @return   user object
    */
    public function getUserById($userId){
        $this->db->where("id", $userId);
        $query = $this->db->get("user");
        return $query->row();
    }
    
    /**
    * Sets the user status to USER_STATUS_BLOCKED(1).
    *
    * @param    int     $userId
    */
    public function blockUser($userId){
        $this->db->where("id", $userId);
        $this->db->update('user', array('status' => USER_STATUS_BLOCKED));
    }
    
    /**
    * Increments failed_login count.
    *
    * @param    int     $userId
    */
    public function addLoginFailed($userId){
        $this->db->where("id", $userId);
        $this->db->set('failed_login', 'failed_login+1', FALSE);
        $this->db->update('user');
    }
    
    /**
    * Resets failed_login count.
    *
    * @param    int     $userId
    */
    public function resetLoginFailed($userId){
        $this->db->where("id", $userId);
        $this->db->set('failed_login', 0);
        $this->db->update('user');
    }
}

?>

