<?php
/**
 * SkillCategoryModel
 *
 * Model class for Job Order entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class SkillCategoryModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns skillCategory objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of skillCategory objects
    */
    public function getSkillCategories($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->order_by($orderBy,$order);
        if($limit === 0){ 
            $query = $this->db->get('skill_category');          
        }else{
            $query = $this->db->get('skill_category',$limit,$offset);         
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns skillCategory object if skillId exist in the database.
    *
    * @param    int     $skillId
    * @return   company object
    */
    public function getSkillCategoryById($skillCategoryId){
        $this->db->where("id", $skillCategoryId);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get("skill_category");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds skillCategory to the database.
    *
    * @param    skill object     $skill
    * @return   id of the new skill.
    */
    public function addSkillCategory($skillCategory){
        $success = $this->db->insert('skill_category', $skillCategory);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates skillCategory details. Returns true if successful.
    *
    * @param    skill object     $skill
    * @return   boolean
    */
    public function updateSkillCategory($skillCategory,$skillCategoryId){
        $this->db->where("id", $skillCategoryId);
        $success = $this->db->update('skill_category', $skillCategory);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of skillCategory that are not deleted.
    */
    public function getSkillCategoryCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('skill_category');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the skillCategory status to IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $skillCategoryId      array of user IDs.
    * @return   boolean
    */
    public function deleteSkillCategory($skillCategoryId){
        $this->db->where_in('id', $skillCategoryId);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $success = $this->db->update('skill_category');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
}