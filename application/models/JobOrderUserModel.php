<?php
/**
 * JobOrderUserModel
 *
 * Model class for Job Order User entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class JobOrderUserModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }
    
    /**
    * Returns job order users for a particular job order.
    *
    * @param    int     $jobOrderIds
    * @return   array of jobOrderUser object
    */
    public function getUsersByJobOrderId($jobOrderIds){
        $this->db->select('job_order_id,user_id,user.name,user.username');
        $this->db->from('job_order_user');
        $this->db->join('user', 'job_order_user.user_id = user.id');
        $this->db->where_in("job_order_id", $jobOrderIds);
        $this->db->where("user.status !=", USER_STATUS_DELETED);
        $query = $this->db->get();
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Adds job order users for a particular job order.
    *
    * @param    array of jobOrderUser object
    * @return   int     result code
    */
    public function addJobOrderUsers($rawJobOrderUsers){
        $jobOrderUsers = $this->createJobOrderUserObject($rawJobOrderUsers);
        $success = $this->db->insert_batch('job_order_user', $jobOrderUsers);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Deletes job order users for a particular job order.
    *
    * @param    jobOrderId  ID of job order
    * @return   int     result code
    */
    public function deleteJobOrderUsers($jobOrderId){
        $this->db->where('job_order_id', $jobOrderId);
        $success = $this->db->delete('job_order_user');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Creates job order user object.
    * 
    * @return   job order object
    */
    private function createJobOrderUserObject($jobOrderUsers){
        $job_order_users = [];
        foreach ($jobOrderUsers as $jobOrderUser){
            $job_order_user = (object)[
                'job_order_id' => $jobOrderUser->job_order_id,
                'user_id' => $jobOrderUser->user_id,
            ];
            array_push($job_order_users, $job_order_user);
        }
        return $job_order_users;
    }
}