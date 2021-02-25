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
        $applicant_skills = $this->ApplicantModel->getApplicantSkill($applicantId);
        if($applicant_skills === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'job_order/detailsView');
            return;
        }
        $data["applicant_skills"] = $applicant_skills;
        renderPage($this,$data,'applicant/detailsView');
    }
}