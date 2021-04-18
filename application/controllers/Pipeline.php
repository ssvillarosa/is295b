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
        $this->load->model('ActivityModel');
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
        $users = $this->UserModel->getUsers(0);
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
    * List of pipelines grouped by job order designed for full page of pipeline module.
    */
    public function jobOrderPipelinePage(){
        $applicant_id = $this->input->get("applicant_id");
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['applicant_id'] = $applicant_id;
        $data['rowsPerPage'] = $rowsPerPage;
        $data['header_on'] = true;
        $this->load->view('pipeline/jobOrderPipelinePage', $data);
    }
    
    /**
    * List of pipelines grouped by job order designed for ajax request.
    */
    public function jobOrderPipelineTable(){
        $applicant_id = $this->input->get("applicant_id");
        // Set pagination details.
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_PIPELINE_AJAX_ROWS_PER_PAGE);
        $totalCount = count($this->PipelineModel->getPipelinesByApplicant(0,0,$applicant_id,'id','desc'));
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        // Set data and display view.
        $job_orders = $this->PipelineModel->getPipelinesByApplicant($rowsPerPage,$data['offset'], $applicant_id);        
        if($job_orders === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            $this->load->view('pipeline/jobOrderPipelineTable', $data);
            return;
        }
        $users = $this->UserModel->getUsers(0);
        if($users === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            $this->load->view('pipeline/jobOrderPipelineTable', $data);
            return;
        }
        $data["users"] = $users;
        $data['pipelines'] = $job_orders;
        $data['applicant_id'] = $applicant_id;
        $this->load->view('pipeline/jobOrderPipelineTable', $data);
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
        // Check if user has access to job order.
        $userHasAccess = $this->checkUserAccessToJobOrder($job_order_id,
                $pipeline->assigned_to);
        if($userHasAccess === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        // If user doesn't have access, assign user to the job order.
        if(!$userHasAccess){
            $job_order_user = (object)[
                'job_order_id' => $job_order_id,
                'user_id' => $pipeline->assigned_to,
            ];
            $addJobOrderUsers = $this->JobOrderUserModel->addJobOrderUsers([$job_order_user]);
            if($addJobOrderUsers === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'job_order/detailsView');
                return;
            }
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
        
        // Add activity.
        $activity = (object)[
            'timestamp' => date('Y-m-d H:i:s'),
            'pipeline_id' => $id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_ADDED_TO_PIPELINE,
            'activity' => "Added to pipeline by ".$this->session->userdata(SESS_USER_FULL_NAME),
        ];
        $result =  $this->ActivityModel->addActivity($activity);
        if($result === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Added candidate ID: ".$applicant_id.
                " to Job Order ID: ".$job_order_id.".");
        
        echo 'Success';
    }
    
    /**
    * Delete pipeline.
    */
    public function delete(){
        if(!$this->input->post('delPipelineIds')){
            echo 'Invalid Pipeline ID';
            return;
        }
        $pipelineIds = explode(",", $this->input->post('delPipelineIds'));
        $success = $this->PipelineModel->deletePipeline($pipelineIds,
                $this->session->userdata(SESS_USER_ID));
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Deleted pipeline ID : ".$this->input->post('delPipelineIds'));
        echo 'Success';
    }
    
    /** 
     * Add candidate application to pipeline.
     */
    public function applicantSubmitAjax(){
        checkApplicantLogin();
        $job_order_id = $this->input->post('job_order_id');
        if(!$job_order_id){
            echo 'Invalid Job Order.';
            return;
        }
        $applicant_id = $this->session->userdata(SESS_APPLICANT_ID);
        if(!$applicant_id){
            echo 'Invalid Session.';
            return;
        }
        if (empty($_FILES['file_attachment']['name'])) {
            echo 'Invalid file.';
            return;
        }
        $pipeline = (object)[
            'job_order_id' => $job_order_id,
            'applicant_id' => $applicant_id,
            'status' => PIPELINE_STATUS_UNSET,
            'rating' => 0,
        ];
        // Check if candidate is already added to pipeline.
        $pipelineExist = $this->checkPipelineExist($job_order_id,$applicant_id);
        if($pipelineExist === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        if($pipelineExist){
            echo 'Duplicate entry error.';
            return;
        }
        // Add entry to pipeline.
        $id = $this->PipelineModel->addPipeline($pipeline);
        if($id === ERROR_CODE){
            echo 'Error occured.';
            return;
        }
        // Upload attachmet and add activity.
        $timestamp = date('Y-m-d H:i:s');
        $result = $this->fileUploadAddActivity($timestamp,$id);
        if($result === ERROR_CODE){
            echo "Error occured.";
            return;
        }
        if($result === UPLOAD_ERROR_CODE){
            echo $this->upload->display_errors();
            return;
        }
        echo "Success";
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
    
    /**
    * Uploads a file attachment.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function fileUploadAddActivity($timestamp,$pipelineId){
        // Configure upload.
        $upload_path = UPLOAD_DIRECTORY.'/'.$pipelineId.'/';
        if(!is_dir($upload_path)){
           mkdir($upload_path);
        }
        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'doc|docx|pdf';
        $config['max_size']             = 2000;
        $this->load->library('upload', $config);
        
        $file = $this->upload->do_upload("file_attachment");
        if(!$file){
            return UPLOAD_ERROR_CODE;
        }
        $filename = $this->upload->data()['file_name'];
        $message = $this->input->post('message');
        $activity_message = "";
        if($message){
            $activity_message .= "Applicant Message: \n".$message."\n\n";
        }
        $activity_message .= 'Uploaded file: '.$filename;
        // Add activity.
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipelineId,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_CANDIDATE_SUBMIT_APPLICATION,
            'activity' => $activity_message,
        ];
        return $this->ActivityModel->addActivity($activity);
    }
}