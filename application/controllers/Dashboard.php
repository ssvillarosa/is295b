<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard
 *
 * Handles dashboard page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Dashboard extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
    }
    
    /**
    * Shows overview of dashboard.
    */
    public function adminOverview(){
        checkUserLogin();
        $data = [];
        renderPage($this,$data,'dashboard/adminOverview');	
    }
    
    /**
    * Shows overview of dashboard.
    */
    public function applicantOverview(){
        checkApplicantLogin();
        $data = [];
        renderApplicantPage($this,$data,'dashboard/adminOverview');
    }
}
