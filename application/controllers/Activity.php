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
        $activities = $this->ActivityModel->getActivityByPipelineId($pipelineId,$rowsPerPage,$data['offset']);
        if($activities === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/activityList');
            return;
        }
        $data['activities'] = $activities;
        // Get list of users.
        $recruiters = $this->UserModel->getUsers(0);
        $data["recruiters"] = $recruiters;
        renderPage($this,$data,'activity/activityList');
    }
    
    /**
    * Add pipeline entry.
    */
    public function add(){
    }
}