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
       
    /**
    * Get list of user activities
    *
    * @return   array of activity object
    */
    public function getUserActivities($userId,$limit=25,$offset=0){
        $this->db->order_by('timestamp', 'DESC');
        $this->db->where("user_id", $userId);
        $query = $this->db->get('activity',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return -1;
        }
        return $query->result();
    }
      
    /**
    * Returns the total count of activities of the user.
    *
    * @param    int     $userId
    */
    public function getUserActivityCount($userId){
        $this->db->where("user_id", $userId);
        $this->db->from('activity');
        return $this->db->count_all_results(); 
    }
}

