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
    }
    
    /**
    * Display list of applicants.
    */
    public function applicantList(){
        checkUserLogin();
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
        checkUserLogin();
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
        // Set data for job order pipeline ajax.
        $data['applicant_id'] = $applicantId;
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['rowsPerPage'] = $rowsPerPage;
        
        renderPage($this,$data,'applicant/detailsView');
    }
    
    /**
    * Updates applicant details.
    */
    public function update(){
        checkUserLogin();
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
        // Set data for job order pipeline ajax.
        $data['applicant_id'] = $applicantId;
        $rowsPerPage = getRowsPerPage($this,COOKIE_JOB_ORDER_PIPELINE_AJAX_ROWS_PER_PAGE);
        $data['rowsPerPage'] = $rowsPerPage;
        // Display form with success message.
        $data["success_message"] = "Applicant successfully updated!";
        renderPage($this,$data,'applicant/detailsView');
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Updated candidate details with ID : ".$applicant->id.".");
    }
    
    /**
    * Adds applicant details.
    */
    public function add(){
        checkUserLogin();
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
        // Check if applicant already exist in the database.
        $confirmed = $this->input->post("confirmed");
        $a = $this->ApplicantModel->getApplicantByFullName
                ($applicant->first_name, $applicant->last_name);
        if($a && !$confirmed){
            $data["confirm_message"] = "Applicant with the same name already exist in the database. Are you sure you want to save?";
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
        $data["success_message"] = "Candidate successfully added! <a href=".
                site_url('applicant/view')."?id=".$newApplicantId.">Go to Details</a>";
        renderPage($this,$data,'applicant/add');
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Added candidate ".$applicant->last_name.
                ",".$applicant->first_name.".");
    }
    
    /**
    * Delete applicant.
    */
    public function delete(){
        checkUserLogin();
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
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Deleted candidate ID : ".$this->input->post('delApplicantIds'));
        echo 'Success';
    }
    
    /**
    * Block applicant.
    */
    public function block(){
        checkUserLogin();
        if(!$this->input->post('applicantIds')){
            echo 'Invalid Applicant ID';
            return;
        }
        $applicantIds = explode(",", $this->input->post('applicantIds'));
        $success = $this->ApplicantModel->blockApplicant($applicantIds);
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Blocked candidate ID : ".$this->input->post('applicantIds'));
        echo 'Success';
    }
    
    /**
    * Activate applicant.
    */
    public function activate(){
        checkUserLogin();
        if(!$this->input->post('applicantIds')){
            echo 'Invalid Applicant ID';
            return;
        }
        $applicantIds = explode(",", $this->input->post('applicantIds'));
        $success = $this->ApplicantModel->activateApplicant($applicantIds);
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Activated candidate ID : ".$this->input->post('applicantIds'));
        echo 'Success';
    }
        
    /**
    * Search page.
    */
    public function search(){
        checkUserLogin();
        renderPage($this,null,'applicant/search');        
    }
    
    /**
    * Search results page.
    */
    public function searchResult(){
        checkUserLogin();
        $fields = [
            "id",
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
        $data = $this->searchApplicant($fields);
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
            "last_name",
            "first_name",
            "skills",
            ];
        $data = $this->searchApplicant($fields,$fields);
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
    private function searchApplicant($fields,$sf=null){
        $searchParams = [];
        // Create search parameters for each field.
        foreach ($fields as $field){
            $param = getSearchParam($this,$field);
            $param ? array_push($searchParams, $param):'';            
        }
        
        // If sf is null, create shownFields from searchParams.
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
            return $data;
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
            if($applicants === ERROR_CODE){
                $data['error_message'] = "Error occured.";
            }
            exportCSV($this->input->get("exportResult"),$applicants,$columnHeaders,[]);
        }else{
            $applicants = $this->ApplicantModel->searchApplicant($searchParams,$shownFields,$rowsPerPage,$data['offset']);
            if($applicants === ERROR_CODE){
                $data['error_message'] = "Error occured.";
            }
        }
        $data['entries'] = $applicants;
        return $data;
    }
    
    /**
    * Display applicant profile.
    */
    public function profile(){
        checkApplicantLogin();
        $applicantId = $this->session->userdata(SESS_APPLICANT_ID);
        if(!$applicantId){
            $data["error_message"] = "Error occured.";
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        $result = $this->ApplicantModel->getApplicantById($applicantId);
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        $data['applicant'] = $result;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        $applicant_skills = $this->ApplicantModel->getApplicantSkill($applicantId);
        if($applicant_skills === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        $data["applicant_skills"] = $applicant_skills;
        renderApplicantPage($this,$data,'applicant/profile');
    }
    
    /**
    * profileUpdate updates applicant profile.
    */
    public function profileUpdate(){
        checkApplicantLogin();
        $this->setValidationDetails();
        $applicant = $this->createApplicantObject(true);
        $applicantId = $this->session->userdata(SESS_APPLICANT_ID);
        $applicant->id = $applicantId;
        $data["applicant"] = $applicant;
        $applicant_skills = $this->createApplicantSkillObject($applicantId);
        $data["applicant_skills"] = $applicant_skills;
        if($this->setData($data) === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        if ($this->form_validation->run() == FALSE){
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        // Update applicant details
        $updateApplicant = $this->ApplicantModel->updateApplicant($applicant,$applicantId);
        if($updateApplicant === ERROR_CODE){
            // Set error message.
            $data["error_message"] = "Error occured.";     
            renderApplicantPage($this,$data,'applicant/profile');
            return;
        }
        // Batch insert skills into applicant skills table.
        if($applicant_skills){
            $updateApplicantSkills = $this->ApplicantModel->deleteApplicantSkills($applicantId)
                    && $this->ApplicantModel->addApplicantSkills($applicant_skills);
            if($updateApplicantSkills === ERROR_CODE){
                // Set error message.
                $data["error_message"] = "Error occured.";     
                renderApplicantPage($this,$data,'applicant/profile');
                return;
            }
        }
        // Display form with success message.
        $data["success_message"] = "Profile successfully updated!";
        renderApplicantPage($this,$data,'applicant/profile');
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
            'birthday' => $post ? $this->input->post('birthday'): '',
            'civil_status' => $post ? $this->input->post('civil_status'): '',
            'email' => $post ? $this->input->post('email'): '',
            'status' => $post ? $this->input->post('status'): '',
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