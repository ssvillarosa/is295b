<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Company
 *
 * Handles company page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Company extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('CompanyModel');
        checkUserLogin();
    }
    
    /**
    * Display list of companies.
    */
    public function companyList(){
        $rowsPerPage = getRowsPerPage($this,COOKIE_COMPANY_ROWS_PER_PAGE);
        $totalCount = $this->CompanyModel->getCompanyCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $result = $this->CompanyModel->getCompanies($rowsPerPage,$data['offset']);        
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['companies'] = $result;
        $data['current_uri'] = 'company/companyList';
        renderPage($this,$data,'company/companyList');
    }
    
    /**
    * Display company details.
    */
    public function view(){
        $companyId = $this->input->get('id');
        if(!$companyId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'company/detailsView');
            return;
        }
        $result = $this->CompanyModel->getCompanyById($companyId);
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'company/detailsView');
            return;
        }
        $data['company'] = $result;
        renderPage($this,$data,'company/detailsView');
    }
}