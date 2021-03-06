<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Registration
 *
 * Handles registration page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Registration extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('RegistrationModel');
        $this->load->model('SkillCategoryModel');
        checkUserLogin();
    }
    
    /**
    * Display list of registrations.
    */
    public function registrationList(){
        $rowsPerPage = getRowsPerPage($this,COOKIE_REGISTRATION_ROWS_PER_PAGE);
        $totalCount = $this->RegistrationModel->getRegistrationCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $result = $this->RegistrationModel->getRegistrations($rowsPerPage,$data['offset']);        
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['registrations'] = $result;
        $data['current_uri'] = 'registration/registrationList';
        renderPage($this,$data,'registration/registrationList');
    }
    
    /**
    * Display registration details.
    */
    public function view(){
        $registrationId = $this->input->get('id');
        if(!$registrationId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        $result = $this->RegistrationModel->getRegistrationById($registrationId);
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        $data['registration'] = $result;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        $registration_skills = $this->RegistrationModel->getRegistrationSkill($registrationId);
        if($registration_skills === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        $data["registration_skills"] = $registration_skills;
        renderPage($this,$data,'registration/detailsView');
    }
    
    /**
    * Updates registration details.
    */
    public function update(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $data["error_message"] = 'Invalid access.';
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        $this->setValidationDetails();
        $this->form_validation->set_rules('registrationId','Registration ID'
                ,'required|integer');
        $registration = $this->createRegistrationObject(true);
        $registrationId = $this->input->post('registrationId');
        $registration->id = $registrationId;
        $data["registration"] = $registration;
        $registration_skills = $this->createRegistrationSkillObject($registrationId);
        $data["registration_skills"] = $registration_skills;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        // Update registration details
        $updateRegistration = $this->RegistrationModel->updateRegistration($registration,$registrationId);
        if($updateRegistration === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";     
            renderPage($this,$data,'registration/detailsView');
            return;
        }
        // Batch insert skills into registration skills table.
        if($registration_skills){
            $updateRegistrationSkills = $this->RegistrationModel->deleteRegistrationSkills($registrationId)
                    && $this->RegistrationModel->addRegistrationSkills($registration_skills);
            if($updateRegistrationSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderPage($this,$data,'registration/detailsView');
                return;
            }
        }
        // Display form with success message.
        $data["success_message"] = "Registration successfully updated!";
        renderPage($this,$data,'registration/detailsView');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Updated registration ".$registration->last_name.",".$registration->first_name." details.");
    }
    
    /**
    * Adds registration details.
    */
    public function add(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            $data["error_message"] = 'Invalid access.';
            renderPage($this,$data,'registration/add');
            return;
        }
        $this->setValidationDetails();
        // Create registration objects and its sub items.
        $registration = $this->createRegistrationObject(true);
        $data["registration"] = $registration;
        $registration_skills = $this->createRegistrationSkillObject(0);
        $data["registration_skills"] = $registration_skills;
        
        $registration->created_by = $this->session->userdata(SESS_USER_ID);
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/add');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderPage($this,$data,'registration/add');
            return;
        }
        // Add registration details.
        $newRegistrationId = $this->RegistrationModel->addRegistration($registration);
        if($newRegistrationId === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'registration/add');
            return;
        }
        // Batch insert skills into registration skills table.
        $new_registration_skills = $this->createRegistrationSkillObject($newRegistrationId);
        if($registration_skills){
            $addRegistrationSkills = $this->RegistrationModel->addRegistrationSkills($new_registration_skills);
            if($addRegistrationSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";
                renderPage($this,$data,'registration/add');
                return;
            }
        }
        // Clear data and display form with success message.
        $empty_registration = $this->createRegistrationObject(false);
        $data["registration"] = $empty_registration;
        $data["registration_skills"] = [];
        $data["success_message"] = "Candidate successfully added!";
        renderPage($this,$data,'registration/add');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Added registration ".$registration->last_name.
                ",".$registration->first_name.".");
    }
    
    /**
    * Delete registration.
    */
    public function delete(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        if(!$this->input->post('delRegistrationIds')){
            echo 'Invalid Registration ID';
            return;
        }
        $registrationIds = explode(",", $this->input->post('delRegistrationIds'));
        $success = $this->RegistrationModel->deleteRegistration($registrationIds,
                $this->session->userdata(SESS_USER_ID));
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Deleted registration ID : ".$this->input->post('delRegistrationIds'));
        echo 'Success';
    }
        
    /**
    * Search page.
    */
    public function search(){
        renderPage($this,null,'registration/search');        
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
            "birthday",
            "civil_status",
            "active_application",
            "email",
            "primary_phone",
            "secondary_phone",
            "work_phone",
            "best_time_to_call",
            "address",
            "can_relocate",
            "current_employer",
            "source",
            "current_pay",
            "desired_pay",
            "skills",
            "educational_background",
            "professional_experience",
            "seminars_and_trainings"
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
            renderPage($this,$data,'registration/searchResult');
            return;
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_REGISTRATION_SEARCH_ROWS_PER_PAGE);
        $totalCount = $this->RegistrationModel->searchRegistrationCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['searcParams'] = $searchParams;
        $data['filters'] = generateTextForFilters($searchParams);
        $data['module'] = 'registration';
        $data['removedRowsPerPage'] = site_url('registration/searchResult').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('registration/searchResult').'?'.getQueryParams(["currentPage"]);
        
        if($this->input->get("exportResult")){
            $registrations = $this->RegistrationModel->searchRegistration($searchParams,$shownFields,0);
            exportCSV($this->input->get("exportResult"),$registrations,$columnHeaders);
        }else{
            $registrations = $this->RegistrationModel->searchRegistration($searchParams,$shownFields,$rowsPerPage,$data['offset']);
        }
        $data['entries'] = $registrations;
        renderPage($this,$data,'common/searchResult');
    }
    
    /**
    * Creates registration object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @return   registration object
    */
    private function createRegistrationObject($post){
        $registration = (object)[
            'last_name' => $post ? $this->input->post('last_name'): '',
            'first_name' => $post ? $this->input->post('first_name'): '',
            'birthday' => $post ? $this->input->post('birthday'): '',
            'civil_status' => $post ? $this->input->post('civil_status'): '',
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
            'objectives' => $post ? $this->input->post('objectives'): '',
            'educational_background' => $post ? $this->input->post('educational_background'): '',
            'professional_experience' => $post ? $this->input->post('professional_experience'): '',
            'seminars_and_trainings' => $post ? $this->input->post('seminars_and_trainings'): '',
        ];
        return $registration;
    }
    
    /**
    * Creates registration skill object.
    * 
    * @return   registration object
    */
    private function createRegistrationSkillObject($registrationId){
        $registration_skills = [];
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
            $registration_skill = (object)[
                'registration_id' => $registrationId,
                'skill_id' => $skillId,
                'name' => $skillNames[$key],
                'years_of_experience' => $yearsOfExperiences[$key]
            ];
            array_push($registration_skills, $registration_skill);
        }
        return $registration_skills;
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