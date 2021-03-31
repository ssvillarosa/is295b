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
    * Returns activity objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of activity objects
    */
    public function getActivities($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        if($limit === 0){
            $query = $this->db->get('activity_list');            
        }else{ 
            $query = $this->db->get('activity_list',$limit,$offset);           
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns activity object if activityId exist in the database.
    *
    * @param    int     $activityId
    * @return   company object
    */
    public function getActivityById($activityId){
        $this->db->where("id", $activityId);
        $query = $this->db->get("activity");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds activity to the database.
    *
    * @param    activity object     $activity
    * @return   id of the new activity.
    */
    public function addActivity($activity){
        $success = $this->db->insert('activity', $activity);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates activity details. Returns true if successful.
    *
    * @param    activity object     $activity
    * @return   boolean
    */
    public function updateActivity($activity,$activityId){
        $this->db->where("id", $activityId);
        $success = $this->db->update('activity', $activity);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of activitys that are not deleted.
    */
    public function getActivityCount(){
        $this->db->from('activity');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Returns array of companies based on critera.
    *
    * @param    object     $searchParams    List of criteria includig display columns
    * @param    int     $offset Offset value
    * @return   array of companies objects
    */
    public function searchActivity($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "ActivityModel->searchUser: No columns to display");
            return false;
        }
        // Set select columns
        $this->db->select("id");
        foreach ($columns as &$column) {
            $this->db->select($column);
        }
        // Set where conditions
        setWhereParams($this,$searchParams);
        if($limit === 0){
            $query = $this->db->get('activity_list');            
        }else{
            $query = $this->db->get('activity_list',$limit,$offset);            
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of activitys based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchActivityCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->from('activity_list');
        $count = $this->db->count_all_results();
        return $count;
    }
}