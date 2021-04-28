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
    * Returns skill objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of skill objects
    */
    public function getSkills($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        if($limit === 0){ 
            $query = $this->db->get('skill_list');          
        }else{
            $query = $this->db->get('skill_list',$limit,$offset);         
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns skill object if skillId exist in the database.
    *
    * @param    int     $skillId
    * @return   company object
    */
    public function getSkillById($skillId){
        $this->db->where("id", $skillId);
        $query = $this->db->get("skill_list");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Returns skill object based on category.
    *
    * @param    int     $skillCategoryId
    * @return   array of skill object
    */
    public function getSkillByCategoryId($skillCategoryId){
        $this->db->where("category_id", $skillCategoryId);
        $query = $this->db->get("skill_list");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Adds skill to the database.
    *
    * @param    skill object     $skill
    * @return   id of the new skill.
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
    * Updates skill details. Returns true if successful.
    *
    * @param    skill object     $skill
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
    * Returns the total count of skills that are not deleted.
    */
    public function getSkillCount(){
        $this->db->from('skill_list');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the skill status to IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
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
    
    /**
    * Checks whether skill already exist in the database.
    *
    * @param    string      $name           Name of the skill.
    * @param    int         $category_id    ID of the category.
    * @return   boolean
    */
    public function skillExist($name,$category_id=''){
        $this->db->where("name", $name);
        if($category_id){
            $this->db->where("category_id", $category_id);
        }
        $query = $this->db->get("skill_list");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return count($query->result()) > 0 ? true : false;
    }
}