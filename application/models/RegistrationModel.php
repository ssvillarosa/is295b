<?php
/**
 * RegistrationModel
 *
 * Model class for registration entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class RegistrationModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns registration objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of registration objects
    */
    public function getRegistrations($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        $query = $this->db->get('registration_list',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns registration object if registrationId exist in the database.
    *
    * @param    int     $registrationId
    * @return   registration object
    */
    public function getRegistrationById($registrationId){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("id", $registrationId);
        $query = $this->db->get("registration");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Returns registration object if email exist in the database.
    *
    * @param    string     $email
    * @return   registration object
    */
    public function getRegistrationByEmail($email){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("email", trim($email));
        $query = $this->db->get("registration");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds registration to the database.
    *
    * @param    registration object     $registration
    * @return   id of the new registration.
    */
    public function addRegistration($registration){
        unset($registration->confirm_password);
        $registration->password = hashThis($registration->password);
        $this->db->set('created_time', 'NOW()', FALSE);
        $success = $this->db->insert('registration', $registration);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates registration details. Returns true if successful.
    *
    * @param    registration object     $registration
    * @param    compay ID          $registrationId
    * @return   boolean
    */
    public function updateRegistration($registration,$registrationId){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("id", $registrationId);
        $success = $this->db->update('registration', $registration);
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
    public function getRegistrationCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('registration');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the registration status to COMPANY_IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $registrationIds      array of Registration IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deleteRegistration($registrationIds,$userId){
        $this->db->where_in('id', $registrationIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('registration');
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
    public function searchRegistration($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "RegistrationModel->searchRegistration: No columns to display");
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
            $query = $this->db->get('registration_list');            
        }else{
            $query = $this->db->get('registration_list',$limit,$offset);            
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
    public function searchRegistrationCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->from('registration_list');
        $count = $this->db->count_all_results();
        return $count;
    }
    
    public function getRegistrationSkill($registrationId){
        $this->db->select('registration_id,skill_id,name,years_of_experience');
        $this->db->from('registration_skill');
        $this->db->join('skill', 'registration_skill.skill_id = skill.id');
        $this->db->where_in("registration_id", $registrationId);
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
    * Adds registration skills for a particular registration.
    *
    * @param    array of registrationSkill object
    * @return   int     result code
    */
    public function addRegistrationSkills($rawRegistrationSkills){
        $registrationSkills = $this->createRegistrationSkillObject($rawRegistrationSkills);
        $success = $this->db->insert_batch('registration_skill', $registrationSkills);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Deletes registration skills for a particular registration.
    *
    * @param    registrationId  ID of registration
    * @return   int     result code
    */
    public function deleteRegistrationSkills($registrationId){
        $this->db->where('registration_id', $registrationId);
        $success = $this->db->delete('registration_skill');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
    
    /**
    * Creates registration skill object.
    * 
    * @return   registration object
    */
    private function createRegistrationSkillObject($registrationSkills){
        $job_order_skills = [];
        foreach ($registrationSkills as $registrationSkill){
            $job_order_skill = (object)[
                'registration_id' => $registrationSkill->registration_id,
                'skill_id' => $registrationSkill->skill_id,
                'years_of_experience' => $registrationSkill->years_of_experience
            ];
            array_push($job_order_skills, $job_order_skill);
        }
        return $job_order_skills;
    }
}
