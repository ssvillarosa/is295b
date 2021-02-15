<?php
/**
 * JobOrderModel
 *
 * Model class for Job Order entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class JobOrderModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns job order objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of job order objects
    */
    public function getJobOrders($limit=25,$offset=0){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get('job_order_list',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns job order object if jobOrderId exist in the database.
    *
    * @param    int     $jobOrderId
    * @return   company object
    */
    public function getJobOrderById($jobOrderId){
        $this->db->where("id", $jobOrderId);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get("job_order");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds job order to the database.
    *
    * @param    job order object     $jobOrder
    * @return   id of the new job order.
    */
    public function addJobOrder($jobOrder){
        $this->db->set('created_time', 'NOW()', FALSE);
        $success = $this->db->insert('job_order', $jobOrder);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates job order details. Returns true if successful.
    *
    * @param    job order object     $jobOrder
    * @return   boolean
    */
    public function updateJobOrder($jobOrder,$jobOrderId){
        $this->db->where("id", $jobOrderId);
        $success = $this->db->update('job_order', $jobOrder);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of job orders that are not deleted.
    */
    public function getJobOrderCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('job_order');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the job order status to IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $JobOrderIds      array of user IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deleteJobOrder($JobOrderIds,$userId){
        $this->db->where_in('id', $JobOrderIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('job_order');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Returns array of companies based on critera.
    *
    * @param    object     $searchParams    List of criteria includig display columns
    * @param    int     $offset Offset value
    * @return   array of companies objects
    */
    public function searchJobOrder($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "JobOrderModel->searchUser: No columns to display");
            return false;
        }
        // Set select columns
        $this->db->select("id");
        foreach ($columns as &$column) {
            $this->db->select($column);
        }
        // Set where conditions
        setWhereParams($this,$searchParams);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        if($limit === 0){
            $query = $this->db->get('job_order_list');            
        }else{
            $query = $this->db->get('job_order_list',$limit,$offset);            
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of job orders based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchJobOrderCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('job_order_list');
        $count = $this->db->count_all_results();
        return $count;
    }
}