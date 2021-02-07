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
    
    /**
    * Update company details.
    */
    public function update(){
        $this->form_validation->set_rules('name', 'Name',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('companyId','Company ID'
                ,'required|integer');
        $company = $this->createCompanyObject(true);
        $company->id = $this->input->post('companyId');
        $data["company"] = $company;
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'company/detailsView');
            return;
        }
        $result = $this->CompanyModel->updateCompany($company,$company->id);
        if($result === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "User successfully updated!";
        }
        // Display form.
        renderPage($this,$data,'company/detailsView');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Updated company ".$company->name." details.");
    }
    
    /**
    * Add company details.
    */
    public function add(){
        $this->form_validation->set_rules('name', 'Name',
                'trim|required|max_length[255]');
        $company = $this->createCompanyObject(true);
        $company->id = $this->input->post('companyId');
        $company->created_by = $this->session->userdata(SESS_USER_ID);
        $data["company"] = $company;
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'company/add');
            return;
        }
        $result = $this->CompanyModel->addCompany($company,$company->id);
        if($result === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "User successfully added!";
        }
        // Display form.
        renderPage($this,$data,'company/add');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Added company ".$company->name.".");
    }
    
    /**
    * Creates company object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @return   company object
    */
    private function createCompanyObject($post){
        $company = (object)[
            'name' => $post ? $this->input->post('name'): '',
            'contact_person' => $post ? $this->input->post('contact_person'): '',
            'primary_phone' => $post ? $this->input->post('primary_phone'): '',
            'secondary_phone' => $post ? $this->input->post('secondary_phone'): '',
            'address' => $post ? $this->input->post('address'): '',
            'website' => $post ? $this->input->post('website'): '',
            'industry' => $post ? $this->input->post('industry'): '',
        ];
        return $company;
    }
}