<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applicant
 *
 * Handles applicant page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Applicant extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('ApplicantModel');
        $this->load->model('SkillCategoryModel');
        checkUserLogin();
    }
    
    /**
    * Display list of applicants.
    */
    public function applicantList(){
        $rowsPerPage = getRowsPerPage($this,COOKIE_APPLICANT_ROWS_PER_PAGE);
        $totalCount = $this->ApplicantModel->getApplicantCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $result = $this->ApplicantModel->getApplicants($rowsPerPage,$data['offset']);        
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['applicants'] = $result;
        $data['current_uri'] = 'applicant/applicantList';
        renderPage($this,$data,'applicant/applicantList');
    }
    
    /**
    * Display applicant details.
    */
    public function view(){
        $applicantId = $this->input->get('id');
        if(!$applicantId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        $result = $this->ApplicantModel->getApplicantById($applicantId);
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        $data['applicant'] = $result;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        $applicant_skills = $this->ApplicantModel->getApplicantSkill($applicantId);
        if($applicant_skills === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        $data["applicant_skills"] = $applicant_skills;
        renderPage($this,$data,'applicant/detailsView');
    }
    
    /**
    * Updates applicant details.
    */
    public function update(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $data["error_message"] = 'Invalid access.';
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        $this->setValidationDetails();
        $this->form_validation->set_rules('applicantId','Applicant ID'
                ,'required|integer');
        $applicant = $this->createApplicantObject(true);
        $applicantId = $this->input->post('applicantId');
        $applicant->id = $applicantId;
        $data["applicant"] = $applicant;
        $applicant_skills = $this->createApplicantSkillObject($applicantId);
        $data["applicant_skills"] = $applicant_skills;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        // Update applicant details
        $updateApplicant = $this->ApplicantModel->updateApplicant($applicant,$applicantId);
        if($updateApplicant === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";     
            renderPage($this,$data,'applicant/detailsView');
            return;
        }
        // Batch insert skills into applicant skills table.
        if($applicant_skills){
            $updateApplicantSkills = $this->ApplicantModel->deleteApplicantSkills($applicantId)
                    && $this->ApplicantModel->addApplicantSkills($applicant_skills);
            if($updateApplicantSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'applicant/detailsView');
                return;
            }
        }
        // Display form with success message.
        $data["success_message"] = "Applicant successfully updated!";
        renderPage($this,$data,'applicant/detailsView');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Updated applicant ".$applicant->last_name.",".$applicant->first_name." details.");
    }
    
    /**
    * Adds applicant details.
    */
    public function add(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $data["error_message"] = 'Invalid access.';
            renderPage($this,$data,'applicant/add');
            return;
        }
        $this->setValidationDetails();
        // Create applicant objects and its sub items.
        $applicant = $this->createApplicantObject(true);
        $data["applicant"] = $applicant;
        $applicant_skills = $this->createApplicantSkillObject(0);
        $data["applicant_skills"] = $applicant_skills;
        
        $applicant->created_by = $this->session->userdata(SESS_USER_ID);
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/add');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'applicant/add');
            return;
        }
        // Add applicant details.
        $newApplicantId = $this->ApplicantModel->addApplicant($applicant);
        if($newApplicantId === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'applicant/add');
            return;
        }
        // Batch insert skills into applicant skills table.
        $new_applicant_skills = $this->createApplicantSkillObject($newApplicantId);
        if($applicant_skills){
            $addApplicantSkills = $this->ApplicantModel->addApplicantSkills($new_applicant_skills);
            if($addApplicantSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";
                renderPage($this,$data,'applicant/add');
                return;
            }
        }
        // Clear data and display form with success message.
        $empty_applicant = $this->createApplicantObject(false);
        $data["applicant"] = $empty_applicant;
        $data["applicant_skills"] = [];
        $data["success_message"] = "Candidate successfully added!";
        renderPage($this,$data,'applicant/add');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Added applicant ".$applicant->last_name.
                ",".$applicant->first_name.".");
    }
    
    /**
    * Delete applicant.
    */
    public function delete(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        if(!$this->input->post('delApplicantIds')){
            echo 'Invalid Applicant ID';
            return;
        }
        $applicantIds = explode(",", $this->input->post('delApplicantIds'));
        $success = $this->ApplicantModel->deleteApplicant($applicantIds,
                $this->session->userdata(SESS_USER_ID));
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Deleted applicant ID : ".$this->input->post('delApplicantIds'));
        echo 'Success';
    }
        
    /**
    * Search page.
    */
    public function search(){
        renderPage($this,null,'applicant/search');        
    }
    
    /**
    * Search results page.
    */
    public function searchResult(){
        // Create search parameters for each field.
        $searchParams = [];
        $fields = [
            "last_name",
            "first_name",
            "email",
            "primary_phone",
            "active_application",
            "secondary_phone",
            "work_phone",
            "address",
            "can_relocate",
            "current_employer",
            "source",
            "best_time_to_call",
            "current_pay",
            "desired_pay",
            "skills"
            ];
        foreach ($fields as $field){
            $param = getSearchParam($this,$field);
            $param ? array_push($searchParams, $param):'';            
        }
        
        // Create array to store fields to be shown
        $shownFields = [];
        // Create column header for the table.
        $columnHeaders = [];
        foreach ($searchParams as $param){
            if($param->show){
                array_push($shownFields, $param->field);   
                array_push($columnHeaders, ucwords(str_replace("_", " ", $param->field)));   
            }
        }
        if(!$shownFields){
            $data['error_message'] = "Select at least one field to be displayed.";
            renderPage($this,$data,'applicant/searchResult');
            return;
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_APPLICANT_SEARCH_ROWS_PER_PAGE);
        $totalCount = $this->ApplicantModel->searchApplicantCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['searcParams'] = $searchParams;
        $data['filters'] = generateTextForFilters($searchParams);
        $data['module'] = 'applicant';
        $data['removedRowsPerPage'] = site_url('applicant/searchResult').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('applicant/searchResult').'?'.getQueryParams(["currentPage"]);
        
        if($this->input->get("exportResult")){
            $applicants = $this->ApplicantModel->searchApplicant($searchParams,$shownFields,0);
            exportCSV($this->input->get("exportResult"),$applicants,$columnHeaders,[]);
        }else{
            $applicants = $this->ApplicantModel->searchApplicant($searchParams,$shownFields,$rowsPerPage,$data['offset']);
        }
        $data['entries'] = $applicants;
        renderPage($this,$data,'common/searchResult');
    }
    
    /**
    * Creates applicant object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @return   applicant object
    */
    private function createApplicantObject($post){
        $applicant = (object)[
            'last_name' => $post ? $this->input->post('last_name'): '',
            'first_name' => $post ? $this->input->post('first_name'): '',
            'email' => $post ? $this->input->post('email'): '',
            'primary_phone' => $post ? $this->input->post('primary_phone'): '',
            'secondary_phone' => $post ? $this->input->post('secondary_phone'): '',
            'work_phone' => $post ? $this->input->post('work_phone'): '',
            'best_time_to_call' => $post ? $this->input->post('best_time_to_call'): '',
            'address' => $post ? $this->input->post('address'): '',
            'source' => $post ? $this->input->post('source'): '',
            'current_employer' => $post ? $this->input->post('current_employer'): '',
            'can_relocate' => $post ? $this->input->post('can_relocate') ? '1' : '0' : '0',
            'current_pay' => $post ? $this->input->post('current_pay'): '',
            'desired_pay' => $post ? $this->input->post('desired_pay'): '',
        ];
        return $applicant;
    }
    
    /**
    * Creates applicant skill object.
    * 
    * @return   applicant object
    */
    private function createApplicantSkillObject($applicantId){
        $applicant_skills = [];
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
            $applicant_skill = (object)[
                'applicant_id' => $applicantId,
                'skill_id' => $skillId,
                'name' => $skillNames[$key],
                'years_of_experience' => $yearsOfExperiences[$key]
            ];
            array_push($applicant_skills, $applicant_skill);
        }
        return $applicant_skills;
    }
    
    /**
    * Apply validation rules for other details to be used in update form.
    */
    private function setValidationDetails(){        
        $this->form_validation->set_rules('last_name', 'Last Name',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('first_name','First Name'
                ,'trim|required|max_length[255]');
        $this->form_validation->set_rules('email','Email'
                ,'trim|required|max_length[255]');
        $this->form_validation->set_rules('primary_phone','Primay Phone'
                ,'trim|required|max_length[255]');
        $this->form_validation->set_rules('address','Address'
                ,'trim|required|max_length[255]');
        $this->form_validation->set_rules('skillIds','Skills'
                ,'required',array('required' => 'Please select at least 1 skill.'));
    }
    
    /**
    * Updates the data variable using pass as reference.
    */
    private function setData(&$data){
        $skillCategories = $this->SkillCategoryModel->getSkillCategories(0,0,'name','asc');
        if($skillCategories === ERROR_CODE){
            return ERROR_CODE;
        }
        $data["skillCategories"] = $skillCategories;
        return SUCCESS_CODE;
    }
}