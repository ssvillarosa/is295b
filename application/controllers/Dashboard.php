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
    public function overview(){
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $this->load->view('dashboard/overview');
        $this->load->view('common/footer');	
    }    
}
