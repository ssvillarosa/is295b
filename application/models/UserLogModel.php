<?php
/**
 * UserLogModel
 *
 * Model class for UserLog entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class UserLogModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }
    
    /**
    * Insert user log to table user_log.
    *
    * @param    int     $userId
    * @param    string  $activity
    */
    public function saveUserLog($userId,$activity){
        $this->db->set('timestamp', 'NOW()', FALSE);
        $this->db->set('user_id', $userId);
        $this->db->set('activity', $activity);
        return $this->db->insert('user_log');
    }
       
    /**
    * Get list of user activities
    *
    * @return   array of user_log object
    */
    public function getUserLogs($userId,$limit=25,$offset=0){
        $this->db->order_by('timestamp', 'DESC');
        $this->db->where("user_id", $userId);
        $query = $this->db->get('user_log',$limit,$offset);
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
    public function getUserLogCount($userId){
        $this->db->where("user_id", $userId);
        $this->db->from('user_log');
        return $this->db->count_all_results(); 
    }
}

