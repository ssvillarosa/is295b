<?php
/**
 * EventModel
 *
 * Model class for Event entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class EventModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns event objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of event objects
    */
    public function getEvents($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        if($limit === 0){
            $query = $this->db->get('event_list');            
        }else{ 
            $query = $this->db->get('event_list',$limit,$offset);           
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns event object if eventId exist in the database.
    *
    * @param    int     $eventId
    * @return   company object
    */
    public function getEventById($eventId){
        $this->db->where("id", $eventId);
        $query = $this->db->get("event");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds event to the database.
    *
    * @param    event object     $event
    * @return   id of the new event.
    */
    public function addEvent($event){
        $success = $this->db->insert('event', $event);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates event details. Returns true if successful.
    *
    * @param    event object     $event
    * @return   boolean
    */
    public function updateEvent($event,$eventId){
        $this->db->where("id", $eventId);
        $success = $this->db->update('event', $event);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of events that are not deleted.
    */
    public function getEventCount(){
        $this->db->from('event');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Returns array of companies based on critera.
    *
    * @param    object     $searchParams    List of criteria includig display columns
    * @param    int     $offset Offset value
    * @return   array of companies objects
    */
    public function searchEvent($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "EventModel->searchUser: No columns to display");
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
            $query = $this->db->get('event_list');            
        }else{
            $query = $this->db->get('event_list',$limit,$offset);            
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of events based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchEventCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->from('event_list');
        $count = $this->db->count_all_results();
        return $count;
    }
}