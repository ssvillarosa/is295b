<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Skill
 *
 * Handles skill api.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Skill extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        checkUserLogin();
        $this->load->model('SkillCategoryModel');
        $this->load->model('SkillModel');
    }
    
    /**
    * List skills into json format.
    */
    public function getSkillsByCategory(){
        $skillCategoryId = $this->input->get("skillCategoyId");
        $skills = $this->SkillModel->getSkillByCategoryId($skillCategoryId);
        if($skills === ERROR_CODE){
            echo "Error";
        }
        echo json_encode($skills);
    }
}