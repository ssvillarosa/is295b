<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activity
 *
 * Handles activity page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Activity extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('ActivityModel');
        $this->load->model('PipelineModel');
        $this->load->model('UserModel');
    }
    
    /**
    * Add pipeline entry.
    */
    public function add(){
        checkUserLogin();
        $pipelineId = $this->input->get('pipelineId');
        if(!$pipelineId){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/addActivity');
            return;
        }
        $pipeline = $this->PipelineModel->getPipelineById($pipelineId);
        if($pipeline === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this,$data,'activity/addActivity');
            return;
        }
        $data['pipeline'] = $pipeline;
        $recruiters = $this->UserModel->getUsers(0);
        $data["recruiters"] = $recruiters;
        renderPage($this,$data,'activity/addActivity');
    }
}