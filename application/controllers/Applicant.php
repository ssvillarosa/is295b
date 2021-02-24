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
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
    }
}