<?php
/**
 * PipelineModel
 *
 * Model class for pipeline entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class PipelineModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }

    /**
    * Returns pipeline objects.
    *
    * @param    int        $limit   Limit count
    * @param    int        $offset  Offset value
    * @param    string     $orderBy order by column value
    * @param    string     $order   order value
    * @return   array of pipeline objects
    */
    public function getPipelines($limit=25,$offset=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        if($limit === 0){
            $query = $this->db->get('pipeline_list');        
        }else{
            $query = $this->db->get('pipeline_list',$limit,$offset);       
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }

    /**
    * Returns pipeline objects.
    *
    * @param    int        $limit           Limit count
    * @param    int        $offset          Offset value
    * @param    int        $job_order_id    Job order id value
    * @param    string     $orderBy         Order by column value
    * @param    string     $order           Order value
    * @return   array of pipeline objects
    */
    public function getPipelinesByJobOrder($limit=25,$offset=0,$job_order_id=0,$orderBy='id',$order='asc'){
        $this->db->order_by($orderBy,$order);
        $this->db->where("job_order_id", $job_order_id);
        if($limit === 0){
            $query = $this->db->get('pipeline_list');        
        }else{
            $query = $this->db->get('pipeline_list',$limit,$offset);       
        }
        if(!$job_order_id){
            log_message('error', "$job_order_id value : ".$job_order_id);
            return ERROR_CODE;
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->result();
    }
    
    /**
    * Returns pipeline object if pipelineId exist in the database.
    *
    * @param    int     $pipelineId
    * @return   pipeline object
    */
    public function getPipelineById($pipelineId){
        $this->db->where("id", $pipelineId);
        $query = $this->db->get("pipeline_list");
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $query->row();
    }
    
    /**
    * Adds pipeline to the database.
    *
    * @param    pipeline object     $pipeline
    * @return   id of the new pipeline.
    */
    public function addPipeline($pipeline){
        $this->db->set('created_time', 'NOW()', FALSE);
        $this->db->set('is_deleted',0);
        $success = $this->db->insert('pipeline', $pipeline);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates pipeline details. Returns true if successful.
    *
    * @param    pipeline object     $pipeline
    * @param    pipeline ID          $pipelineId
    * @return   boolean
    */
    public function updatePipeline($pipeline,$pipelineId){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->where("id", $pipelineId);
        $success = $this->db->update('pipeline', $pipeline);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return ERROR_CODE;
        }
        return SUCCESS_CODE;
    }
        
    /**
    * Returns the total count of pipelines that are not deleted.
    */
    public function getPipelineCount(){
        $this->db->where("is_deleted !=", IS_DELETED_TRUE);
        $this->db->from('pipeline');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the pipeline status to IS_DELETED_TRUE. Returns SUCCESS_CODE if successful.
    *
    * @param    int[]     $pipelineIds      array of Pipeline IDs.
    * @param    int       $userId          ID of the user who performed delete.
    * @return   boolean
    */
    public function deletePipeline($pipelineIds,$userId){
        $this->db->where_in('id', $pipelineIds);
        $this->db->set('is_deleted', IS_DELETED_TRUE);
        $this->db->set('deleted_time', 'NOW()', FALSE);
        $this->db->set('deleted_by', $userId);
        $success = $this->db->update('pipeline');
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
    * @return   array of pipeline objects
    */
    public function searchPipeline($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "PipelineModel->searchPipeline: No columns to display");
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
            $query = $this->db->get('pipeline_list');            
        }else{
            $query = $this->db->get('pipeline_list',$limit,$offset);            
        }
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of pipelines based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchPipelineCount($searchParams){
        setWhereParams($this,$searchParams);
        $this->db->from('pipeline_list');
        $count = $this->db->count_all_results();
        return $count;
    }
}
