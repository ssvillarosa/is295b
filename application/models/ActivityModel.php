<?php
/**
 * ActivityModel
 *
 * Model class for Activity entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class ActivityModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }
    
    /**
    * Insert user log to table activity.
    *
    * @param    int     $userId
    * @param    string  $activity
    */
    public function saveUserActivity($userId,$activity){
        $this->db->set('timestamp', 'NOW()', FALSE);
        $this->db->set('user_id', $userId);
        $this->db->set('activity', $activity);
        return $this->db->insert('activity');
    }
}
?>

