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
        $this->load->model('JobOrderSkillModel');
        $this->load->model('SkillCategoryModel');
        $this->load->model('SkillModel');
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
        renderPage($this,$data,'job_order/detailsView');
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
        $job_order = $this->createJobOrderObject(true);
        $jobOrderId = $this->input->post('jobOrderId');
        $job_order->id = $jobOrderId;
        $data["job_order"] = $job_order;
        $job_order_skills = $this->createJobOrderSkillObject($jobOrderId);
        $data["job_order_skills"] = $job_order_skills;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $updateJobOrder = $this->JobOrderModel->updateJobOrder($job_order,$jobOrderId);
        $updateJobOrderSkills = $this->JobOrderSkillModel->deleteJobOrderSkills($jobOrderId)
                && $this->JobOrderSkillModel->addJobOrderSkills($job_order_skills);
        if($updateJobOrder === ERROR_CODE || $updateJobOrderSkills === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "Job order successfully updated!";
        }
        // Display form.
        renderPage($this,$data,'job_order/detailsView');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Updated job order ".$job_order->title." details.");
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
            'created_time' => $post ? $this->input->post('created_time'): '',
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
                'skill_id' => $skillIds[$key],
                'name' => $skillNames[$key],
                'years_of_experience' => $yearsOfExperiences[$key]
            ];
            array_push($job_order_skills, $job_order_skill);
        }
        return $job_order_skills;
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
        return SUCCESS_CODE;
    }
}