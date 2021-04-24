<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard
 *
 * Handles admin_dashboard page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Admin_dashboard extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('PipelineModel');
        checkUserLogin();
    }
    
    /**
    * Shows overview of admin_dashboard.
    */
    public function overview(){
        renderPage($this, [], 'admin_dashboard/overview');
    }
    
    public function getAssignedToMe(){
        $userId = $this->session->userdata(SESS_USER_ID);
        // Set pagination details.
        $rowsPerPage = getRowsPerPage($this,COOKIE_DASHBOARD_ASSIGNED_TO_ME);
        $orderBy = getOrderBy($this,COOKIE_DASHBOARD_ASSIGNED_TO_ME_ORDER_BY);
        $order = getOrder($this,COOKIE_DASHBOARD_ASSIGNED_TO_ME_ORDER);
        $totalCount = count($this->PipelineModel->getPipelinesByUser(0,0,$userId,$orderBy,$order));
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage,$orderBy,$order);
        $userPipelines = $this->PipelineModel->
                getPipelinesByUser($rowsPerPage,$data['offset'],$userId,$orderBy,$order);
        if($userPipelines === ERROR_CODE){
            $data["error_message"] = "Error occured.";
            renderPage($this, $data, 'admin_dashboard/overview');
            return;
        }
        $data["user_pipelines"] = $userPipelines;
        $this->load->view('admin_dashboard/assignedToMe',$data);
    }
}
