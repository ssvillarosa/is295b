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
    * @param    int     $jobOrderIds
    * @return   array of jobOrderSkill object
    */
    public function getSkillsByJobOrderId($jobOrderIds){
        $this->db->select('job_order_id,skill_id,name,years_of_experience');
        $this->db->from('job_order_skill');
        $this->db->join('skill', 'job_order_skill.skill_id = skill.id');
        $this->db->where_in("job_order_id", $jobOrderIds);
        $this->db->where("skill.is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get();
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Adds job order skills for a particular job order.
    *
    * @param    array of jobOrderSkill object
    * @return   int     result code
    */
    public function addJobOrderSkills($rawJobOrderSkills){
        $jobOrderSkills = $this->createJobOrderSkillObject($rawJobOrderSkills);
        $success = $this->db->insert_batch('job_order_skill', $jobOrderSkills);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Deletes job order skills for a particular job order.
    *
    * @param    jobOrderId  ID of job order
    * @return   int     result code
    */
    public function deleteJobOrderSkills($jobOrderId){
        $this->db->where('job_order_id', $jobOrderId);
        $success = $this->db->delete('job_order_skill');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Creates job order skill object.
    * 
    * @return   job order object
    */
    private function createJobOrderSkillObject($jobOrderSkills){
        $job_order_skills = [];
        foreach ($jobOrderSkills as $jobOrderSkill){
            $job_order_skill = (object)[
                'job_order_id' => $jobOrderSkill->job_order_id,
                'skill_id' => $jobOrderSkill->skill_id,
                'years_of_experience' => $jobOrderSkill->years_of_experience
            ];
            array_push($job_order_skills, $job_order_skill);
        }
        return $job_order_skills;
    }
}