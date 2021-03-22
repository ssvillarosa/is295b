<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pipeline
 *
 * Handles pipeline page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Pipeline extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        checkUserLogin();
        $this->load->model('PipelineModel');
        $this->load->model('JobOrderUserModel');
        $this->load->model('UserModel');
    }
    
    /**
    * List of pipelines grouped by job order designed for full page of pipeline module.
    */
    public function applicantPipelinePage(){
        $job_order_id = $this->input->get("job_order_id");
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['job_order_id'] = $job_order_id;
        $data['rowsPerPage'] = $rowsPerPage;
        $data['header_on'] = true;
        $this->load->view('pipeline/applicantPipelinePage', $data);
    }
    
    /**
    * List of pipelines grouped by job order designed for ajax request.
    */
    public function applicantPipelineTable(){
        $job_order_id = $this->input->get("job_order_id");
        // Set pagination details.
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $totalCount = count($this->PipelineModel->getPipelinesByJobOrder(0,0,$job_order_id));
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        // Check if user has access to job order.
        $userHasAccess = $this->checkUserAccessToJobOrder($job_order_id,
                $this->session->userdata(SESS_USER_ID));
        if($userHasAccess === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            $this->load->view('pipeline/applicantPipelineTable', $data);
            return;
        }
        $data['user_has_access'] = $userHasAccess;
        // Set data and display view.
        $applicants = $this->PipelineModel->getPipelinesByJobOrder($rowsPerPage,$data['offset'], $job_order_id);        
        if($applicants === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            $this->load->view('pipeline/applicantPipelineTable', $data);
            return;
        }
        $data['pipelines'] = $applicants;
        $data['job_order_id'] = $job_order_id;
        $this->load->view('pipeline/applicantPipelineTable', $data);
    }
    
    /**
    * Checks if user has access to job order. If user has admin role or user 
    * is assigned to job order, return true. Otherwise, return false.
    * 
    * @param    integer     $job_order_id   Value of job order ID.
    * @param    integer     $user_id        Value of user ID.
    * @return   boolean
    */
    private function checkUserAccessToJobOrder($job_order_id,$user_id){
        $user=$this->UserModel->getUserById($user_id);
        if($user->role == USER_ROLE_ADMIN){
            return true;
        }
        $job_order_users = $this->JobOrderUserModel->getUsersByJobOrderId($job_order_id);
        if($job_order_users === ERROR_CODE){
            return ERROR_CODE;
        }
        foreach ($job_order_users as $user){
            if($user->user_id == $user_id){
                return true;
            }
        }
        return false;
    }
}