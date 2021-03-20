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
    }
    
    /**
    * List of pipelines grouped by job order designed for ajax request.
    */
    public function applicantPipelinePage(){
        $job_order_id = $this->input->get("job_order_id");
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['job_order_id'] = $job_order_id;
        $data['rowsPerPage'] = $rowsPerPage;
        $data['header_on'] = true;
        $this->load->view('pipeline/applicantPipelinePage', $data);
    }
    
    public function getApplicantsByJobOrder(){
        $job_order_id = $this->input->get("job_order_id");
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $totalCount = count($this->PipelineModel->getPipelinesByJobOrder(0,0,$job_order_id));
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $applicants = $this->PipelineModel->getPipelinesByJobOrder($rowsPerPage,$data['offset'], $job_order_id);        
        if($applicants === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['pipelines'] = $applicants;
        $data['job_order_id'] = $job_order_id;
        $data['module'] = 'pipeline/applicantPipelinePage';
        $this->load->view('pipeline/applicantPipelineTable', $data);
    }
}