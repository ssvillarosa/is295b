<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activity
 *
 * Handles activity page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Activity extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('ActivityModel');
        $this->load->model('PipelineModel');
        $this->load->model('UserModel');
        $this->load->model('JobOrderUserModel');
        $this->load->library('email');
    }
    
    /**
    * Display list of activities.
    */
    public function activityListByPipeline(){
        checkUserLogin();
        $pipelineId = $this->input->get('pipelineId');
        // Set pagination details.
        $rowsPerPage = getRowsPerPage($this,COOKIE_ACTIVITY_AJAX_ROWS_PER_PAGE);
        $totalCount = count($this->ActivityModel->getActivityByPipelineId($pipelineId));
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        // Get pipeline details.
        if(!$pipelineId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/activityList');
            return;
        }
        $pipeline = $this->PipelineModel->getPipelineById($pipelineId);
        if($pipeline === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/activityList');
            return;
        }
        $data['pipeline'] = $pipeline;
        // Get actvities for the pipeline.
        $activities = $this->ActivityModel->getActivityByPipelineId($pipelineId,$rowsPerPage,$data['offset'],"timestamp","desc");
        if($activities === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/activityList');
            return;
        }
        $data['activities'] = $activities;
        // Get list of users assigned to the job order.
        $recruiters = $this->JobOrderUserModel->getUsersByJobOrderId($pipeline->job_order_id);
        $data["recruiters"] = $recruiters;
        renderPage($this,$data,'activity/activityList');
    }
    
    /**
    * Add pipeline entry.
    */
    public function add(){
        $pipelineId = $this->input->post("pipelineId");
        $pipeline = $this->PipelineModel->getPipelineById($pipelineId);
        if($pipeline === ERROR_CODE){
            echo "Error occured.";
            return;
        }
        if(!$this->session->userdata(SESS_USER_ROLE)== USER_ROLE_ADMIN ||
                !$this->session->userdata(SESS_USER_ID) == $pipeline->assigned_to){
            echo "Invalid Access.";
            return;
        }
        $timestamp = date('Y-m-d H:i:s');
        // Perform update rating.
        if($this->input->post('check_rating')){
            $result = $this->updateRating($timestamp,$pipeline);
            if($result === ERROR_CODE){
                echo "Error occured.";
                return;
            }
        }
        // Perform change assignment.
        if($this->input->post('check_assigned_to')){
            $result = $this->changeAssignment($timestamp,$pipeline);
            if($result === ERROR_CODE){
                echo "Error occured.";
                return;
            }
        }
        // Peform change status.
        if($this->input->post('check_status')){
            $result = $this->updateStatus($timestamp,$pipeline);
            if($result === ERROR_CODE){
                echo "Error occured.";
                return;
            }
        }
        // Add note activity.
        if($this->input->post('check_notes')){
            $result = $this->addNote($timestamp,$pipeline);
            if($result === ERROR_CODE){
                echo "Error occured.";
                return;
            }
        }
        // Add email activity.
        if($this->input->post('check_email')){
            $result = $this->sendEmail($timestamp,$pipeline);
            if($result === ERROR_CODE){
                echo "Error occured.";
                return;
            }
        }
        echo "Success";
    }
    
    /**
    * Update the rating field of the pipeline object.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function updateRating($timestamp,$pipeline){
        $newRating = $this->input->post("rateScore");
        if(!$newRating){
            return ERROR_CODE;
        }
        $pipelineUpdates = (object)["rating"=>$newRating];
        // Update pipeline status value.
        $result = $this->PipelineModel->updatePipeline($pipelineUpdates,$pipeline->id);
        if($result === ERROR_CODE){
            return ERROR_CODE;
        }
        // Add activity.
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipeline->id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_RATING_UPDATE,
            'activity' => 'Change rating from '.$pipeline->rating.' stars to '.$newRating.' stars.',
        ];
        return $this->ActivityModel->addActivity($activity);
    }
    
    /**
    * Update the assigned_to field of the pipeline object.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function changeAssignment($timestamp,$pipeline){
        $assigntToUserId = $this->input->post("user_select");
        if(!$assigntToUserId){
            return ERROR_CODE;
        }
        $pipelineUpdates = (object)["assigned_to"=>$assigntToUserId];
        // Update pipeline assigned_to value.
        $result = $this->PipelineModel->updatePipeline($pipelineUpdates,$pipeline->id);
        if($result === ERROR_CODE){
            return ERROR_CODE;
        }
        // Add activity.
        $newUser = $this->UserModel->getUserById($assigntToUserId);
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipeline->id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_CHANGE_ASSIGNMENT,
            'activity' => 'Change assignment from '.$pipeline->name.' to '.$newUser->name.'.',
        ];
        return $this->ActivityModel->addActivity($activity);
    }
    
    /**
    * Update the status field of the pipeline object.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function updateStatus($timestamp,$pipeline){
        $newStatus = $this->input->post("status");
        if(!$newStatus){
            return ERROR_CODE;
        }
        $pipelineUpdates = (object)["status"=>$newStatus];
        // Update pipeline status value.
        $result = $this->PipelineModel->updatePipeline($pipelineUpdates,$pipeline->id);
        if($result === ERROR_CODE){
            return ERROR_CODE;
        }
        // Add activity.
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipeline->id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_STATUS_UPDATE,
            'activity' => 'Change status from '.$pipeline->status.' to '.
            getPipelineStatusDictionary($newStatus).'.',
        ];
        return $this->ActivityModel->addActivity($activity);
    }
    
    /**
    * Adds a note activity.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function addNote($timestamp,$pipeline){
        $notes = $this->input->post("activity_notes");
        if(!$notes){
            return ERROR_CODE;
        }
        // Add activity.
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipeline->id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_NOTE,
            'activity' => $notes,
        ];
        return $this->ActivityModel->addActivity($activity);
    }
    
    /**
    * Adds an email activity.
    * 
    * @param    string              $timestamp      String represenstation of current time stamp.
    * @param    pipeline object     $pipeline       Pipeline object containing the current pipeline details.
    */
    private function sendEmail($timestamp,$pipeline){
        $email_details = "Email Details:";
        $subject = $this->input->post("email_subject");
        $email_details .= "\n Subject: ".$subject;
        $from = $this->input->post("email_from");
        $email_details .= "\n From: ".$from;
        $to = $this->input->post("email_to");
        $email_details .= "\n To: ".$to;
        if($this->input->post("check_copy")){
            $cc = $this->input->post("email_cc");
            $email_details .= "\n Cc: ".$cc;
            $reply_to = $this->input->post("email_reply_to");
            $email_details .= "\n Reply-to: ".$reply_to;
        }
        $message = $this->input->post("email_message");
        $email_details .= "\n Message: ".$message;
        if(!$subject || !$from || !$to || !$message){
            return ERROR_CODE;
        }
        // Send email.
        $this->email->subject($subject);
        $this->email->from($from);
        $this->email->to($to);
        $this->email->message($message);
        if($this->input->post("check_copy")){
            $this->email->cc($cc);
            $this->email->reply_to($reply_to);
        }
        // Send email if not in test env.
        if(strpos(ENVIRONMENT, "test")){
            $this->email->send();
        }
        // Add activity.
        $activity = (object)[
            'timestamp' => $timestamp,
            'pipeline_id' => $pipeline->id,
            'updated_by' => $this->session->userdata(SESS_USER_ID),
            'activity_type' => ACTIVITY_TYPE_EMAIL,
            'activity' => $email_details,
        ];
        echo $email_details;
        return $this->ActivityModel->addActivity($activity);
    }
}