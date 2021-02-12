<?php
/**
 * CompanyModel
 *
 * Model class for company entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class CompanyModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns user objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of company objects
    */
    public function getCompanies($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->order_by($orderBy,$order);
        $query = $this->db->get('company',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns company object if companyId exist in the database.
    *
    * @param    int     $companyId
    * @return   company object
    */
    public function getCompanyById($companyId){
        $this->db->where("id", $companyId);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $query = $this->db->get("company");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds company to the database.
    *
    * @param    company object     $company
    * @return   id of the new company.
    */
    public function addCompany($company){
        $this->db->set('created_time', 'NOW()', FALSE);
        $success = $this->db->insert('company', $company);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates company details. Returns true if successful.
    *
    * @param    company object     $user
    * @return   boolean
    */
    public function updateCompany($company,$companyId){
        $this->db->where("id", $companyId);
        $success = $this->db->update('company', $company);
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
    public function getCompanyCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('company');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the company status to COMPANY_IS_DELETED_TRUE(1). Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $companyIds      array of user IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deleteCompany($companyIds,$userId){
        $this->db->where_in('id', $companyIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('company');
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
    public function searchUser($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "CompanyModel->searchUser: No columns to display");
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
            $query = $this->db->get('company');            
        }else{
            $query = $this->db->get('company',$limit,$offset);            
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
    public function searchUserCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('company');
        $count = $this->db->count_all_results();
        return $count;
    }
}
