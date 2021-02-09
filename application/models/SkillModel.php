<?php
/**
 * SkillModel
 *
 * Model class for Job Order entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class SkillModel extends CI_Model{
    
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
    public function getSkills($limit=25,$offset=0){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get('skill',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns job order object if skillId exist in the database.
    *
    * @param    int     $skillId
    * @return   company object
    */
    public function getSkillById($skillId){
        $this->db->where("id", $skillId);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get("skill");
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
    * @param    job order object     $skill
    * @return   id of the new job order.
    */
    public function addSkill($skill){
        $this->db->set('created_time', 'NOW()', FALSE);
        $success = $this->db->insert('skill', $skill);
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
    * @param    job order object     $skill
    * @return   boolean
    */
    public function updateSkill($skill,$skillId){
        $this->db->where("id", $skillId);
        $success = $this->db->update('skill', $skill);
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
    public function getSkillCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('skill');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the job order status to IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $SkillIds      array of user IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deleteSkill($SkillIds,$userId){
        $this->db->where_in('id', $SkillIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('skill');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
}