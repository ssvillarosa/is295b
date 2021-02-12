<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JobOrder
 *
 * Handles job order page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Job_Order extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        checkUserLogin();
        $this->load->model('JobOrderModel');
        $this->load->model('CompanyModel');
    }
    
    /**
    * Display list of job orders.
    */
    public function jobOrderList(){
        $rowsPerPage = getRowsPerPage($this,COOKIE_COMPANY_ROWS_PER_PAGE);
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
        $data['current_uri'] = 'job_order/jobOrderList';
        renderPage($this,$data,'job_order/jobOrderList');
    }
    
    /**
    * Display job order details.
    */
    public function view(){
        $jobOrderId = $this->input->get('id');
        if(!$jobOrderId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $result = $this->JobOrderModel->getJobOrderById($jobOrderId);
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $companies = $this->CompanyModel->getCompanies(0);
        if($companies === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $data["job_order"] = $result;
        $data["companies"] = $companies;
        renderPage($this,$data,'job_order/detailsView');
    }
}