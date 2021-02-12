<?php
/**
 * JobOrderSkillModel
 *
 * Model class for Job Order Skill entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class JobOrderSkillModel extends CI_Model{
    
    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }
    
    /**
    * Returns job order skills for a particular job order.
    *
    * @param    int     $jobOrderId
    * @return   array of jobOrderSkill object
    */
    public function getSkillsByJobOrderId($jobOrderId){
        $this->db->select('job_order_id,skill_id,name,years_of_experience');
        $this->db->from('job_order_skill');
        $this->db->join('skill', 'job_order_skill.skill_id = skill.id');
        $this->db->where("job_order_id", $jobOrderId);
        $this->db->where("skill.is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get();
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
}