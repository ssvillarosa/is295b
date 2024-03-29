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
class Job_order extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        checkUserLogin();
        $this->load->model('JobOrderModel');
        $this->load->model('CompanyModel');
        $this->load->model('JobOrderSkillModel');
        $this->load->model('JobOrderUserModel');
        $this->load->model('SkillCategoryModel');
        $this->load->model('UserModel');
        $this->load->model('SkillModel');
    }
    
    /**
    * Display list of job orders.
    */
    public function jobOrderList(){
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_ROWS_PER_PAGE);
        $totalCount = $this->JobOrderModel->getJobOrderCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['assignedToMe'] = getJobOrderListFilter($this,COOKIE_JOB_ORDER_ASSIGNED_TO_ME);
        if(!$data['assignedToMe']){            
            $result = $this->JobOrderModel->getJobOrders($rowsPerPage,
                    $data['offset'],'id','desc');         
            if($result === ERROR_CODE){
                $data["error_message"] = "Error occured.";        
            }
            $data['job_orders'] = $result;
        }else{
            // Get job orders only by logged in user.
            $userId = $this->session->userdata(SESS_USER_ID);
            $res = $this->JobOrderModel->getJobOrderByUserId($userId);        
            if($res === ERROR_CODE){
                $data["error_message"] = "Error occured.";        
            }
            $joIds = [];
            foreach ($res as $jo){
                array_push($joIds, $jo->id);
            }
            if(count($joIds)){
                $result = $this->JobOrderModel->getJobOrdersByIds($joIds,
                        $rowsPerPage,$data['offset'],'id','desc');        
                if($result === ERROR_CODE){
                    $data["error_message"] = "Error occured.";        
                }
                $data['job_orders'] = $result;
            }else{
                $data['job_orders'] = [];
            }
        }
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
        $job_order = $this->JobOrderModel->getJobOrderById($jobOrderId);
        if($job_order === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $data["job_order"] = $job_order;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $job_order_skills = $this->JobOrderSkillModel->getSkillsByJobOrderId($jobOrderId);
        if($job_order_skills === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $data["job_order_skills"] = $job_order_skills;
        $job_order_users = $this->JobOrderUserModel->getUsersByJobOrderId($jobOrderId);
        if($job_order_users === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $data["job_order_users"] = $job_order_users;
        // Set data for applicant pipeline ajax.
        $data['job_order_id'] = $jobOrderId;
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['rowsPerPage'] = $rowsPerPage;
        
        renderPage($this,$data,'job_order/detailsView');
    }
    
    /**
    * Adds job order details.
    */
    public function add(){
        $this->setValidationDetails();
        // Create job order objects and its sub items.
        $job_order = $this->createJobOrderObject(true);
        $data["job_order"] = $job_order;
        $job_order_skills = $this->createJobOrderSkillObject(0);
        $data["job_order_skills"] = $job_order_skills;
        $job_order_users = $this->createJobOrderUserObject(0);
        $data["job_order_users"] = $job_order_users;
        
        // Set company value if there is parameter from GET request.
        $selectedCompany = $this->input->get_post("company_id");
        $job_order->company_id = $selectedCompany;
        // Set referrer value
        $referrer = $this->input->get_post("referrer");
        $data["referrer"] = $referrer;
        
        $job_order->created_by = $this->session->userdata(SESS_USER_ID);
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/add');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'job_order/add');
            return;
        }
        // Add job order details.
        $newJobOrderId = $this->JobOrderModel->addJobOrder($job_order);
        if($newJobOrderId === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/add');
            return;
        }
        // Batch insert skills into job order skills table.
        $new_job_order_skills = $this->createJobOrderSkillObject($newJobOrderId);
        if($job_order_skills){
            $addJobOrderSkills = $this->JobOrderSkillModel->addJobOrderSkills($new_job_order_skills);
            if($addJobOrderSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";
                renderPage($this,$data,'job_order/add');
                return;
            }
        }
        // Batch insert users into job order user table.
        $new_job_order_users = $this->createJobOrderUserObject($newJobOrderId);
        if($job_order_users){
            $addJobOrderUsers = $this->JobOrderUserModel->addJobOrderUsers($new_job_order_users);
            if($addJobOrderUsers === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'job_order/detailsView');
                return;
            }
        }
        // Clear data and display form with success message.
        $empty_job_order = $this->createJobOrderObject(false);
        $data["job_order"] = $empty_job_order;
        $data["job_order_skills"] = [];
        $data["job_order_users"] = [];
        $data["success_message"] = "Job order successfully added!";
        renderPage($this,$data,'job_order/add');
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Added job order ".$job_order->title."(ID:".$newJobOrderId.").");
        
        // If referrer is set, redirect to referrer.
        if($referrer){
            header("Refresh: 1; url=". base_url().$referrer);
        }
    }
    
    /**
    * Updates job order details.
    */
    public function update(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $data["error_message"] = 'Invalid access.';
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $this->setValidationDetails();
        $this->form_validation->set_rules('jobOrderId','Job Order ID'
                ,'required|integer');
        $job_order = $this->createJobOrderObject(true);
        $jobOrderId = $this->input->post('jobOrderId');
        $job_order->id = $jobOrderId;
        $data["job_order"] = $job_order;
        $job_order_skills = $this->createJobOrderSkillObject($jobOrderId);
        $data["job_order_skills"] = $job_order_skills;
        $job_order_users = $this->createJobOrderUserObject($jobOrderId);
        $data["job_order_users"] = $job_order_users;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        // Update job order details
        $updateJobOrder = $this->JobOrderModel->updateJobOrder($job_order,$jobOrderId);
        if($updateJobOrder === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";     
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        // Batch insert skills into job order skills table.
        $this->JobOrderSkillModel->deleteJobOrderSkills($jobOrderId);
        if($job_order_skills){
            $updateJobOrderSkills = $this->JobOrderSkillModel->addJobOrderSkills($job_order_skills);
            if($updateJobOrderSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'job_order/detailsView');
                return;
            }
        }
        // Batch insert users into job order user table.
        $this->JobOrderUserModel->deleteJobOrderUsers($jobOrderId);
        if($job_order_users){
            $updateJobOrderUsers = $this->JobOrderUserModel->addJobOrderUsers($job_order_users);
            if($updateJobOrderUsers === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'job_order/detailsView');
                return;
            }
        }
        // Display form with success message.
        $data["success_message"] = "Job order successfully updated!";
        
        // Set data for applicant pipeline ajax.
        $data['job_order_id'] = $jobOrderId;
        $rowsPerPage = getRowsPerPage($this,COOKIE_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['rowsPerPage'] = $rowsPerPage;
        
        renderPage($this,$data,'job_order/detailsView');
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Updated job order ".$job_order->title." details.");
    }
    
    /**
    * Delete job order.
    */
    public function delete(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        if(!$this->input->post('delJobOrderIds')){
            echo 'Invalid Job Order ID';
            return;
        }
        $jobOrderIds = explode(",", $this->input->post('delJobOrderIds'));
        $success = $this->JobOrderModel->deleteJobOrder($jobOrderIds,
                $this->session->userdata(SESS_USER_ID));
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Deleted job order ID : ".$this->input->post('delJobOrderIds'));
        echo 'Success';
    }
        
    /**
    * Search page.
    */
    public function search(){
        renderPage($this,null,'job_order/search');        
    }
    
    /**
    * Search results page.
    */
    public function searchResult(){
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
        $data = $this->searchJobOrder($fields);
        if(!$this->input->get("exportResult")){
            renderPage($this,$data,'common/searchResult');
        }
    }
    
    /**
    * Returns search result as JSON.
    */
    public function searchAjax(){
        checkUserLogin();
        $fields = [
            "id",
            "title",
            "skills",
            ];
        $data = $this->searchJobOrder($fields,$fields);
        if(isset($data['error_message'])){
            echo $data['error_message'];
            return;
        }
        echo json_encode($data["entries"]);
    }
    
    /**
    * Do the actual search function.
    * 
    * @param    array of strings    $fields     Each item corresponds to one column in the database table.
    * @param    array of string     $sf         Each item correspond to field which will be shown.
    * 
    * @return dataobject $data  Contains all information about page including search results and pagination. 
    */
    private function searchJobOrder($fields,$sf=null){
        // Create search parameters for each field.
        $searchParams = [];
        foreach ($fields as $field){
            $param = getSearchParam($this,$field);
            $param ? array_push($searchParams, $param):'';            
        }
        
        // Create array to store fields to be shown
        $shownFields = $sf;
        if(is_null($shownFields)){
            $shownFields = [];
        }
        // Create column header for the table.
        $columnHeaders = [];
        foreach ($searchParams as $param){
            if($param->show){
                array_push($columnHeaders, ucwords(str_replace("_", " ", $param->field)));   
            }
            if($param->show && is_null($sf)){
                array_push($shownFields, $param->field);
            }
        }
        if(!$shownFields){
            $data['error_message'] = "Select at least one field to be displayed.";
            return;
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_SEARCH_ROWS_PER_PAGE);
        $totalCount = $this->JobOrderModel->searchJobOrderCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['searcParams'] = $searchParams;
        $data['filters'] = generateTextForFilters($searchParams);
        $data['module'] = 'job_order';
        $data['removedRowsPerPage'] = site_url('job_order/searchResult').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('job_order/searchResult').'?'.getQueryParams(["currentPage"]);
        
        if($this->input->get("exportResult")){
            $job_orders = $this->JobOrderModel->searchJobOrder($searchParams,$shownFields,0);
            if($job_orders === ERROR_CODE){
                $data['error_message'] = "Error occured.";
            }
            exportCSV($this->input->get("exportResult"),$job_orders,$columnHeaders,[]);
        }else{
            $job_orders = $this->JobOrderModel->searchJobOrder($searchParams,$shownFields,$rowsPerPage,$data['offset']);
            if($job_orders === ERROR_CODE){
                $data['error_message'] = "Error occured.";
            }
        }
        $data['entries'] = $job_orders;
        return $data;
    }
    
    /**
    * List of job orders designed for ajax request.
    */
    public function ajaxListPage(){
        $fields = [
            "id",
            "title",
            "company",
            "status",
            "users",
            ];
        // Create search parameters for each field.
        $searchParams = [];
        // Create array to store fields to be shown
        $shownFields = [];
        // Create column header for the table.
        $columnHeaders = [];
        foreach ($fields as $field){
            $param = getSearchParam($this,$field);
            if(!$param){
                continue;
            }
            array_push($searchParams, $param); 
            if($param->show){
                array_push($shownFields, $param->field);
                array_push($columnHeaders, ucwords(str_replace("_", " ", $param->field)));  
            }
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_AJAX_ROWS_PER_PAGE);
        $totalCount = $this->JobOrderModel->searchJobOrderCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['toolbar_text'] = "Job Orders";
        $data['module'] = 'job_order';
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['searcParams'] = $searchParams;
        $data['ajaxContainer'] = 'companyJobOderList';
        $data['removedRowsPerPage'] = site_url('job_order/ajaxListPage').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('job_order/ajaxListPage').'?'.getQueryParams(["currentPage"]);
        
        $job_orders = $this->JobOrderModel->searchJobOrder($searchParams,$shownFields,$rowsPerPage,$data['offset']);
        $data['entries'] = $job_orders;
        $this->load->view('common/ajaxListPage', $data);
    }
    
    /**
    * Creates job order object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @return   job order object
    */
    private function createJobOrderObject($post){
        $job_order = (object)[
            'title' => $post ? $this->input->post('title'): '',
            'company_id' => $post ? $this->input->post('company_id'): '',
            'job_function' => $post ? $this->input->post('job_function'): '',
            'requirement' => $post ? $this->input->post('requirement'): '',
            'min_salary' => $post ? $this->input->post('min_salary'): '',
            'max_salary' => $post ? $this->input->post('max_salary'): '',
            'location' => $post ? $this->input->post('location'): '',
            'status' => $post ? $this->input->post('status'): '',
            'employment_type' => $post ? $this->input->post('employment_type'): '',
            'slots_available' => $post ? $this->input->post('slots_available'): '',
            'priority_level' => $post ? $this->input->post('priority_level'): '',
        ];
        return $job_order;
    }
    
    /**
    * Creates job order skill object.
    * 
    * @return   job order object
    */
    private function createJobOrderSkillObject($jobOrderId){
        $job_order_skills = [];
        if(!$this->input->post('skillIds') || !$this->input->post('skillNames')
                || !$this->input->post('yearsOfExperiences')){
            return [];
        }
        $skillIds = explode(",", $this->input->post('skillIds'));
        $skillNames = explode(",", $this->input->post('skillNames'));
        $yearsOfExperiences = explode(",", $this->input->post('yearsOfExperiences'));
        if(count($skillIds) != count($skillNames) || 
                count($skillNames) != count($yearsOfExperiences)){
            return ERROR_CODE;
        }
        foreach ($skillIds as $key => $skillId){
            $job_order_skill = (object)[
                'job_order_id' => $jobOrderId,
                'skill_id' => $skillId,
                'name' => $skillNames[$key],
                'years_of_experience' => $yearsOfExperiences[$key]
            ];
            array_push($job_order_skills, $job_order_skill);
        }
        return $job_order_skills;
    }
    
    /**
    * Creates job order user object.
    * 
    * @return   job order user object
    */
    private function createJobOrderUserObject($jobOrderId){
        $job_order_users = [];
        if(!$this->input->get_post('userIds') || !$this->input->get_post('userNames')){
            return [];
        }
        $userIds = explode(",", $this->input->get_post('userIds'));
        $userNames = explode(",", $this->input->get_post('userNames'));
        if(count($userIds) != count($userNames)){
            return ERROR_CODE;
        }
        foreach ($userIds as $key => $userId){
            $job_order_user = (object)[
                'job_order_id' => $jobOrderId,
                'user_id' => $userId,
                'name' => $userNames[$key]
            ];
            array_push($job_order_users, $job_order_user);
        }
        return $job_order_users;
    }
    
    /**
    * Apply validation rules for other details to be used in update form.
    */
    private function setValidationDetails(){        
        $this->form_validation->set_rules('title', 'Title',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('company_id','Company'
                ,'required|integer');
        $this->form_validation->set_rules('min_salary','Min Salary'
                ,'required|integer');
        $this->form_validation->set_rules('max_salary','Max Salary'
                ,'required|integer');
        $this->form_validation->set_rules('employment_type','Employment Type'
                ,'required|integer');
        $this->form_validation->set_rules('job_function','Job Function'
                ,'required');
        $this->form_validation->set_rules('requirement','Requirement'
                ,'required');
        $this->form_validation->set_rules('status','Status'
                ,'required|integer');
    }
    
    /**
    * Updates the data variable using pass as reference.
    */
    private function setData(&$data){
        $companies = $this->CompanyModel->getCompanies(0,0,"name","asc");
        if($companies === ERROR_CODE){
            return ERROR_CODE;
        }
        $data["companies"] = $companies;
        $skillCategories = $this->SkillCategoryModel->getSkillCategories(0,0,'name','asc');
        if($skillCategories === ERROR_CODE){
            return ERROR_CODE;
        }
        $data["skillCategories"] = $skillCategories;
        $recruiters = $this->UserModel->getUsers(0);
        $data["recruiters"] = $recruiters;
        return SUCCESS_CODE;
    }
}