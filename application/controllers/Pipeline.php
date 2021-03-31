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
        $totalCount = count($this->PipelineModel->getPipelinesByJobOrder(0,0,$job_order_id,'id','desc'));
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
        $users = $this->JobOrderUserModel->getUsersByJobOrderId($job_order_id);
        if($users === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            $this->load->view('pipeline/applicantPipelineTable', $data);
            return;
        }
        $data["users"] = $users;
        $data['pipelines'] = $applicants;
        $data['job_order_id'] = $job_order_id;
        $this->load->view('pipeline/applicantPipelineTable', $data);
    }
    
    /**
    * Display pipeline details.
    */
    public function view(){
        checkUserLogin();
        $pipelineId = $this->input->get('id');
        if(!$pipelineId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'pipeline/detailsView');
            return;
        }
        $pipeline = $this->PipelineModel->getPipelineById($pipelineId);
        if($pipeline === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'pipeline/detailsView');
            return;
        }
        $data['pipeline'] = $pipeline;
        renderPage($this,$data,'pipeline/detailsView');
    }
    
    /**
    * Add pipeline entry.
    */
    public function add(){
        $job_order_id = $this->input->post('job_order_id');
        if(!$job_order_id){
            echo 'Invalid Job Order';
            return;
        }
        $applicant_id = $this->input->post('applicant_id');
        if(!$applicant_id){
            echo 'Please select a candidate.';
            return;
        }
        if(!$this->input->post('assigned_to')){
            echo 'Please select an assignee.';
            return;
        }
        $pipeline = $this->createPipelineObject(true);
        // If the logged in user is not admin, assign the assigned_to to that user.
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $pipeline->assigned_to = $this->session->userdata(SESS_USER_ID);
        }
        $pipeline->status = PIPELINE_STATUS_UNSET;
        $pipeline->created_by = $this->session->userdata(SESS_USER_ID);
        $pipeline->rating = 0;
        // Check if candidate is already added to pipeline.
        $pipelineExist = $this->checkPipelineExist($job_order_id,$applicant_id);
        if($pipelineExist === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        if($pipelineExist){
            echo 'Candidate is already added in the pipeline.';
            return;
        }
        // Add entry to pipeline.
        $id = $this->PipelineModel->addPipeline($pipeline);
        if($id === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        echo 'Success';
    }
    
    /**
    * Add pipeline entry.
    */
    public function addActivity(){
        checkUserLogin();
        $pipelineId = $this->input->get('id');
        if(!$pipelineId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'pipeline/detailsView');
            return;
        }
        $pipeline = $this->PipelineModel->getPipelineById($pipelineId);
        if($pipeline === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'pipeline/detailsView');
            return;
        }
        $data['pipeline'] = $pipeline;
        if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN){
            $recruiters = $this->UserModel->getUsers(0);
            $data["recruiters"] = $recruiters;
        }
        renderPage($this,$data,'pipeline/addActivity');
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
    
    /**
    * Checks if the candidate is already added to pipeline. If applicant and
    * job order exist, return true. Otherwise, return false.
    * 
    * @param    integer     $job_order_id   Value of job order ID.
    * @param    integer     $candidate_id   Value of candidate ID.
    * @return   boolean
    */
    private function checkPipelineExist($job_order_id,$applicant_id){
        $pipelines = $this->PipelineModel->getPipelinesByJobOrder(0,0,$job_order_id);
        if($pipelines === ERROR_CODE){
            return ERROR_CODE;
        }
        foreach ($pipelines as $pipeline){
            if(strval($pipeline->applicant_id) === strval($applicant_id)){
                return true;
            }
        }
        return false;
    }
    
    /**
    * Creates pipeline object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @return   pipeline object
    */
    private function createPipelineObject($post){
        $pipeline = (object)[
            'job_order_id' => $post ? $this->input->post('job_order_id'): '',
            'applicant_id' => $post ? $this->input->post('applicant_id'): '',
            'status' => $post ? $this->input->post('status'): '',
            'assigned_to' => $post ? $this->input->post('assigned_to'): '',
            'rating' => $post ? $this->input->post('rating'): '',
            'created_by' => $post ? $this->input->post('created_by'): '',
        ];
        return $pipeline;
    }
}