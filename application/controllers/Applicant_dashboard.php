<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard
 *
 * Handles applicant_dashboard page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Applicant_dashboard extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('JobOrderModel');
    }
    
    /**
    * Shows overview of applicant_dashboard.
    */
    public function jobs(){
        checkApplicantLogin();
        $data = [];
        $rowsPerPage = getRowsPerPage($this,COOKIE_APPLICANT_JOB_ORDER_ROWS_PER_PAGE);
        $totalCount = $this->JobOrderModel->getJobOrderCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $result = $this->JobOrderModel->getJobOrders($rowsPerPage,$data['offset']);        
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['job_orders'] = $result;
        renderApplicantPage($this,$data,'applicant_dashboard/jobsPage');
    }
    
    /**
    * Shows list of applicant's submitted applications.
    */
    public function myApplications(){
        checkApplicantLogin();
        renderApplicantPage($this,[],'applicant_dashboard/myApplications');
    }
    
    public function searchJobResult(){
        checkApplicantLogin();
        $fields = [
            "id",
            "title",
            "company",
            "status",
            "employment_type",
            "job_function",
            "requirement",
            "min_salary",
            "max_salary",
            "location",
            "slots_available",
            "priority_level",
            "is_deleted",
            "skills",
            "recruiters"
        ];
        // Create search parameters for each field.
        $searchParams = [];
        $title = $this->input->get('title');
        if($title){
            array_push($searchParams,(object) [
                'field' => 'title',
                'condition' => 'C',
                'value' => $this->input->get('title'),
                'show' => 'on',
            ]);
        }
        $company = $this->input->get('company');
        if($company){
            array_push($searchParams,(object) [
                'field' => 'company',
                'condition' => 'C',
                'value' => $this->input->get('company'),
                'show' => 'on',
            ]);
        }
        $min_salary = $this->input->get('min_salary');
        if($min_salary){
            array_push($searchParams,(object) [
                'field' => 'min_salary',
                'condition' => 'A',
                'value' => $this->input->get('min_salary'),
                'show' => 'on',
            ]);
        }
        $max_salary = $this->input->get('max_salary');
        if($max_salary){
            array_push($searchParams,(object) [
                'field' => 'max_salary',
                'condition' => 'B',
                'value' => $this->input->get('max_salary'),
                'show' => 'on',
            ]);
        }
        $employment_type = $this->input->get('employment_type');
        if($employment_type){
            array_push($searchParams,(object) [
                'field' => 'employment_type',
                'condition' => 'E',
                'value' => $this->input->get('employment_type'),
                'show' => 'on',
            ]);
        }
        $location = $this->input->get('location');
        if($location){
            array_push($searchParams,(object) [
                'field' => 'location',
                'condition' => 'C',
                'value' => $this->input->get('location'),
                'show' => 'on',
            ]);
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_APPLICANT_JOB_ORDER_ROWS_PER_PAGE);
        $totalCount = $this->JobOrderModel->searchJobOrderCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        
        $job_orders_array = $this->JobOrderModel->searchJobOrder($searchParams,$fields,$rowsPerPage,$data['offset']);
        $job_orders = [];
        foreach ($job_orders_array as $job_order){
          array_push($job_orders,(object)$job_order);
        }
        $data['job_orders'] = $job_orders;
        $data['title'] = $title;
        $data['company'] = $company;
        $data['min_salary'] = $min_salary;
        $data['max_salary'] = $max_salary;
        $data['employment_type'] = $employment_type;
        $data['location'] = $location;
        $data['filters'] = generateTextForFilters($searchParams);
        $data['fullUrl'] = site_url('applicant_dashboard/searchJobResult').'?'.getQueryParams(["rowsPerPage","currentPage"]);
        renderApplicantPage($this,$data,'applicant_dashboard/jobsPage');
    }
}
