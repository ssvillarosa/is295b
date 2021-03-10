<?php
/**
 * ApplicantModel
 *
 * Model class for applicant entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class ApplicantModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns applicant objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of applicant objects
    */
    public function getApplicants($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->order_by($orderBy,$order);
        $query = $this->db->get('applicant',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns applicant object if applicantId exist in the database.
    *
    * @param    int     $applicantId
    * @return   applicant object
    */
    public function getApplicantById($applicantId){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("id", $applicantId);
        $query = $this->db->get("applicant");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Returns applicant object if email exist in the database.
    *
    * @param    string     $email
    * @return   applicant object
    */
    public function getApplicantByEmail($email){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("email", trim($email));
        $query = $this->db->get("applicant");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Sets the applicant status to APPLICANT_STATUS_BLOCKED and returns true if success.
    *
    * @param    int     $applicantId
    * @return   boolean
    */
    public function blockApplicant($applicantIds){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where_in('id', $applicantIds);
        $success = $this->db->update('applicant', array('status' => APPLICANT_STATUS_BLOCKED));
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Sets the applicant status to APPLICANT_STATUS_ACTIVE and returns true if success.
    *
    * @param    int     $applicantId
    * @return   boolean
    */
    public function activateApplicant($applicantIds){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where_in('id', $applicantIds);
        $success = $this->db->update('applicant', array('status' => APPLICANT_STATUS_ACTIVE));
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Adds applicant to the database.
    *
    * @param    applicant object     $applicant
    * @return   id of the new applicant.
    */
    public function addApplicant($applicant){
        $this->db->set('created_time', 'NOW()', FALSE);
        $success = $this->db->insert('applicant', $applicant);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates applicant details. Returns true if successful.
    *
    * @param    applicant object     $applicant
    * @param    compay ID          $applicantId
    * @return   boolean
    */
    public function updateApplicant($applicant,$applicantId){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("id", $applicantId);
        $success = $this->db->update('applicant', $applicant);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of companies that are not deleted.
    */
    public function getApplicantCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('applicant');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the applicant status to COMPANY_IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $applicantIds      array of Applicant IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deleteApplicant($applicantIds,$userId){
        $this->db->where_in('id', $applicantIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('applicant');
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
    public function searchApplicant($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "ApplicantModel->searchApplicant: No columns to display");
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
            $query = $this->db->get('applicant_list');            
        }else{
            $query = $this->db->get('applicant_list',$limit,$offset);            
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of companies based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchApplicantCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->from('applicant_list');
        $count = $this->db->count_all_results();
        return $count;
    }
    
    public function getApplicantSkill($applicantId){
        $this->db->select('applicant_id,skill_id,name,years_of_experience');
        $this->db->from('applicant_skill');
        $this->db->join('skill', 'applicant_skill.skill_id = skill.id');
        $this->db->where_in("applicant_id", $applicantId);
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
    * Adds applicant skills for a particular applicant.
    *
    * @param    array of applicantSkill object
    * @return   int     result code
    */
    public function addApplicantSkills($rawApplicantSkills){
        $applicantSkills = $this->createApplicantSkillObject($rawApplicantSkills);
        $success = $this->db->insert_batch('applicant_skill', $applicantSkills);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Deletes applicant skills for a particular applicant.
    *
    * @param    applicantId  ID of applicant
    * @return   int     result code
    */
    public function deleteApplicantSkills($applicantId){
        $this->db->where('applicant_id', $applicantId);
        $success = $this->db->delete('applicant_skill');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Creates applicant skill object.
    * 
    * @return   applicant object
    */
    private function createApplicantSkillObject($applicantSkills){
        $job_order_skills = [];
        foreach ($applicantSkills as $applicantSkill){
            $job_order_skill = (object)[
                'applicant_id' => $applicantSkill->applicant_id,
                'skill_id' => $applicantSkill->skill_id,
                'years_of_experience' => $applicantSkill->years_of_experience
            ];
            array_push($job_order_skills, $job_order_skill);
        }
        return $job_order_skills;
    }
}
